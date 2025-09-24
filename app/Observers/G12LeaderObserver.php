<?php

namespace App\Observers;

use App\Models\G12Leader;
use App\Services\CacheService;

class G12LeaderObserver
{
    /**
     * Handle the G12Leader "created" event.
     */
    public function created(G12Leader $g12Leader): void
    {
        CacheService::clearFormOptionsCache();
    }

    /**
     * Handle the G12Leader "updated" event.
     */
    public function updated(G12Leader $g12Leader): void
    {
        CacheService::clearFormOptionsCache();
    }

    /**
     * Handle the G12Leader "deleted" event.
     */
    public function deleted(G12Leader $g12Leader): void
    {
        CacheService::clearFormOptionsCache();
    }
}