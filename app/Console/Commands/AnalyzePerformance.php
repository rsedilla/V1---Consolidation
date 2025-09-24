<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PerformanceMonitoringService;
use Illuminate\Support\Facades\DB;

class AnalyzePerformance extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'performance:analyze {--queries=10 : Number of sample queries to run}';

    /**
     * The console command description.
     */
    protected $description = 'Analyze application performance and identify bottlenecks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting performance analysis...');
        
        $queryCount = (int) $this->option('queries');
        
        // Test database performance
        $this->testDatabasePerformance($queryCount);
        
        // Test cache performance
        $this->testCachePerformance();
        
        // Show cached metrics
        $this->showCachedMetrics();
        
        $this->info('Performance analysis completed!');
        
        return 0;
    }

    /**
     * Test database query performance
     */
    private function testDatabasePerformance(int $queryCount): void
    {
        $this->info("Testing database performance with {$queryCount} sample queries...");
        
        $monitor = new PerformanceMonitoringService();
        $monitor->startQueryMonitoring();
        
        // Run some sample queries to test performance
        for ($i = 0; $i < $queryCount; $i++) {
            // Test different query patterns
            switch ($i % 4) {
                case 0:
                    // Simple select
                    DB::table('members')->where('id', '>', 0)->limit(10)->get();
                    break;
                case 1:
                    // With joins
                    DB::table('members')
                        ->join('member_types', 'members.member_type_id', '=', 'member_types.id')
                        ->limit(10)
                        ->get();
                    break;
                case 2:
                    // Count query
                    DB::table('members')->count();
                    break;
                case 3:
                    // Aggregation
                    DB::table('members')
                        ->select('member_type_id', DB::raw('COUNT(*) as count'))
                        ->groupBy('member_type_id')
                        ->get();
                    break;
            }
        }
        
        $metrics = $monitor->getPerformanceMetrics();
        
        $this->table(['Metric', 'Value'], [
            ['Execution Time', $metrics['execution_time_ms'] . ' ms'],
            ['Memory Usage', $metrics['memory_usage_mb'] . ' MB'],
            ['Peak Memory', $metrics['peak_memory_mb'] . ' MB'],
            ['Query Count', $metrics['query_count']],
            ['Slow Queries', count($metrics['slow_queries'])],
            ['Duplicate Queries', count($metrics['duplicate_queries'])],
        ]);
        
        if (!empty($metrics['slow_queries'])) {
            $this->warn('Slow queries detected:');
            foreach ($metrics['slow_queries'] as $query) {
                $this->line("  - {$query['query']} ({$query['time']}ms)");
            }
        }
        
        if (!empty($metrics['duplicate_queries'])) {
            $this->warn('Duplicate queries detected:');
            foreach ($metrics['duplicate_queries'] as $queryStr => $count) {
                $this->line("  - {$count}x: " . substr($queryStr, 0, 100) . '...');
            }
        }
    }

    /**
     * Test cache performance
     */
    private function testCachePerformance(): void
    {
        $this->info('Testing cache performance...');
        
        $startTime = microtime(true);
        
        // Test cache operations
        cache()->put('test_key', 'test_value', 60);
        $value = cache()->get('test_key');
        cache()->forget('test_key');
        
        $endTime = microtime(true);
        $cacheTime = round(($endTime - $startTime) * 1000, 2);
        
        $this->info("Cache operations completed in {$cacheTime} ms");
    }

    /**
     * Show cached performance metrics
     */
    private function showCachedMetrics(): void
    {
        $metrics = PerformanceMonitoringService::getCachedMetrics();
        
        if (empty($metrics)) {
            $this->info('No cached performance metrics found.');
            return;
        }
        
        $this->info('Recent performance metrics:');
        
        $recentMetrics = array_slice($metrics, -5); // Show last 5
        
        foreach ($recentMetrics as $entry) {
            $m = $entry['metrics'];
            $this->line("  {$entry['timestamp']}: {$m['execution_time_ms']}ms, {$m['memory_usage_mb']}MB, {$m['query_count']} queries");
        }
    }
}