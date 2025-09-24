<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CacheService;

class WarmUpCache extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'cache:warm-up';

    /**
     * The console command description.
     */
    protected $description = 'Warm up application cache with frequently accessed data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Warming up application cache...');
        
        try {
            CacheService::warmUpCache();
            $this->info('Cache warmed up successfully!');
        } catch (\Exception $e) {
            $this->error('Failed to warm up cache: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}