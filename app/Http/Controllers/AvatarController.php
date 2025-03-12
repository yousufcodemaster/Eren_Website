<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AvatarController extends Controller
{
    /**
     * Get the avatar URL for a user based on their role and premium type
     */
    public static function getAvatarUrl(User $user): string
    {
        // If user has a Discord avatar, use it
        if (!empty($user->discord_avatar)) {
            return $user->discord_avatar;
        }
        
        // Otherwise, use default avatar based on role and premium type
        if ($user->role === 'admin') {
            return asset('images/avatars/admin-avatar.png');
        }
        
        // For premium users
        if ($user->premium_type) {
            switch ($user->premium_type) {
                case 'All':
                    return asset('images/avatars/premium-avatar.png');
                case 'Bypass':
                    return asset('images/avatars/bypass-avatar.png');
                case 'Streamer':
                    return asset('images/avatars/streamer-avatar.png');
                case 'External':
                    return asset('images/avatars/external-avatar.png');
                case 'Reseller':
                    return asset('images/avatars/reseller-avatar.png');
                default:
                    return asset('images/avatars/premium-avatar.png');
            }
        }
        
        // Default user avatar
        return asset('images/avatars/user-avatar.png');
    }
    
    /**
     * Get HTML for displaying a user's avatar
     */
    public static function getAvatarHtml(User $user, string $size = 'md'): string
    {
        $sizeClasses = [
            'xs' => 'h-6 w-6',
            'sm' => 'h-8 w-8',
            'md' => 'h-10 w-10',
            'lg' => 'h-12 w-12',
            'xl' => 'h-16 w-16',
        ];
        
        $avatarUrl = self::getAvatarUrl($user);
        $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
        
        return '<img src="' . $avatarUrl . '" alt="' . $user->name . '" class="' . $sizeClass . ' rounded-full object-cover">';
    }
} 