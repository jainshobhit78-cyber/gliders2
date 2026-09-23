<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VisualCaptcha
{
    public const LENGTH = 5;

    private const ALPHABET = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';

    public static function issue(Request $request, string $context): string
    {
        self::assertContext($context);

        $code = '';
        $max = strlen(self::ALPHABET) - 1;

        for ($i = 0; $i < self::LENGTH; $i++) {
            $code .= self::ALPHABET[random_int(0, $max)];
        }

        $request->session()->put(self::sessionKey($context), self::digest($code));
        $request->session()->put(self::issuedAtKey($context), now()->timestamp);

        return $code;
    }

    public static function verify(Request $request, string $context, ?string $answer): bool
    {
        self::assertContext($context);

        $stored = (string) $request->session()->pull(self::sessionKey($context), '');
        $issuedAt = (int) $request->session()->pull(self::issuedAtKey($context), 0);
        $normalised = Str::upper(trim((string) $answer));

        if ($stored === '' || $issuedAt < now()->subMinutes(10)->timestamp) {
            return false;
        }

        return hash_equals($stored, self::digest($normalised));
    }

    public static function renderPng(string $code): string
    {
        $width = 220;
        $height = 70;
        $canvas = imagecreatetruecolor($width, $height);

        $navy = imagecolorallocate($canvas, 5, 22, 50);
        $navyLight = imagecolorallocate($canvas, 15, 50, 92);
        $orange = imagecolorallocate($canvas, 245, 130, 31);
        $white = imagecolorallocate($canvas, 242, 247, 255);
        $muted = imagecolorallocate($canvas, 91, 128, 171);

        imagefill($canvas, 0, 0, $navy);

        for ($i = 0; $i < 10; $i++) {
            imageline(
                $canvas,
                random_int(0, $width),
                random_int(0, $height),
                random_int(0, $width),
                random_int(0, $height),
                $i % 3 === 0 ? $orange : $navyLight
            );
        }

        for ($i = 0; $i < 180; $i++) {
            imagesetpixel($canvas, random_int(0, $width - 1), random_int(0, $height - 1), $muted);
        }

        foreach (str_split($code) as $index => $character) {
            $glyph = imagecreatetruecolor(34, 42);
            imagealphablending($glyph, false);
            imagesavealpha($glyph, true);
            $transparent = imagecolorallocatealpha($glyph, 0, 0, 0, 127);
            imagefill($glyph, 0, 0, $transparent);

            $glyphColour = imagecolorallocate($glyph, $index % 2 === 0 ? 242 : 245, $index % 2 === 0 ? 247 : 130, $index % 2 === 0 ? 255 : 31);
            imagestring($glyph, 5, 9, 11, $character, $glyphColour);

            $scaled = imagecreatetruecolor(45, 56);
            imagealphablending($scaled, false);
            imagesavealpha($scaled, true);
            imagefill($scaled, 0, 0, imagecolorallocatealpha($scaled, 0, 0, 0, 127));
            imagecopyresampled($scaled, $glyph, 0, 0, 0, 0, 45, 56, 34, 42);
            imagedestroy($glyph);

            $rotated = imagerotate($scaled, random_int(-13, 13), imagecolorallocatealpha($scaled, 0, 0, 0, 127));
            imagesavealpha($rotated, true);
            imagedestroy($scaled);

            $x = 9 + ($index * 41) + random_int(-2, 2);
            $y = 7 + random_int(-3, 3);
            imagecopy($canvas, $rotated, $x, $y, 0, 0, imagesx($rotated), imagesy($rotated));
            imagedestroy($rotated);
        }

        ob_start();
        imagepng($canvas, null, 7);
        $png = (string) ob_get_clean();
        imagedestroy($canvas);

        return $png;
    }

    public static function limiterKey(string $context, Request $request): string
    {
        self::assertContext($context);

        return 'captcha-failures:' . $context . '|' . $request->ip();
    }

    private static function digest(string $value): string
    {
        return hash_hmac('sha256', Str::upper(trim($value)), (string) config('app.key'));
    }

    private static function sessionKey(string $context): string
    {
        return 'visual_captcha.' . $context . '.hash';
    }

    private static function issuedAtKey(string $context): string
    {
        return 'visual_captcha.' . $context . '.issued_at';
    }

    private static function assertContext(string $context): void
    {
        abort_unless(in_array($context, ['admin', 'public'], true), 404);
    }
}
