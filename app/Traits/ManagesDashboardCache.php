<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use App\Models\User;

trait ManagesDashboardCache
{
    /**
     * Get the cache key for the dashboard stats based on user role
     */
    protected function getDashboardCacheKey($user): string
    {
        if ($user instanceof User && $user->isLeader() && $user->leaderRecord) {
            return "dashboard_stats_leader_{$user->id}";
        }
        
        return "dashboard_stats_admin";
    }
    
    /**
     * Get cached dashboard stats with a TTL
     */
    protected function getCachedStats($user, int $ttl = 300): array
    {
        $cacheKey = $this->getDashboardCacheKey($user);
        
        return Cache::remember($cacheKey, $ttl, function () use ($user) {
            return $this->generateStats($user);
        });
    }
    
    /**
     * Clear the dashboard cache for a specific user or all users
     */
    public static function clearDashboardCache($userId = null): void
    {
        if ($userId) {
            $user = User::find($userId);
            if ($user && $user->isLeader() && $user->leaderRecord) {
                Cache::forget("dashboard_stats_leader_{$userId}");
            } else {
                Cache::forget("dashboard_stats_admin");
            }
        } else {
            // Clear admin cache
            Cache::forget("dashboard_stats_admin");
            // Note: Individual leader caches will expire naturally
        }
    }
}
