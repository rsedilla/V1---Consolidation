<?php

namespace App\Traits;

trait HasTrainingProgressScopes
{
    /**
     * Scope to exclude members who already have New Life Training records
     * Useful for preventing duplicate entries when adding to New Life Training
     */
    public function scopeWithoutNewLifeTraining($query)
    {
        return $query->whereDoesntHave('startUpYourNewLife');
    }

    /**
     * Scope to exclude members who already have Sunday Service records
     * Useful for preventing duplicate entries when adding to Sunday Service
     */
    public function scopeWithoutSundayService($query)
    {
        return $query->whereDoesntHave('sundayServices');
    }

    /**
     * Scope to exclude members who already have Cell Group records
     * Useful for preventing duplicate entries when adding to Cell Group
     */
    public function scopeWithoutCellGroup($query)
    {
        return $query->whereDoesntHave('cellGroups');
    }

    /**
     * Scope to exclude members who are currently enrolled in Life Class
     * Used to hide completed training records once member progresses to Life Class
     */
    public function scopeNotInLifeClass($query)
    {
        return $query->whereDoesntHave('lifeclassCandidates');
    }

    /**
     * Scope to exclude members who have been promoted to SOL (any level)
     * Used to hide members who have graduated to SOL training
     */
    public function scopeNotInSol($query)
    {
        return $query->whereDoesntHave('solProfiles', function ($q) {
            $q->where('current_sol_level_id', '>=', 1);
        });
    }
}
