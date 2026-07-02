<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\GeneralSetting;

class MaintenanceModeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (GeneralSetting::isMaintenanceMode()) {
            // Bypass maintenance mode check for admin routes, logins, and logouts
            if (!$request->is('admin*') && !$request->is('login*') && !$request->is('logout*') && !$request->is('chatbot*')) {
                return response()->view('frontend.maintenance', [], 503);
            }
        }

        return $next($request);
    }
}
