<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Re-run the authoritative spreadsheet roster so distinct, non-consecutive
        // tenures remain separate cards. Then restore newest-first presentation
        // and collapse only B. L. Meena's uninterrupted GM-to-CGM promotion into
        // one current-leader card, as requested by the content owner.
        $authoritativeRoster = require database_path('migrations/2026_08_04_100000_seed_opf_leadership_roster.php');
        $authoritativeRoster->up();

        $latestFirst = require database_path('migrations/2026_08_05_100000_reverse_opf_order_and_attach_leader_photos.php');
        $latestFirst->up();

        $mergeCurrentLeader = require database_path('migrations/2026_08_05_120000_merge_bl_meena_opf_tenures.php');
        $mergeCurrentLeader->up();
    }

    public function down(): void
    {
        // Historical editorial records are intentionally not collapsed on rollback.
    }
};
