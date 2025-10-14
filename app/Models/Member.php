<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\OptimizedQueries;
use App\Traits\HasMemberScopes;
use App\Traits\HasTrainingProgressScopes;
use App\Traits\HasMemberQualifications;

class Member extends Model
{
    use OptimizedQueries,
        HasMemberScopes,
        HasTrainingProgressScopes,
        HasMemberQualifications;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'birthday',
        'wedding_anniversary_date',
        'email',
        'phone',
        'address',
        'status_id',
        'member_type_id',
        'g12_leader_id',
        'consolidator_id',
        'vip_status_id',
        'consolidation_date'
    ];

    protected $casts = [
        'birthday' => 'date',
        'wedding_anniversary_date' => 'date',
        'consolidation_date' => 'date',
    ];

    public function memberType()
    {
        return $this->belongsTo(MemberType::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function g12Leader()
    {
        return $this->belongsTo(G12Leader::class);
    }

    public function consolidator()
    {
        return $this->belongsTo(Member::class, 'consolidator_id');
    }

    public function sundayServices()
    {
        return $this->hasMany(SundayService::class);
    }

    public function cellGroups()
    {
        return $this->hasMany(CellGroup::class);
    }

    public function startUpYourNewLife()
    {
        return $this->hasMany(StartUpYourNewLife::class);
    }

    public function lifeclassCandidates()
    {
        return $this->hasMany(LifeclassCandidate::class);
    }

    public function solProfiles()
    {
        return $this->hasMany(SolProfile::class);
    }
    
    // Alias for backward compatibility
    public function sol1()
    {
        return $this->solProfiles();
    }

    public function vipStatus()
    {
        return $this->belongsTo(VipStatus::class);
    }

    // Member type scopes (VIP, Consolidator, etc.) are in HasMemberScopes trait
    // Training progress scopes (NotInLifeClass, NotInSol, etc.) are in HasTrainingProgressScopes trait
    // Qualification methods (isQualifiedForLifeClass, etc.) are in HasMemberQualifications trait
}
