<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class BrakeParachuteSpecificationCorrectionsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('status')->default('Active');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->longText('technical_specs')->nullable();
            $table->longText('main_capabilities')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_categories');

        parent::tearDown();
    }

    public function test_reviewed_brake_parachutes_share_the_same_specification_order(): void
    {
        $category = ProductCategory::create([
            'name' => 'Brake Parachutes',
            'status' => 'Active',
        ]);

        $titles = [
            'Brake Parachute (Hybrid) for LCA (Tejas)',
            'Brake Parachute for SU-30 A/C',
            'Brake Parachute for MiG-29 UPG A/C',
            'Brake Parachute for MIG-21/23/25 Series A/C',
            'Brake Parachute for Mirage-2000 A/C',
            'Brake Parachute for Jaguar A/C',
            'Brake Parachute for Hawk (AJT) Aircraft',
        ];

        foreach ($titles as $title) {
            Product::create([
                'category_id' => $category->id,
                'title' => $title,
                'technical_specs' => [['parameter' => 'Legacy', 'value' => 'Legacy']],
            ]);
        }

        $untouched = Product::create([
            'category_id' => $category->id,
            'title' => 'Parachute Recovery System for PTA-Lakshya MK-II',
            'technical_specs' => [['parameter' => 'Recovery Speed', 'value' => '270 kmph']],
        ]);

        $migration = require database_path('migrations/2026_08_11_010000_uniform_brake_parachute_specifications.php');
        $migration->up();

        $expectedHeadings = [
            'Design of Canopy',
            'Surface Area of Main Parachute',
            'Span / Width of Arm',
            'No. of Rigging Lines / Length',
            'Deployment Speed (Normal / Emergency)',
            'Basic Material',
            'Rigging Lines Material',
            'Mass of Parachute',
            'Life of Parachute',
        ];

        foreach ($titles as $title) {
            $match = str_contains($title, 'UPG') ? 'MiG-29' : $title;
            $record = DB::table('products')->where('title', 'like', "%{$match}%")->first();

            $this->assertNotNull($record, $title);
            $specs = json_decode($record->technical_specs, true, flags: JSON_THROW_ON_ERROR);
            $this->assertSame($expectedHeadings, array_column($specs, 'parameter'), $title);
        }

        $this->assertSame(
            'Brake Parachute for MiG-29 A/C',
            DB::table('products')->where('title', 'like', '%MiG-29%')->value('title')
        );
        $this->assertSame(
            '300 kmph / 390 kmph',
            $this->specValue('Mirage-2000', 'Deployment Speed (Normal / Emergency)')
        );
        $this->assertSame('32', $this->specValue('Tejas', 'No. of Rigging Lines / Length'));
        $this->assertSame(
            '48 m² total (24 m² each - 2 nos.)',
            $this->specValue('SU-30', 'Surface Area of Main Parachute')
        );

        $untouchedSpecs = json_decode(
            DB::table('products')->where('id', $untouched->id)->value('technical_specs'),
            true,
            flags: JSON_THROW_ON_ERROR
        );
        $this->assertSame('Recovery Speed', $untouchedSpecs[0]['parameter']);
    }

    private function specValue(string $titleFragment, string $parameter): string
    {
        $specs = json_decode(
            DB::table('products')
                ->where('title', 'like', "%{$titleFragment}%")
                ->value('technical_specs'),
            true,
            flags: JSON_THROW_ON_ERROR
        );

        return collect($specs)->firstWhere('parameter', $parameter)['value'];
    }
}
