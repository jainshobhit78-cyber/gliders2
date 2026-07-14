<?php

namespace Tests\Feature;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Tests\TestCase;

class AdminCrudMarkupTest extends TestCase
{
    public function test_admin_views_do_not_link_directly_to_destructive_routes(): void
    {
        $violations = [];
        $views = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(resource_path('views/backend'))
        );

        foreach ($views as $view) {
            if (! $view->isFile() || ! str_ends_with($view->getFilename(), '.blade.php')) {
                continue;
            }

            $contents = file_get_contents($view->getPathname());
            preg_match_all('/<a\b(?:(?!<\/a>).)*<\/a>/is', $contents, $anchors);

            foreach ($anchors[0] as $anchor) {
                if (preg_match('/href\s*=.*(?:delete|destroy)/is', $anchor)) {
                    $violations[] = $view->getPathname();
                }
            }
        }

        $this->assertSame([], array_values(array_unique($violations)),
            "Destructive routes must use CSRF-protected forms, not links.\n".implode("\n", $violations)
        );
    }

    public function test_destructive_routes_reject_get_requests(): void
    {
        foreach (app('router')->getRoutes() as $route) {
            if (! preg_match('/(?:delete|destroy)/i', $route->uri())) {
                continue;
            }

            $this->assertNotContains('GET', $route->methods(), $route->uri().' must not accept GET.');

            $expectedMethod = $route->uri() === 'admin/destroy/{id}' ? 'POST' : 'DELETE';
            $this->assertContains($expectedMethod, $route->methods(),
                $route->uri().' must accept '.$expectedMethod.'.'
            );
        }
    }

    public function test_delete_component_spoofs_delete_and_includes_csrf_protection(): void
    {
        $component = file_get_contents(resource_path('views/components/delete-form.blade.php'));

        $this->assertStringContainsString('@csrf', $component);
        $this->assertStringContainsString("@method('DELETE')", $component);
        $this->assertStringContainsString('method="POST"', $component);
    }

    public function test_leadership_forms_include_position_without_duplicate_dynamic_ids(): void
    {
        foreach (['add', 'edit'] as $view) {
            $contents = file_get_contents(resource_path("views/backend/about/leadership/{$view}.blade.php"));

            $this->assertStringContainsString('name="position"', $contents);
            $this->assertStringNotContainsString('id="bioEditor"', $contents);
            $this->assertStringNotContainsString('id="pictureInput"', $contents);
            $this->assertStringNotContainsString('id="imagePreview"', $contents);
        }
    }

    public function test_category_templates_have_one_valid_script_section(): void
    {
        foreach (['add', 'edit'] as $view) {
            $contents = file_get_contents(resource_path("views/backend/products/categories/{$view}.blade.php"));

            $this->assertSame(1, substr_count($contents, "@section('script')"));
            preg_match_all('/<script\b[^>]*>(.*?)<\/script>/is', $contents, $scripts);

            foreach ($scripts[1] as $script) {
                $this->assertDoesNotMatchRegularExpression(
                    '/^\s*<\/?(?:div|form|select|button)\b/im',
                    $script
                );
            }
        }
    }
}
