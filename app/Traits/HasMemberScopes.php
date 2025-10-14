<?php

namespace App\Traits;

use App\Models\MemberType;
use Illuminate\Support\Facades\Cache;

trait HasMemberScopes
{
    /**
     * Scope to get only VIP members
     * Optimized with direct member_type_id lookup to avoid join
     */
    public function scopeVips($query)
    {
        static $vipTypeId;
        
        if (!isset($vipTypeId)) {
            $vipTypeId = Cache::remember(
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
            $consolidatorTypeId = Cache::remember(
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
}
