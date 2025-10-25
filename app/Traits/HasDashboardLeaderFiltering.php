<?php

namespace App\Traits;

use App\Models\G12Leader;
use Illuminate\Support\Collection;

trait HasDashboardLeaderFiltering
{
    /**
     * Get leaders to display based on user role
     * Users with leader records see their direct children
     * Admin without leader record sees top-level leaders (direct 12 of root)
     */
    protected function getDisplayLeaders($user): Collection
    {
        // Check if user has a leader record (covers Leader and Equipping roles)
        if ($user->leaderRecord) {
            return $this->getDirectChildren($user->leaderRecord->id);
        } elseif ($user->isAdmin()) {
            return $this->getTopLevelLeaders();
        }
        
        return collect();
    }
    
    /**
     * Get top-level leaders (direct children of root leader)
     */
    protected function getTopLevelLeaders(): Collection
    {
        $rootLeader = G12Leader::whereNull('parent_id')->first();
        
        if ($rootLeader) {
            // Get direct children of the root leader only
            return G12Leader::with('user')
                ->where('parent_id', $rootLeader->id)
                ->whereHas('user')
                ->get()
                ->sortBy(fn($leader) => $leader->user->name ?? '');
        }
        
        // Fallback: if no root, show top-level leaders (those without parents)
        return G12Leader::with('user')
            ->whereNull('parent_id')
            ->whereHas('user')
            ->get()
            ->sortBy(fn($leader) => $leader->user->name ?? '');
    }
    
    /**
     * Get direct children of a specific leader
     */
    protected function getDirectChildren(int $parentId): Collection
    {
        return G12Leader::with('user')
            ->where('parent_id', $parentId)
            ->whereHas('user')
            ->get()
            ->sortBy(fn($leader) => $leader->user->name ?? '');
    }
    
    /**
     * Get visible leader IDs for the current user
     * Returns null for admin (sees all), array of IDs for leaders
     */
    protected function getVisibleLeaderIds($user): ?array
    {
        if ($user->isAdmin()) {
            return null; // Admin sees all
        } elseif ($user->isLeader() && $user->leaderRecord) {
            return $user->leaderRecord->getAllDescendantIds();
        }
        
        return [];
    }
}
