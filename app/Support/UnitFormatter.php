<?php

namespace App\Support;

class UnitFormatter
{
    /**
     * Normalise measurement units to their internationally accepted symbols
     * (kg, m, s, m/s, km, kmph, gsm, m², ft) regardless of how they were typed
     * in the admin panel ("Kg", "Kmph", "GSM", "m/sec", "Sq. Mtr.", ...).
     *
     * Rules are ordered: compound units (m/sec, sq m) must run before the
     * standalone "sec"/"metre" rules or they would be partially rewritten.
     */
    protected static function rules(): array
    {
        return [
            // m/sec, meter/second, metres / sec  ->  m/s   (before the standalone "sec" rule)
            '/\b(?:m|met(?:er|re)s?)\s*\/\s*sec(?:ond)?s?\b\.?/iu' => 'm/s',

            // km/h, km/hr, kph, Kmph -> kmph
            '/\bkm\s*\/\s*hr?\b/iu' => 'kmph',
            '/\bkm?ph\b/iu'         => 'kmph',

            // square metres: sqm, sq m, Sq. Mtr. -> m²   (before the plain metre rule)
            '/\bsq\.?\s*(?:m|mtrs?|met(?:er|re)s?)\.?(?![a-z])/iu' => 'm²',

            // kilograms: Kg, KG, Kgs -> kg
            '/\bkgs?\b/iu' => 'kg',

            // grams per square metre: GSM, Gsm -> gsm
            '/\bgsm\b/iu' => 'gsm',

            // kilometres after a number -> km
            '/(?<=\d)(\s*)kilomet(?:er|re)s?\b\.?/iu' => '$1km',

            // metres after a number: "12 meter", "17 Mtr." -> "12 m"
            '/(?<=\d)(\s*)(?:mtrs?|met(?:er|re)s?)\b\.?/iu' => '$1m',

            // seconds after a number: "30 sec", "30 seconds" -> "30 s"
            '/(?<=\d)(\s*)sec(?:ond)?s?\b\.?/iu' => '$1s',

            // feet after a number -> ft
            '/(?<=\d)(\s*)(?:feet|foot)\b\.?/iu' => '$1ft',

            // knots lowercase
            '/\bknots\b/iu' => 'knots',
        ];
    }

    /**
     * Normalise a string, or every string inside an array, recursively.
     * HTML tags are left untouched so attributes/styles are never rewritten.
     */
    public static function normalize($value)
    {
        if (is_array($value)) {
            return array_map([static::class, 'normalize'], $value);
        }

        if (! is_string($value) || $value === '') {
            return $value;
        }

        // Split on tags so only visible text nodes are transformed.
        $parts = preg_split('/(<[^>]*>)/u', $value, -1, PREG_SPLIT_DELIM_CAPTURE);

        foreach ($parts as $i => $part) {
            if ($part === '' || $part[0] === '<') {
                continue;
            }

            foreach (static::rules() as $pattern => $replacement) {
                $part = preg_replace($pattern, $replacement, $part);
            }

            $parts[$i] = $part;
        }

        return implode('', $parts);
    }
}
