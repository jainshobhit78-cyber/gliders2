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
        $this->assertStringNotContainsString('autoSliderEnabled', $view);
        $this->assertStringNotContainsString('Media <span>Releases</span>', $view);
        $this->assertStringNotContainsString('card-icon-wrapper', $view);
        $this->assertStringNotContainsString('id="videoToggleBtn"', $view);
    }

    public function test_contact_and_footer_markup_match_the_requested_layout(): void
    {
        $home = file_get_contents(__DIR__.'/../../resources/views/frontend/home/index.blade.php');
        $footer = file_get_contents(__DIR__.'/../../resources/views/frontend/layouts/footer.blade.php');

        foreach (['Name', 'Company Name', 'Location', 'Email', 'Phone Number', 'Message'] as $placeholder) {
            $this->assertStringContainsString('placeholder="'.$placeholder.'"', $home);
        }

        $this->assertStringContainsString('footer-updates-scroll', $footer);
        $this->assertStringContainsString('View More Updates', $footer);
    }

    public function test_admin_product_list_exposes_homepage_order(): void
    {
        $view = file_get_contents(__DIR__.'/../../resources/views/backend/products/product/list.blade.php');

        $this->assertStringContainsString('Homepage Order', $view);
        $this->assertStringContainsString('name="homepage_order"', $view);
        $this->assertStringContainsString("route('admin.product.homepage-order'", $view);
    }
}
