<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Performance Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration file contains settings that affect application 
    | performance including caching, database optimization, and monitoring.
    |
    */

    'cache' => [
        // Cache duration for form options (in seconds)
        'form_options_ttl' => env('CACHE_FORM_OPTIONS_TTL', 3600), // 1 hour

        // Cache duration for user permissions (in seconds)
        'permissions_ttl' => env('CACHE_PERMISSIONS_TTL', 1800), // 30 minutes

        // Cache duration for dashboard stats (in seconds)
        'dashboard_stats_ttl' => env('CACHE_DASHBOARD_STATS_TTL', 300), // 5 minutes
    ],

    'database' => [
        // Enable query logging for performance monitoring
        'log_queries' => env('DB_LOG_QUERIES', false),

        // Log slow queries (in milliseconds)
        'slow_query_threshold' => env('DB_SLOW_QUERY_THRESHOLD', 1000),

        // Maximum number of eager loaded relationships
        'max_eager_load_depth' => 3,
    ],

    'pagination' => [
        // Default items per page for Filament tables
        'default_per_page' => 25,

        // Maximum items per page
        'max_per_page' => 100,
    ],

    'monitoring' => [
        // Enable performance monitoring
        'enabled' => env('PERFORMANCE_MONITORING', false),

        // Memory usage threshold for warnings (in MB)
        'memory_threshold' => 128,

        // Execution time threshold for warnings (in seconds)
        'execution_time_threshold' => 5,
    ],
];