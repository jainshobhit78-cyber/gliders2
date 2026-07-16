<?php

namespace Tests\Feature;

use App\Support\UploadedDocument;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class UploadedDocumentTest extends TestCase
{
    private string $uploadDirectory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->uploadDirectory = storage_path('framework/testing/document-uploads');
        File::deleteDirectory($this->uploadDirectory);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->uploadDirectory);

        parent::tearDown();
    }

    public function test_pdf_upload_keeps_its_original_filename(): void
    {
        $filename = UploadedDocument::store(
            UploadedFile::fake()->create('RTI Annual Report 2026.pdf', 10, 'application/pdf'),
            $this->uploadDirectory
        );

        $this->assertSame('RTI Annual Report 2026.pdf', $filename);
        $this->assertFileExists($this->uploadDirectory.DIRECTORY_SEPARATOR.$filename);
    }

    public function test_duplicate_pdf_names_receive_a_readable_suffix(): void
    {
        $first = UploadedDocument::store(
            UploadedFile::fake()->create('Board Report.pdf', 10, 'application/pdf'),
            $this->uploadDirectory
        );
        $second = UploadedDocument::store(
            UploadedFile::fake()->create('Board Report.pdf', 10, 'application/pdf'),
            $this->uploadDirectory
        );

        $this->assertSame('Board Report.pdf', $first);
        $this->assertSame('Board Report (2).pdf', $second);
    }

    public function test_all_pdf_upload_controllers_use_the_original_name_uploader(): void
    {
        $controllers = glob(app_path('Http/Controllers/Backend/*Controller.php')) ?: [];
        $violations = [];

        foreach ($controllers as $controller) {
            $contents = file_get_contents($controller);

            if (preg_match("/hasFile\\('pdfs?'\\)/", $contents)
                && ! str_contains($contents, 'UploadedDocument::store')) {
                $violations[] = basename($controller);
            }
        }

        $this->assertSame([], $violations);
    }

    public function test_removed_homepage_social_icons_are_hidden_and_remaining_icons_are_responsive(): void
    {
        $header = file_get_contents(resource_path('views/frontend/layouts/header.blade.php'));
        $styles = file_get_contents(public_path('frontend/css/style.css'));

        $this->assertMatchesRegularExpression('/social_instagram[^>]+hidden/', $header);
        $this->assertMatchesRegularExpression('/social_youtube[^>]+hidden/', $header);
        $this->assertStringContainsString('<a href="" hidden aria-hidden="true">', $header);
        $this->assertStringContainsString('.social-links-list > a:not([hidden]) svg', $styles);
    }
}
