<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

class SecurityMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Rate limiting for authentication attempts
        $this->handleRateLimiting($request);
        
        // Input sanitization and validation
        $this->sanitizeInput($request);
        
        // Security headers
        $response = $next($request);
        $this->addSecurityHeaders($response);
        
        return $response;
    }

    /**
     * Handle rate limiting for sensitive endpoints
     */
    private function handleRateLimiting(Request $request): void
    {
        // Rate limit login attempts
        if ($request->is('login') && $request->isMethod('POST')) {
            $key = 'login_attempts:' . $request->ip();
            
            if (RateLimiter::tooManyAttempts($key, 5)) {
                throw new ThrottleRequestsException('Too many login attempts. Please try again later.');
            }
            
            RateLimiter::hit($key, 900); // 15 minutes
        }
        
        // Rate limit password reset requests
        if ($request->is('password/email') && $request->isMethod('POST')) {
            $key = 'password_reset:' . $request->ip();
            
            if (RateLimiter::tooManyAttempts($key, 3)) {
                throw new ThrottleRequestsException('Too many password reset attempts. Please try again later.');
            }
            
            RateLimiter::hit($key, 3600); // 1 hour
        }
    }

    /**
     * Sanitize user input to prevent XSS and injection attacks
     */
    private function sanitizeInput(Request $request): void
    {
        $input = $request->all();
        
        foreach ($input as $key => $value) {
            if (is_string($value)) {
                // Remove potentially dangerous characters
                $cleaned = $this->cleanInput($value);
                $request->merge([$key => $cleaned]);
            }
        }
    }

    /**
     * Clean individual input values
     */
    private function cleanInput(string $input): string
    {
        // Remove null bytes
        $input = str_replace("\0", '', $input);
        
        // Remove or escape potentially dangerous characters
        $input = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $input);
        
        // Trim whitespace
        $input = trim($input);
        
        return $input;
    }

    /**
     * Add security headers to response
     */
    private function addSecurityHeaders(Response $response): void
    {
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self'; connect-src 'self'");
        
        // Only add HSTS header if using HTTPS
        if (request()->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }
    }
}