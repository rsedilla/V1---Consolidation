<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait HasHierarchyTraversal
{
    /**
     * Cache for descendant IDs to avoid repeated queries
     */
    private $descendantIdsCache = null;

    /**
     * Cache for ancestor IDs to avoid repeated queries
     */
    private $ancestorIdsCache = null;

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
     * Check if this leader is a descendant of another leader
     */
    public function isDescendantOf($leader)
    {
        return in_array($leader->id, $this->getAllAncestorIds());
    }

    /**
     * Check if this leader is an ancestor of another leader
     */
    public function isAncestorOf($leader)
    {
        return in_array($this->id, $leader->getAllAncestorIds());
    }
}
