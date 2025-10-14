<?php

namespace App\Traits;

trait HasSolProfileHelpers
{
    /**
     * Get full name
     */
    public function getFullNameAttribute(): string
    {
        $parts = array_filter([
            $this->first_name,
            $this->middle_name,
            $this->last_name,
        ]);
        
        return implode(' ', $parts);
    }

    /**
     * Check if this student is qualified for SOL 2
     */
    public function isQualifiedForSol2(): bool
    {
        return $this->current_sol_level_id == 1 && 
               $this->sol1Candidate && 
               $this->sol1Candidate->isCompleted();
    }

    /**
     * Get completion progress for current level
     */
    public function getCompletionProgress(): array
    {
        // For SOL 1
        if ($this->current_sol_level_id == 1) {
            if (!$this->sol1Candidate) {
                return [
                    'completed' => 0,
                    'total' => 10,
                    'percentage' => 0,
                ];
            }

            return [
                'completed' => $this->sol1Candidate->getCompletionCount(),
                'total' => 10,
                'percentage' => $this->sol1Candidate->getCompletionPercentage(),
            ];
        }

        // For SOL 2
        if ($this->current_sol_level_id == 2) {
            if (!$this->sol2Candidate) {
                return [
                    'completed' => 0,
                    'total' => 10,
                    'percentage' => 0,
                ];
            }

            return [
                'completed' => $this->sol2Candidate->getCompletionCount(),
                'total' => 10,
                'percentage' => $this->sol2Candidate->getCompletionPercentage(),
            ];
        }

        // Future: SOL 3 and beyond
        return [
            'completed' => 0,
            'total' => 10,
            'percentage' => 0,
        ];
    }

    /**
     * Promote to next SOL level
     */
    public function promoteToNextLevel(): bool
    {
        if ($this->current_sol_level_id >= 3) {
            return false; // Already at max level
        }

        $this->current_sol_level_id++;
        return $this->save();
    }
}
