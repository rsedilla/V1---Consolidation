<?php

namespace App\Traits;

trait HasSolScopes
{
    /**
     * Scope to filter by G12 leader through solProfile relationship
     */
    public function scopeForG12Leader($query, $g12LeaderId)
    {
        return $query->whereHas('solProfile', function ($q) use ($g12LeaderId) {
            $q->where('g12_leader_id', $g12LeaderId);
        });
    }

    /**
     * Scope to get records under specific leaders (hierarchy)
     */
    public function scopeUnderLeaders($query, array $leaderIds)
    {
        return $query->whereHas('solProfile', function ($q) use ($leaderIds) {
            $q->whereIn('g12_leader_id', $leaderIds);
        });
    }

    /**
     * Scope to get active (not graduated) records
     */
    public function scopeActive($query)
    {
        return $query->whereNull('graduation_date');
    }

    /**
     * Scope to get cell leaders through solProfile relationship
     */
    public function scopeCellLeaders($query)
    {
        return $query->whereHas('solProfile', function ($q) {
            $q->where('is_cell_leader', true);
        });
    }
}
