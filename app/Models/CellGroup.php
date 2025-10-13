<?php

namespace App\Models;


use App\Models\Traits\HasLessonCompletion;
use Illuminate\Database\Eloquent\Model;


class CellGroup extends Model
{
    use HasLessonCompletion;

    protected $fillable = [
        'member_id',
        'attendance_date',
        'notes',
        'cell_group_1_date',
        'cell_group_2_date',
        'cell_group_3_date',
        'cell_group_4_date'
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'cell_group_1_date' => 'date',
        'cell_group_2_date' => 'date',
        'cell_group_3_date' => 'date',
        'cell_group_4_date' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Define lesson fields for HasLessonCompletion trait
     * (Cell Groups tracks 4 sessions instead of lessons)
     */
    protected function getLessonFields(): array
    {
        return [
            'cell_group_1_date',
            'cell_group_2_date',
            'cell_group_3_date',
            'cell_group_4_date',
        ];
    }

    /**
     * Define total session count for HasLessonCompletion trait
     */
    protected function getLessonCount(): int
    {
        return 4;
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
     * Scope to get completed cell groups for members under specific leaders
     */
    public function scopeCompletedUnderLeaders($query, array $leaderIds)
    {
        return $query->completed()
            ->whereHas('member', function ($q) use ($leaderIds) {
                $q->underLeaders($leaderIds);
            });
    }
}
