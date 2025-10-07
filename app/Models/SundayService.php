<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SundayService extends Model
{
    protected $fillable = [
        'member_id',
        'service_date',
        'completed',
        'notes',
        'sunday_service_1_date',
        'sunday_service_2_date',
        'sunday_service_3_date',
        'sunday_service_4_date'
    ];

    protected $casts = [
        'service_date' => 'date',
        'completed' => 'boolean',
        'sunday_service_1_date' => 'date',
        'sunday_service_2_date' => 'date',
        'sunday_service_3_date' => 'date',
        'sunday_service_4_date' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Scope to filter by G12 leader through member relationship
     */
    public function scopeForG12Leader($query, $g12LeaderId)
    {
        return $query->whereHas('member', function ($q) use ($g12LeaderId) {
            $q->where('g12_leader_id', $g12LeaderId);
        });
    }

    /**
     * Scope to get records where ALL 4 Sunday services are completed
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('sunday_service_1_date')
            ->whereNotNull('sunday_service_2_date')
            ->whereNotNull('sunday_service_3_date')
            ->whereNotNull('sunday_service_4_date');
    }

    /**
     * Scope to get completed services for members under specific leaders
     */
    public function scopeCompletedUnderLeaders($query, array $leaderIds)
    {
        return $query->completed()
            ->whereHas('member', function ($q) use ($leaderIds) {
                $q->underLeaders($leaderIds);
            });
    }
}
