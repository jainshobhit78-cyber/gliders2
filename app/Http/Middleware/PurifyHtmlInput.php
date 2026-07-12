<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PurifyHtmlInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();

        array_walk_recursive($input, function (&$val) {
            if (is_string($val)) {
                $val = $this->sanitize($val);
            }
        });

        $request->merge($input);

        return $next($request);
    }

    /**
     * Sanitizes rich text inputs by removing malicious scripts, frames, and event handlers.
     */
    private function sanitize(string $val): string
    {
        // Early return for standard non-HTML strings to maximize performance
        if (!str_contains($val, '<') && !preg_match('/on\w+=/i', $val) && !str_contains($val, 'javascript:')) {
            return $val;
        }

        // Remove script tags and their contents
        $val = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $val);

        // Remove iframe, frame, object, embed tags
        $val = preg_replace('/<(iframe|frame|object|embed)\b[^>]*>(.*?)<\/\1>/is', '', $val);
        $val = preg_replace('/<(iframe|frame|object|embed)\b[^>]*\/?>/is', '', $val);

        // Remove inline event handlers (e.g. onload, onerror, onclick, onmouseover)
        $val = preg_replace('/on[a-zA-Z]+\s*=\s*["\'](.*?)["\']/is', '', $val);
        $val = preg_replace('/on[a-zA-Z]+\s*=\s*[^\s>]+/is', '', $val);

        // Remove javascript: pseudo-protocol in links or sources
        $val = preg_replace('/href\s*=\s*["\']\s*javascript:[^"\']*["\']/is', 'href="#"', $val);
        $val = preg_replace('/src\s*=\s*["\']\s*javascript:[^"\']*["\']/is', 'src=""', $val);

        return $val;
    }
}
