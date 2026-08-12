<?php

namespace Tests\Unit;

use App\Support\DocumentLink;
use PHPUnit\Framework\TestCase;

class DocumentLinkTest extends TestCase
{
    public function test_it_removes_legacy_timestamp_prefixes(): void
    {
        $this->assertSame(
            'Adv_03_2026.pdf',
            DocumentLink::downloadName('1780566177_Adv_03_2026.pdf', 'Advertisement')
        );
    }

    public function test_it_removes_multiple_legacy_prefixes(): void
    {
        $this->assertSame(
            'Annual Report 2024-25.pdf',
            DocumentLink::downloadName('1780401170_6a1ec41207570_Annual Report 2024-25.pdf', 'Annual Report')
        );
    }

    public function test_it_replaces_numeric_names_with_the_document_title(): void
    {
        $this->assertSame(
            'Adv_03_2026.pdf',
            DocumentLink::downloadName('1237689.pdf', 'Adv 03 2026')
        );
    }

    public function test_it_keeps_current_original_filenames(): void
    {
        $this->assertSame(
            'Recruitment Notice (Final).pdf',
            DocumentLink::downloadName('Recruitment Notice (Final).pdf', 'Advertisement')
        );
    }
}
