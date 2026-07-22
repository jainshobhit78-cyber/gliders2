<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');

        // Content-Security-Policy. The site relies on inline scripts/handlers and
        // admin-provided third-party embeds (Facebook, Instagram widgets, analytics),
        // so script/style/frame sources stay permissive over https. The strict parts
        // — object-src, base-uri, form-action and frame-ancestors — add real
        // clickjacking / injection protection without breaking existing pages.
        // CSP is only applied to non-admin responses so it can never interfere with
        // the rich-text editor / upload tooling in the admin panel.
        if (!$request->is('admin', 'admin/*')) {
            $csp = implode('; ', [
                "default-src 'self'",
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' https:",
                "style-src 'self' 'unsafe-inline' https:",
                "img-src 'self' data: blob: https:",
                "font-src 'self' data: https:",
                "media-src 'self' data: blob: https:",
                "frame-src https:",
                "connect-src 'self' https:",
                "object-src 'none'",
                "base-uri 'self'",
                "form-action 'self'",
                "frame-ancestors 'self'",
            ]);
            $response->headers->set('Content-Security-Policy', $csp);
        }

        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
