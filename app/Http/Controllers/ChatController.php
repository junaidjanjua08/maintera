<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\ChatMessage;
use App\Models\FareOffer;
use App\Models\User;

class ChatController extends Controller
{
    /**
     * Show chat interface for an order
     */
    public function show(Order $order)
    {
        // Check if user has access to this chat
        $user = Auth::user();
        
        if ($user->role === 'customer' && $order->user_id !== $user->id) {
            abort(403, 'Unauthorized access to chat');
        }
        
        if ($user->role === 'technician' && $order->technician_id !== $user->id) {
            abort(403, 'Unauthorized access to chat');
        }
        
        // Check if fare offer is accepted
        $acceptedOffer = $order->fareOffers()->where('status', 'accepted')->first();
        if (!$acceptedOffer) {
            abort(403, 'Chat is only available after fare offer is accepted');
        }
        
        $messages = $order->chatMessages()->with('sender')->get();
        
        // Ensure order has necessary relationships loaded
        $order->load(['customer', 'technician', 'category', 'subcategory']);
        
        // Mark messages as read
        $order->chatMessages()
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        
        if ($user->role === 'technician') {
            return view('technician.pages.chat', compact('order', 'messages', 'acceptedOffer'));
        } else {
            return view('chat.show', compact('order', 'messages', 'acceptedOffer'));
        }
    }

