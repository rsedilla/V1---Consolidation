<?php

namespace App\Observers;

use App\Models\MemberType;
use App\Services\CacheService;

class MemberTypeObserver
{
    /**
     * Handle the MemberType "created" event.
     */
    public function created(MemberType $memberType): void
    {
        CacheService::clearFormOptionsCache();
    }

    /**
     * Handle the MemberType "updated" event.
     */
    public function updated(MemberType $memberType): void
    {
        CacheService::clearFormOptionsCache();
    }

    /**
     * Handle the MemberType "deleted" event.
     */
    public function deleted(MemberType $memberType): void
    {
        CacheService::clearFormOptionsCache();
    }
}