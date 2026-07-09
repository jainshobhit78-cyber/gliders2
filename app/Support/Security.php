<?php

namespace App\Support;

class Security
{
    private const ALLOWED_TAGS = '<p><br><strong><b><em><i><u><ul><ol><li><blockquote><h1><h2><h3><h4><h5><h6><span><div><table><thead><tbody><tr><th><td><a>';

    public static function cleanHtml(?string $html): string
    {
        if ($html === null || $html === '') {
            return '';
        }

        $html = preg_replace('/<\s*(script|style|iframe|object|embed|form|input|button|meta|link)[^>]*>.*?<\s*\/\s*\1\s*>/is', '', $html);
        $html = preg_replace('/<\s*(script|style|iframe|object|embed|form|input|button|meta|link)[^>]*\/?\s*>/is', '', $html);
        $html = strip_tags($html, self::ALLOWED_TAGS);
        $html = preg_replace('/\s+on[a-z]+\s*=\s*(".*?"|\'.*?\'|[^\s>]+)/is', '', $html);
        $html = preg_replace('/\s+(href|src)\s*=\s*([\'"])\s*(javascript:|data:|vbscript:).*?\2/is', '', $html);
        $html = preg_replace('/\s+style\s*=\s*(".*?"|\'.*?\'|[^\s>]+)/is', '', $html);

        return $html ?? '';
    }
}
