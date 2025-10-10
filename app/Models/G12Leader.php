<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class G12Leader extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'parent_id',
    ];

    /**
     * Cache for descendant IDs to avoid repeated queries
     */
    private $descendantIdsCache = null;

    /**
     * Cache for ancestor IDs to avoid repeated queries
     */
    private $ancestorIdsCache = null;

    /**
     * Get the user account for this G12 leader (if they have login access)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all members under this G12 leader
     */
    public function members()
    {
        return $this->hasMany(Member::class);
    }

    /**
     * Get the parent G12 leader (if any)
     */
    public function parent()
    {
        return $this->belongsTo(G12Leader::class, 'parent_id');
    }

    /**
     * Get direct child G12 leaders
     */
    public function children()
    {
        return $this->hasMany(G12Leader::class, 'parent_id');
    }

    /**
     * Get all descendant G12 leader IDs (optimized with caching)
     * Cache duration: 1 hour (3600 seconds)
     */
    public function getAllDescendantIds()
    {
        // Return cached value if available
        if ($this->descendantIdsCache !== null) {
            return $this->descendantIdsCache;
        }

        // Use Laravel cache (1 hour TTL)
        $cacheKey = "g12_descendants_{$this->id}";
        
        $descendants = Cache::remember($cacheKey, 3600, function () {
            // Start with current leader ID
            $descendants = collect([$this->id]);
            
            // Use iterative approach with single query per level
            $currentLevelIds = [$this->id];
            
            while (!empty($currentLevelIds)) {
                // Get all children of current level in one query (indexed)
                $nextLevelIds = static::whereIn('parent_id', $currentLevelIds)
                    ->pluck('id')
                    ->toArray();
                
                if (empty($nextLevelIds)) {
                    break;
                }
                
                // Add to descendants
                $descendants = $descendants->merge($nextLevelIds);
                
                // Move to next level
                $currentLevelIds = $nextLevelIds;
            }
            
            return $descendants->unique()->values()->toArray();
        });

        // Store in instance cache
        $this->descendantIdsCache = $descendants;
        
        return $descendants;
    }

    /**
     * Get all ancestor G12 leader IDs (optimized with caching)
     * Cache duration: 1 hour (3600 seconds)
     */
    public function getAllAncestorIds()
    {
        // Return cached value if available
        if ($this->ancestorIdsCache !== null) {
            return $this->ancestorIdsCache;
        }

        // Use Laravel cache (1 hour TTL)
        $cacheKey = "g12_ancestors_{$this->id}";
        
        $ancestors = Cache::remember($cacheKey, 3600, function () {
            $ancestors = collect();
            
            // Use iterative approach instead of recursive
            $currentId = $this->parent_id;
            
            while ($currentId !== null) {
                $ancestors->push($currentId);
                
                // Get next parent in single query (now indexed)
                $parent = static::find($currentId);
                $currentId = $parent ? $parent->parent_id : null;
            }
            
            return $ancestors->unique()->values()->toArray();
        });

        // Store in instance cache
        $this->ancestorIdsCache = $ancestors;
        
        return $ancestors;
    }

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
     * Check if this leader is a descendant of another leader
     */
    public function isDescendantOf(G12Leader $leader)
    {
        return in_array($leader->id, $this->getAllAncestorIds());
    }

    /**
     * Check if this leader is an ancestor of another leader
     */
    public function isAncestorOf(G12Leader $leader)
    {
        return in_array($this->id, $leader->getAllAncestorIds());
    }

    /**
     * Get all members visible to this G12 leader (including descendants)
     */
    public function getAllVisibleMembers()
    {
        $visibleLeaderIds = $this->getAllDescendantIds();
        return Member::whereIn('g12_leader_id', $visibleLeaderIds)->get();
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
