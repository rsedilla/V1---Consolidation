<?php

namespace App\Observers;

use App\Models\Status;
use App\Services\CacheService;

class StatusObserver
{
    /**
     * Handle the Status "created" event.
     */
    public function created(Status $status): void
    {
        CacheService::clearFormOptionsCache();
    }

    /**
     * Handle the Status "updated" event.
     */
    public function updated(Status $status): void
    {
        CacheService::clearFormOptionsCache();
    }

    /**
     * Handle the Status "deleted" event.
     */
    public function deleted(Status $status): void
    {
        CacheService::clearFormOptionsCache();
    }
}