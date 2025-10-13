<?php

namespace App\Models;

use App\Models\Traits\HasLessonCompletion;
use Illuminate\Database\Eloquent\Model;

class LifeclassCandidate extends Model
{
    use HasLessonCompletion;
    protected $fillable = [
        'member_id',
        'life_class_party_date',
        'lesson_1_completion_date',
        'lesson_2_completion_date',
        'lesson_3_completion_date',
        'lesson_4_completion_date',
        'encounter_completion_date',
        'lesson_6_completion_date',
        'lesson_7_completion_date',
        'lesson_8_completion_date',
        'lesson_9_completion_date',
        'graduation_date',
        'notes'
    ];

    protected $casts = [
        'life_class_party_date' => 'date',
        'lesson_1_completion_date' => 'date',
        'lesson_2_completion_date' => 'date',
        'lesson_3_completion_date' => 'date',
        'lesson_4_completion_date' => 'date',
        'encounter_completion_date' => 'date',
        'lesson_6_completion_date' => 'date',
        'lesson_7_completion_date' => 'date',
        'lesson_8_completion_date' => 'date',
        'lesson_9_completion_date' => 'date',
        'graduation_date' => 'date',
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

    /**
     * Define lesson fields for HasLessonCompletion trait
     * Life Class has 9 lessons: L1-L4, Encounter, L6-L9 (no L5)
     */
    protected function getLessonFields(): array
    {
        return [
            'lesson_1_completion_date',
            'lesson_2_completion_date',
            'lesson_3_completion_date',
            'lesson_4_completion_date',
            'encounter_completion_date',
            'lesson_6_completion_date',
            'lesson_7_completion_date',
            'lesson_8_completion_date',
            'lesson_9_completion_date',
        ];
    }

    /**
     * Define total lesson count for HasLessonCompletion trait
     */
    protected function getLessonCount(): int
    {
        return 9;
    }

    /**
     * Check if this candidate has been promoted to SOL 1
     */
    public function isPromotedToSol1(): bool
    {
        return \App\Models\SolProfile::where('member_id', $this->member_id)
            ->where('current_sol_level_id', 1)
            ->exists();
    }
}
