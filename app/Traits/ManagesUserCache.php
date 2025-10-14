<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ManagesUserCache
{
    /**
     * Clear all caches for this user
     * Call this when user's G12 leader assignment changes
     */
    public static function clearUserCache($userId)
    {
        $cacheKeys = [
            "user_{$userId}_available_leaders",
            "user_{$userId}_available_consolidators",
            "equipping_user_{$userId}_visible_leaders",
        ];

        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }
        
        // Also clear global caches that might be affected
        Cache::forget('all_g12_leaders');
        Cache::forget('all_consolidators');
    }

    /**
     * Boot method to handle cache invalidation
     */
    protected static function booted()
    {
        // Clear cache when user's G12 leader assignment changes
        static::saved(function ($user) {
            if ($user->isDirty('g12_leader_id') || $user->isDirty('role')) {
                static::clearUserCache($user->id);
            }
        });

        // Clear cache when user is deleted
        static::deleted(function ($user) {
            static::clearUserCache($user->id);
        });
    }
}
