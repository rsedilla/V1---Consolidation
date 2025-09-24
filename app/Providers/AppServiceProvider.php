<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\MemberType;
use App\Models\Status;
use App\Models\G12Leader;
use App\Observers\MemberTypeObserver;
use App\Observers\StatusObserver;
use App\Observers\G12LeaderObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register model observers to clear cache when reference data changes
        MemberType::observe(MemberTypeObserver::class);
        Status::observe(StatusObserver::class);
        G12Leader::observe(G12LeaderObserver::class);
    }
}
