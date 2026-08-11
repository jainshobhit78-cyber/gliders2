<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Apply the marked 03-Aug-2026 review and keep the same nine specification
     * headings, in the same order, across every brake-parachute product.
     * Values absent from the reviewed source are labelled rather than guessed.
     */
    public function up(): void
    {
        $products = [
            'Tejas' => [
                'specs' => [
                    ['Design of Canopy', 'Uni-cross', 'Uni-cross canopy configuration.'],
                    ['Surface Area of Main Parachute', '17 m²', 'Total main parachute area.'],
                    ['Span / Width of Arm', '5.75 m / 1.73 m', 'Canopy span and arm width.'],
                    ['No. of Rigging Lines / Length', '32', 'Number of rigging lines.'],
                    ['Deployment Speed (Normal / Emergency)', '285 kmph / 340 kmph', 'Normal and emergency deployment speeds.'],
                    ['Basic Material', 'Fabric Nylon 66, 93 gsm U/D', 'Primary canopy material.'],
                    ['Rigging Lines Material', 'Tape Para-Aramid (Kevlar), 21 mm, BS: 900 kgf', 'Rigging-line material and breaking strength.'],
                    ['Mass of Parachute', '10 kg (approx.)', 'Approximate parachute mass.'],
                    ['Life of Parachute', '45 streamings / 8 years', 'Certified service life.'],
                ],
            ],
            'SU-30' => [
                'description' => '<p>The brake parachute is intended to reduce the landing run of the aircraft and provide additional safety during emergencies.</p>',
                'specs' => [
                    ['Design of Canopy', 'Uni-cross', 'Twin-canopy uni-cross configuration.'],
                    ['Surface Area of Main Parachute', '48 m² total (24 m² each - 2 nos.)', 'Total area of the two main parachutes.'],
                    ['Span / Width of Arm', '6.85 m / 2.15 m', 'Canopy span and arm width.'],
                    ['No. of Rigging Lines / Length', '32 / 6500 mm', 'Number and length of rigging lines.'],
                    ['Deployment Speed (Normal / Emergency)', '260 kmph / 300 kmph', 'Normal and emergency deployment speeds.'],
                    ['Basic Material', 'Fabric Nylon 66, 93 gsm U/D', 'Primary canopy material.'],
                    ['Rigging Lines Material', 'Tape Nylon 66, BS: 850 kgf, resin treated', 'Rigging-line material and breaking strength.'],
                    ['Mass of Parachute', '27 kg (approx.)', 'Approximate parachute mass.'],
                    ['Life of Parachute', '60 streamings / 10 years', 'Certified service life.'],
                ],
                'capabilities' => [
                    ['heading' => 'Twin-Canopy Uni-cross Design', 'description' => 'Deploys two 24 m² canopy parachutes to generate the deceleration force required for the SU-30 fighter aircraft.'],
                    ['heading' => 'High-Temperature-Resistant Nylon Construction', 'description' => 'Built with Nylon 66 fabric for high-temperature resistance and high shock resistance during emergency landings.'],
                ],
            ],
            'MiG-29' => [
                'title' => 'Brake Parachute for MiG-29 A/C',
                'description' => '<p>High-performance brake parachute designed for safe landing and retardation of the MiG-29 fighter aircraft.</p>',
                'specs' => [
                    ['Design of Canopy', 'Uni-cross', 'Uni-cross canopy configuration.'],
                    ['Surface Area of Main Parachute', '14.4 m²', 'Total main parachute area.'],
                    ['Span / Width of Arm', '5.30 m / 1.69 m', 'Canopy span and arm width.'],
                    ['No. of Rigging Lines / Length', '32 / 5.30 m', 'Number and length of rigging lines.'],
                    ['Deployment Speed (Normal / Emergency)', '180 kmph / 310 kmph', 'Normal and emergency deployment speeds.'],
                    ['Basic Material', 'Fabric Nylon, 93 gsm U/D', 'Primary canopy material.'],
                    ['Rigging Lines Material', 'Tape Nylon, 22 mm, BS: 600 kgf', 'Rigging-line material and breaking strength.'],
                    ['Mass of Parachute', '9 kg (approx.)', 'Approximate parachute mass.'],
                    ['Life of Parachute', '55 streamings / 10 years', 'Certified service life.'],
                ],
            ],
            'MIG-21/23/25' => [
                'specs' => [
                    ['Design of Canopy', 'MiG-21: Uni-cross; MiG-23: Uni-cross; MiG-25: Uni-cross (Twin)', 'Canopy configuration by aircraft.'],
                    ['Surface Area of Main Parachute', 'MiG-21: 15.3 m²; MiG-23: 21 m²; MiG-25: 23.2 m²', 'Main parachute area by aircraft.'],
                    ['Span / Width of Arm', 'Not specified', 'No reviewed value is available.'],
                    ['No. of Rigging Lines / Length', 'Not specified', 'No reviewed value is available.'],
                    ['Deployment Speed (Normal / Emergency)', 'MiG-21: 180 / 300-320 kmph; MiG-23: 180-300 / 300-320 kmph; MiG-25: 330 / above 330 kmph', 'Normal and emergency deployment speeds by aircraft.'],
                    ['Basic Material', 'Fabric Nylon, 109 gsm U/D', 'Primary canopy material.'],
                    ['Rigging Lines Material', 'Not specified', 'No reviewed value is available.'],
                    ['Mass of Parachute', 'MiG-21: 14 kg; MiG-23: 18.5 kg; MiG-25: 54 kg', 'Parachute mass by aircraft.'],
                    ['Life of Parachute', 'Not specified', 'No reviewed value is available.'],
                ],
            ],
            'Mirage-2000' => [
                'specs' => [
                    ['Design of Canopy', 'Uni-cross', 'Uni-cross canopy configuration.'],
                    ['Surface Area of Main Parachute', '13.5 m²', 'Total main parachute area.'],
                    ['Span / Width of Arm', '5.28 m / 1.4 m', 'Canopy span and arm width.'],
                    ['No. of Rigging Lines / Length', '32 / 4.350 m', 'Number and length of rigging lines.'],
                    ['Deployment Speed (Normal / Emergency)', '300 kmph / 390 kmph', 'Normal and emergency deployment speeds.'],
                    ['Basic Material', 'Fabric Nylon, 105 gsm, undyed', 'Primary canopy material.'],
                    ['Rigging Lines Material', 'Cord Nylon 66, BS: 380 kgf', 'Rigging-line material and breaking strength.'],
                    ['Mass of Parachute', '15 kg (approx.)', 'Approximate parachute mass.'],
                    ['Life of Parachute', '40 streamings / 8 years', 'Certified service life.'],
                ],
                'capabilities' => [
                    ['heading' => 'Aerodynamic Deceleration', 'description' => 'Significantly reduces the landing run of the Mirage-2000 aircraft during normal and emergency landing rolls.'],
                    ['heading' => 'High-Strength Nylon Material', 'description' => 'Manufactured using 105 gsm undyed nylon fabric for thermal resistance and deployment stability.'],
                    ['heading' => 'Reliable Extraction', 'description' => 'Uses 32 rigging lines, each 4.350 m long, for rapid, symmetrical and twist-free canopy inflation.'],
                ],
            ],
            'Jaguar' => [
                'specs' => [
                    ['Design of Canopy', 'Ribbon Type', 'Ribbon-type canopy configuration.'],
                    ['Surface Area of Main Parachute', '24 m²', 'Total main parachute area.'],
                    ['Span / Width of Arm', '5.54 m', 'Nominal canopy diameter.'],
                    ['No. of Rigging Lines / Length', '24 / 5500 mm', 'Number and length of rigging lines.'],
                    ['Deployment Speed (Normal / Emergency)', '150 knots / 180 knots', 'Normal and emergency deployment speeds.'],
                    ['Basic Material', 'Ribbon Nylon, 50 mm / 16 mm', 'Primary canopy material.'],
                    ['Rigging Lines Material', 'Webbing Nylon Tubular, 14 mm, BS: 1100 kgf', 'Rigging-line material and breaking strength.'],
                    ['Mass of Parachute', '12 kg (approx.)', 'Approximate parachute mass.'],
                    ['Life of Parachute', '40 streamings / 10 years', 'Certified service life.'],
                ],
                'capabilities' => [
                    ['heading' => 'Ribbon-Type Canopy', 'description' => 'Uses high-tensile nylon ribbons with gaps to allow controlled airflow and minimise high-speed deployment shock.'],
                    ['heading' => 'Metallic Storage Container', 'description' => 'Fits in a specialised metallic tail storage container with auxiliary-parachute deployment straps.'],
                ],
            ],
            'Hawk' => [
                'specs' => [
                    ['Design of Canopy', 'Ring Slot', 'Ring-slot canopy configuration.'],
                    ['Surface Area of Main Parachute', '11.4 m²', 'Total main parachute area.'],
                    ['Span / Width of Arm', '3.82 m', 'Nominal canopy diameter.'],
                    ['No. of Rigging Lines / Length', '30 / 5480 mm', 'Number and length of rigging lines.'],
                    ['Deployment Speed (Normal / Emergency)', '160 knots', 'Maximum marked deployment speed.'],
                    ['Basic Material', 'Fabric Nylon 66, 90 gsm U/D', 'Primary canopy material.'],
                    ['Rigging Lines Material', 'Cordage Nylon, 250 kgf, with core, undyed', 'Rigging-line material and strength.'],
                    ['Mass of Parachute', '6.2 kg (approx.)', 'Approximate parachute mass.'],
                    ['Life of Parachute', '45 streamings / 8 years', 'Certified service life.'],
                ],
            ],
        ];

        foreach ($products as $titleFragment => $data) {
            $product = DB::table('products')
                ->whereRaw('LOWER(title) LIKE ?', ['%'.strtolower($titleFragment).'%'])
                ->first();

            if (! $product) {
                continue;
            }

            $update = [
                'technical_specs' => json_encode(
                    array_map(fn (array $row) => [
                        'parameter' => $row[0],
                        'value' => $row[1],
                        'description' => $row[2],
                        'icon' => '',
                    ], $data['specs']),
                    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                ),
                'updated_at' => now(),
            ];

            foreach (['title', 'description'] as $field) {
                if (isset($data[$field])) {
                    $update[$field] = $data[$field];
                }
            }

            if (isset($data['capabilities'])) {
                $update['main_capabilities'] = json_encode(
                    $data['capabilities'],
                    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                );
            }

            DB::table('products')->where('id', $product->id)->update($update);
        }
    }

    public function down(): void
    {
        // Product content is mutable admin data. Restore a database backup if
        // this editorial correction ever needs to be reversed.
    }
};
