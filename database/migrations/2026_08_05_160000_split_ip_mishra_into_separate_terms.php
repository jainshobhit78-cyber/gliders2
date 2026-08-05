<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Shri I. P. Mishra held the post twice with other General Managers in
     * between, so he belongs on the page as two cards sitting in their own
     * chronological slots - not as one "(Two Terms)" entry, and not as an
     * unbroken 1992-1998 tenure.
     *
     * The earlier merge collapsed him; this restores both terms and then
     * re-sorts the whole roster by tenure start date so each card lands in the
     * right position.
     */
    private string $leaderName = 'Shri I. P. Mishra';

    private array $terms = [
        ['role' => 'General Manager', 'start' => '12.01.1992', 'end' => '26.08.1993', 'color' => '#2e6b9e'],
        ['role' => 'General Manager', 'start' => '07.06.1997', 'end' => '17.08.1998', 'color' => '#8a5a2b'],
    ];

    public function up(): void
    {
        $key = $this->nameKey($this->leaderName);

        $stale = DB::table('legacy_leaders')->where('type', 'opf')->get(['id', 'name', 'image'])
            ->filter(fn($r) => $this->nameKey($r->name) === $key);

        $image = $stale->firstWhere(fn($r) => !empty($r->image))->image ?? null;

        DB::table('legacy_leaders')->whereIn('id', $stale->pluck('id'))->delete();

        foreach ($this->terms as $term) {
            DB::table('legacy_leaders')->insert($this->buildRow($term, $image));
        }

        $this->resortByTenureStart();
    }

    public function down(): void
    {
        $this->resortByTenureStart();
    }

    private function buildRow(array $term, ?string $image): array
    {
        $start = $this->parseDmy($term['start']);
        $end = $this->parseDmy($term['end']);
        $startLong = $start->format('d M Y');
        $endLong = $end->format('d M Y');
        $role = $term['role'];

        return [
            'name' => $this->leaderName,
            'role' => $role,
            'type' => 'opf',
            'tenure_start' => $start->format('Y'),
            'tenure_end' => $end->format('Y'),
            'tenure_text' => 'Tenure: ' . $startLong . ' - ' . $endLong,
            'initials' => 'IM',
            'color' => $term['color'],
            'image' => $image,
            'description' => $this->leaderName . ' served as ' . $role
                . ' of the Ordnance Parachute Factory, Kanpur, from ' . $startLong . ' to ' . $endLong . '.',
            'quote' => null,
            'achievements' => implode("\n", [
                'Held the office of ' . $role . ', Ordnance Parachute Factory, Kanpur',
                'Tenure: ' . $startLong . ' - ' . $endLong,
                'Directed parachute and allied defence equipment production through this period',
            ]),
            'focus_areas' => json_encode([
                ['icon' => 'gear', 'label' => 'Parachute Manufacturing'],
                ['icon' => 'people', 'label' => 'Factory Administration'],
            ]),
            'stats' => json_encode([
                ['icon' => 'calendar', 'number' => $this->duration($start, $end), 'label' => 'Length of Tenure'],
                ['icon' => 'flag', 'number' => $start->format('Y'), 'label' => 'Assumed Office'],
            ]),
            'timeline' => json_encode([
                ['year' => $start->format('Y'), 'title' => 'Assumed charge as ' . $role, 'icon' => 'flag'],
                ['year' => $end->format('Y'), 'title' => 'Completed tenure', 'icon' => 'star'],
            ]),
            'display_order' => 999,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Newest tenure first, ordered by start date. Re-deriving this from the
     * dates keeps re-inserted rows in the right slot regardless of their id.
     */
    private function resortByTenureStart(): void
    {
        $rows = DB::table('legacy_leaders')->where('type', 'opf')->get(['id', 'tenure_text']);

        $sorted = $rows->sortByDesc(function ($r) {
            $date = $this->startDate($r->tenure_text);

            return $date ? $date->format('Ymd') : '00000000';
        })->values();

        foreach ($sorted as $i => $row) {
            DB::table('legacy_leaders')->where('id', $row->id)->update(['display_order' => $i + 1]);
        }
    }

    private function startDate(?string $text): ?DateTime
    {
        if ($text && preg_match('/^Tenure:\s*(.+?)\s+-\s+/', $text, $m)) {
            $date = DateTime::createFromFormat('d M Y', trim($m[1]));

            if ($date) {
                $date->setTime(0, 0, 0);

                return $date;
            }
        }

        return null;
    }

    private function parseDmy(string $value): DateTime
    {
        $date = DateTime::createFromFormat('d.m.Y', $value);
        $date->setTime(0, 0, 0);

        return $date;
    }

    private function duration(DateTime $start, DateTime $end): string
    {
        $diff = $start->diff($end);

        if ($diff->y > 0) {
            return $diff->m > 0 ? $diff->y . ' yr ' . $diff->m . ' mo' : $diff->y . ' yr';
        }

        if ($diff->m > 0) {
            return $diff->m . ' mo';
        }

        return ($diff->days + 1) . ' days';
    }

    private function nameKey(string $name): string
    {
        $name = strtolower($name);
        $name = preg_replace('/^(shri|smt|dr|major|col|lt|capt)\.?\s+/', '', $name);
        $name = str_replace(['.', '-'], ' ', $name);

        return trim(preg_replace('/\s+/', ' ', $name));
    }
};
