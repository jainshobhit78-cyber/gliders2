<?php

namespace Tests\Feature;

use App\Support\BrakeParachuteSpecifications;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MarkedParachuteProductCorrectionsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->longText('specs_subtext')->nullable();
            $table->longText('technical_specs')->nullable();
            $table->longText('main_capabilities')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('products');
        parent::tearDown();
    }

    public function test_all_brake_products_have_the_same_eight_headings_and_corrected_values(): void
    {
        foreach (['Tejas', 'SU-30', 'MiG-29', 'MIG-21/23/25', 'Mirage-2000', 'Jaguar', 'Hawk'] as $name) {
            $this->insert("Brake Parachute for {$name}");
        }
        $this->insert('Unrelated product', [['parameter' => 'Original', 'value' => 'unchanged']]);

        $migration = require database_path('migrations/2026_09_22_010000_apply_marked_parachute_product_corrections.php');
        $migration->up();

        foreach (['Tejas', 'SU-30', 'MiG-29', 'MIG-21/23/25', 'Mirage-2000', 'Jaguar', 'Hawk'] as $name) {
            $specs = $this->specs($name);
            $this->assertSame(BrakeParachuteSpecifications::HEADINGS, array_column($specs, 'parameter'));
            $this->assertCount(8, $specs);
        }
        $this->assertSame('MiG-21: 15.2 m²; MiG-23: 21 m²; MiG-25: 25 m² (twin canopies)', $this->specs('MIG-21/23/25')[1]['value']);
        $this->assertSame('5.75 m / 1.73 m', $this->specs('Tejas')[2]['value']);
        $this->assertStringContainsString('32 / 6500 mm', $this->specs('SU-30')[5]['description']);
        $this->assertSame('unchanged', $this->specs('Unrelated')[0]['value']);

        // Maintenance reseeds and manual reruns must not duplicate rows.
        $migration->up();
        $this->assertCount(8, $this->specs('Tejas'));
    }

    public function test_non_brake_corrections_preserve_their_own_specification_layout(): void
    {
        $this->insert('Parachute Recovery System for PTA-Lakshya MK-II', [
            ['parameter' => 'Recovery Altitude', 'value' => '300 m to 9 km'],
            ['parameter' => 'Rate of Descent / Max Recovery Mass', 'value' => '6–7 m/s / 500 kg'],
        ]);
        $this->insert('P-7 Heavy Drop System for IL-76 Aircraft', [
            ['parameter' => 'Platform Size', 'value' => '4216 × 2802 × 193 mm'],
            ['parameter' => 'Landing Speed', 'value' => '7 m/s'],
        ]);
        $this->insert('Parachute Paratroop Type PTR-M', [
            ['parameter' => 'Dropping Load Limit', 'value' => '160 kg'],
            ['parameter' => 'Rate of Descent', 'value' => '4.5–5.8 m/s'],
        ]);

        $migration = require database_path('migrations/2026_09_22_010000_apply_marked_parachute_product_corrections.php');
        $migration->up();

        $lakshya = $this->specs('Lakshya');
        $this->assertSame('300 m to 9 km AGL', $lakshya[0]['value']);
        $this->assertCount(1, $lakshya);
        $this->assertSame('4216 × 2602 × 193 mm', $this->specs('P-7')[0]['value']);
        $this->assertSame('8 m/s', $this->specs('P-7')[1]['value']);
        $this->assertSame('113.6 kg', $this->specs('PTR-M')[0]['value']);
        $this->assertSame(
            '100 jumps or 15 years from manufacture, whichever is earlier',
            collect($this->specs('PTR-M'))->firstWhere('parameter', 'Life of Parachute')['value']
        );
    }

    public function test_admin_saves_cannot_rename_or_reorder_brake_headings(): void
    {
        $submitted = array_fill(0, 8, ['parameter' => 'Changed heading', 'value' => 'value']);
        $saved = BrakeParachuteSpecifications::forAdminSave('Brake Parachute for Hawk', $submitted);
        $this->assertSame(BrakeParachuteSpecifications::HEADINGS, array_column($saved, 'parameter'));
        $this->assertSame($submitted, BrakeParachuteSpecifications::forAdminSave('Parasail Assembly', $submitted));
    }

    public function test_remaining_marked_products_map_to_their_specific_corrections(): void
    {
        $cases = [
            ['Parasail Assembly', 'Diameter of Canopy', '7.230 m'],
            ['High Altitude Parachute (HAP)', 'Rate of descent', '16–18 ft/s (approx.)'],
            ['Pilot Parachute Seat Mk-10', 'Assembly Mass', '9.25 kg (approx.)'],
            ['Pilot Parachute BMK-41 for Kiran Aircraft', 'Max Altitude Limit', '6000 m AMSL'],
            ['Combat Free Fall Parachute RAM AIR 9 Cell', 'Suspended Mass (Max)', '200 kg'],
            ['Parachute Tactical Assault Reserve (PTA-R)', 'Life of Parachute', '13 years or one emergency drop, whichever is earlier'],
            ['Parachute Tactical Assault Main (PTA-M)', 'Rate of Descent', '18 ft/s'],
            ['ECAD Supply Dropping Parachute 8.5M', 'Life of Parachute', '10 years in storage or 2 drops, whichever is earlier'],
            ['Heavy Drop System for AN-32 A/C', 'Reusability', '5 times'],
        ];
        foreach ($cases as [$title, $parameter]) {
            $this->insert($title, [['parameter' => $parameter, 'value' => 'old']]);
        }

        $migration = require database_path('migrations/2026_09_22_010000_apply_marked_parachute_product_corrections.php');
        $migration->up();

        foreach ($cases as [$title, $parameter, $expected]) {
            $fragment = str_contains($title, 'RAM AIR') ? 'MCPS' : $title;
            $specs = $this->specs($fragment);
            $this->assertSame($expected, collect($specs)->firstWhere('parameter', $parameter)['value'], $title);
        }
        $this->assertSame(1, DB::table('products')->where('title', 'like', '%RAM AIR 9 Cell%')->count());
    }

    private function insert(string $title, array $specs = []): void
    {
        DB::table('products')->insert([
            'title' => $title,
            'description' => $title,
            'specs_subtext' => $title,
            'technical_specs' => json_encode($specs),
            'main_capabilities' => '[]',
        ]);
    }

    private function specs(string $fragment): array
    {
        return json_decode(DB::table('products')->where('title', 'like', "%{$fragment}%")->value('technical_specs'), true, flags: JSON_THROW_ON_ERROR);
    }
}
