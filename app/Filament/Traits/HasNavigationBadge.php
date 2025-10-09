<?php

namespace App\Filament\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

trait HasNavigationBadge
{
    /**
     * Get navigation badge showing count of records
     * Override this method in the resource if custom badge key is needed
     */
    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();
        $badgeKey = static::getNavigationBadgeCacheKey();
        
        // Cache badge count for 5 minutes per user
        $cacheKey = $user instanceof User && $user->isLeader() && $user->leaderRecord
            ? "{$badgeKey}_leader_{$user->id}"
            : "{$badgeKey}_admin";
        
        return Cache::remember($cacheKey, 300, function () {
            // Use the resource's own query filtering logic
            return static::getEloquentQuery()->count();
        });
    }
    
    /**
     * Clear navigation badge cache for a specific user or all users
     */
    public static function clearNavigationBadgeCache($userId = null): void
    {
        $badgeKey = static::getNavigationBadgeCacheKey();
        
        if ($userId) {
            Cache::forget("{$badgeKey}_leader_{$userId}");
        } else {
            Cache::forget("{$badgeKey}_admin");
        }
    }
    
    /**
     * Get the cache key prefix for this resource's navigation badge
     * Override this in each resource to provide a unique key
     * 
     * @return string
     */
    abstract protected static function getNavigationBadgeCacheKey(): string;
}
