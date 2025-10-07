<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LifeclassCandidate extends Model
{
    protected $fillable = [
        'member_id',
        'qualified_date',
        'notes'
    ];

    protected $casts = [
        'qualified_date' => 'date'
    ];

    /**
     * Get the member that this candidate belongs to
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Scope to filter candidates by G12 leader
     * Used for leader-specific data filtering
     */
    public function scopeForG12Leader($query, $g12LeaderId)
    {
        return $query->whereHas('member', function($q) use ($g12LeaderId) {
            $q->where('g12_leader_id', $g12LeaderId);
        });
    }

    /**
     * Scope to get candidates for members under specific leaders
     */
    public function scopeUnderLeaders($query, array $leaderIds)
    {
        return $query->whereHas('member', function ($q) use ($leaderIds) {
            $q->underLeaders($leaderIds);
        });
    }
}
