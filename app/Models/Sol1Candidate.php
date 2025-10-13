<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sol1Candidate extends Model
{
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
     * Scope to get completed records (all 10 lessons done)
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('lesson_1_completion_date')
            ->whereNotNull('lesson_2_completion_date')
            ->whereNotNull('lesson_3_completion_date')
            ->whereNotNull('lesson_4_completion_date')
            ->whereNotNull('lesson_5_completion_date')
            ->whereNotNull('lesson_6_completion_date')
            ->whereNotNull('lesson_7_completion_date')
            ->whereNotNull('lesson_8_completion_date')
            ->whereNotNull('lesson_9_completion_date')
            ->whereNotNull('lesson_10_completion_date');
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
     * Helper Methods
     */
    
    /**
     * Check if all 10 SOL 1 lessons are completed
     */
    public function isCompleted(): bool
    {
        return !is_null($this->lesson_1_completion_date) &&
               !is_null($this->lesson_2_completion_date) &&
               !is_null($this->lesson_3_completion_date) &&
               !is_null($this->lesson_4_completion_date) &&
               !is_null($this->lesson_5_completion_date) &&
               !is_null($this->lesson_6_completion_date) &&
               !is_null($this->lesson_7_completion_date) &&
               !is_null($this->lesson_8_completion_date) &&
               !is_null($this->lesson_9_completion_date) &&
               !is_null($this->lesson_10_completion_date);
    }

    /**
     * Get completion count (how many lessons completed out of 10)
     */
    public function getCompletionCount(): int
    {
        $count = 0;
        $lessons = [
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
        return ($this->getCompletionCount() / 10) * 100;
    }

    /**
     * Check if qualified for SOL 2 promotion
     */
    public function isQualifiedForSol2(): bool
    {
        return $this->isCompleted() && is_null($this->graduation_date);
    }
}
