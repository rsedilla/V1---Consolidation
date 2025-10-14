<?php

namespace App\Traits;

trait HasSolProfileScopes
{
    /**
     * Scope to filter by G12 leader (direct)
     */
    public function scopeForG12Leader($query, $g12LeaderId)
    {
        return $query->where('g12_leader_id', $g12LeaderId);
    }

    /**
     * Scope to get records under specific leaders (hierarchy)
     */
    public function scopeUnderLeaders($query, array $leaderIds)
    {
        return $query->whereIn('g12_leader_id', $leaderIds);
    }

    /**
     * Scope to get active records
     */
    public function scopeActive($query)
    {
        return $query->whereHas('status', function ($q) {
            $q->where('name', '!=', 'Inactive');
        });
    }

    /**
     * Scope to get cell leaders only
     */
    public function scopeCellLeaders($query)
    {
        return $query->where('is_cell_leader', true);
    }

    /**
     * Scope by SOL level
     */
    public function scopeAtLevel($query, int $levelNumber)
    {
        return $query->whereHas('currentSolLevel', function ($q) use ($levelNumber) {
            $q->where('level_number', $levelNumber);
        });
    }
}
