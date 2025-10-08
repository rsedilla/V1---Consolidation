<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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
        
        // Query Performance Monitoring (Development Only)
        if ($this->app->environment('local')) {
            $this->enableQueryPerformanceMonitoring();
        }
    }
    
    /**
     * Enable query performance monitoring for development
     * Logs slow queries and provides debugging information
     */
    protected function enableQueryPerformanceMonitoring(): void
    {
        DB::listen(function ($query) {
            // Log queries that take longer than 100ms
            if ($query->time > 100) {
                $user = Auth::user();
                Log::channel('daily')->warning('Slow Query Detected', [
                    'sql' => $query->sql,
                    'bindings' => $query->bindings,
                    'time' => $query->time . 'ms',
                    'connection' => $query->connectionName,
                    'url' => request()->fullUrl(),
                    'user_id' => $user ? $user->id : null,
                ]);
            }
            
            // Optional: Log ALL queries in debug mode (very verbose)
            if (config('app.debug') && env('LOG_ALL_QUERIES', false)) {
                Log::channel('daily')->debug('Query Executed', [
                    'sql' => $query->sql,
                    'time' => $query->time . 'ms',
                ]);
            }
        });
    }
}
