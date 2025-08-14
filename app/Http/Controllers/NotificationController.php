<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(): JsonResponse
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => Auth::user()->unreadNotifications()->count()
        ]);
    }

    public function markAsRead(Request $request): JsonResponse
    {
        $notification = Auth::user()->notifications()->findOrFail($request->notification_id);
        $notification->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'unread_count' => Auth::user()->unreadNotifications()->count()
        ]);
    }

    public function markAllAsRead(): JsonResponse
    {
        Auth::user()->unreadNotifications()->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'unread_count' => 0
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $notification = Auth::user()->notifications()->findOrFail($request->notification_id);
        $notification->delete();

        return response()->json([
            'success' => true,
            'unread_count' => Auth::user()->unreadNotifications()->count()
        ]);
    }
}
