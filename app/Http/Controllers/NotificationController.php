<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the authenticated user
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
        
        // Return different views based on user role
        if (Auth::user()->role === 'customer') {
            return view('customer.notifications.index', compact('notifications'));
        } else {
            return view('technician.notifications.index', compact('notifications'));
        }
    }

    /**
     * Mark a specific notification as read
     */
    public function markAsRead($id)
    {
        try {
            $notification = Auth::user()->notifications()->findOrFail($id);
            $notification->markAsRead();
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Notification marked as read'
                ]);
            }
            
            // Redirect based on user role
            if (Auth::user()->role === 'customer') {
                return redirect()->route('customer.notifications.index')
                               ->with('sweet_success', 'Notification marked as read successfully!');
            } else {
                return redirect()->route('technician.notifications.index')
                               ->with('sweet_success', 'Notification marked as read successfully!');
            }
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to mark notification as read'
                ], 500);
            }
            
            // Redirect based on user role
            if (Auth::user()->role === 'customer') {
                return redirect()->route('customer.notifications.index')
                               ->with('sweet_error', 'Failed to mark notification as read');
            } else {
                return redirect()->route('technician.notifications.index')
                               ->with('sweet_error', 'Failed to mark notification as read');
            }
        }
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        try {
            $user = Auth::user();
            $unreadCount = $user->unreadNotifications->count();
            
            $user->unreadNotifications->markAsRead();
            
            return response()->json([
                'success' => true,
                'message' => 'All notifications marked as read',
                'unread_count' => $unreadCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark all notifications as read: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get unread notifications count
     */
    public function getUnreadCount()
    {
        try {
            $count = Auth::user()->unreadNotifications->count();
            
            return response()->json([
                'success' => true,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'count' => 0
            ], 500);
        }
    }

    /**
     * Delete a notification
     */
    public function destroy($id)
    {
        try {
            $notification = Auth::user()->notifications()->findOrFail($id);
            $notification->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Notification deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete notification'
            ], 500);
        }
    }
} 