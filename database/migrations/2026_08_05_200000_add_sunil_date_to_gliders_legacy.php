<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Adds Shri Sunil Date, I.O.F.S (Retired), to the Gliders India Limited
     * legacy list. He held the post of Chairman & Managing Director from
     * 01.10.2024 to 31.12.2024, between Shri V. K. Tiwari and Shri M C
     * Balasubramaniam.
     *
     * That also corrects the preceding entry: Shri V. K. Tiwari was recorded
     * as serving until 2025, which cannot hold if the post changed hands in
     * October 2024. His tenure end moves to 2024 so the three do not overlap.
     *
     * Note: the supplied biography states he took charge on 08.05.2024, which
     * conflicts with the 01.10.2024 start confirmed separately. The confirmed
     * tenure is used here and the biography text omits the disputed date.
     */
    public function up(): void
    {
        DB::table('legacy_leaders')
            ->where('type', 'gliders')
            ->where('name', 'like', '%Tiwari%')
            ->update([
                'tenure_end' => '2024',
                'tenure_text' => 'Tenure: 2021 – 2024',
                'updated_at' => now(),
            ]);

        DB::table('legacy_leaders')
            ->where('type', 'gliders')
            ->where('name', 'like', '%Sunil Date%')
            ->delete();

        DB::table('legacy_leaders')->insert([
            'name' => 'Shri Sunil Date',
            'role' => 'Chairman & Managing Director',
            'type' => 'gliders',
            'tenure_start' => '2024',
            'tenure_end' => '2024',
            'tenure_text' => 'Tenure: 01 Oct 2024 – 31 Dec 2024',
            'initials' => 'SD',
            'color' => '#2e6b9e',
            'image' => null,
            'description' => 'Shri Sunil Date, I.O.F.S (Retired), took over as Chairman & Managing Director of Gliders India Limited on 01.10.2024. A BE in Electronics and Telecommunications Engineering, he was associated with the Industrial Systems Group of BHEL for one and a half years before joining the Ordnance Factories organisation. An IOFS officer of the 1989 batch, he has held important positions in various Ordnance factories including HAPF, OFIT, OFPM and OFAJ, bringing a rich experience of more than 35 years across maintenance, procurement, quality, R&D and production.',
            'quote' => null,
            'achievements' => implode("\n", [
                'Headed the Quality and Maintenance divisions at Ordnance Factory Ambajhari',
                'Notable contributions in plant and process modernization, predictive maintenance, Industry 4.0 and quality functions',
                'Qualified Energy Auditor from the 2005 BEE examination, placed among the top 10 in India',
                'Member of the Energy Management and Energy Saving Sectional Committee of BIS',
            ]),
            'focus_areas' => json_encode([
                ['icon' => 'gear', 'label' => 'Plant & Process Modernization'],
                ['icon' => 'monitor', 'label' => 'Industry 4.0 & Predictive Maintenance'],
                ['icon' => 'bulb', 'label' => 'Energy Management'],
            ]),
            'stats' => json_encode([
                ['icon' => 'chart', 'number' => '35+', 'label' => 'Years of Experience'],
                ['icon' => 'medal', 'number' => 'Top 10', 'label' => 'BEE Energy Auditor, India'],
            ]),
            'timeline' => json_encode([
                ['year' => '1989', 'title' => 'Joined IOFS, 1989 Batch', 'icon' => 'flag'],
                ['year' => '2005', 'title' => 'Qualified BEE Energy Auditor', 'icon' => 'medal'],
                ['year' => '2024', 'title' => 'Assumed Charge as CMD', 'icon' => 'flag'],
                ['year' => '2024', 'title' => 'Completed Tenure', 'icon' => 'star'],
            ]),
            'display_order' => 999,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->renumberByTenureStart();
    }

    public function down(): void
    {
        DB::table('legacy_leaders')
            ->where('type', 'gliders')
            ->where('name', 'like', '%Sunil Date%')
            ->delete();

        DB::table('legacy_leaders')
            ->where('type', 'gliders')
            ->where('name', 'like', '%Tiwari%')
            ->update([
                'tenure_end' => '2025',
                'tenure_text' => 'Tenure: 2021 – 2025',
                'updated_at' => now(),
            ]);

        $this->renumberByTenureStart();
    }

    /** Newest tenure first, matching how the OPF list reads. */
    private function renumberByTenureStart(): void
    {
        $rows = DB::table('legacy_leaders')
            ->where('type', 'gliders')
            ->get(['id', 'tenure_start'])
            ->sortByDesc(fn($r) => (int) $r->tenure_start)
            ->values();

        foreach ($rows as $i => $row) {
            DB::table('legacy_leaders')->where('id', $row->id)->update(['display_order' => $i + 1]);
        }
    }
};
