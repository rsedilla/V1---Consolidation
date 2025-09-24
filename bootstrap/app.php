<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Add security middleware to web routes
        $middleware->web(append: [
            \App\Http\Middleware\SecurityMiddleware::class,
            \App\Http\Middleware\StrongAuthenticationMiddleware::class,
            \App\Http\Middleware\OptimizeAssets::class,
            \App\Http\Middleware\PerformanceMonitoring::class,
        ]);
        
        // Ensure CSRF protection is enabled for all web routes
        $middleware->validateCsrfTokens(except: [
            // Add any routes that should be exempt from CSRF protection
        ]);
        
        // Add rate limiting for API routes
        $middleware->api(prepend: [
            'throttle:60,1', // 60 requests per minute
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
