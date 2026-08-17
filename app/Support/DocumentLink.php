<?php

namespace App\Support;

final class DocumentLink
{
    /**
     * Build the concise, consistent public heading used for annual reports.
     */
    public static function annualReportHeading(?string $storedFilename): string
    {
        return 'ANNUAL REPORT '.self::annualReportYear($storedFilename);
    }

    /**
     * Build the filename visitors receive when downloading an annual report.
     */
    public static function annualReportDownloadName(?string $storedFilename): string
    {
        return 'Annual Report '.self::annualReportYear($storedFilename).'.pdf';
    }

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

    private static function annualReportYear(?string $storedFilename): string
    {
        $filename = basename(str_replace('\\', '/', (string) $storedFilename));

        if (preg_match('/(?:20)?(\d{2})[\s_.-]+(\d{2})(?!\d)/u', $filename, $matches)) {
            return $matches[1].'-'.$matches[2];
        }

        // The first GIL report was historically stored as "AR_22".
        if (preg_match('/(?:^|[^a-z0-9])AR[\s_.-]*(\d{2})(?!\d)/iu', $filename, $matches)) {
            $endYear = (int) $matches[1];

            return sprintf('%02d-%02d', ($endYear + 99) % 100, $endYear);
        }

        return 'DOCUMENT';
    }
}
