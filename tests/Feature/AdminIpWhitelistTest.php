<?php

namespace Tests\Feature;

use App\Models\GeneralSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminIpWhitelistTest extends TestCase
{
    use RefreshDatabase;

    public function test_unapproved_ip_cannot_view_admin_login_page(): void
    {
        GeneralSetting::query()->firstOrCreate([])->update([
            'ip_whitelist' => '103.199.204.226, 103.110.48.180',
        ]);

        $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.77'])
            ->get('/admin/login')
            ->assertForbidden();
    }

    public function test_approved_ip_can_view_admin_login_page(): void
    {
        GeneralSetting::query()->firstOrCreate([])->update([
            'ip_whitelist' => '103.199.204.226, 103.110.48.180',
        ]);

        $this->withServerVariables(['REMOTE_ADDR' => '103.199.204.226'])
            ->get('/admin/login')
            ->assertOk();
    }

    public function test_forwarded_for_header_does_not_bypass_allowlist(): void
    {
        GeneralSetting::query()->firstOrCreate([])->update([
            'ip_whitelist' => '103.199.204.226',
        ]);

        $this->withServerVariables(['REMOTE_ADDR' => '198.51.100.77'])
            ->withHeader('X-Forwarded-For', '103.199.204.226')
            ->get('/admin/login')
            ->assertForbidden();
    }
}
