<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\G12Leader;
use Illuminate\Support\Facades\Cache;

class WarmG12CacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:warm-g12
                          {--clear : Clear existing caches before warming}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Warm the G12 leader hierarchy cache to improve performance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting G12 hierarchy cache warming...');
        
        // Clear existing caches if requested
        if ($this->option('clear')) {
            $this->info('Clearing existing caches...');
            G12Leader::clearHierarchyCache(); // Clear all hierarchy caches
            Cache::forget('all_g12_leaders');
            Cache::forget('all_consolidators');
            $this->info('✓ Caches cleared');
        }
        
        // Warm hierarchy cache
        $this->info('Warming hierarchy caches...');
        $rootCount = G12Leader::warmHierarchyCache();
        $this->info("✓ Warmed cache for {$rootCount} root leaders");
        
        // Warm global caches
        $this->info('Warming global leader cache...');
        $leaderCount = G12Leader::orderBy('name')->pluck('name', 'id')->count();
        Cache::remember('all_g12_leaders', 1800, function () {
            return G12Leader::orderBy('name')->pluck('name', 'id')->toArray();
        });
        $this->info("✓ Cached {$leaderCount} leaders");
        
        $this->info('Warming consolidator cache...');
        $consolidatorCount = \App\Models\Member::consolidators()->count();
        Cache::remember('all_consolidators', 1800, function () {
            return \App\Models\Member::consolidators()
                ->select('id', 'first_name', 'last_name')
                ->orderBy('first_name')
                ->get()
                ->mapWithKeys(function ($member) {
                    return [$member->id => $member->first_name . ' ' . $member->last_name];
                })
                ->toArray();
        });
        $this->info("✓ Cached {$consolidatorCount} consolidators");
        
        $this->newLine();
        $this->info('🎉 Cache warming completed successfully!');
        $this->info('Application performance should be significantly improved.');
        
        // Show cache statistics
        $this->newLine();
        $this->info('Cache Statistics:');
        $stats = G12Leader::getCacheStats();
        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Leaders', $stats['total_leaders']],
                ['Cached Descendants', $stats['cached_descendants']],
                ['Cached Ancestors', $stats['cached_ancestors']],
                ['Descendant Cache Hit Rate', $stats['cache_hit_rate_descendants'] . '%'],
                ['Ancestor Cache Hit Rate', $stats['cache_hit_rate_ancestors'] . '%'],
            ]
        );
        
        return Command::SUCCESS;
    }
}
