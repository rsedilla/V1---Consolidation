<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ManagesHierarchyCache
{
    /**
     * Clear the hierarchy cache for this leader and all related leaders
     */
    public static function clearHierarchyCache($leaderId = null)
    {
        if ($leaderId) {
            // Clear specific leader's cache
            Cache::forget("g12_descendants_{$leaderId}");
            Cache::forget("g12_ancestors_{$leaderId}");
        } else {
            // Clear all G12 hierarchy caches (pattern-based)
            // Note: This requires iterating all leaders, but it's rarely called
            $allLeaderIds = static::pluck('id');
            foreach ($allLeaderIds as $id) {
                Cache::forget("g12_descendants_{$id}");
                Cache::forget("g12_ancestors_{$id}");
            }
        }
    }

    /**
     * Boot method to clear cache when hierarchy changes
     */
    protected static function booted()
    {
        // Clear cache when a leader is created, updated, or deleted
        static::saved(function ($leader) {
            // Clear this leader's cache
            static::clearHierarchyCache($leader->id);
            
            // Clear parent and children caches
            if ($leader->parent_id) {
                static::clearHierarchyCache($leader->parent_id);
            }
            
            // If parent_id changed, clear old parent's cache too
            if ($leader->isDirty('parent_id') && $leader->getOriginal('parent_id')) {
                static::clearHierarchyCache($leader->getOriginal('parent_id'));
            }
            
            // Clear User caches for users assigned to this leader
            if ($leader->user_id) {
                \App\Models\User::clearUserCache($leader->user_id);
            }
            
            // Clear all users under this leader's hierarchy
            $users = \App\Models\User::where('g12_leader_id', $leader->id)->get();
            foreach ($users as $user) {
                \App\Models\User::clearUserCache($user->id);
            }
        });

        static::deleted(function ($leader) {
            // Clear this leader's cache
            static::clearHierarchyCache($leader->id);
            
            // Clear parent's cache
            if ($leader->parent_id) {
                static::clearHierarchyCache($leader->parent_id);
            }
            
            // Clear User caches
            if ($leader->user_id) {
                \App\Models\User::clearUserCache($leader->user_id);
            }
        });
    }

    /**
     * Warm the hierarchy cache for all root leaders
     * Call this on application boot or after major hierarchy changes
     * to prevent cold cache performance penalties
     */
    public static function warmHierarchyCache()
    {
        // Find all root leaders (no parent)
        $rootLeaders = static::whereNull('parent_id')->get();
        
        $cachedCount = 0;
        foreach ($rootLeaders as $leader) {
            // This will populate the cache
            $leader->getAllDescendantIds();
            $cachedCount++;
        }
        
        return $cachedCount;
    }
    
    /**
     * Get cache statistics for monitoring
     */
    public static function getCacheStats(): array
    {
        $allLeaders = static::all();
        $cachedDescendants = 0;
        $cachedAncestors = 0;
        
        foreach ($allLeaders as $leader) {
            if (Cache::has("g12_descendants_{$leader->id}")) {
                $cachedDescendants++;
            }
            if (Cache::has("g12_ancestors_{$leader->id}")) {
                $cachedAncestors++;
            }
        }
        
        return [
            'total_leaders' => $allLeaders->count(),
            'cached_descendants' => $cachedDescendants,
            'cached_ancestors' => $cachedAncestors,
            'cache_hit_rate_descendants' => $allLeaders->count() > 0 
                ? round(($cachedDescendants / $allLeaders->count()) * 100, 2) 
                : 0,
            'cache_hit_rate_ancestors' => $allLeaders->count() > 0 
                ? round(($cachedAncestors / $allLeaders->count()) * 100, 2) 
                : 0,
        ];
    }
}
