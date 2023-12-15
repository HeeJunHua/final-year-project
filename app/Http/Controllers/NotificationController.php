<?php

namespace App\Http\Controllers;
// app/Http/Controllers/NotificationController.php

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'newest');
    
        $getAllUserNotifications = Notification::where('user_id', auth()->id());
    
        if ($sort === 'oldest') {
            $getAllUserNotifications = $getAllUserNotifications->oldest('created_at')->get();
        } else {
            $getAllUserNotifications = $getAllUserNotifications->latest('created_at')->get();
        }
    
        return view('notifications.index', compact('getAllUserNotifications'));
    }
                    
    public function markAllAsRead()
    {
        $userNotifications = Notification::where('user_id', auth()->id())
            ->where('notification_read', false)
            ->take(5)
            ->get();

        foreach ($userNotifications as $notification) {
            $notification->update(['notification_read' => true]);
        }

        return redirect()->back()->with('success', 'First 5 notifications marked as read');
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);

        if ($notification->user_id == auth()->id() && !$notification->notification_read) {
            $notification->update(['notification_read' => true]);
            return redirect()->back()->with('success', 'Successfully mark as read.');
        }

        return redirect()->back()->with('error', 'Unable to mark the notification as read');
    }
}
