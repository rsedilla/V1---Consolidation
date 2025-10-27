<?php

namespace App\Models;

use App\Traits\HasSolProfileScopes;
use Illuminate\Database\Eloquent\Builder;

/**
 * SolGraduate Model
 * 
 * This is a specialized view of SolProfile records where current_sol_level_id = 4 (Graduate)
 * It provides a focused interface for managing SOL graduates without creating a separate table.
 */
class SolGraduate extends SolProfile
{
    use HasSolProfileScopes;
    
    protected $table = 'sol_profiles';

    /**
     * Boot the model and apply global scope to only show graduates
     */
    protected static function booted(): void
    {
        parent::booted();
        
        static::addGlobalScope('graduates_only', function (Builder $builder) {
            $builder->where('current_sol_level_id', 4); // SOL Graduate level
        });
    }

    /**
     * Relationships
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function g12Leader()
    {
        return $this->belongsTo(G12Leader::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function currentSolLevel()
    {
        return $this->belongsTo(SolLevel::class, 'current_sol_level_id');
    }

    public function sol3Candidate()
    {
        return $this->hasOne(Sol3Candidate::class, 'sol_profile_id');
    }

    /**
     * Get the full name of the graduate
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
     * Check if this graduate is a cell leader
     */
    public function isCellLeader(): bool
    {
        return (bool) $this->is_cell_leader;
    }

    /**
     * Get the graduation date from SOL 3 candidate record
     */
    public function getGraduationDate()
    {
        return $this->sol3Candidate?->graduation_date;
    }
}
