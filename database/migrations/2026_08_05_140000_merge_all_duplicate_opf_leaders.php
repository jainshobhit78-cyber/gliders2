<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Collapses every remaining repeated name in the OPF roster to one entry.
     *
     * Two shapes exist in the source record:
     *
     *  - Back-to-back postings, where a leader changed designation mid-tenure
     *    (OIC -> GM, GM -> Chief GM). These merge into one continuous tenure
     *    carrying the final designation, with the change kept in the timeline.
     *
     *  - Separate terms, where a leader returned after someone else had held
     *    the post. Shri I. P. Mishra served 1992-93 and again 1997-98. These
     *    merge into one entry too, but the tenure is written out as both terms
     *    and the role is marked accordingly, so the gap is never implied away.
     *
     * A gap of more than 90 days between postings distinguishes the two.
     */
    private const SEPARATE_TERM_GAP_DAYS = 90;

    public function up(): void
    {
        $groups = DB::table('legacy_leaders')
            ->where('type', 'opf')
            ->orderBy('id')
            ->get()
            ->groupBy(fn($r) => $this->nameKey($r->name))
            ->filter(fn($g) => $g->count() > 1);

        foreach ($groups as $rows) {
            $rows = $rows->values();

            $this->isContinuous($rows)
                ? $this->mergeContinuous($rows)
                : $this->mergeSeparateTerms($rows);

            DB::table('legacy_leaders')
                ->whereIn('id', $rows->slice(0, -1)->pluck('id'))
                ->delete();
        }

        $this->renumber();
    }

    public function down(): void
    {
        // Removed rows cannot be reconstructed here; re-run the roster seed
        // migration to restore the full list.
        $this->renumber();
    }

    private function isContinuous($rows): bool
    {
        for ($i = 1; $i < $rows->count(); $i++) {
            $prevEnd = $this->endDate($rows[$i - 1]);
            $nextStart = $this->startDate($rows[$i]);

            if (!$prevEnd || !$nextStart) {
                continue;
            }

            if ($prevEnd->diff($nextStart)->days > self::SEPARATE_TERM_GAP_DAYS) {
                return false;
            }
        }

        return true;
    }

    /** One unbroken tenure; keep the final designation. */
    private function mergeContinuous($rows): void
    {
        $first = $rows->first();
        $last = $rows->last();

        [$startLong] = $this->splitTenure($first->tenure_text);
        [$changedLong, $endLong] = $this->splitTenure($last->tenure_text);
        $isCurrent = $last->tenure_end === '' || $last->tenure_end === null;

        $timeline = [
            ['year' => $first->tenure_start, 'title' => 'Assumed charge as ' . $first->role, 'icon' => 'flag'],
            ['year' => $last->tenure_start, 'title' => 'Continued as ' . $last->role, 'icon' => 'arrowUp'],
            [
                'year' => $isCurrent ? 'Present' : $last->tenure_end,
                'title' => $isCurrent ? 'Currently in office' : 'Completed tenure',
                'icon' => 'star',
            ],
        ];

        DB::table('legacy_leaders')->where('id', $last->id)->update([
            'tenure_start' => $first->tenure_start,
            'tenure_text' => 'Tenure: ' . $startLong . ' - ' . $endLong,
            'image' => $this->firstImage($rows) ?: $last->image,
            'description' => $last->name . ' assumed charge as ' . $first->role
                . ' of the Ordnance Parachute Factory, Kanpur, on ' . $startLong
                . ', continued as ' . $last->role . ' from ' . $changedLong
                . ($isCurrent ? ', and continues to head the Factory.' : ', and served until ' . $endLong . '.'),
            'achievements' => $this->achievements($last->role, $startLong . ' - ' . $endLong),
            'timeline' => json_encode($timeline),
            'updated_at' => now(),
        ]);
    }

    /** Non-consecutive terms; spell both out rather than spanning the gap. */
    private function mergeSeparateTerms($rows): void
    {
        $last = $rows->last();

        $terms = $rows->map(function ($r) {
            [$s, $e] = $this->splitTenure($r->tenure_text);
            return $s . ' - ' . $e;
        })->all();

        $count = count($terms);
        $word = $count === 2 ? 'Two Terms' : $count . ' Terms';
        $role = $last->role . ' (' . $word . ')';

        $timeline = [];
        foreach ($rows as $i => $r) {
            $ordinal = $i === 0 ? 'first' : ($i === 1 ? 'second' : 'later');
            $timeline[] = [
                'year' => $r->tenure_start,
                'title' => ($i === 0 ? 'Began ' : 'Returned for ') . $ordinal . ' term as ' . $r->role,
                'icon' => 'flag',
            ];
            $timeline[] = [
                'year' => $r->tenure_end,
                'title' => 'Completed ' . $ordinal . ' term',
                'icon' => 'star',
            ];
        }

        DB::table('legacy_leaders')->where('id', $last->id)->update([
            'role' => $role,
            'tenure_start' => $rows->first()->tenure_start,
            'tenure_text' => 'Tenure: ' . implode(' and ', $terms),
            'image' => $this->firstImage($rows) ?: $last->image,
            'description' => $last->name . ' served as ' . $last->role
                . ' of the Ordnance Parachute Factory, Kanpur, across ' . strtolower($word)
                . ': ' . implode(' and ', $terms) . '.',
            'achievements' => $this->achievements($role, implode(' and ', $terms)),
            'timeline' => json_encode($timeline),
            'updated_at' => now(),
        ]);
    }

    private function achievements(string $role, string $tenure): string
    {
        return implode("\n", [
            'Held the office of ' . $role . ', Ordnance Parachute Factory, Kanpur',
            'Tenure: ' . $tenure,
            'Directed parachute and allied defence equipment production through this period',
        ]);
    }

    private function firstImage($rows): ?string
    {
        foreach ($rows as $r) {
            if (!empty($r->image)) {
                return $r->image;
            }
        }

        return null;
    }

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

    private function startDate($row): ?DateTime
    {
        [$s] = $this->splitTenure($row->tenure_text);

        return $this->parse($s);
    }

    private function endDate($row): ?DateTime
    {
        [, $e] = $this->splitTenure($row->tenure_text);

        return $this->parse($e);
    }

    private function parse(string $value): ?DateTime
    {
        $date = DateTime::createFromFormat('d M Y', trim($value));

        if (!$date) {
            return null; // "Till Date" and anything unexpected
        }

        $date->setTime(0, 0, 0);

        return $date;
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
