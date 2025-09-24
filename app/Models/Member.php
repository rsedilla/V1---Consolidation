<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\OptimizedQueries;

class Member extends Model
{
    use OptimizedQueries;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'birthday',
        'email',
        'phone',
        'address',
        'status_id',
        'member_type_id',
        'g12_leader_id',
        'consolidator_id',
        'vip_status_id'
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

    public function vipStatus()
    {
        return $this->belongsTo(VipStatus::class);
    }

    // Scope to get only consolidators
    public function scopeConsolidators($query)
    {
        return $query->whereHas('memberType', function ($q) {
            $q->where('name', 'Consolidator');
        });
    }

    // Scope to get only VIP members
    public function scopeVips($query)
    {
        return $query->whereHas('memberType', function ($q) {
            $q->where('name', 'VIP');
        });
    }

    /**
     * Scope to filter members by G12 leader
     * Used for leader-specific data filtering
     */
    public function scopeForG12Leader($query, $g12LeaderId)
    {
        return $query->where('g12_leader_id', $g12LeaderId);
    }

    /**
     * Check if this member is qualified for Life Class
     * Uses MemberCompletionService for the logic
     */
    public function isQualifiedForLifeClass(): bool
    {
        return \App\Services\MemberCompletionService::isQualifiedForLifeClass($this);
    }

    /**
     * Get completion progress for this member
     */
    public function getCompletionProgress(): array
    {
        return \App\Services\MemberCompletionService::getCompletionProgress($this);
    }

    /**
     * Check if a member with the same name exists
     * This is useful for validation before creating new members
     */
    public static function nameExists($firstName, $lastName, $excludeId = null): bool
    {
        $query = static::where('first_name', $firstName)
                      ->where('last_name', $lastName);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }
}
