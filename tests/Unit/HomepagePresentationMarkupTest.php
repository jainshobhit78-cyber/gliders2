<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class HomepagePresentationMarkupTest extends TestCase
{
    public function test_homepage_uses_manual_product_controls_and_no_media_release_section(): void
    {
        $view = file_get_contents(__DIR__.'/../../resources/views/frontend/home/index.blade.php');

        $this->assertStringContainsString('product-slider-prev', $view);
        $this->assertStringContainsString('product-slider-next', $view);
        $this->assertStringContainsString('loop: false', $view);
        $this->assertStringContainsString('autoplay: false', $view);
        $this->assertStringContainsString('grabCursor: true', $view);
        $this->assertStringNotContainsString('autoSliderEnabled', $view);
        $this->assertStringNotContainsString('Media <span>Releases</span>', $view);
        $this->assertStringNotContainsString('card-icon-wrapper', $view);
        $this->assertStringNotContainsString('id="videoToggleBtn"', $view);
        $this->assertStringContainsString('id="heroVideoStop"', $view);
        $this->assertStringContainsString('video.muted = false', $view);
    }

    public function test_contact_and_footer_markup_match_the_requested_layout(): void
    {
        $home = file_get_contents(__DIR__.'/../../resources/views/frontend/home/index.blade.php');
        $footer = file_get_contents(__DIR__.'/../../resources/views/frontend/layouts/footer.blade.php');

        foreach (['Name', 'Company Name', 'Location', 'Email', 'Phone Number', 'Message'] as $placeholder) {
            $this->assertStringContainsString('placeholder="'.$placeholder.'"', $home);
        }

        $this->assertStringContainsString('footer-updates-scroll', $footer);
        $this->assertStringContainsString("route('news.show', \$news->id)", $footer);
        $this->assertStringNotContainsString("route('news.category', \$news->category_id)", $footer);
        $this->assertStringContainsString('View More Updates', $footer);
        $this->assertStringContainsString("route('products.index')", $footer);
        $this->assertStringContainsString("route('careers')", $footer);
        $this->assertStringContainsString('footer-balanced-column', $footer);
        $this->assertStringContainsString('footer-column-body', $footer);

        $css = file_get_contents(__DIR__.'/../../public/frontend/css/style.css');
        $this->assertStringContainsString('color: #ff9f4b !important;', $css);
        $this->assertStringNotContainsString('.premium-product-card[class*="theme-"] .btn-view-details {', $css);
        $this->assertStringContainsString('.hero-banner.video-interacted .hero-video-stop', $css);
    }

    public function test_outdated_commercial_news_is_removed_by_migration(): void
    {
        $migration = file_get_contents(__DIR__.'/../../database/migrations/2026_09_24_030000_remove_outdated_commercial_news.php');

        $this->assertStringContainsString('Record $3.7 Million Export Order Secured by Gloders India.', $migration);
        $this->assertStringContainsString('DPSUs get a 340 crore boost', $migration);
        $this->assertStringContainsString("whereIn('title', self::TITLES)->delete()", $migration);
    }

    public function test_admin_product_list_exposes_homepage_order(): void
    {
        $view = file_get_contents(__DIR__.'/../../resources/views/backend/products/product/list.blade.php');

        $this->assertStringContainsString('Homepage Order', $view);
        $this->assertStringContainsString('name="homepage_order"', $view);
        $this->assertStringContainsString("route('admin.product.homepage-order'", $view);
    }

    public function test_homepage_product_showcase_uses_twelve_curated_catalogue_photos_in_order(): void
    {
        $controller = file_get_contents(__DIR__.'/../../app/Http/Controllers/Frontend/HomeController.php');
        $css = file_get_contents(__DIR__.'/../../public/frontend/css/style.css');
        $orderedProducts = [
            "[0, 'Man Carrying Parachutes', 'BMK-41'",
            "[0, 'Man Carrying Parachutes', 'Seat Mk-10'",
            "[1, 'Brake Parachutes', 'LCA (Tejas)'",
            "[1, 'Brake Parachutes', 'SU-30'",
            "[2, 'Man Carrying Parachutes', 'PTA-M'",
            "[2, 'Man Carrying Parachutes', 'PTA-R'",
            "[3, 'Cargo Parachutes', 'P-7 Heavy Drop'",
            "[3, 'Cargo Parachutes', 'ECAD'",
            "[4, 'Rubber Inflatables', 'BAPLW'",
            "[4, 'Rubber Inflatables', 'Gemini Craft'",
            "[5, 'Technical Clothing', 'NBC Suit'",
            "[5, 'Technical Clothing', 'Wind Cheater'",
        ];

        $previousPosition = -1;
        foreach ($orderedProducts as $productSlot) {
            $position = strpos($controller, $productSlot);
            $this->assertNotFalse($position, "Missing homepage product slot: {$productSlot}");
            $this->assertGreaterThan($previousPosition, $position, 'Homepage product slots must keep the approved order.');
            $previousPosition = $position;
        }

        $this->assertSame(12, substr_count($controller, '.jpg\'],'));
        $this->assertStringContainsString('object-fit: contain !important;', $css);
        $this->assertStringContainsString('background-image: var(--homepage-product-photo);', $css);
    }
}
