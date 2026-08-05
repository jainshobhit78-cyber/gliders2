<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Two adjustments to the OPF roster seeded in
     * 2026_08_04_100000_seed_opf_leadership_roster:
     *
     * 1. Show the most recent tenure first, matching how the Gliders India
     *    legacy list already reads.
     * 2. Reuse a leader's existing photo when the same person already has one
     *    stored against another legacy entry (M. C. Balasubramaniam appears in
     *    both the Gliders and OPF rosters).
     *
     * Both steps are recomputed from scratch rather than toggled, so re-running
     * them is safe.
     */
    public function up(): void
    {
        $this->orderLatestFirst();
        $this->attachKnownPhotos();
    }

    public function down(): void
    {
        // Restore oldest-first ordering. Photos are left in place; they point at
        // files that exist regardless of sort order.
        $ids = DB::table('legacy_leaders')->where('type', 'opf')->orderBy('id')->pluck('id');

        foreach ($ids as $i => $id) {
            DB::table('legacy_leaders')->where('id', $id)->update(['display_order' => $i + 1]);
        }
    }

    /**
     * Rows were inserted oldest-first, so ascending id is the chronological
     * sequence. Assigning descending display_order over that puts the newest
     * tenure at position 1.
     */
    private function orderLatestFirst(): void
    {
        $ids = DB::table('legacy_leaders')->where('type', 'opf')->orderBy('id')->pluck('id');
        $total = count($ids);

        foreach ($ids as $i => $id) {
            DB::table('legacy_leaders')->where('id', $id)->update(['display_order' => $total - $i]);
        }
    }

    /** Fill blank OPF photos from any other legacy row for the same person. */
    private function attachKnownPhotos(): void
    {
        $photos = [];
        $sourceRows = DB::table('legacy_leaders')
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->get(['name', 'image']);

        foreach ($sourceRows as $row) {
            $photos[$this->nameKey($row->name)] = $row->image;
        }

        $targets = DB::table('legacy_leaders')->where('type', 'opf')->get(['id', 'name', 'image']);

        foreach ($targets as $row) {
            if (!empty($row->image)) {
                continue;
            }

            $key = $this->nameKey($row->name);

            if (isset($photos[$key])) {
                DB::table('legacy_leaders')->where('id', $row->id)->update(['image' => $photos[$key]]);
            }
        }
    }

    /** Matches a leader across name spellings ("M C" vs "M. C."). */
    private function nameKey(string $name): string
    {
        $name = strtolower($name);
        $name = preg_replace('/^(shri|smt|dr|major|col|lt|capt)\.?\s+/', '', $name);
        $name = str_replace(['.', '-'], ' ', $name);

        return trim(preg_replace('/\s+/', ' ', $name));
    }
};
