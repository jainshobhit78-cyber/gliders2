<?php

namespace Tests\Feature;

use App\Http\Controllers\Backend\SystemSettingsController;
use App\Models\GeneralSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class LaunchExperienceTest extends TestCase
{
    use RefreshDatabase;

    public function test_enabled_launch_experience_appears_on_homepage_with_live_content(): void
    {
        GeneralSetting::firstOrCreate([])->update([
            'launch_animation_enabled' => true,
            'launch_animation_target_at' => '2026-08-14 18:30:00',
            'launch_animation_title' => 'Freedom Takes Flight',
            'launch_animation_message' => 'A special Independence Day message from Gliders India.',
            'launch_animation_button_text' => 'Experience the Website',
            'launch_animation_auto_reveal_seconds' => 9,
            'launch_brand_title' => 'Custom Brand',
            'launch_ribbon_title' => 'A Custom Era',
            'launch_countdown_text_3' => 'Three custom seconds',
            'launch_finale_title' => 'Custom Digital Home',
            'launch_animation_fireworks_enabled' => false,
            'launch_animation_confetti_enabled' => false,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('id="launchExperience"', false);
        $response->assertSee('Freedom Takes Flight');
        $response->assertSee('A special Independence Day message from Gliders India.');
        $response->assertSee('Experience the Website');
        $response->assertSee('data-duration="14"', false);
        $response->assertSee('id="launchCountdownNumber">5', false);
        $response->assertSee('launch-ribbon-stage', false);
        $response->assertSee('id="launchFireworksCanvas"', false);
        $response->assertSee('Custom Brand');
        $response->assertSee('A Custom Era');
        $response->assertSee('Three custom seconds');
        $response->assertSee('Custom Digital Home');
        $response->assertSee('data-fireworks="false"', false);
        $response->assertDontSee('id="launchConfettiField"', false);
        $response->assertSee('2026-08-15T00:00:00+05:30', false);
        $response->assertSee('frontend/images/logo/gliders.png');
    }

    public function test_disabled_experience_stays_off_but_can_be_previewed(): void
    {
        GeneralSetting::firstOrCreate([])->update(['launch_animation_enabled' => false]);

        $this->get('/')
            ->assertOk()
            ->assertDontSee('id="launchExperience"', false);

        $this->get('/?launch_preview=1')
            ->assertOk()
            ->assertSee('id="launchExperience"', false)
            ->assertSee('data-preview="true"', false);
    }

    public function test_launch_experience_is_limited_to_homepage(): void
    {
        GeneralSetting::firstOrCreate([])->update(['launch_animation_enabled' => true]);

        $this->get('/products')
            ->assertOk()
            ->assertDontSee('id="launchExperience"', false);
    }

    public function test_launch_settings_endpoint_persists_explicit_off_state(): void
    {
        GeneralSetting::firstOrCreate([])->update(['launch_animation_enabled' => true]);

        $request = Request::create('/admin/settings/launch', 'POST', [
            'launch_animation_enabled' => '0',
            'launch_animation_auto_reveal_seconds' => 16,
        ]);

        app(SystemSettingsController::class)->updateLaunch($request);

        $this->assertFalse(GeneralSetting::first()->fresh()->launch_animation_enabled);
    }

    public function test_launch_assets_include_session_memory_countdown_and_animated_reveal(): void
    {
        $script = file_get_contents(public_path('frontend/js/launch-experience.js'));
        $styles = file_get_contents(public_path('frontend/css/launch-experience.css'));
        $settings = file_get_contents(resource_path('views/backend/settings/index.blade.php'));

        $this->assertStringContainsString('window.sessionStorage', $script);
        $this->assertStringContainsString('enterRibbonScene', $script);
        $this->assertStringContainsString('enterCountdownScene', $script);
        $this->assertStringContainsString('enterFinaleScene', $script);
        $this->assertStringContainsString('showCountdownValue', $script);
        $this->assertStringContainsString('ribbon-cut', $script);
        $this->assertStringContainsString('revealWebsite', $script);
        $this->assertStringContainsString('@media (prefers-reduced-motion: reduce)', $styles);
        $this->assertStringContainsString('launch-transition__panel--saffron', $styles);
        $this->assertStringContainsString('launchRibbonLeft', $styles);
        $this->assertStringContainsString('launch-fireworks-canvas', $styles);
        $this->assertStringContainsString('launchNumberTick', $styles);
        $this->assertStringContainsString('name="launch_animation_enabled"', $settings);
        $this->assertStringContainsString('name="launch_countdown_text_5"', $settings);
        $this->assertStringContainsString('id="launchSettingsSubmitForm"', $settings);
        $this->assertStringContainsString('id="systemSettingsForm"', $settings);
        $this->assertStringContainsString('name="launch_animation_enabled" value="0"', $settings);
        $this->assertStringContainsString('launchPane.classList.contains("active")', $settings);
        $this->assertStringContainsString('admin.csrf.refresh', $settings);
        $this->assertStringContainsString('Preview Animation', $settings);
    }
}
