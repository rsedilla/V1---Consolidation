<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\PerformanceMonitoringService;

class PerformanceMonitoring
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip monitoring for asset requests and health checks
        if ($this->shouldSkipMonitoring($request)) {
            return $next($request);
        }

        $monitor = new PerformanceMonitoringService();
        $monitor->startQueryMonitoring();

        $response = $next($request);

        // Only monitor if performance monitoring is enabled
        if (config('performance.monitoring.enabled', false)) {
            $metrics = $monitor->getPerformanceMetrics();
            
            // Log performance issues
            $monitor->logPerformanceIssues($metrics);
            
            // Cache metrics for dashboard
            $monitor->cacheMetrics($metrics);
            
            // Add performance headers in development
            if (app()->environment('local')) {
                $response->headers->set('X-Execution-Time', $metrics['execution_time_ms'] . 'ms');
                $response->headers->set('X-Memory-Usage', $metrics['memory_usage_mb'] . 'MB');
                $response->headers->set('X-Query-Count', $metrics['query_count']);
            }
        }

        return $response;
    }

    /**
     * Determine if monitoring should be skipped for this request
     */
    private function shouldSkipMonitoring(Request $request): bool
    {
        $path = $request->getPathInfo();
        
        // Skip for assets
        if (preg_match('/\.(css|js|png|jpg|jpeg|gif|svg|webp|woff|woff2|ttf|eot|ico)$/i', $path)) {
            return true;
        }
        
        // Skip for health checks
        if ($path === '/up' || $path === '/health') {
            return true;
        }
        
        // Skip for API routes (they might have their own monitoring)
        if (str_starts_with($path, '/api/')) {
            return true;
        }
        
        return false;
    }
}