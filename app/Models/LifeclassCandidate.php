<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LifeclassCandidate extends Model
{
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
     * Scope to get records where ALL 9 lessons are completed
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('lesson_1_completion_date')
            ->whereNotNull('lesson_2_completion_date')
            ->whereNotNull('lesson_3_completion_date')
            ->whereNotNull('lesson_4_completion_date')
            ->whereNotNull('encounter_completion_date')
            ->whereNotNull('lesson_6_completion_date')
            ->whereNotNull('lesson_7_completion_date')
            ->whereNotNull('lesson_8_completion_date')
            ->whereNotNull('lesson_9_completion_date');
    }

    /**
     * Check if all 9 Life Class lessons are completed
     */
    public function isCompleted(): bool
    {
        return !is_null($this->lesson_1_completion_date) &&
               !is_null($this->lesson_2_completion_date) &&
               !is_null($this->lesson_3_completion_date) &&
               !is_null($this->lesson_4_completion_date) &&
               !is_null($this->encounter_completion_date) &&
               !is_null($this->lesson_6_completion_date) &&
               !is_null($this->lesson_7_completion_date) &&
               !is_null($this->lesson_8_completion_date) &&
               !is_null($this->lesson_9_completion_date);
    }

    /**
     * Get completion count (how many lessons completed out of 9)
     */
    public function getCompletionCount(): int
    {
        $count = 0;
        $lessons = [
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

        foreach ($lessons as $lesson) {
            if (!is_null($this->$lesson)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Get completion percentage
     */
    public function getCompletionPercentage(): float
    {
        return ($this->getCompletionCount() / 9) * 100;
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
