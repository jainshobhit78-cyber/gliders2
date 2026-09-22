<?php

use App\Support\BrakeParachuteSpecifications;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Start from the prior reviewed sheet on both installations, even when
        // one of them has not yet run the August content migration.
        $prior = require database_path('migrations/2026_08_11_010000_uniform_brake_parachute_specifications.php');
        $prior->up();

        foreach (['Tejas', 'SU-30', 'MiG-29', 'MIG-21/23/25', 'Mirage-2000', 'Jaguar', 'Hawk'] as $needle) {
            $this->updateProduct($needle, function (array &$product) use ($needle): void {
                $old = $product['technical_specs'];
                if (count($old) !== 9) {
                    throw new RuntimeException("Expected nine reviewed brake specifications for {$needle}.");
                }

                // The retired fourth row contains useful rigging line counts
                // and lengths; retain it as a detail of the material row.
                $riggingDetail = trim((string) ($old[3]['value'] ?? ''));
                $rows = [$old[0], $old[1], $old[2], $old[4], $old[5], $old[6], $old[7], $old[8]];
                foreach ($rows as $index => &$row) {
                    $row['parameter'] = BrakeParachuteSpecifications::HEADINGS[$index];
                }
                unset($row);
                if ($riggingDetail !== '' && $riggingDetail !== 'Not specified') {
                    $rows[5]['description'] = 'Rigging lines (count / length): '.$riggingDetail.'. '.($rows[5]['description'] ?? '');
                }

                if ($needle === 'MIG-21/23/25') {
                    $rows[1]['value'] = 'MiG-21: 15.2 m²; MiG-23: 21 m²; MiG-25: 25 m² (twin canopies)';
                    $rows[2]['value'] = 'MiG-21: 5.15 m / 1.65 m; MiG-23: 6.3 m / 1.99 m; MiG-25: 6.8 m / 2 m';
                    $rows[3]['value'] = 'MiG-21: 180 kmph / 300 kmph; MiG-23 and MiG-25: see aircraft limits';
                    $rows[3]['description'] = 'The handwritten emergency limits for MiG-23 and MiG-25 require confirmation before publication.';
                    $rows[5]['value'] = 'MiG-21: Tape Nylon, 15 mm, BS 800 kgf; MiG-23/25: Tape Textile Nylon, 43 mm U/D';
                    $rows[5]['description'] = 'The source also marks 9000 N without a clear aircraft assignment; MiG-23 rigging-line length is marked 6.750 m.';
                    $rows[6]['value'] = 'MiG-21: 11.5 kg (approx.); MiG-23/25: pending unit confirmation';
                    $rows[6]['description'] = 'The source writes the other two masses as 18 kgf and 57 kgf. Force units cannot be published as mass without confirmation.';
                    $rows[7]['value'] = 'MiG-21: 40 + 5 streamings (subject to condition) or 10 years; MiG-23/25: pending allocation confirmation';
                    $rows[7]['description'] = 'The source also marks 45 streamings or 8 years, but does not clearly identify which aircraft it applies to.';
                    $product['main_capabilities'] = [
                        ['heading' => 'Multi-Aircraft Compatibility', 'description' => 'Separate uni-cross configurations for the MiG-21, MiG-23 and twin-canopy MiG-25 systems.'],
                        ['heading' => 'Brake Parachute Systems', 'description' => 'Aircraft-specific canopy areas of 15.2 m², 21 m² and 25 m² respectively.'],
                    ];
                }

                $product['technical_specs'] = $rows;
            });
        }

        $this->updateProduct('Lakshya', function (array &$p): void {
            $this->setSpec($p, 'Recovery Altitude', '300 m to 9 km AGL');
            $this->removeSpec($p, 'Rate of Descent / Max Recovery Mass');
            $this->replaceCapability($p, 'High-Altitude Deployment', 'Operates across a recovery altitude of 300 m to 9 km AGL at speeds up to 684 kmph.');
        });
        $this->updateProduct('Parasail', function (array &$p): void {
            $this->setSpec($p, 'Diameter of Canopy', '7.230 m');
            $this->setSpec($p, 'Rigging Line Length', '6450–6750 mm');
            $this->setSpec($p, 'No. of Gores/Panels', '24 gores / 4 panels per gore');
        });
        $this->updateProduct('PTR-M', function (array &$p): void {
            $p['description'] = str_ireplace('457m', '228.6 m AGL', (string) $p['description']);
            $p['specs_subtext'] = str_ireplace(['457m', '457 m'], '228.6 m AGL', (string) $p['specs_subtext']);
            $this->setSpec($p, 'Diameter of Canopy', '10.66 m (nominal)');
            $this->setSpec($p, 'Dropping Load Limit', '113.6 kg');
            $this->setSpec($p, 'Rate of Descent', '5.41–5.58 m/s');
            $this->setSpec($p, 'Min Jump Height', '228.6 m AGL');
            $this->setSpec($p, 'Life of Parachute', '100 jumps or 15 years from manufacture, whichever is earlier');
            $this->replaceCapability($p, 'Large Canopy Area', 'The 10.66 m nominal canopy supports a controlled descent of 5.41–5.58 m/s.');
        });
        $this->updateProduct('High Altitude Parachute', function (array &$p): void {
            foreach (['description', 'specs_subtext'] as $field) {
                $p[$field] = str_ireplace(['20,000 ft. ASL', '20,000 ft ASL', '20,000 ft.'], '15,000 ft AMSL', (string) $p[$field]);
            }
            $this->setSpec($p, 'Design of Canopy', 'Parabolic', 'Parabolic canopy design.');
            $this->setSpec($p, 'Diameter of Canopy', '10.66 m');
            $this->setSpec($p, 'Weight of Parachute', '15 kg (approx.)');
            $this->setSpec($p, 'Rate of descent', '16–18 ft/s (approx.)');
            $this->setSpec($p, 'Life of Parachute', '13 years or 100 jumps, whichever is earlier');
            $this->replaceCapability($p, 'High Altitude Drops', 'Designed for high-altitude dropping zones up to 15,000 ft AMSL.');
            $this->replaceCapability($p, 'Static Line Training', 'Supports static-line release for paratrooper training and operations from AN-32 aircraft.');
        });
        $this->updateProduct('Seat Mk-10', function (array &$p): void {
            $this->setSpec($p, 'Canopy Diameter', '7.31 m / 24 ft (nominal)');
            $this->setSpec($p, 'Assembly Mass', '9.25 kg (approx.)');
            $this->setSpec($p, 'Life of Parachute', '11 years or one-time use, whichever is earlier');
            foreach ($p['main_capabilities'] as &$cap) {
                $cap['description'] = str_ireplace('harness shedding', 'harness removal', (string) ($cap['description'] ?? ''));
            }
            unset($cap);
        });
        $this->updateProduct('BMK-41', function (array &$p): void {
            $this->setSpec($p, 'Canopy Diameter', '7.3 m / 24 ft');
            $this->setSpec($p, 'Max Altitude Limit', '6000 m AMSL');
            $this->setSpec($p, 'Life of Parachute', '12 years in storage or one emergency escape, whichever is earlier');
        });
        $this->updateProduct('RAM AIR 9 Cell', function (array &$p): void {
            $p['title'] = 'Military Combat Parachute (MCPS) RAM AIR 9 Cell';
            $this->setSpec($p, 'Design of Canopy', 'Semi-elliptical aerofoil');
            $this->setSpec($p, 'Rate of descent (Full Glide)', '4.5 m/s');
            $this->setSpec($p, 'Suspended Mass (Max)', '200 kg');
            $this->setSpec($p, 'Altitude of Opening', '2000–3000 ft AMSL');
            $this->setSpec($p, 'Life of Parachute', 'Over 10 years shelf life or 500 jumps, whichever is earlier');
            foreach ($p['main_capabilities'] as &$cap) {
                $cap['description'] = str_ireplace('rectangular', 'semi-elliptical', (string) ($cap['description'] ?? ''));
            }
            unset($cap);
        });
        $this->updateProduct('Tactical Assault Reserve', function (array &$p): void {
            $this->setSpec($p, 'Life of Parachute', '13 years or one emergency drop, whichever is earlier');
        });
        $this->updateProduct('Tactical Assault Main', function (array &$p): void {
            foreach (['description', 'specs_subtext'] as $field) {
                $p[$field] = str_replace('jumps. Stable', 'jumps and is stable', (string) $p[$field]);
            }
            $this->setSpec($p, 'Rate of Descent', '18 ft/s');
            $this->setSpec($p, 'Life of Parachute', '13 years or 100 jumps, whichever is earlier');
            foreach ($p['technical_specs'] as &$row) {
                $row['description'] = str_replace(['shaped skirt', 'Canopy width'], ['shaped canopy', 'Canopy size'], (string) ($row['description'] ?? ''));
            }
            unset($row);
        });
        $this->updateProduct('P-7 Heavy Drop', function (array &$p): void {
            foreach (['description', 'specs_subtext'] as $field) {
                $p[$field] = str_ireplace('7 Ton weight class', '7-ton class', (string) $p[$field]);
            }
            $this->setSpec($p, 'Platform Size', '4216 × 2602 × 193 mm');
            $this->setSpec($p, 'All Up Weight', '8500 kg (approx.)');
            $this->setSpec($p, 'Payload Capacity', '7000 kg (7 ton)');
            $this->setSpec($p, 'Landing Speed', '8 m/s');
        });
        $this->updateProduct('ECAD', function (array &$p): void {
            $this->setSpec($p, 'No. of Gores/Panels', '28 gores / 4 panels per gore');
            $this->setSpec($p, 'Life of Parachute', '10 years in storage or 2 drops, whichever is earlier');
        });
        $this->updateProduct('Heavy Drop System for AN-32', function (array &$p): void {
            foreach (['description', 'specs_subtext'] as $field) {
                $p[$field] = str_ireplace('auxiliary parachutes open initially to stabilize', 'extractor and auxiliary parachutes initially stabilise', (string) $p[$field]);
            }
            $this->setSpec($p, 'Reusability', '5 times', 'A cluster of five main parachutes is used.');
        });
    }

    private function updateProduct(string $needle, callable $change): void
    {
        $matches = DB::table('products')->whereRaw('LOWER(title) LIKE ?', ['%'.strtolower($needle).'%'])->get();
        if ($matches->count() === 0) {
            // Some sites may not have every product yet. The audit checklist
            // reports missing records so they can be created separately.
            return;
        }
        if ($matches->count() !== 1) {
            throw new RuntimeException("Ambiguous product match for {$needle}.");
        }
        $row = $matches->first();
        $product = [
            'title' => $row->title,
            'description' => $row->description,
            'specs_subtext' => $row->specs_subtext,
            'technical_specs' => json_decode((string) $row->technical_specs, true) ?: [],
            'main_capabilities' => json_decode((string) $row->main_capabilities, true) ?: [],
        ];
        $change($product);
        DB::table('products')->where('id', $row->id)->update([
            'title' => $product['title'],
            'description' => $product['description'],
            'specs_subtext' => $product['specs_subtext'],
            'technical_specs' => json_encode($product['technical_specs'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'main_capabilities' => json_encode($product['main_capabilities'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'updated_at' => now(),
        ]);
    }

    private function setSpec(array &$product, string $parameter, string $value, ?string $description = null): void
    {
        foreach ($product['technical_specs'] as &$row) {
            if (strcasecmp(trim((string) ($row['parameter'] ?? '')), $parameter) === 0) {
                $row['value'] = $value;
                if ($description !== null) {
                    $row['description'] = $description;
                }
                return;
            }
        }
        unset($row);
        $product['technical_specs'][] = ['parameter' => $parameter, 'value' => $value, 'description' => $description ?? '', 'icon' => ''];
    }

    private function removeSpec(array &$product, string $parameter): void
    {
        $product['technical_specs'] = array_values(array_filter(
            $product['technical_specs'],
            fn (array $row) => strcasecmp(trim((string) ($row['parameter'] ?? '')), $parameter) !== 0
        ));
    }

    private function replaceCapability(array &$product, string $heading, string $description): void
    {
        foreach ($product['main_capabilities'] as &$capability) {
            if (strcasecmp(trim((string) ($capability['heading'] ?? '')), $heading) === 0) {
                $capability['description'] = $description;
                return;
            }
        }
    }

    public function down(): void
    {
        // Editorial product data can be changed through the admin panel.
        // Restore a database backup if these reviewed corrections must be undone.
    }
};
