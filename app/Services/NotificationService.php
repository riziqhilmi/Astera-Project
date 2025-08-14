<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public static function createNotification($userId, $type, $title, $message, $icon = null, $color = 'blue', $data = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'icon' => $icon,
            'color' => $color,
            'data' => $data
        ]);
    }

    public static function notifyUserActivity($userId, $activity, $details = null)
    {
        $iconMap = [
            'login' => 'fas fa-sign-in-alt',
            'logout' => 'fas fa-sign-out-alt',
            'profile_update' => 'fas fa-user-edit',
            'password_change' => 'fas fa-key',
            'data_create' => 'fas fa-plus',
            'data_update' => 'fas fa-edit',
            'data_delete' => 'fas fa-trash',
            'role_change' => 'fas fa-user-tag'
        ];

        $colorMap = [
            'login' => 'green',
            'logout' => 'blue',
            'profile_update' => 'blue',
            'password_change' => 'yellow',
            'data_create' => 'green',
            'data_update' => 'blue',
            'data_delete' => 'red',
            'role_change' => 'purple'
        ];

        return self::createNotification(
            $userId,
            'user_activity',
            'User Activity: ' . ucfirst(str_replace('_', ' ', $activity)),
            $details ?? "User performed {$activity}",
            $iconMap[$activity] ?? 'fas fa-info-circle',
            $colorMap[$activity] ?? 'blue',
            ['activity' => $activity, 'details' => $details]
        );
    }

    public static function notifyDataUpdate($userId, $dataType, $action, $itemName = null)
    {
        $iconMap = [
            'barang' => 'fas fa-box-open',
            'ruangan' => 'fas fa-door-open',
            'user' => 'fas fa-users',
            'barang_masuk' => 'fas fa-arrow-down',
            'barang_keluar' => 'fas fa-arrow-up'
        ];

        $colorMap = [
            'create' => 'green',
            'update' => 'blue',
            'delete' => 'red'
        ];

        $message = ucfirst($action) . " data {$dataType}";
        if ($itemName) {
            $message .= ": {$itemName}";
        }

        return self::createNotification(
            $userId,
            'data_update',
            'Data Update: ' . ucfirst($dataType),
            $message,
            $iconMap[$dataType] ?? 'fas fa-database',
            $colorMap[$action] ?? 'blue',
            ['data_type' => $dataType, 'action' => $action, 'item_name' => $itemName]
        );
    }

    public static function notifyRoleChange($userId, $oldRole, $newRole)
    {
        return self::createNotification(
            $userId,
            'role_change',
            'Role Changed',
            "Your role has been changed from {$oldRole} to {$newRole}",
            'fas fa-user-tag',
            'purple',
            ['old_role' => $oldRole, 'new_role' => $newRole]
        );
    }

    public static function notifySystemEvent($userId, $event, $message, $color = 'blue')
    {
        return self::createNotification(
            $userId,
            'system',
            'System: ' . ucfirst($event),
            $message,
            'fas fa-cog',
            $color,
            ['event' => $event]
        );
    }

    public static function notifyAllUsers($type, $title, $message, $icon = null, $color = 'blue', $data = null)
    {
        $users = User::all();
        $notifications = [];

        foreach ($users as $user) {
            $notifications[] = self::createNotification(
                $user->id,
                $type,
                $title,
                $message,
                $icon,
                $color,
                $data
            );
        }

        return $notifications;
    }
}
