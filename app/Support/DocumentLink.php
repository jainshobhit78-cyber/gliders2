<?php

namespace App\Support;

final class DocumentLink
{
    /**
     * Return a safe, human-readable download name for legacy and current uploads.
     */
    public static function downloadName(?string $storedFilename, ?string $fallbackTitle = null): string
    {
        $filename = basename(str_replace('\\', '/', (string) $storedFilename));
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION) ?: 'pdf');
        $stem = pathinfo($filename, PATHINFO_FILENAME);

        // Older uploads were prefixed with timestamps or generated hexadecimal IDs.
        do {
            $previous = $stem;
            $stem = preg_replace('/^(?:\d{7,14}|[a-f0-9]{12,32})[_-]+/iu', '', $stem) ?? $stem;
        } while ($stem !== $previous);

        if ($stem === '' || preg_match('/^[\d\s._()\[\]-]+$/u', $stem)) {
            $stem = self::titleStem($fallbackTitle);
        }

        $stem = trim($stem, " .\t\n\r\0\x0B");
        $stem = function_exists('mb_substr') ? mb_substr($stem, 0, 140) : substr($stem, 0, 140);

        return ($stem !== '' ? $stem : 'document').'.'.$extension;
    }

    private static function titleStem(?string $title): string
    {
        $title = html_entity_decode(strip_tags((string) $title), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $title = preg_replace('/[^\pL\pN()\[\].-]+/u', '_', trim($title)) ?? '';
        $title = preg_replace('/_+/u', '_', $title) ?? '';

        return trim($title, '._- ');
    }
}
