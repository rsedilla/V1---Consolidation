<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class SecurityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Force HTTPS in production
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Prevent lazy loading in development to catch N+1 queries
        if (app()->environment('local')) {
            Model::preventLazyLoading();
        }

        // Set default string length for MySQL compatibility
        Schema::defaultStringLength(191);

        // Add custom validation rules
        $this->addCustomValidationRules();
        
        // Configure security settings
        $this->configureSecuritySettings();
    }

    /**
     * Add custom validation rules for security
     */
    private function addCustomValidationRules(): void
    {
        // Validate that input doesn't contain SQL injection patterns
        Validator::extend('no_sql_injection', function ($attribute, $value, $parameters, $validator) {
            if (!is_string($value)) {
                return true;
            }

            $dangerous_patterns = [
                '/(\bselect\b|\binsert\b|\bupdate\b|\bdelete\b|\bdrop\b|\bunion\b)/i',
                '/(\bor\b|\band\b)\s+\d+\s*=\s*\d+/i',
                '/[\'"];\s*(\bselect\b|\binsert\b|\bupdate\b|\bdelete\b)/i',
                '/\-\-/',
                '/\/\*.*\*\//',
                '/\bexec\b|\bexecute\b/i',
            ];

            foreach ($dangerous_patterns as $pattern) {
                if (preg_match($pattern, $value)) {
                    return false;
                }
            }

            return true;
        });

        // Validate that input doesn't contain XSS patterns
        Validator::extend('no_xss', function ($attribute, $value, $parameters, $validator) {
            if (!is_string($value)) {
                return true;
            }

            $xss_patterns = [
                '/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi',
                '/javascript:/i',
                '/on\w+\s*=/i',
                '/<iframe\b/i',
                '/<object\b/i',
                '/<embed\b/i',
                '/<link\b/i',
                '/<meta\b/i',
            ];

            foreach ($xss_patterns as $pattern) {
                if (preg_match($pattern, $value)) {
                    return false;
                }
            }

            return true;
        });

        // Validate safe file names
        Validator::extend('safe_filename', function ($attribute, $value, $parameters, $validator) {
            if (!is_string($value)) {
                return true;
            }

            // Only allow alphanumeric characters, hyphens, underscores, and periods
            return preg_match('/^[a-zA-Z0-9._-]+$/', $value);
        });
    }

    /**
     * Configure additional security settings
     */
    private function configureSecuritySettings(): void
    {
        // Set secure cookie settings
        config([
            'session.cookie' => config('app.name') . '_session',
            'session.secure' => app()->environment('production'),
            'session.http_only' => true,
            'session.same_site' => 'strict',
        ]);

        // Configure password hashing
        config([
            'hashing.bcrypt.rounds' => env('BCRYPT_ROUNDS', 12),
        ]);
    }
}