<?php

namespace App\Http\Controllers\Api;

use App\Notification;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    /**
     * Get recent notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRecentNotifications()
    {
        return response()->json(auth()->user()->getRecentNotifications());
    }

    /**
     * Mark notification as read @API.
     *
     * @param $notificationId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markRead($notificationId)
    {
        if ($notification = auth()->user()->unReadNotifications()
                                ->whereId($notificationId)
                                ->first()
        ) {
            $notification->markAsRead();

            return response()->json([
                'success' => true,
            ]);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    /**
     * View all notifications.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewAll()
    {
        $notifications = auth()->user()->notifications;

        // Mark as read if unread
        $notifications->each->markAsRead();

        return response()->json($notifications);
    }
}
