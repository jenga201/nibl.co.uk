<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Marks every web response as publicly cacheable (parity with the
 * slim/http-cache middleware used before the Laravel migration).
 */
final class SetHttpCacheHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);
        $response->headers->set(
            'Cache-Control',
            sprintf('public, max-age=%d', config('nibl.http_cache_max_age'))
        );

        return $response;
    }
}
