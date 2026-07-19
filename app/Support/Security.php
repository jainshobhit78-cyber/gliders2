<?php

namespace App\Support;

class Security
{
    private const ALLOWED_TAGS = '<p><br><strong><b><em><i><u><ul><ol><li><blockquote><h1><h2><h3><h4><h5><h6><span><div><table><thead><tbody><tr><th><td><a>';

    /**
     * Elements that must be removed together with their contents. Anything that can
     * execute script, load remote resources, or break out of the content area.
     */
    private const DANGEROUS_TAGS = 'script|style|iframe|object|embed|form|input|button|textarea|select|option|meta|link|base|svg|math|template|frame|frameset|applet|param|noscript|title|xml';

    /**
     * Sanitise untrusted rich-text (admin CMS content) for safe display.
     *
     * Regex-based defence-in-depth: removes dangerous elements (with content),
     * whitelists tags, strips inline event handlers and style, and neutralises
     * dangerous URI schemes even when hidden behind whitespace or HTML entities.
     */
    public static function cleanHtml(?string $html): string
    {
        if ($html === null || $html === '') {
            return '';
        }

        // 1) Drop HTML comments (can hide conditional-comment payloads).
        $html = preg_replace('/<!--.*?-->/s', '', $html);

        // 2) Remove dangerous elements and their contents, looping to defeat
        //    nested / overlapping obfuscation like <scr<script>ipt>.
        do {
            $before = $html;
            $html = preg_replace(
                '/<\s*(' . self::DANGEROUS_TAGS . ')\b[^>]*>.*?<\s*\/\s*\1\s*>/is',
                '',
                (string) $html
            );
            $html = preg_replace(
                '/<\s*\/?\s*(' . self::DANGEROUS_TAGS . ')\b[^>]*>/is',
                '',
                (string) $html
            );
        } while ($html !== $before);

        // 3) Keep only the whitelisted tags.
        $html = strip_tags((string) $html, self::ALLOWED_TAGS);

        // 4) Strip inline event handlers (onclick, onerror, onmouseover, ...).
        $html = preg_replace('/\son[a-z0-9_\-]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/is', '', (string) $html);

        // 5) Strip style attributes (expression()/url() vectors).
        $html = preg_replace('/\sstyle\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/is', '', (string) $html);

        // 6) Remove any attribute whose value resolves to a dangerous URI scheme,
        //    tolerant of whitespace and HTML-entity obfuscation (e.g. jav&#x09;ascript:).
        $html = preg_replace_callback(
            '/\s([a-zA-Z_:][a-zA-Z0-9_:\-]*)\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/s',
            static function (array $m): string {
                $value = trim($m[2], '"\'');
                $probe = html_entity_decode($value, ENT_QUOTES | ENT_HTML5);
                $probe = preg_replace('/[\s\x00-\x20]+/', '', (string) $probe);

                if (preg_match('/^(?:javascript|data|vbscript|file):/i', (string) $probe)) {
                    return '';
                }

                return $m[0];
            },
            (string) $html
        );

        return $html ?? '';
    }
}
