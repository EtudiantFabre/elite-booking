<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Mark a specific notification as read.
     */
    public function markAsRead($id)
    {
        $notification = auth()->user()->unreadNotifications()->findOrFail($id);
        $notification->markAsRead();

        return back();
    }

    /**
     * Mark all notifications as read for the authenticated user.
     */
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back();
    }

    /**
     * Delete all notifications for the authenticated user.
     */
    public function destroyAll()
    {
        auth()->user()->notifications()->delete();

        return back();
    }
}
