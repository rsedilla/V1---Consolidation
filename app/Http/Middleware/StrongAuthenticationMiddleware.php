<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class StrongAuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check for session hijacking attempts
        $this->checkSessionIntegrity($request);
        
        // Validate password strength on password change requests
        $this->validatePasswordStrength($request);
        
        // Check for suspicious authentication patterns
        $this->checkAuthenticationPatterns($request);
        
        return $next($request);
    }

    /**
     * Check session integrity to prevent session hijacking
     */
    private function checkSessionIntegrity(Request $request): void
    {
        if (Auth::check()) {
            $user = Auth::user();
            $sessionKey = 'user_session_integrity_' . $user->id;
            
            // Store user agent and IP on first auth
            if (!Session::has($sessionKey)) {
                Session::put($sessionKey, [
                    'user_agent' => $request->userAgent(),
                    'ip_address' => $request->ip(),
                    'created_at' => now()
                ]);
            } else {
                $sessionData = Session::get($sessionKey);
                
                // Check if user agent or IP changed (potential session hijacking)
                if ($sessionData['user_agent'] !== $request->userAgent() || 
                    $sessionData['ip_address'] !== $request->ip()) {
                    
                    // Log the suspicious activity
                    logger('Suspicious session activity detected', [
                        'user_id' => $user->id,
                        'original_user_agent' => $sessionData['user_agent'],
                        'current_user_agent' => $request->userAgent(),
                        'original_ip' => $sessionData['ip_address'],
                        'current_ip' => $request->ip()
                    ]);
                    
                    // Force logout for security
                    Auth::logout();
                    Session::invalidate();
                    Session::regenerateToken();
                    
                    abort(401, 'Session security violation detected. Please login again.');
                }
            }
        }
    }

    /**
     * Validate password strength on password change requests
     */
    private function validatePasswordStrength(Request $request): void
    {
        if ($request->has('password') && $request->isMethod('POST')) {
            $password = $request->input('password');
            
            if ($password && !$this->isStrongPassword($password)) {
                abort(422, 'Password does not meet security requirements. Password must be at least 8 characters long and contain uppercase, lowercase, numbers, and special characters.');
            }
        }
    }

    /**
     * Check if password meets strength requirements
     */
    private function isStrongPassword(string $password): bool
    {
        // Minimum 8 characters
        if (strlen($password) < 8) {
            return false;
        }
        
        // Must contain at least one uppercase letter
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }
        
        // Must contain at least one lowercase letter
        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }
        
        // Must contain at least one digit
        if (!preg_match('/\d/', $password)) {
            return false;
        }
        
        // Must contain at least one special character
        if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $password)) {
            return false;
        }
        
        return true;
    }

    /**
     * Check for suspicious authentication patterns
     */
    private function checkAuthenticationPatterns(Request $request): void
    {
        // Check for multiple failed login attempts from same IP
        if ($request->is('login') && $request->isMethod('POST')) {
            $failedAttempts = Session::get('failed_login_attempts', 0);
            
            if ($failedAttempts >= 3) {
                // Require CAPTCHA or additional verification
                logger('Multiple failed login attempts detected', [
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'attempts' => $failedAttempts
                ]);
            }
        }
    }
}