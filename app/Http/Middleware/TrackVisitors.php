<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitors
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Track only main GET requests (page views)
        // Exclude AJAX requests, administrative panels, and API endpoints
        if (
            $request->isMethod('GET') &&
            !$request->ajax() &&
            !$request->is('admin*') &&
            !$request->is('api*') &&
            !$request->is('_debugbar*')
        ) {
            try {
                $setting = GeneralSetting::firstOrCreate([]);
                $setting->increment('visitor_count');
            } catch (\Exception $e) {
                // Fail silently to prevent crashing the page if migration is not run yet
            }
        }

        return $next($request);
    }
}
