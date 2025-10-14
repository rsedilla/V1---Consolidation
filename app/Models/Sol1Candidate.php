<?php

namespace App\Models;

use App\Models\Traits\HasLessonCompletion;
use Illuminate\Database\Eloquent\Model;

class Sol1Candidate extends Model
{
    use HasLessonCompletion;
    protected $table = 'sol_1_candidates';
    
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
    public function sol1()
    {
        return $this->solProfile();
    }

    /**
     * Scopes
     */
    
    /**
     * Scope to filter by G12 leader through solProfile relationship
     */
    public function scopeForG12Leader($query, $g12LeaderId)
    {
        return $query->whereHas('solProfile', function ($q) use ($g12LeaderId) {
            $q->where('g12_leader_id', $g12LeaderId);
        });
    }

    /**
     * Scope to get records under specific leaders (hierarchy)
     */
    public function scopeUnderLeaders($query, array $leaderIds)
    {
        return $query->whereHas('solProfile', function ($q) use ($leaderIds) {
            $q->whereIn('g12_leader_id', $leaderIds);
        });
    }

    /**
     * Define lesson fields for HasLessonCompletion trait
     * SOL 1 has 10 lessons: L1-L10
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
     * Scope to get active (not graduated) records
     */
    public function scopeActive($query)
    {
        return $query->whereNull('graduation_date');
    }

    /**
     * Scope to get records that are qualified for SOL 2 (completed all 10 lessons but not graduated)
     */
    public function scopeQualifiedForSol2($query)
    {
        return $query->completed()->whereNull('graduation_date');
    }

    /**
     * Scope to get cell leaders through solProfile relationship
     */
    public function scopeCellLeaders($query)
    {
        return $query->whereHas('solProfile', function ($q) {
            $q->where('is_cell_leader', true);
        });
    }

    /**
     * Scope to filter out candidates who have been promoted to SOL 2
     * Hides them from SOL 1 Progress (they appear in SOL 2 Progress instead)
     * Database records are preserved for history
     */
    public function scopeNotPromotedToSol2($query)
    {
        return $query->whereDoesntHave('solProfile', function ($q) {
            $q->where('current_sol_level_id', '>=', 2);
        });
    }

    /**
     * Check if qualified for SOL 2 promotion
     */
    public function isQualifiedForSol2(): bool
    {
        return $this->isCompleted() && is_null($this->graduation_date);
    }

    /**
     * Check if already promoted to SOL 2
     */
    public function isPromotedToSol2(): bool
    {
        return !is_null($this->graduation_date) && 
               Sol2Candidate::where('sol_profile_id', $this->sol_profile_id)->exists();
    }
}
