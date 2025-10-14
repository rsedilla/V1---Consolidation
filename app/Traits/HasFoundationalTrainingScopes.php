<?php

namespace App\Traits;

trait HasFoundationalTrainingScopes
{
    /**
     * Scope to filter by G12 leader through member relationship
     * Used across all foundational training models (New Life, Sunday Service, Cell Group)
     */
    public function scopeForG12Leader($query, $g12LeaderId)
    {
        return $query->whereHas('member', function ($q) use ($g12LeaderId) {
            $q->where('g12_leader_id', $g12LeaderId);
        });
    }

    /**
     * Scope to get completed training for members under specific leaders
     * Used for hierarchy-based filtering (admin/leader/equipping roles)
     */
    public function scopeCompletedUnderLeaders($query, array $leaderIds)
    {
        return $query->completed()
            ->whereHas('member', function ($q) use ($leaderIds) {
                $q->underLeaders($leaderIds);
            });
    }

    /**
     * Scope to get completed training for VIP members under specific leaders
     * Useful for reports and filtering VIP-specific progress
     */
    public function scopeCompletedForVipsUnderLeaders($query, array $leaderIds)
    {
        return $query->completed()
            ->whereHas('member', function ($q) use ($leaderIds) {
                $q->vips()->underLeaders($leaderIds);
            });
    }
}
