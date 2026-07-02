<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\GeneralSetting;

class IpWhitelistMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $whitelist = GeneralSetting::getIpWhitelist();
        
        if (!empty($whitelist)) {
            $clientIp = $request->ip();
            if (!in_array($clientIp, $whitelist)) {
                abort(403, "Access denied. Your IP address ({$clientIp}) is not authorized to access the administration panel.");
            }
        }

        return $next($request);
    }
}
