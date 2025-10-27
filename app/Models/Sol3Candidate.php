<?php

namespace App\Models;

use App\Models\Traits\HasLessonCompletion;
use App\Traits\HasSolScopes;
use App\Traits\HasSolLessonConfiguration;
use Illuminate\Database\Eloquent\Model;

class Sol3Candidate extends Model
{
    use HasLessonCompletion,
        HasSolScopes,
        HasSolLessonConfiguration;
    
    protected $table = 'sol_3_candidates';
    
    protected $fillable = [
        'sol_profile_id',
        'enrollment_date',
        'graduation_date',
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
        'notes',
    ];

    protected $casts = [
        'enrollment_date' => 'date',
        'graduation_date' => 'date',
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

    /**
     * Relationships
     */
    public function solProfile()
    {
        return $this->belongsTo(SolProfile::class, 'sol_profile_id');
    }
    
    // Alias for backward compatibility
    public function sol3()
    {
        return $this->solProfile();
    }

    // SOL scopes (ForG12Leader, UnderLeaders, Active, CellLeaders) are in HasSolScopes trait
    // Lesson configuration (getLessonFields, getLessonCount) is in HasSolLessonConfiguration trait

    /**
     * Scope to filter out candidates who have been promoted to SOL Graduate
     * Hides them from SOL 3 Progress (they appear in SOL Graduate instead)
     * Database records are preserved for history
     */
    public function scopeNotPromotedToSolGrad($query)
    {
        return $query->whereDoesntHave('solProfile', function ($q) {
            $q->where('current_sol_level_id', '>=', 4);
        });
    }

    /**
     * Check if this candidate has completed all lessons (for future SOL 4 or graduation)
     */
    public function isQualifiedForGraduation(): bool
    {
        return $this->isCompleted() && is_null($this->graduation_date);
    }

    /**
     * Check if this candidate has already graduated
     */
    public function hasGraduated(): bool
    {
        return !is_null($this->graduation_date);
    }

    /**
     * Check if the associated SOL Profile is at Graduate level
     */
    public function isAtGraduateLevel(): bool
    {
        return $this->solProfile && $this->solProfile->current_sol_level_id == 4;
    }
}
