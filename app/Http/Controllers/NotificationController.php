<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class NotificationController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'error' => 'User not authenticated'
                ], 401);
            }

            $notifications = Notification::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get()
                ->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'type' => $notification->type,
                        'title' => $notification->title,
                        'message' => $notification->message,
                        'icon' => $notification->icon ?? $this->getDefaultIcon($notification->type),
                        'color' => $notification->color ?? 'blue',
                        'is_read' => (bool) $notification->is_read,
                        'created_at' => $notification->created_at->toISOString(),
                        'read_at' => $notification->read_at ? $notification->read_at->toISOString() : null,
                        'data' => $notification->data
                    ];
                });

            $unreadCount = Notification::where('user_id', $user->id)->where('is_read', false)->count();

            return response()->json([
                'success' => true,
                'notifications' => $notifications,
                'unread_count' => $unreadCount
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching notifications: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to fetch notifications',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function markAsRead(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'notification_id' => 'required|integer|exists:notifications,id'
            ]);

            $user = Auth::user();
            $notification = Notification::where('user_id', $user->id)->findOrFail($request->notification_id);
            
            $notification->update([
                'is_read' => true,
                'read_at' => now()
            ]);

            $unreadCount = Notification::where('user_id', $user->id)->where('is_read', false)->count();

            return response()->json([
                'success' => true,
                'unread_count' => $unreadCount,
                'message' => 'Notification marked as read'
            ]);

        } catch (\Exception $e) {
            Log::error('Error marking notification as read: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to mark notification as read',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function markAllAsRead(): JsonResponse
    {
        try {
            $user = Auth::user();
            
            Notification::where('user_id', $user->id)
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'unread_count' => 0,
                'message' => 'All notifications marked as read'
            ]);

        } catch (\Exception $e) {
            Log::error('Error marking all notifications as read: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to mark all notifications as read',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'notification_id' => 'required|integer|exists:notifications,id'
            ]);

            $user = Auth::user();
            $notification = Notification::where('user_id', $user->id)->findOrFail($request->notification_id);
            $notification->delete();

            $unreadCount = Notification::where('user_id', $user->id)->where('is_read', false)->count();

            return response()->json([
                'success' => true,
                'unread_count' => $unreadCount,
                'message' => 'Notification deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting notification: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to delete notification',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function getDefaultIcon(string $type): string
    {
        return match ($type) {
            'user_activity' => 'fas fa-user',
            'data_update' => 'fas fa-database',
            'system' => 'fas fa-cog',
            'role_change' => 'fas fa-user-tag',
            'barang_masuk' => 'fas fa-box-open',
            'barang_keluar' => 'fas fa-box',
            'warning' => 'fas fa-exclamation-triangle',
            'error' => 'fas fa-times-circle',
            default => 'fas fa-bell'
        };
    }
}
