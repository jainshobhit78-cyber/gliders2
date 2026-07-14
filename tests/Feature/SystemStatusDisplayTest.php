<?php

namespace Tests\Feature;

use App\Support\SystemStatus;
use Tests\TestCase;

class SystemStatusDisplayTest extends TestCase
{
    public function test_login_displays_live_client_and_connection_details(): void
    {
        $response = $this
            ->withServerVariables([
                'REMOTE_ADDR' => '203.0.113.42',
                'HTTPS' => 'on',
                'SSL_PROTOCOL' => 'TLSv1.3',
            ])
            ->get('https://gliders.test/admin/login');

        $response->assertOk();
        $response->assertSee('IP: 203.0.113.42');
        $response->assertSee('TLSv1.3');
        $response->assertDontSee('10.89.0.21');
        $response->assertDontSee('18 JUN 2025');
    }

    public function test_system_snapshot_contains_the_current_deployment_time(): void
    {
        $status = app(SystemStatus::class)->snapshot(request());

        $this->assertNotEmpty($status['deployed_at_iso']);
        $this->assertMatchesRegularExpression('/^\d{2} [A-Z]{3} \d{2}:\d{2}$/', $status['deployed_at_label']);
        $this->assertStringEndsWith(' IST', $status['deployed_at_title']);
    }

    public function test_sidebar_no_longer_contains_placeholder_status_values(): void
    {
        $sidebar = file_get_contents(resource_path('views/backend/layout/sidebar.blade.php'));

        $this->assertStringNotContainsString('15D : 04H : 32M', $sidebar);
        $this->assertStringContainsString("$"."systemStatus['database_online']", $sidebar);
        $this->assertStringContainsString('LAST DEPLOY', $sidebar);
        $this->assertStringContainsString("$"."systemStatus['deployed_at_label']", $sidebar);
    }
}
