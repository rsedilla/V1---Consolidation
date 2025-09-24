<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\MemberType;
use App\Models\Status;
use App\Models\VipStatus;
use App\Models\G12Leader;
use App\Models\Member;

class CacheService
{
    const CACHE_DURATION = 3600; // 1 hour

    /**
     * Get cached member types for form options
     */
    public static function getMemberTypes(): array
    {
        return Cache::remember('member_types_options', self::CACHE_DURATION, function () {
            return MemberType::query()
                ->orderBy('name')
                ->pluck('name', 'id')
                ->toArray();
        });
    }

    /**
     * Get cached statuses for form options
     */
    public static function getStatuses(): array
    {
        return Cache::remember('statuses_options', self::CACHE_DURATION, function () {
            return Status::query()
                ->orderBy('name')
                ->pluck('name', 'id')
                ->toArray();
        });
    }

    /**
     * Get cached VIP statuses for form options
     */
    public static function getVipStatuses(): array
    {
        return Cache::remember('vip_statuses_options', self::CACHE_DURATION, function () {
            return VipStatus::query()
                ->orderBy('name')
                ->pluck('name', 'id')
                ->toArray();
        });
    }

    /**
     * Get cached G12 leaders for form options
     */
    public static function getG12Leaders(): array
    {
        return Cache::remember('g12_leaders_options', self::CACHE_DURATION, function () {
            return G12Leader::query()
                ->orderBy('name')
                ->pluck('name', 'id')
                ->toArray();
        });
    }

    /**
     * Get cached consolidators for form options
     */
    public static function getConsolidators(): array
    {
        return Cache::remember('consolidators_options', self::CACHE_DURATION, function () {
            return Member::query()
                ->consolidators()
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->get()
                ->mapWithKeys(function ($member) {
                    return [$member->id => $member->first_name . ' ' . $member->last_name];
                })
                ->toArray();
        });
    }

    /**
     * Clear all cached form options
     */
    public static function clearFormOptionsCache(): void
    {
        Cache::forget('member_types_options');
        Cache::forget('statuses_options');
        Cache::forget('vip_statuses_options');
        Cache::forget('g12_leaders_options');
        Cache::forget('consolidators_options');
    }

    /**
     * Warm up all caches
     */
    public static function warmUpCache(): void
    {
        self::getMemberTypes();
        self::getStatuses();
        self::getVipStatuses();
        self::getG12Leaders();
        self::getConsolidators();
    }
}