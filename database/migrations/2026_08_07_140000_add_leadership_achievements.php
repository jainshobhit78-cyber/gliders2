<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Records the achievements and milestones supplied for the three current
     * leadership entries, replacing the placeholder text seeded earlier.
     *
     * The source document is organised by financial year, which maps onto the
     * roles as follows:
     *
     *   2023-24  Shri M C Balasubramaniam as General Manager, OPF
     *   2024-25  Shri M C Balasubramaniam, spanning his elevation to CMD on
     *            23.01.2025 - recorded against the CMD entry
     *   2025-26  Shri B L Meena as Chief General Manager, OPF
     *
     * Figures are quoted as given in the source. Nothing is inferred.
     */
    public function up(): void
    {
        // ---- Shri M C Balasubramaniam, Chairman & Managing Director ----
        $this->apply('gliders', '%Balasubramaniam%', [
            'achievements' => [
                'Sale value of Rs. 8.88 Cr achieved against export orders, with Rs. 7.88 Cr of export orders in hand',
                'Highest-ever sale value against Indian Air Force orders at Rs. 85.15 Cr, surpassing the previous record',
                'Highest-ever quantity of Pilot Parachutes supplied - 304 units, over and above 121 canopies',
                'Highest-ever quantity of HD Para P-7 supplied - 44 units, with a further 14 units of HD Para AN-32 to the Indian Army',
                '500 KW solar power plant installed, saving 2,63,142 KWH and Rs. 18.08 lakh - a 27.40% reduction against 2023-24',
                'LAToT received from DRDO for MCPS, Activated Carbon Fabric CBRN Suit Mk VI, Flame Retardant Anti-G Suit and Pilot Parachute for Hawk aircraft',
                'Highest-ever post-corporatisation sale values recorded - Rs. 206.01 Cr in 2022-23 and Rs. 176.83 Cr in 2023-24',
            ],
            'stats' => [
                ['icon' => 'rupee', 'number' => 'Rs. 85.15 Cr', 'label' => 'Highest IAF Sales, 2024-25'],
                ['icon' => 'chart', 'number' => 'Rs. 8.88 Cr', 'label' => 'Export Sale Value'],
            ],
            'timeline' => [
                ['year' => '2023', 'title' => 'General Manager, Ordnance Parachute Factory', 'icon' => 'flag'],
                ['year' => '2025', 'title' => 'Assumed Charge as Chairman & Managing Director', 'icon' => 'arrowUp'],
                ['year' => '2025', 'title' => 'Highest-ever IAF Sales of Rs. 85.15 Cr', 'icon' => 'chart'],
            ],
        ]);

        // ---- Shri M. C. Balasubramaniam, General Manager, OPF ----
        $this->apply('opf', '%Balasubramaniam%', [
            'achievements' => [
                'Bulk production and supply of indigenous Pilot Parachute PSU-36 for SU-30 commenced from the last quarter of 2022-23',
                'Bulk production and supply of indigenous Brake Parachute for Hawk aircraft commenced from the last quarter of 2022-23',
                'Bulk Production Clearance for the P-7 Heavy Drop Parachute System received from the Indian Army in September 2023 for 140 units worth Rs. 209.11 Cr',
                'All-time high production achieved for Supply Drop Parachutes, P-3 Heavy Drop Parachutes and various pilot parachutes',
                'MoU signed with IITs for improvement and modernisation of production and inspection processes',
                'Export orders worth approximately Rs. 20.85 Cr secured in FY 2023-24 from several countries',
                'Manufacturing capacity for brake and pilot parachutes across fighter aircraft variants enhanced through state-of-the-art machinery',
                'Recovery Parachute System manufactured and supplied for Gaganyaan, India\'s first manned space mission',
                'Supplied to ADRDE Agra - Recovery Para System Gaganyaan (01), Air Drop Container ADC-150 (60) and Para System FIAM ALWT (50)',
                'Engaged with ADRDE/DRDO as Developmental Associated Production Partner for Para Tactical Assault Gajraj 2.0 and Smart Parachute Ribbon Canopy 3.3 m',
                'Drone Rescue Parachute of 12-15 kg payload capacity developed as an emergency recovery system for drones',
                'AS9100D certification acquired for global quality standards in the aviation, space and defence industries',
                'AFQMS certification awarded by DGAQA for Aeronautical Stores during Defence Expo',
                'Recertification of ISO 9001:2015, ISO 14001:2015 and ISO 45001:2018 successfully completed',
            ],
            'stats' => [
                ['icon' => 'rupee', 'number' => 'Rs. 209.11 Cr', 'label' => 'P-7 Bulk Production Clearance'],
                ['icon' => 'globe', 'number' => 'Rs. 20.85 Cr', 'label' => 'Export Orders, 2023-24'],
            ],
            'timeline' => [
                ['year' => '2023', 'title' => 'Assumed Charge as General Manager', 'icon' => 'flag'],
                ['year' => '2023', 'title' => 'P-7 Bulk Production Clearance, Rs. 209.11 Cr', 'icon' => 'wrench'],
                ['year' => '2024', 'title' => 'Gaganyaan Recovery Parachute System Supplied', 'icon' => 'medal'],
                ['year' => '2025', 'title' => 'Completed Tenure', 'icon' => 'star'],
            ],
        ]);

        // ---- Shri B. L. Meena, Chief General Manager, OPF ----
        $this->apply('opf', '%Meena%', [
            'achievements' => [
                'Cumulative sales of Rs. 229.67 Cr achieved in FY 2025-26, the highest cumulative figure in the last eight years',
                'Highest-ever sales value recorded for parachute production alone, compared with historical data',
                'Exports worth Rs. 7.24 Cr supplied in FY 2025-26, with further orders worth Rs. 26.29 Cr secured from Vietnam for FY 2026-27',
                'Self-Certification status awarded by DGQA for KM Float and Boat Assault',
                'Heavy Drop HD Para P-7 (140 units, Rs. 218 Cr) completed within the stipulated two-year timeline, by March 2026',
                'Indigenously developed MCPS prototype successfully trialled at Sheopur, Madhya Pradesh, with ToT absorption completed',
            ],
            'stats' => [
                ['icon' => 'rupee', 'number' => 'Rs. 229.67 Cr', 'label' => 'Cumulative Sales, FY 2025-26'],
                ['icon' => 'globe', 'number' => 'Rs. 26.29 Cr', 'label' => 'Vietnam Orders, FY 2026-27'],
            ],
            'timeline' => [
                ['year' => '2025', 'title' => 'Assumed Charge as General Manager', 'icon' => 'flag'],
                ['year' => '2025', 'title' => 'Elevated to Chief General Manager', 'icon' => 'arrowUp'],
                ['year' => '2026', 'title' => 'HD Para P-7 Completed - 140 Units, Rs. 218 Cr', 'icon' => 'wrench'],
                ['year' => 'Present', 'title' => 'Currently in Office', 'icon' => 'star'],
            ],
        ]);
    }

    public function down(): void
    {
        // Achievement content is admin-editable; restore from the legacy_leaders
        // backup taken alongside this migration if needed.
    }

    private function apply(string $type, string $nameLike, array $data): void
    {
        DB::table('legacy_leaders')
            ->where('type', $type)
            ->where('name', 'like', $nameLike)
            ->update([
                'achievements' => implode("\n", $data['achievements']),
                'stats' => json_encode($data['stats']),
                'timeline' => json_encode($data['timeline']),
                'updated_at' => now(),
            ]);
    }
};
