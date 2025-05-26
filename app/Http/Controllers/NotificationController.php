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
                        ->whereNull('read_at')
                        ->paginate(10);
    
    return view('technician.notifications.index', compact('notifications'));
}

    /**
     * Mark a specific notification as read
     */
  public function markAsRead($id)
{
   
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
      
         return redirect()->route('technician.notifications.index')->with('sweet_success', 'Notification read successfully!');
}
    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        
        Auth::user()->unreadNotifications->markAsRead();
        
        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read'
        ]);
    }

    /**
     * Get unread notifications count
     */
    public function getUnreadCount()
    {
        $count = Auth::user()->unreadNotifications->count();
        
        return response()->json([
            'count' => $count
        ]);
    }

    /**
     * Delete a notification
     */
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Notification deleted successfully'
        ]);
    }
} 