    /**
     * Send a message
     */
    public function sendMessage(Request $request, Order $order)
    {
        $request->validate([
            'message' => 'nullable|string|max:1000',
            'message_type' => 'nullable|in:text,image,file,location',
            'file' => 'nullable|file|max:10240', // 10MB max
            'location_data' => 'nullable|array'
        ]);

        $user = Auth::user();
        
        // Check if user has access to this chat
        if ($user->role === 'customer' && $order->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        if ($user->role === 'technician' && $order->technician_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Check if at least one of message or file is provided
        if (empty($request->message) && !$request->hasFile('file')) {
            return response()->json(['error' => 'Message or file is required'], 422);
        }

        $messageData = [
            'order_id' => $order->id,
            'sender_id' => $user->id,
            'sender_type' => $user->role,
            'message' => $request->message ?? '',
            'message_type' => $request->message_type ?? 'text'
        ];

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('chat-files', $filename, 'public');
            
            $messageData['file_path'] = $path;
            $messageData['file_name'] = $file->getClientOriginalName();
            $messageData['file_size'] = $file->getSize();
            $messageData['message_type'] = $request->message_type ?? 'file';
        }

        // Handle location data
        if ($request->location_data) {
            $messageData['location_data'] = $request->location_data;
            $messageData['message_type'] = 'location';
        }

        $message = ChatMessage::create($messageData);
        $message->load('sender');

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Get new messages (for real-time updates)
     */
    public function getNewMessages(Request $request, Order $order)
    {
        $user = Auth::user();
        $lastMessageId = $request->get('last_message_id', 0);
        
        $messages = $order->chatMessages()
            ->where('id', '>', $lastMessageId)
            ->with('sender')
            ->get();
        
        // Mark messages as read
        $order->chatMessages()
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        
        return response()->json([
            'messages' => $messages,
            'unread_count' => $order->unreadMessages($user->id)
        ]);
    }

    /**
     * Mark messages as read
     */
    public function markAsRead(Request $request, Order $order)
    {
        $user = Auth::user();
        
        $order->chatMessages()
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        
        return response()->json(['success' => true]);
    }

    /**
     * Download chat file
     */
    public function downloadFile(ChatMessage $message)
    {
        $user = Auth::user();
        
        // Check if user has access to this message
        if ($user->role === 'customer' && $message->order->user_id !== $user->id) {
            abort(403, 'Unauthorized access');
        }
        
        if ($user->role === 'technician' && $message->order->technician_id !== $user->id) {
            abort(403, 'Unauthorized access');
        }
        
        if (!$message->file_path || !Storage::disk('public')->exists($message->file_path)) {
            abort(404, 'File not found');
        }
        
        $path = storage_path('app/public/' . $message->file_path);
        return response()->download($path, $message->file_name);
    }

    /**
     * Get chat list for user
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'customer') {
            $orders = Order::where('user_id', $user->id)
                ->whereHas('fareOffers', function($query) {
                    $query->where('status', 'accepted');
                })
                ->with(['technician', 'chatMessages' => function($query) {
                    $query->latest()->limit(1);
                }])
                ->get()
                ->filter(function($order) use ($user) {
                    // Filter out chats that the user has deleted
                    return !$user->hasDeletedChat($order->id);
                })
                ->map(function($order) use ($user) {
                    $order->unread_count = $order->unreadMessages($user->id);
                    // Get the latest message timestamp for sorting
                    $order->latest_message_time = $order->chatMessages->first() ? 
                        $order->chatMessages->first()->created_at : 
                        $order->created_at;
                    return $order;
                })
                ->sortByDesc('latest_message_time')
                ->values();
            
            // Mark all messages as read when viewing chat list
            ChatMessage::whereHas('order', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
                
            return view('chat.index', compact('orders'));
        } else {
            $orders = Order::where('technician_id', $user->id)
                ->whereHas('fareOffers', function($query) {
                    $query->where('status', 'accepted');
                })
                ->with(['customer', 'chatMessages' => function($query) {
                    $query->latest()->limit(1);
                }])
                ->get()
                ->filter(function($order) use ($user) {
                    // Filter out chats that the user has deleted
                    return !$user->hasDeletedChat($order->id);
                })
                ->map(function($order) use ($user) {
                    $order->unread_count = $order->unreadMessages($user->id);
                    // Get the latest message timestamp for sorting
                    $order->latest_message_time = $order->chatMessages->first() ? 
                        $order->chatMessages->first()->created_at : 
                        $order->created_at;
                    return $order;
                })
                ->sortByDesc('latest_message_time')
                ->values();
            
            // Mark all messages as read when viewing chat list
            ChatMessage::whereHas('order', function($query) use ($user) {
                $query->where('technician_id', $user->id);
            })
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
                
            return view('technician.pages.chat-list', compact('orders'));
        }
    }

    /**
     * Get unread chat messages count for navbar notification
     */
    public function getNotificationCount()
    {
        $user = Auth::user();
        
        if ($user->role !== 'customer') {
            return response()->json(['count' => 0]);
        }
        
        $count = $user->getUnreadChatMessagesCount();
        
        return response()->json(['count' => $count]);
    }

    /**
     * Get unread chat messages count for technician navbar notification
     */
    public function getTechnicianNotificationCount()
    {
        $user = Auth::user();
        
        if ($user->role !== 'technician') {
            return response()->json(['count' => 0]);
        }
        
        $count = $user->getUnreadChatMessagesCountForTechnician();
        
        return response()->json(['count' => $count]);
    }

    /**
     * Delete a chat message
     */
    public function deleteMessage(ChatMessage $message)
    {
        $user = Auth::user();
        
        // Check if user has access to this message
        if ($user->role === 'customer' && $message->order->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }
        
        if ($user->role === 'technician' && $message->order->technician_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }
        
        // Only allow users to delete their own messages
        if ($message->sender_id !== $user->id) {
            return response()->json(['error' => 'You can only delete your own messages'], 403);
        }
        
        try {
            // Delete associated file if exists
            if ($message->file_path && Storage::disk('public')->exists($message->file_path)) {
                Storage::disk('public')->delete($message->file_path);
            }
            
            $message->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Message deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to delete message: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete entire chat for a user (soft delete)
     */
    public function deleteChat(Order $order)
    {
        $user = Auth::user();
        
        // Check if user has access to this chat
        if ($user->role === 'customer' && $order->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }
        
        if ($user->role === 'technician' && $order->technician_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }
        
        try {
            // Mark chat as deleted for this user
            $user->deleteChat($order->id);
            
            return response()->json([
                'success' => true,
                'message' => 'Chat deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to delete chat: ' . $e->getMessage()
            ], 500);
        }
    }
}
