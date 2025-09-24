<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OptimizeAssets
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only apply to asset requests
        if ($this->isAssetRequest($request)) {
            $this->addCacheHeaders($response);
            $this->addCompressionHeaders($response);
        }

        return $response;
    }

    /**
     * Check if the request is for an asset
     */
    private function isAssetRequest(Request $request): bool
    {
        $path = $request->getPathInfo();
        
        // Check for common asset file extensions
        return preg_match('/\.(css|js|png|jpg|jpeg|gif|svg|webp|woff|woff2|ttf|eot|ico)$/i', $path);
    }

    /**
     * Add cache headers for better performance
     */
    private function addCacheHeaders(Response $response): void
    {
        // Set cache headers for 1 year for static assets
        $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
        
        // Add ETag for cache validation
        $content = $response->getContent();
        if ($content) {
            $etag = md5($content);
            $response->headers->set('ETag', '"' . $etag . '"');
        }
        
        // Add expires header
        $response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000));
    }

    /**
     * Add compression headers
     */
    private function addCompressionHeaders(Response $response): void
    {
        // Add Vary header for proper caching with compression
        $response->headers->set('Vary', 'Accept-Encoding');
        
        // Add security headers for assets
        $response->headers->set('X-Content-Type-Options', 'nosniff');
    }
}