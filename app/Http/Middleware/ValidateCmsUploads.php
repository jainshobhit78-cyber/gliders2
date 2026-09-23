<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class ValidateCmsUploads
{
    private const MAX_IMAGE_BYTES = 5 * 1024 * 1024;

    private const MAX_PDF_BYTES = 10 * 1024 * 1024;

    private const MAX_VIDEO_BYTES = 100 * 1024 * 1024;

    private const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

    private const VIDEO_EXTENSIONS = ['mp4', 'webm', 'ogg'];

    private const PDF_EXTENSIONS = ['pdf'];

    private const BLOCKED_EXTENSIONS = [
        'php', 'phtml', 'phar', 'php3', 'php4', 'php5', 'php7', 'php8',
        'htaccess', 'cgi', 'pl', 'py', 'sh', 'bat', 'cmd', 'exe', 'dll',
        'js', 'html', 'htm', 'svg',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        foreach ($this->flattenFiles($request->allFiles()) as $upload) {
            $field = $upload['field'];
            $file = $upload['file'];

            if (! $file instanceof UploadedFile) {
                continue;
            }

            $extension = strtolower($file->getClientOriginalExtension());
            $mime = strtolower((string) $file->getMimeType());
            $originalName = strtolower($file->getClientOriginalName());

            if (! $file->isValid()) {
                return $this->uploadError($field, 'The selected file could not be uploaded. ' . $file->getErrorMessage());
            }

            if (
                in_array($extension, self::BLOCKED_EXTENSIONS, true)
                || preg_match('/\.(php\d*|phtml|phar|htaccess)(\.|$)/i', $originalName)
            ) {
                return $this->uploadError($field, 'This file type is blocked for security reasons.');
            }

            if (in_array($extension, self::IMAGE_EXTENSIONS, true)) {
                if (! str_starts_with($mime, 'image/')) {
                    return $this->uploadError($field, 'The selected image is not a valid JPG, JPEG, PNG, WEBP, or GIF file.');
                }
                if ($file->getSize() > self::MAX_IMAGE_BYTES) {
                    return $this->uploadError($field, 'The selected image must not be larger than 5 MB.');
                }
                continue;
            }

            if (in_array($extension, self::PDF_EXTENSIONS, true)) {
                if ($mime !== 'application/pdf') {
                    return $this->uploadError($field, 'The selected document is not a valid PDF file.');
                }
                if ($file->getSize() > self::MAX_PDF_BYTES) {
                    return $this->uploadError($field, 'The selected PDF must not be larger than 10 MB.');
                }
                continue;
            }

            if (in_array($extension, self::VIDEO_EXTENSIONS, true)) {
                if (! str_starts_with($mime, 'video/')) {
                    return $this->uploadError($field, 'The selected video is not a valid MP4, WEBM, or OGG file.');
                }
                if ($file->getSize() > self::MAX_VIDEO_BYTES) {
                    return $this->uploadError($field, 'The selected video must not be larger than 100 MB.');
                }
                continue;
            }

            return $this->uploadError(
                $field,
                'Unsupported file type. Upload a JPG, JPEG, PNG, WEBP, or GIF image; a PDF document; or an MP4, WEBM, or OGG video.'
            );
        }

        return $next($request);
    }

    private function uploadError(string $field, string $message)
    {
        return back()->withErrors([$field => $message])->withInput();
    }

    /**
     * @return array<int, array{field: string, file: mixed}>
     */
    private function flattenFiles(array $files, string $prefix = ''): array
    {
        $flat = [];

        foreach ($files as $key => $file) {
            $field = $prefix === '' ? (string) $key : $prefix . '.' . $key;
            if (is_array($file)) {
                $flat = array_merge($flat, $this->flattenFiles($file, $field));
            } else {
                $flat[] = ['field' => $field, 'file' => $file];
            }
        }

        return $flat;
    }
}
