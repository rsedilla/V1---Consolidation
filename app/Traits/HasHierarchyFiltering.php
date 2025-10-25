<?php

namespace App\Traits;

use App\Models\G12Leader;
use App\Models\Member;
use Illuminate\Support\Facades\Cache;

trait HasHierarchyFiltering
{
    /**
     * Instance cache for visible leader IDs to prevent duplicate queries in same request
     */
    private $visibleLeaderIdsCache = null;

    /**
     * Get visible leader IDs for data filtering based on user role
     * - Admin: See all leaders (returns empty array, no filtering)
     * - Equipping: See their own hierarchy if they have a leader record (same as Leader role)
     * - Leader: See their own hierarchy (including descendants)
     * - User: No access (returns empty array)
     * 
     * @return array Array of G12Leader IDs that the user can access
     */
    public function getVisibleLeaderIdsForFiltering(): array
    {
        // Admin sees everything - no filtering needed
        if ($this->isAdmin()) {
            return [];
        }

        // Equipping users see their own hierarchy (if they have a leader record)
        // Just like Leaders, they maintain their own hierarchy boundaries
        if ($this->isEquipping() && $this->leaderRecord) {
            return $this->getVisibleLeaderIds();
        }

        // Leaders see their own hierarchy
        if ($this->isLeader() && $this->leaderRecord) {
            return $this->getVisibleLeaderIds();
        }

        // Regular users have no access
        return [];
    }

    /**
     * Check if equipping user can access data for a specific member
     * 
     * @param Member $member The member to check access for
     * @return bool True if user can access the member's data
     */
    public function canAccessMemberData(Member $member): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if ($this->isEquipping() && $this->assignedLeader) {
            $visibleLeaderIds = $this->getVisibleLeaderIdsForFiltering();
            return in_array($member->g12_leader_id, $visibleLeaderIds);
        }

        if ($this->isLeader() && $this->leaderRecord) {
            $visibleLeaderIds = $this->getVisibleLeaderIds();
            return in_array($member->g12_leader_id, $visibleLeaderIds);
        }

        return false;
    }

    /**
     * Get cached visible leader IDs to prevent duplicate hierarchy traversal in same request
     */
    private function getVisibleLeaderIds(): array
    {
        if ($this->visibleLeaderIdsCache === null) {
            $this->visibleLeaderIdsCache = $this->leaderRecord->getAllDescendantIds();
        }
        return $this->visibleLeaderIdsCache;
    }

    /**
     * Get all members visible to this user based on hierarchy
     */
    public function getVisibleMembers()
    {
        if ($this->isAdmin()) {
            return Member::query();
        }
        
        if ($this->leaderRecord) {
            $visibleLeaderIds = $this->getVisibleLeaderIds();
            return Member::whereIn('g12_leader_id', $visibleLeaderIds);
        }

        return Member::where('id', '=', 0);
    }

    /**
     * Check if user can view a specific member
     */
    public function canViewMember(Member $member): bool
    {
        if ($this->isAdmin()) {
            return true;
        }
        
        if ($this->leaderRecord) {
            $visibleLeaderIds = $this->getVisibleLeaderIds();
            return in_array($member->g12_leader_id, $visibleLeaderIds);
        }

        return false;
    }

    /**
     * Check if user can edit a specific member
     */
    public function canEditMember(Member $member): bool
    {
        return $this->canViewMember($member);
    }
}
