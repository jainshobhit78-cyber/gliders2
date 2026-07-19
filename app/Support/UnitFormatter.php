<?php

namespace App\Support;

class UnitFormatter
{
    /**
     * Number words understood by wordsToNumber() ("ten" -> 10, "twenty-five" -> 25).
     */
    protected static function numberWords(): array
    {
        return [
            'zero' => 0, 'one' => 1, 'two' => 2, 'three' => 3, 'four' => 4,
            'five' => 5, 'six' => 6, 'seven' => 7, 'eight' => 8, 'nine' => 9,
            'ten' => 10, 'eleven' => 11, 'twelve' => 12, 'thirteen' => 13,
            'fourteen' => 14, 'fifteen' => 15, 'sixteen' => 16, 'seventeen' => 17,
            'eighteen' => 18, 'nineteen' => 19, 'twenty' => 20, 'thirty' => 30,
            'forty' => 40, 'fifty' => 50, 'sixty' => 60, 'seventy' => 70,
            'eighty' => 80, 'ninety' => 90,
        ];
    }

    /**
     * Spelled-out unit names mapped to their accepted symbols. Ordered longest-first
     * so "millimetres" is matched before "metres".
     */
    protected static function spelledUnits(): array
    {
        return [
            'mill?imet(?:er|re)s?'  => 'mm',
            'centimet(?:er|re)s?'   => 'cm',
            'kilomet(?:er|re)s?'    => 'km',
            'met(?:er|re)s?|mtrs?'  => 'm',
            'kilograms?'            => 'kg',
            'milligrams?'           => 'mg',
            'grams?'                => 'g',
            'sec(?:ond)?s?'         => 's',
            'minutes?'              => 'min',
            'hours?'                => 'h',
            'inch(?:es)?'           => 'in',
            'feet|foot'             => 'ft',
            'yards?'                => 'yd',
            'pounds?|lbs?'          => 'lb',
            'lit(?:er|re)s?'        => 'L',
            'newtons?'              => 'N',
            'percent'               => '%',
        ];
    }

    /** Single alternation of every spelled-out unit name. */
    protected static function spelledUnitPattern(): string
    {
        return implode('|', array_keys(static::spelledUnits()));
    }

    /** Resolve a matched spelled-out unit word to its symbol. */
    protected static function unitSymbol(string $word): string
    {
        foreach (static::spelledUnits() as $pattern => $symbol) {
            if (preg_match('/^(?:' . $pattern . ')$/iu', $word)) {
                return $symbol;
            }
        }

        return $word;
    }

    /** "twenty-five" -> 25. Returns null if the phrase isn't a plain number. */
    protected static function wordsToNumber(string $phrase): ?int
    {
        $map = static::numberWords();
        $tokens = preg_split('/[\s\-]+|\band\b/iu', strtolower(trim($phrase)), -1, PREG_SPLIT_NO_EMPTY);

        $total = 0;
        $current = 0;
        $seen = false;

        foreach ($tokens as $tok) {
            if (isset($map[$tok])) {
                $current += $map[$tok];
                $seen = true;
            } elseif ($tok === 'hundred') {
                $current = max($current, 1) * 100;
                $seen = true;
            } elseif ($tok === 'thousand') {
                $total += max($current, 1) * 1000;
                $current = 0;
                $seen = true;
            } else {
                return null;
            }
        }

        return $seen ? $total + $current : null;
    }

    /**
     * Simple regex rules for compound/abbreviated units. These run before the
     * spelled-out passes because "m/sec" and "sq m" must not be split apart.
     */
    protected static function rules(): array
    {
        return [
            // m/sec, meter/second, metres / sec  ->  m/s
            '/\b(?:m|met(?:er|re)s?)\s*\/\s*sec(?:ond)?s?\b\.?/iu' => 'm/s',

            // km/h, km/hr, kph, Kmph -> kmph
            '/\bkm\s*\/\s*hr?\b/iu' => 'kmph',
            '/\bkm?ph\b/iu'         => 'kmph',

            // square metres: sqm, sq m, Sq. Mtr. -> m²
            '/\bsq\.?\s*(?:m|mtrs?|met(?:er|re)s?)\.?(?![a-z])/iu' => 'm²',

            // kilograms: Kg, KG, Kgs -> kg
            '/\bkgs?\b/iu' => 'kg',

            // grams per square metre: GSM, Gsm -> gsm
            '/\bgsm\b/iu' => 'gsm',

            // knots lowercase (kept as a word; "kn" reads poorly in prose)
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

        $parts = preg_split('/(<[^>]*>)/u', $value, -1, PREG_SPLIT_DELIM_CAPTURE);

        foreach ($parts as $i => $part) {
            if ($part === '' || $part[0] === '<') {
                continue;
            }

            foreach (static::rules() as $pattern => $replacement) {
                $part = preg_replace($pattern, $replacement, $part);
            }

            $part = static::convertSpelledNumbers($part);
            $part = static::convertSpelledUnits($part);

            $parts[$i] = $part;
        }

        return implode('', $parts);
    }

    /**
     * "ten millimetres" -> "10 mm". Only fires when the number word is directly
     * followed by a unit name, so ordinary prose ("one of the systems") is safe.
     */
    protected static function convertSpelledNumbers(string $text): string
    {
        $numberWord = implode('|', array_merge(array_keys(static::numberWords()), ['hundred', 'thousand']));
        $phrase = '(?:' . $numberWord . ')(?:[\s\-]+(?:and[\s\-]+)?(?:' . $numberWord . '))*';
        $pattern = '/\b(' . $phrase . ')\s+(' . static::spelledUnitPattern() . ')\b\.?/iu';

        return preg_replace_callback($pattern, function ($m) {
            $number = static::wordsToNumber($m[1]);

            if ($number === null) {
                return $m[0];
            }

            $symbol = static::unitSymbol($m[2]);

            return $number . ($symbol === '%' ? '' : ' ') . $symbol;
        }, $text) ?? $text;
    }

    /**
     * "10 millimetres" -> "10 mm". Requires a preceding number so genuine nouns
     * ("foot pump", "meter reading", "second stage") are never touched.
     */
    protected static function convertSpelledUnits(string $text): string
    {
        $pattern = '/(?<=\d)(\s*)(' . static::spelledUnitPattern() . ')\b\.?/iu';

        return preg_replace_callback($pattern, function ($m) {
            $symbol = static::unitSymbol($m[2]);

            if ($symbol === '%') {
                return $symbol;
            }

            return ($m[1] === '' ? ' ' : $m[1]) . $symbol;
        }, $text) ?? $text;
    }
}
