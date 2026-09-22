# Parachute product correction checklist

Source: `Brake Para Corrections 03.08.2026 (2).pdf` (the `(2)(1)` copy is identical) and `Other Parachutes Corrections 17.08.2026(1).pdf`. Page numbers below refer to those files, not live-site product IDs. The data correction is `2026_09_22_010000_apply_marked_parachute_product_corrections.php` and matches products by title so it can run against each site's database independently.

All **brake parachutes only** now have these eight headings in this exact order: Design of Canopy; Surface Area of Main Parachute; Span/ Width of Arm; Deployment speed (Normal/Emergency); Basic Canopy Material; Rigging Line Material; Mass of Parachutes; Life of Parachutes. The former ninth rigging-count/length row is preserved in the rigging-material detail. Admin edits also retain the eight-heading order.

| Product matched in website | Marked source | Correction applied to product data |
| --- | --- | --- |
| Tejas brake parachute | Brake p. 1 | Eight headings; span 5.75 m; Kevlar breaking strength 900 kgf; mass and life retained from review. |
| SU-30 brake parachute | Brake p. 2 | Eight headings; 48 m² twin canopy; 6.85 m / 2.15 m; 6500 mm rigging lines; 260 / 300 kmph; corrected nylon and service life. |
| MiG-29 brake parachute | Brake p. 3 | Eight headings; removed UPG; 14.4 m²; 5.30 m / 1.69 m; 180 / 310 kmph; corrected material, mass and life. |
| MiG-21/23/25 brake parachute | Other p. 1 | Eight headings; 15.2 / 21 / 25 m²; aircraft-specific spans; MiG-21 speed and material; unclear mass units, speed limits and life allocation flagged below. |
| Mirage-2000 brake parachute | Brake p. 4 | Eight headings; 13.5 m²; 5.28 m / 1.4 m; 300 / 390 kmph; removed crossed-out Mockleno weave; corrected line material and life. |
| Jaguar brake parachute | Brake p. 5 | Eight headings; 5.54 m canopy; 150 / 180 knots; corrected line material, mass and life; metallic storage container copy. |
| Hawk brake parachute | Brake p. 6 | Eight headings; 11.4 m²; 3.82 m; 160 knots max; removed aircraft landing-mass row; corrected fabric, line material and life. |
| PTA-Lakshya Mk-II recovery system | Other pp. 2–3 | Recovery altitude explicitly AGL; removed crossed-out descent/mass row; corrected capability copy. |
| Parasail Assembly | Other p. 4 | 7.230 m diameter, 6450–6750 mm line length, 24 gores / 4 panels per gore. Own specification layout retained. |
| PTR-M | Other p. 5 | 10.66 m nominal canopy, 113.6 kg load, 5.41–5.58 m/s descent, 228.6 m AGL minimum, 100 jumps / 15 years. |
| High Altitude Parachute | Other p. 6 | 15,000 ft AMSL, parabolic 10.66 m canopy, 15 kg approx., 16–18 ft/s approx., 13 years / 100 jumps. |
| Pilot Parachute Seat Mk-10 | Other p. 7 | Nominal 24 ft canopy, 9.25 kg approx., 11 years / one-time use; harness removal wording. |
| Pilot Parachute BMK-41 | Other p. 8 | 7.3 m / 24 ft canopy, 6000 m AMSL, 12 years storage / one emergency escape. |
| MCPS RAM AIR 9 Cell | Other p. 9 | Corrected title, semi-elliptical aerofoil, 4.5 m/s, 200 kg max, 2000–3000 ft AMSL, life and capability text. |
| Tactical Assault Reserve | Other p. 10 | 13 years or one emergency drop. |
| Tactical Assault Main | Other p. 11 | Copy fixes, 18 ft/s descent, 13 years / 100 jumps. |
| P-7 Heavy Drop | Other p. 12 | 7-ton class, 4216 × 2602 × 193 mm platform, 8500 kg approx., 7000 kg payload, 8 m/s landing. |
| ECAD Supply Dropping | Other p. 13 | 28 gores / 4 panels per gore; 10 years storage or 2 drops. |
| AN-32 Heavy Drop | Other p. 14 | Extractor and auxiliary parachute sequence; five uses with five main parachutes. |

## Items requiring source confirmation

- On Other p. 1, the MiG-23/25 masses are handwritten as `18 kgf` and `57 kgf` under a mass heading. `kgf` measures force, not mass. The site intentionally shows **pending unit confirmation** rather than silently converting these to kg.
- The MiG-23/25 normal/emergency speeds, the `9000 N` rigging-material breaking strength, and which variant receives the `45 streamings or 8 years` life limit are not unambiguously assigned by the handwritten marks. These remain flagged for confirmation.
- If either live database has a product missing or duplicate titles for a match, review that site's migration log and product list. The migration skips absent products and rejects ambiguous matches. Administrator-uploaded specification PDFs are separate files and should be checked for staleness after the database update.

## Deployment and verification

Apply the same repository revision and run `php artisan migrate --force` separately against the gold-heron database and the VPS/cloud database. Clear Laravel application/view caches on each site. Verify the product detail pages and the generated print/PDF view on **both** URLs; a code push alone does not update stored database values. Neither live site is considered verified until its product pages are checked after deployment.
