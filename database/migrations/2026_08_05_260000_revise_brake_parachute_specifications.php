<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Applies the reviewer's marked corrections to the six brake parachute
     * specification sheets.
     *
     * Only the unambiguous corrections are applied here. Two marked values are
     * deliberately NOT applied because they contradict other values given in
     * the same review and would publish a geometrically impossible sheet:
     *
     *  - Hawk (AJT), "canopy area 3.82 m2". 3.82 m is the canopy's nominal
     *    diameter, and the same review adds it again as Span/Width. A 3.82 m
     *    diameter canopy has an area of about 11.46 m2, which is the 11.4 m2
     *    already recorded. Span/Width is added; the area is left alone.
     *  - MiG-29 UPG, "canopy area 82.4 m2". The same review gives a span of
     *    about 6.8 m, which implies an area in the region of 14-17 m2, close
     *    to the 14.4 m2 already recorded. 82.4 m2 would be larger than the
     *    SU-30's twin-canopy system at 50 m2 total.
     *
     * Both are flagged for confirmation rather than guessed at.
     *
     * Corrections calling for wording that was not supplied - the Kevlar,
     * Polyamide Nylon, locking strap, ribbon, Cord Nylon 66, Cordage Nylon 250
     * and landing mass revisions, and "Life of Product" on all six sheets -
     * are not applied, since no replacement text or value was given.
     */
    private array $changes = [
        // 1. Brake Parachute (Hybrid) for LCA (Tejas)
        7 => [
            'set' => [
                'Span / Width of Arm' => '5.75 m / 1.73 m',
                'No. Of Rigging Line' => '45',
            ],
            'rename' => [
                'Mass of Parachute' => 'Package / System Weight',
            ],
            'add' => [
                ['Payload', '10 kg (approx.)', 'Maximum payload carried by the system.'],
            ],
        ],

        // 2. Brake Parachute for SU-30 A/C
        3 => [
            'set' => [
                'Span / Width of Arm' => '6.85 - 6.915 m / 2.1 m',
                'No. Of rigging lines / Length' => '32 / 6800 mm',
                'Landing Speed (Normal / Emergency)' => '260 - 300 kmph',
            ],
            'rename' => [
                'Max. Operational load / Weight' => 'Load Carrying Capacity / System Weight',
            ],
            'add' => [
                ['Payload', '27 kg (approx.)', 'Maximum payload carried by the system.'],
            ],
        ],

        // 3. Brake Parachute for MiG-29 UPG A/C
        6 => [
            'set' => [
                'Landing Speed (Normal / Emergency)' => '180 - 310 kmph',
            ],
            'add' => [
                ['Span / Width', '6.8 m (approx.)', 'Geometric dimensions of the canopy.'],
                ['Payload', '9 kg (approx.)', 'Maximum payload carried by the system.'],
            ],
            'description' => 'Brake Parachute designed for safe landing and retardation of the MiG-29 UPG fighter jet.',
        ],

        // 4. Brake Parachute for Mirage-2000 A/C
        15 => [
            'set' => [
                'Measurement of Canopy' => '13.5 sqm',
                'No. Of Rigging lines' => '32 / 4350 mm',
            ],
            'rename' => [
                'Measurement of Canopy' => 'Canopy Surface Area',
                'No. Of Rigging lines' => 'No. Of Rigging Lines / Length',
                'Salient Features' => 'Deployment Speed (Normal / Emergency)',
            ],
            'delete' => ['Effective length of rigging lines'],
            'setAfterRename' => [
                'Deployment Speed (Normal / Emergency)' => '300 - 730 kmph',
            ],
            'add' => [
                ['Span / Width', '5.28 m / 1.4 m', 'Geometric dimensions of the canopy.'],
                ['Payload', '15 kg (approx.)', 'Maximum payload carried by the system.'],
            ],
        ],

        // 5. Brake Parachute for Jaguar A/C
        19 => [
            'set' => [
                'Diameter of Canopy' => '24 sqm',
            ],
            'rename' => [
                'Diameter of Canopy' => 'Canopy Surface Area',
            ],
            'add' => [
                ['Span / Width', '5.4 m', 'Geometric dimensions of the canopy.'],
                ['Payload', '12 kg (approx.)', 'Maximum payload carried by the system.'],
                ['Nylon Tubular Webbing', 'KOS-1100', 'Tubular webbing specification.'],
            ],
        ],

        // 6. Brake Parachute for Hawk (AJT) Aircraft
        17 => [
            'delete' => ['Max. Deployment Speed'],
            'add' => [
                ['Span / Width', '3.82 m', 'Geometric dimensions of the canopy.'],
                ['Payload', '6.2 kg (approx.)', 'Maximum payload carried by the system.'],
            ],
        ],
    ];

    public function up(): void
    {
        foreach ($this->changes as $id => $ops) {
            $product = DB::table('products')->where('id', $id)->first();

            if (!$product) {
                continue;
            }

            $specs = json_decode($product->technical_specs, true) ?: [];

            foreach ($ops['set'] ?? [] as $parameter => $value) {
                $specs = $this->setValue($specs, $parameter, $value);
            }

            foreach ($ops['rename'] ?? [] as $from => $to) {
                $specs = $this->rename($specs, $from, $to);
            }

            foreach ($ops['setAfterRename'] ?? [] as $parameter => $value) {
                $specs = $this->setValue($specs, $parameter, $value);
            }

            foreach ($ops['delete'] ?? [] as $parameter) {
                $specs = array_values(array_filter(
                    $specs,
                    fn($row) => $this->key($row['parameter'] ?? '') !== $this->key($parameter)
                ));
            }

            foreach ($ops['add'] ?? [] as [$parameter, $value, $description]) {
                $specs = $this->upsert($specs, $parameter, $value, $description);
            }

            $specs = $this->normalise($specs);

            $update = ['technical_specs' => json_encode($specs), 'updated_at' => now()];

            if (isset($ops['description'])) {
                $update['description'] = $ops['description'];
            }

            DB::table('products')->where('id', $id)->update($update);
        }
    }

    public function down(): void
    {
        // Specification content is edited through the admin panel; restore from
        // the products backup taken alongside this migration if needed.
    }

    /**
     * Some rows in the existing data omit keys entirely - the Mirage-2000
     * "Salient Features" row carries no description - so every row is brought
     * up to the full shape the admin editor expects.
     */
    private function normalise(array $specs): array
    {
        return array_values(array_map(fn($row) => [
            'parameter' => $row['parameter'] ?? '',
            'value' => $row['value'] ?? '',
            'description' => $row['description'] ?? '',
            'icon' => $row['icon'] ?? '',
        ], $specs));
    }

    private function setValue(array $specs, string $parameter, string $value): array
    {
        foreach ($specs as &$row) {
            if ($this->key($row['parameter'] ?? '') === $this->key($parameter)) {
                $row['value'] = $value;
            }
        }

        return $specs;
    }

    private function rename(array $specs, string $from, string $to): array
    {
        foreach ($specs as &$row) {
            if ($this->key($row['parameter'] ?? '') === $this->key($from)) {
                $row['parameter'] = $to;
            }
        }

        return $specs;
    }

    /** Adds the row, or updates it in place when the parameter already exists. */
    private function upsert(array $specs, string $parameter, string $value, string $description): array
    {
        foreach ($specs as &$row) {
            if ($this->key($row['parameter'] ?? '') === $this->key($parameter)) {
                $row['value'] = $value;
                $row['description'] = $description;

                return $specs;
            }
        }
        unset($row);

        $specs[] = [
            'parameter' => $parameter,
            'value' => $value,
            'description' => $description,
            'icon' => '',
        ];

        return $specs;
    }

    /** Parameter names are compared loosely so spacing differences do not matter. */
    private function key(string $name): string
    {
        return trim(preg_replace('/\s+/', ' ', strtolower($name)));
    }
};
