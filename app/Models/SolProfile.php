<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolProfile extends Model
{
    protected $table = 'sol_profiles';
    
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'birthday',
        'email',
        'phone',
        'address',
        'status_id',
        'g12_leader_id',
        'wedding_anniversary_date',
        'is_cell_leader',
        'member_id',
        'current_sol_level_id',
        'notes',
    ];

    protected $casts = [
        'birthday' => 'date',
        'wedding_anniversary_date' => 'date',
        'is_cell_leader' => 'boolean',
    ];

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

    public function sol1Candidate()
    {
        return $this->hasOne(Sol1Candidate::class, 'sol_profile_id');
    }

    public function sol2Candidate()
    {
        return $this->hasOne(Sol2Candidate::class, 'sol_profile_id');
    }

    /**
     * Scopes
     */
    
    /**
     * Scope to filter by G12 leader (direct)
     */
    public function scopeForG12Leader($query, $g12LeaderId)
    {
        return $query->where('g12_leader_id', $g12LeaderId);
    }

    /**
     * Scope to get records under specific leaders (hierarchy)
     */
    public function scopeUnderLeaders($query, array $leaderIds)
    {
        return $query->whereIn('g12_leader_id', $leaderIds);
    }

    /**
     * Scope to get active records
     */
    public function scopeActive($query)
    {
        return $query->whereHas('status', function ($q) {
            $q->where('name', '!=', 'Inactive');
        });
    }

    /**
     * Scope to get cell leaders only
     */
    public function scopeCellLeaders($query)
    {
        return $query->where('is_cell_leader', true);
    }

    /**
     * Scope by SOL level
     */
    public function scopeAtLevel($query, int $levelNumber)
    {
        return $query->whereHas('currentSolLevel', function ($q) use ($levelNumber) {
            $q->where('level_number', $levelNumber);
        });
    }

    /**
     * Helper Methods
     */
    
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

        // Future: Add SOL 2 and SOL 3 logic here
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
