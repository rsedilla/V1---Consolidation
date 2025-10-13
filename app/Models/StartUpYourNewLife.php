<?php

namespace App\Models;

use App\Models\Traits\HasLessonCompletion;
use Illuminate\Database\Eloquent\Model;

class StartUpYourNewLife extends Model
{
    use HasLessonCompletion;

    protected $table = 'start_up_your_new_life';
    
    protected $fillable = [
        'member_id',
        'notes',
        'lesson_1_completion_date',
        'lesson_2_completion_date',
        'lesson_3_completion_date',
        'lesson_4_completion_date',
        'lesson_5_completion_date',
        'lesson_6_completion_date',
        'lesson_7_completion_date',
        'lesson_8_completion_date',
        'lesson_9_completion_date',
        'lesson_10_completion_date',
    ];

    protected $casts = [
        'lesson_1_completion_date' => 'date',
        'lesson_2_completion_date' => 'date',
        'lesson_3_completion_date' => 'date',
        'lesson_4_completion_date' => 'date',
        'lesson_5_completion_date' => 'date',
        'lesson_6_completion_date' => 'date',
        'lesson_7_completion_date' => 'date',
        'lesson_8_completion_date' => 'date',
        'lesson_9_completion_date' => 'date',
        'lesson_10_completion_date' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Define lesson fields for HasLessonCompletion trait
     */
    protected function getLessonFields(): array
    {
        return [
            'lesson_1_completion_date',
            'lesson_2_completion_date',
            'lesson_3_completion_date',
            'lesson_4_completion_date',
            'lesson_5_completion_date',
            'lesson_6_completion_date',
            'lesson_7_completion_date',
            'lesson_8_completion_date',
            'lesson_9_completion_date',
            'lesson_10_completion_date',
        ];
    }

    /**
     * Define total lesson count for HasLessonCompletion trait
     */
    protected function getLessonCount(): int
    {
        return 10;
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
     * Scope to get completed lessons for VIP members under specific leaders
     */
    public function scopeCompletedForVipsUnderLeaders($query, array $leaderIds)
    {
        return $query->completed()
            ->whereHas('member', function ($q) use ($leaderIds) {
                $q->vips()->underLeaders($leaderIds);
            });
    }
}
