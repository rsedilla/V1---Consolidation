<?php

namespace App\Models;

use App\Models\Traits\HasLessonCompletion;
use App\Traits\HasSolScopes;
use App\Traits\HasSolLessonConfiguration;
use Illuminate\Database\Eloquent\Model;

class Sol2Candidate extends Model
{
    use HasLessonCompletion,
        HasSolScopes,
        HasSolLessonConfiguration;
    
    protected $table = 'sol_2_candidates';
    
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
    public function sol2()
    {
        return $this->solProfile();
    }

    // SOL scopes (ForG12Leader, UnderLeaders, Active, CellLeaders) are in HasSolScopes trait
    // Lesson configuration (getLessonFields, getLessonCount) is in HasSolLessonConfiguration trait

    /**
     * Scope to get records that are qualified for SOL 3 (completed all 10 lessons but not graduated)
     */
    public function scopeQualifiedForSol3($query)
    {
        return $query->completed()->whereNull('graduation_date');
    }

    /**
     * Scope to filter out candidates who have been promoted to SOL 3
     * Hides them from SOL 2 Progress (they appear in SOL 3 Progress instead)
     * Database records are preserved for history
     */
    public function scopeNotPromotedToSol3($query)
    {
        return $query->whereDoesntHave('solProfile', function ($q) {
            $q->where('current_sol_level_id', '>=', 3);
        });
    }

    /**
     * Check if qualified for SOL 3 promotion
     */
    public function isQualifiedForSol3(): bool
    {
        return $this->isCompleted() && is_null($this->graduation_date);
    }

    /**
     * Check if already promoted to SOL 3
     */
    public function isPromotedToSol3(): bool
    {
        return !is_null($this->graduation_date) && 
               Sol3Candidate::where('sol_profile_id', $this->sol_profile_id)->exists();
    }
}
