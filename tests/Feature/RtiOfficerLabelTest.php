<?php

namespace Tests\Feature;

use Tests\TestCase;

class RtiOfficerLabelTest extends TestCase
{
    public function test_rti_officer_views_label_the_field_as_organisation(): void
    {
        $frontend = file_get_contents(resource_path('views/frontend/rti/index.blade.php'));

        $this->assertSame(2, substr_count($frontend, '<strong>Organisation:</strong>'));
        $this->assertStringNotContainsString('<strong>Role:</strong>', $frontend);

        foreach (['add', 'edit'] as $view) {
            $form = file_get_contents(resource_path("views/backend/rti/officers/{$view}.blade.php"));

            $this->assertStringContainsString(
                '<label class="form-label-title">Organisation</label>',
                $form
            );
            $this->assertStringContainsString('name="role"', $form);
        }
    }
}
