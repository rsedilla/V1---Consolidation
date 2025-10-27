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
     * Check if this student is qualified for SOL 3
     */
    public function isQualifiedForSol3(): bool
    {
        return $this->current_sol_level_id == 2 && 
               $this->sol2Candidate && 
               $this->sol2Candidate->isCompleted();
    }

    /**
     * Check if this student is qualified for SOL Grad (graduation)
     */
    public function isQualifiedForSolGrad(): bool
    {
        return $this->current_sol_level_id == 3 && 
               $this->sol3Candidate && 
               $this->sol3Candidate->isCompleted();
    }

    /**
     * Check if this student has graduated (SOL Grad)
     */
    public function isGraduated(): bool
    {
        return $this->current_sol_level_id == 4;
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

        // For SOL 3
        if ($this->current_sol_level_id == 3) {
            if (!$this->sol3Candidate) {
                return [
                    'completed' => 0,
                    'total' => 10,
                    'percentage' => 0,
                ];
            }

            return [
                'completed' => $this->sol3Candidate->getCompletionCount(),
                'total' => 10,
                'percentage' => $this->sol3Candidate->getCompletionPercentage(),
            ];
        }

        // For SOL Grad (level 4) - already graduated, no more lessons
        if ($this->current_sol_level_id == 4) {
            return [
                'completed' => 10,
                'total' => 10,
                'percentage' => 100,
                'graduated' => true,
            ];
        }

        // Future: SOL 5 and beyond
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
        if ($this->current_sol_level_id >= 4) {
            return false; // Already graduated
        }

        $this->current_sol_level_id++;
        return $this->save();
    }
}
