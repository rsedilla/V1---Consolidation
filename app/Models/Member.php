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
        'vip_status_id',
        'consolidation_date'
    ];

    protected $casts = [
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

    public function vipStatus()
    {
        return $this->belongsTo(VipStatus::class);
    }

    /**
     * Scope to get only VIP members
     * Optimized with direct member_type_id lookup to avoid join
     */
    public function scopeVips($query)
    {
        static $vipTypeId;
        
        if (!isset($vipTypeId)) {
            $vipTypeId = \Illuminate\Support\Facades\Cache::remember(
                'member_type_vip_id',
                3600,
                fn() => MemberType::where('name', 'VIP')->value('id')
            );
        }
        
        return $query->where('member_type_id', $vipTypeId);
    }

    /**
     * Scope to get only Consolidator members
     * Optimized with direct member_type_id lookup to avoid join
     */
    public function scopeConsolidators($query)
    {
        static $consolidatorTypeId;
        
        if (!isset($consolidatorTypeId)) {
            $consolidatorTypeId = \Illuminate\Support\Facades\Cache::remember(
                'member_type_consolidator_id',
                3600,
                fn() => MemberType::where('name', 'Consolidator')->value('id')
            );
        }
        
        return $query->where('member_type_id', $consolidatorTypeId);
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
     * Scope to filter members under multiple G12 leaders (hierarchy)
     * Used for filtering by leader hierarchy
     */
    public function scopeUnderLeaders($query, array $leaderIds)
    {
        return $query->whereIn('g12_leader_id', $leaderIds);
    }

    /**
     * Scope to get active members (optional - if you have status filtering)
     */
    public function scopeActive($query)
    {
        return $query->whereHas('status', function ($q) {
            $q->where('name', '!=', 'Inactive');
        });
    }

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

    /**
     * Scope to get members who are NOT in StartUpYourNewLife (New Life Training)
     * Used to show only available VIPs for New Life Training enrollment
     */
    public function scopeWithoutNewLifeTraining($query)
    {
        return $query->whereDoesntHave('startUpYourNewLife');
    }

    /**
     * Scope to get members who are NOT in SundayService
     * Used to show only available VIPs for Sunday Service enrollment
     */
    public function scopeWithoutSundayService($query)
    {
        return $query->whereDoesntHave('sundayServices');
    }

    /**
     * Scope to get members who are NOT in CellGroup
     * Used to show only available VIPs for Cell Group enrollment
     */
    public function scopeWithoutCellGroup($query)
    {
        return $query->whereDoesntHave('cellGroups');
    }
}
