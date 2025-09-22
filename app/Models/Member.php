<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;
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
        'consolidator_id'
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
     * Check if a member with the same name exists (excluding soft deleted)
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

    /**
     * Restore a soft deleted member by name
     * Useful when trying to "create" a member that was previously soft deleted
     */
    public static function restoreByName($firstName, $lastName): ?self
    {
        $member = static::onlyTrashed()
                       ->where('first_name', $firstName)
                       ->where('last_name', $lastName)
                       ->first();
        
        if ($member) {
            $member->restore();
            return $member->fresh();
        }
        
        return null;
    }
}
