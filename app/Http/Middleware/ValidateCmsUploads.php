<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class ValidateCmsUploads
{
    private const MAX_UPLOAD_KB = 51200;

    private const ALLOWED_EXTENSIONS = [
        'jpg', 'jpeg', 'png', 'webp', 'gif',
        'pdf',
        'mp4', 'webm', 'ogg',
    ];

    private const ALLOWED_MIME_PREFIXES = [
        'image/',
        'video/',
    ];

    private const ALLOWED_MIMES = [
        'application/pdf',
    ];

    private const BLOCKED_EXTENSIONS = [
        'php', 'phtml', 'phar', 'php3', 'php4', 'php5', 'php7', 'php8',
        'htaccess', 'cgi', 'pl', 'py', 'sh', 'bat', 'cmd', 'exe', 'dll',
        'js', 'html', 'htm', 'svg',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        foreach ($this->flattenFiles($request->allFiles()) as $file) {
            if (!$file instanceof UploadedFile) {
                continue;
            }

            $extension = strtolower($file->getClientOriginalExtension());
            $mime = strtolower((string) $file->getMimeType());
            $originalName = strtolower($file->getClientOriginalName());

            if (
                !$file->isValid()
                || $file->getSize() > self::MAX_UPLOAD_KB * 1024
                || in_array($extension, self::BLOCKED_EXTENSIONS, true)
                || preg_match('/\.(php\d*|phtml|phar|htaccess)(\.|$)/i', $originalName)
                || !in_array($extension, self::ALLOWED_EXTENSIONS, true)
                || !$this->isAllowedMime($mime)
            ) {
                abort(422, 'Uploaded file type or size is not allowed.');
            }
        }

        return $next($request);
    }

    private function isAllowedMime(string $mime): bool
    {
        if (in_array($mime, self::ALLOWED_MIMES, true)) {
            return true;
        }

        foreach (self::ALLOWED_MIME_PREFIXES as $prefix) {
            if (str_starts_with($mime, $prefix)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array<int, mixed>
     */
    private function flattenFiles(array $files): array
    {
        $flat = [];

        array_walk_recursive($files, function ($file) use (&$flat) {
            $flat[] = $file;
        });

        return $flat;
    }
}
