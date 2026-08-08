<?php

namespace Tests\Feature;

use App\Models\GeneralSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $response->assertSee('Our New Digital Home');
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
        $this->assertStringContainsString('Preview Animation', $settings);
    }
}
