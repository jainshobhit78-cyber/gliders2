<?php

namespace Tests\Feature;

use App\Models\Product;
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
        $response->assertSee(route('products.offering', 'parachutes'));
        $response->assertSee(route('products.offering', 'rubber-inflatables'));
        $response->assertSee(route('products.offering', 'technical-clothing'));
        $response->assertSee('Our Business');
        $response->assertSee('Partners');
        $response->assertDontSee('Trusted by Forces,');
    }

    public function test_rubber_offering_contains_floats_and_inflatable_boats_only(): void
    {
        $rubber = ProductCategory::create(['name' => 'Rubber Products', 'status' => 'Active']);
        $parachutes = ProductCategory::create(['name' => 'Parachute Systems', 'status' => 'Active']);

        Product::create(['category_id' => $rubber->id, 'title' => 'KM Float Assembly']);
        Product::create(['category_id' => $rubber->id, 'title' => 'Inflatable Assault Boat']);
        Product::create(['category_id' => $parachutes->id, 'title' => 'Personnel Parachute']);

        $response = $this->get(route('products.offering', 'rubber-inflatables'));

        $response->assertOk();
        $response->assertSee('KM Float Assembly');
        $response->assertSee('Inflatable Assault Boat');
        $response->assertDontSee('Personnel Parachute');
    }

    public function test_parachute_offering_contains_parachute_products(): void
    {
        $category = ProductCategory::create(['name' => 'Aerial Systems', 'status' => 'Active']);
        Product::create(['category_id' => $category->id, 'title' => 'Brake Parachute']);
        Product::create(['category_id' => $category->id, 'title' => 'Unrelated Navigation Unit']);

        $response = $this->get(route('products.offering', 'parachutes'));

        $response->assertOk();
        $response->assertSee('Brake Parachute');
        $response->assertDontSee('Unrelated Navigation Unit');
    }

    public function test_technical_clothing_shows_coming_soon_until_products_are_added(): void
    {
        $response = $this->get(route('products.offering', 'technical-clothing'));

        $response->assertOk();
        $response->assertSee('Technical Clothing');
        $response->assertSee('Coming Soon');

        $category = ProductCategory::create(['name' => 'Technical Clothing', 'status' => 'Active']);
        Product::create(['category_id' => $category->id, 'title' => 'Protective Flight Suit']);

        $response = $this->get(route('products.offering', 'technical-clothing'));

        $response->assertOk();
        $response->assertSee('Protective Flight Suit');
        $response->assertDontSee('Our team is preparing this product range.');
    }
}
