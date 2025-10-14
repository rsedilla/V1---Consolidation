<?php

namespace App\Models;

use App\Traits\HasSolProfileScopes;
use App\Traits\HasSolProfileHelpers;
use Illuminate\Database\Eloquent\Model;

class SolProfile extends Model
{
    use HasSolProfileScopes, HasSolProfileHelpers;
    
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

    public function sol3Candidate()
    {
        return $this->hasOne(Sol3Candidate::class, 'sol_profile_id');
    }

    public function lifeclassCandidate()
    {
        return $this->hasOne(LifeclassCandidate::class, 'sol_profile_id');
    }

    // SOL profile scopes (ForG12Leader, UnderLeaders, Active, CellLeaders, AtLevel) are in HasSolProfileScopes trait
    // Helper methods (getFullNameAttribute, isQualifiedForSol2, getCompletionProgress, promoteToNextLevel) are in HasSolProfileHelpers trait
}
