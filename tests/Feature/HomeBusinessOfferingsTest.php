<?php

namespace Tests\Feature;

use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeBusinessOfferingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_lists_the_three_business_offerings_and_partner_heading(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Our <span>Offerings</span>', false);
        $response->assertSee('Parachutes');
        $response->assertSee('Rubber Inflatables');
        $response->assertSee('Technical Clothing');
        $response->assertSee(route('products.index', ['offering' => 'parachutes']));
        $response->assertSee(route('products.index', ['offering' => 'rubber-inflatables']));
        $response->assertSee(route('products.index', ['offering' => 'technical-clothing']));
        $response->assertSee('Our Business');
        $response->assertSee('Partners');
        $response->assertDontSee('Trusted by Forces,');
        $response->assertDontSee('Experienced');
        $response->assertDontSee('Leadership Team');
        $response->assertDontSee('Commitment to');
        $response->assertDontSee('Driving Innovation');
        $response->assertSee('products-title-line');
    }

    public function test_rubber_offering_contains_floats_and_inflatable_boats_only(): void
    {
        ProductCategory::create(['name' => 'KM Floats', 'status' => 'Active']);
        ProductCategory::create(['name' => 'Inflatable Boats', 'status' => 'Active']);
        ProductCategory::create(['name' => 'Parachute Systems', 'status' => 'Active']);

        $response = $this->get(route('products.index', ['offering' => 'rubber-inflatables']));

        $response->assertOk();
        $response->assertSee('Rubber Inflatables');
        $response->assertSee('KM Floats');
        $response->assertSee('Inflatable Boats');
        $response->assertDontSee('Parachute Systems');
    }

    public function test_parachute_offering_contains_parachute_products(): void
    {
        ProductCategory::create(['name' => 'Brake Parachutes', 'status' => 'Active']);
        ProductCategory::create(['name' => 'Man Carrying Parachutes', 'status' => 'Active']);
        ProductCategory::create(['name' => 'Rubber Products', 'status' => 'Active']);

        $response = $this->get(route('products.index', ['offering' => 'parachutes']));

        $response->assertOk();
        $response->assertSee('Parachutes');
        $response->assertSee('Brake Parachutes');
        $response->assertSee('Man Carrying Parachutes');
        $response->assertDontSee('Rubber Products');
    }

    public function test_technical_clothing_shows_coming_soon_until_products_are_added(): void
    {
        $response = $this->get(route('products.index', ['offering' => 'technical-clothing']));

        $response->assertOk();
        $response->assertSee('Technical Clothing');
        $response->assertSee('Coming Soon');

        ProductCategory::create(['name' => 'Technical Clothing', 'status' => 'Active']);

        $response = $this->get(route('products.index', ['offering' => 'technical-clothing']));

        $response->assertOk();
        $response->assertSee('Technical Clothing');
        $response->assertDontSee('New technical clothing will appear here when they are added.');
    }

    public function test_legacy_offering_url_redirects_to_the_products_page_filter(): void
    {
        $this->get(route('products.offering', 'parachutes'))
            ->assertRedirect(route('products.index', ['offering' => 'parachutes']));
    }

    public function test_unfiltered_products_page_keeps_its_original_heading_and_all_categories(): void
    {
        ProductCategory::create(['name' => 'Brake Parachutes', 'status' => 'Active']);
        ProductCategory::create(['name' => 'KM Floats', 'status' => 'Active']);

        $response = $this->get(route('products.index'));

        $response->assertOk();
        $response->assertSee('Our Products');
        $response->assertSee('Brake Parachutes');
        $response->assertSee('KM Floats');
    }

    public function test_homepage_leadership_cards_use_a_uniform_layout(): void
    {
        $styles = file_get_contents(public_path('frontend/css/style.css'));

        $this->assertStringContainsString('align-items: stretch;', $styles);
        $this->assertStringContainsString('overflow: hidden !important;', $styles);
        $this->assertStringContainsString('max-width: 400px;', $styles);
        $this->assertStringContainsString('min-height: 550px;', $styles);
        $this->assertStringContainsString('.managementSlider .leader-img img', $styles);
        $this->assertStringContainsString('object-fit: cover;', $styles);
        $this->assertStringContainsString('.managementSlider .leader-card .profile-btn', $styles);
    }
}
