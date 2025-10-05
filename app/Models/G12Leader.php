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
     */
    public function getAllDescendantIds()
    {
        // Return cached value if available
        if ($this->descendantIdsCache !== null) {
            return $this->descendantIdsCache;
        }

        // Use Laravel cache for 1 hour (adjust as needed)
        $cacheKey = "g12_descendants_{$this->id}";
        
        $descendants = Cache::remember($cacheKey, 3600, function () {
            // Start with current leader ID
            $descendants = collect([$this->id]);
            
            // Use iterative approach with single query per level
            $currentLevelIds = [$this->id];
            
            while (!empty($currentLevelIds)) {
                // Get all children of current level in one query
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
     */
    public function getAllAncestorIds()
    {
        // Return cached value if available
        if ($this->ancestorIdsCache !== null) {
            return $this->ancestorIdsCache;
        }

        // Use Laravel cache for 1 hour (adjust as needed)
        $cacheKey = "g12_ancestors_{$this->id}";
        
        $ancestors = Cache::remember($cacheKey, 3600, function () {
            $ancestors = collect();
            
            // Use iterative approach instead of recursive
            $currentId = $this->parent_id;
            
            while ($currentId !== null) {
                $ancestors->push($currentId);
                
                // Get next parent in single query
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
            Cache::forget("g12_descendants_{$leaderId}");
            Cache::forget("g12_ancestors_{$leaderId}");
        } else {
            // Clear all G12 hierarchy caches
            Cache::flush();
        }
    }

    /**
     * Boot method to clear cache when hierarchy changes
     */
    protected static function booted()
    {
        // Clear cache when a leader is created, updated, or deleted
        static::saved(function ($leader) {
            static::clearHierarchyCache($leader->id);
            // Also clear parent and children caches
            if ($leader->parent_id) {
                static::clearHierarchyCache($leader->parent_id);
            }
        });

        static::deleted(function ($leader) {
            static::clearHierarchyCache($leader->id);
            if ($leader->parent_id) {
                static::clearHierarchyCache($leader->parent_id);
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
}
