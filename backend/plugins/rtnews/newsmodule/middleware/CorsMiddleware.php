<?php

namespace RtNews\NewsModule\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        $allowedOrigins = Config::get('cors.allowed_origins', []);
        $origin = $request->headers->get('Origin');

        $response = $next($request);

        if (in_array($origin, $allowedOrigins)) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
        }

        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');

        return $response;
    }
}
