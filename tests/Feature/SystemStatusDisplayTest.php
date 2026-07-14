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

    public function test_uptime_is_formatted_for_the_status_card(): void
    {
        $seconds = (2 * 86400) + (3 * 3600) + (4 * 60) + 5;

        $this->assertSame('02D : 03H : 04M', SystemStatus::formatUptime($seconds));
        $this->assertSame('Unavailable', SystemStatus::formatUptime(null));
    }

    public function test_sidebar_no_longer_contains_placeholder_status_values(): void
    {
        $sidebar = file_get_contents(resource_path('views/backend/layout/sidebar.blade.php'));

        $this->assertStringNotContainsString('15D : 04H : 32M', $sidebar);
        $this->assertStringContainsString("$"."systemStatus['database_online']", $sidebar);
        $this->assertStringContainsString('data-uptime-seconds', $sidebar);
    }
}
