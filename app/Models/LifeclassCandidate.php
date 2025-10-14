<?php

namespace App\Models;

use App\Models\Traits\HasLessonCompletion;
use Illuminate\Database\Eloquent\Model;

class LifeclassCandidate extends Model
{
    use HasLessonCompletion;
    protected $fillable = [
        'sol_profile_id',
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
     * Get the SOL profile that this candidate belongs to
     */
    public function solProfile()
    {
        return $this->belongsTo(SolProfile::class, 'sol_profile_id');
    }

    /**
     * Get the member that this candidate belongs to (if linked)
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Scope to filter candidates by G12 leader
     * Used for leader-specific data filtering
     * Checks both member.g12_leader_id and solProfile.g12_leader_id
     */
    public function scopeForG12Leader($query, $g12LeaderId)
    {
        return $query->where(function($q) use ($g12LeaderId) {
            $q->whereHas('member', function($subQ) use ($g12LeaderId) {
                $subQ->where('g12_leader_id', $g12LeaderId);
            })
            ->orWhereHas('solProfile', function($subQ) use ($g12LeaderId) {
                $subQ->where('g12_leader_id', $g12LeaderId);
            });
        });
    }

    /**
     * Scope to get candidates for members under specific leaders
     * Checks both member.g12_leader_id and solProfile.g12_leader_id
     */
    public function scopeUnderLeaders($query, array $leaderIds)
    {
        return $query->where(function($q) use ($leaderIds) {
            $q->whereHas('member', function ($subQ) use ($leaderIds) {
                $subQ->underLeaders($leaderIds);
            })
            ->orWhereHas('solProfile', function($subQ) use ($leaderIds) {
                $subQ->whereIn('g12_leader_id', $leaderIds);
            });
        });
    }

    /**
     * Scope to get only candidates who have NOT been promoted to SOL
     * Filters out students who are already in any SOL level (1, 2, 3, etc.)
     * They should only appear in their respective SOL level tables
     * 
     * For candidates with solProfile: checks if current_sol_level_id is still 0 (Life Class)
     * For candidates with member only: checks if they don't have any SOL profiles
     */
    public function scopeNotPromotedToSol1($query)
    {
        return $query->where(function($q) {
            // Case 1: Has solProfile - check if still at Life Class level (level_number = 0)
            $q->whereHas('solProfile', function($subQ) {
                $lifeClassLevel = \App\Models\SolLevel::where('level_number', 0)->first();
                if ($lifeClassLevel) {
                    $subQ->where('current_sol_level_id', $lifeClassLevel->id);
                }
            })
            // Case 2: Has member but no SOL profile - not promoted yet
            ->orWhere(function($subQ) {
                $subQ->whereNotNull('member_id')
                     ->whereDoesntHave('member.solProfiles');
            });
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
     * Check if this candidate has been promoted to SOL (any level)
     */
    public function isPromotedToSol1(): bool
    {
        return \App\Models\SolProfile::where('member_id', $this->member_id)
            ->exists();
    }
}
