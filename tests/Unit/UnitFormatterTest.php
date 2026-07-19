<?php

namespace Tests\Unit;

use App\Support\UnitFormatter;
use PHPUnit\Framework\TestCase;

class UnitFormatterTest extends TestCase
{
    public function test_it_uses_consistent_measurement_symbols(): void
    {
        $text = '100 Gsm, 285 Kmph, 800 Kg, 7 m/sec, 17 Sq. Mtr., 105 gm, 6000 M and ten millimeters.';

        $this->assertSame(
            '100 gsm, 285 kmph, 800 kg, 7 m/s, 17 m², 105 g, 6000 m and 10 mm.',
            UnitFormatter::normalize($text)
        );
    }

    public function test_it_normalizes_product_content_arrays_without_altering_html_tags(): void
    {
        $content = [
            'parameter' => 'Length 4.7 meters',
            'value' => '130 kgs',
            'description' => '<p>Maximum descent: 5 seconds at 7 m/sec.</p>',
        ];

        $this->assertSame([
            'parameter' => 'Length 4.7 m',
            'value' => '130 kg',
            'description' => '<p>Maximum descent: 5 s at 7 m/s.</p>',
        ], UnitFormatter::normalize($content));
    }
}
