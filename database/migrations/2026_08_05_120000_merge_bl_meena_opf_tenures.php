<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Shri B. L. Meena occupied two consecutive OPF postings - General Manager
     * from 24 Feb 2025, then Chief General Manager from 08 Oct 2025 - and the
     * source record lists them as separate rows, so he appeared twice at the
     * head of the roster.
     *
     * Collapses them into the single Chief General Manager entry, widened to
     * cover the whole unbroken tenure so the card still shows when he actually
     * took charge. The promotion itself is preserved in the timeline.
     *
     * Only the leaders named here are merged; the other repeated names in the
     * roster are left as separate tenures.
     */
    private array $mergeLeaders = ['b l meena'];

    public function up(): void
    {
        foreach ($this->mergeLeaders as $key) {
            $rows = DB::table('legacy_leaders')
                ->where('type', 'opf')
                ->orderBy('id')
                ->get(['id', 'name', 'role', 'tenure_text', 'tenure_start', 'tenure_end'])
                ->filter(fn($r) => $this->nameKey($r->name) === $key)
                ->values();

            if ($rows->count() < 2) {
                continue; // already merged, or nothing to do
            }

            $earliest = $rows->first();
            $latest = $rows->last();

            [$startLong] = $this->splitTenure($earliest->tenure_text);
            [$promotedLong, $endLong] = $this->splitTenure($latest->tenure_text);

            $isCurrent = $latest->tenure_end === '' || $latest->tenure_end === null;

            DB::table('legacy_leaders')->where('id', $latest->id)->update([
                'tenure_start' => $earliest->tenure_start,
                'tenure_text' => 'Tenure: ' . $startLong . ' - ' . $endLong,
                'description' => $latest->name . ' assumed charge as ' . $earliest->role
                    . ' of the Ordnance Parachute Factory, Kanpur, on ' . $startLong
                    . ', was elevated to ' . $latest->role . ' on ' . $promotedLong
                    . ($isCurrent ? ', and continues to head the Factory.' : ', and served until ' . $endLong . '.'),
                'achievements' => implode("\n", [
                    'Held the office of ' . $latest->role . ', Ordnance Parachute Factory, Kanpur',
                    'Tenure: ' . $startLong . ' - ' . $endLong,
                    'Directed parachute and allied defence equipment production through this period',
                ]),
                'timeline' => json_encode([
                    ['year' => $earliest->tenure_start, 'title' => 'Assumed charge as ' . $earliest->role, 'icon' => 'flag'],
                    ['year' => $latest->tenure_start, 'title' => 'Elevated to ' . $latest->role, 'icon' => 'arrowUp'],
                    [
                        'year' => $isCurrent ? 'Present' : $latest->tenure_end,
                        'title' => $isCurrent ? 'Currently in office' : 'Completed tenure',
                        'icon' => 'star',
                    ],
                ]),
                'updated_at' => now(),
            ]);

            DB::table('legacy_leaders')
                ->whereIn('id', $rows->slice(0, -1)->pluck('id'))
                ->delete();
        }

        $this->renumber();
    }

    public function down(): void
    {
        // The removed rows cannot be reconstructed here; re-run the roster seed
        // migration to restore the full list.
        $this->renumber();
    }

    /** Keeps display_order contiguous from 1 after rows are removed. */
    private function renumber(): void
    {
        $ids = DB::table('legacy_leaders')
            ->where('type', 'opf')
            ->orderBy('display_order')
            ->orderBy('id')
            ->pluck('id');

        foreach ($ids as $i => $id) {
            DB::table('legacy_leaders')->where('id', $id)->update(['display_order' => $i + 1]);
        }
    }

    /** "Tenure: 24 Feb 2025 - 07 Oct 2025" => ['24 Feb 2025', '07 Oct 2025'] */
    private function splitTenure(?string $text): array
    {
        if ($text && preg_match('/^Tenure:\s*(.+?)\s+-\s+(.+)$/', $text, $m)) {
            return [trim($m[1]), trim($m[2])];
        }

        return ['', ''];
    }

    private function nameKey(string $name): string
    {
        $name = strtolower($name);
        $name = preg_replace('/^(shri|smt|dr|major|col|lt|capt)\.?\s+/', '', $name);
        $name = str_replace(['.', '-'], ' ', $name);

        return trim(preg_replace('/\s+/', ' ', $name));
    }
};
