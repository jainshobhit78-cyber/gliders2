<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use RuntimeException;

final class UploadedDocument
{
    /**
     * Store a document under a safe version of its original filename.
     */
    public static function store(UploadedFile $file, string $directory): string
    {
        if (! is_dir($directory) && ! @mkdir($directory, 0755, true) && ! is_dir($directory)) {
            throw new RuntimeException('Unable to create the document upload directory.');
        }

        $originalName = basename(str_replace('\\', '/', $file->getClientOriginalName()));
        $baseName = pathinfo($originalName, PATHINFO_FILENAME);
        $baseName = preg_replace('/[^\pL\pN _().\-\[\]]+/u', '_', $baseName) ?: 'document';
        $baseName = trim($baseName, " .\t\n\r\0\x0B");
        $baseName = $baseName !== '' ? $baseName : 'document';

        $extension = strtolower($file->getClientOriginalExtension() ?: ($file->guessExtension() ?: 'pdf'));
        $extension = preg_replace('/[^a-z0-9]+/', '', $extension) ?: 'pdf';

        $filename = $baseName.'.'.$extension;
        $suffix = 2;

        while (file_exists($directory.DIRECTORY_SEPARATOR.$filename)) {
            $filename = sprintf('%s (%d).%s', $baseName, $suffix, $extension);
            $suffix++;
        }

        $file->move($directory, $filename);

        return $filename;
    }
}
