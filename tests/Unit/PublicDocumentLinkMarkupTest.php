<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class PublicDocumentLinkMarkupTest extends TestCase
{
    public function test_public_templates_do_not_use_generic_click_to_download_copy(): void
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(dirname(__DIR__, 2).'/resources/views/frontend')
        );

        foreach ($iterator as $file) {
            if (! $file->isFile() || $file->getExtension() !== 'php') {
                continue;
            }

            $contents = file_get_contents($file->getPathname());

            $this->assertStringNotContainsString(
                'Click here to Download',
                $contents,
                $file->getPathname().' still contains generic PDF link copy.'
            );
        }
    }
}
