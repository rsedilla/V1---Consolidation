<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class PerformanceMonitoringService
{
    private array $queryLog = [];
    private float $startTime;
    private int $startMemory;

    public function __construct()
    {
        $this->startTime = microtime(true);
        $this->startMemory = memory_get_usage(true);
    }

    /**
     * Start monitoring database queries
     */
    public function startQueryMonitoring(): void
    {
        DB::enableQueryLog();
    }

    /**
     * Stop monitoring and get performance metrics
     */
    public function getPerformanceMetrics(): array
    {
        $endTime = microtime(true);
        $endMemory = memory_get_usage(true);
        
        $executionTime = round(($endTime - $this->startTime) * 1000, 2); // in milliseconds
        $memoryUsage = round(($endMemory - $this->startMemory) / 1024 / 1024, 2); // in MB
        $peakMemory = round(memory_get_peak_usage(true) / 1024 / 1024, 2); // in MB
        
        $queries = DB::getQueryLog();
        $queryCount = count($queries);
        $slowQueries = $this->getSlowQueries($queries);
        
        return [
            'execution_time_ms' => $executionTime,
            'memory_usage_mb' => $memoryUsage,
            'peak_memory_mb' => $peakMemory,
            'query_count' => $queryCount,
            'slow_queries' => $slowQueries,
            'duplicate_queries' => $this->getDuplicateQueries($queries),
        ];
    }

    /**
     * Get slow queries (over threshold)
     */
    private function getSlowQueries(array $queries): array
    {
        $threshold = config('performance.database.slow_query_threshold', 1000);
        
        return array_filter($queries, function ($query) use ($threshold) {
            return ($query['time'] ?? 0) > $threshold;
        });
    }

    /**
     * Detect duplicate queries
     */
    private function getDuplicateQueries(array $queries): array
    {
        $queryStrings = array_map(function ($query) {
            return $query['query'] ?? '';
        }, $queries);
        
        $duplicates = array_count_values($queryStrings);
        
        return array_filter($duplicates, function ($count) {
            return $count > 1;
        });
    }

    /**
     * Log performance metrics if they exceed thresholds
     */
    public function logPerformanceIssues(array $metrics): void
    {
        $memoryThreshold = config('performance.monitoring.memory_threshold', 128);
        $timeThreshold = config('performance.monitoring.execution_time_threshold', 5000);
        
        if ($metrics['peak_memory_mb'] > $memoryThreshold) {
            Log::warning('High memory usage detected', [
                'peak_memory_mb' => $metrics['peak_memory_mb'],
                'threshold_mb' => $memoryThreshold,
            ]);
        }
        
        if ($metrics['execution_time_ms'] > $timeThreshold) {
            Log::warning('Slow execution time detected', [
                'execution_time_ms' => $metrics['execution_time_ms'],
                'threshold_ms' => $timeThreshold,
            ]);
        }
        
        if (!empty($metrics['slow_queries'])) {
            Log::warning('Slow queries detected', [
                'slow_queries_count' => count($metrics['slow_queries']),
                'queries' => $metrics['slow_queries'],
            ]);
        }
        
        if (!empty($metrics['duplicate_queries'])) {
            Log::info('Duplicate queries detected (possible N+1 problem)', [
                'duplicate_queries' => $metrics['duplicate_queries'],
            ]);
        }
    }

    /**
     * Cache performance metrics for dashboard
     */
    public function cacheMetrics(array $metrics): void
    {
        $cacheKey = 'performance_metrics_' . date('Y-m-d-H');
        $ttl = config('performance.cache.dashboard_stats_ttl', 300);
        
        $existingMetrics = Cache::get($cacheKey, []);
        $existingMetrics[] = [
            'timestamp' => now()->toISOString(),
            'metrics' => $metrics,
        ];
        
        // Keep only last 100 entries
        if (count($existingMetrics) > 100) {
            $existingMetrics = array_slice($existingMetrics, -100);
        }
        
        Cache::put($cacheKey, $existingMetrics, $ttl);
    }

    /**
     * Get cached performance metrics for dashboard
     */
    public static function getCachedMetrics(): array
    {
        $cacheKey = 'performance_metrics_' . date('Y-m-d-H');
        return Cache::get($cacheKey, []);
    }
}