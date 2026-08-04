<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Complete historical roster of the heads of Ordnance Parachute Factory, Kanpur.
     *
     * Format: [name, role, tenure start (d.m.Y), tenure end (d.m.Y or null for current)]
     * Kept in strict chronological order — display_order is assigned from this order.
     */
    private array $roster = [
        // ----- Officer-in-Charge (1941 - 1961) -----
        ['Shri A. R. Ventris',        'Officer-in-Charge', '01.10.1941', '04.07.1945'],
        ['Shri H. L. Holt',           'Officer-in-Charge', '05.07.1945', '11.09.1945'],
        ['Shri H. J. Pitman',         'Officer-in-Charge', '12.09.1945', '23.10.1946'],
        ['Major W. Nicholson',        'Officer-in-Charge', '24.10.1946', '08.04.1947'],
        ['Shri B. Singh',             'Officer-in-Charge', '09.04.1947', '16.07.1948'],
        ['Shri S. N. Gupt',           'Officer-in-Charge', '17.07.1948', '24.04.1958'],
        ['Shri Amar Chand',           'Officer-in-Charge', '25.04.1958', '30.09.1961'],

        // ----- General Manager (1961 onwards) -----
        ['Shri Amar Chand',           'General Manager',       '01.10.1961', '20.01.1964'],
        ['Shri S. L. Kumar',          'General Manager',       '21.01.1964', '28.02.1969'],
        ['Shri J. S. Rastogi',        'General Manager',       '01.03.1969', '01.05.1974'],
        ['Shri G. B. L. Murthy',      'General Manager',       '02.05.1974', '06.05.1975'],
        ['Shri A. K. Niyogi',         'General Manager',       '01.05.1976', '02.06.1978'],
        ['Shri B. L. Khurana',        'General Manager',       '15.06.1978', '12.11.1979'],
        ['Shri K. S. Ganesh Babu',    'General Manager (OIC)', '12.11.1979', '16.11.1982'],
        ['Shri K. S. Ganesh Babu',    'General Manager',       '17.11.1982', '30.06.1991'],
        ['Shri P. R. Rao',            'General Manager',       '01.07.1991', '11.01.1992'],
        ['Shri I. P. Mishra',         'General Manager',       '12.01.1992', '26.08.1993'],
        ['Shri A. S. Bhattacharya',   'General Manager',       '01.09.1993', '13.05.1995'],
        ['Shri Mahendra Swaroop',     'General Manager',       '15.05.1995', '31.05.1997'],
        ['Shri I. P. Mishra',         'General Manager',       '07.06.1997', '17.08.1998'],
        ['Shri C. B. Singh',          'General Manager',       '18.08.1998', '31.08.2001'],
        ['Shri Arun Saxena',          'General Manager',       '31.08.2001', '07.09.2002'],
        ['Shri Harnam Singh',         'General Manager',       '07.09.2002', '03.07.2003'],
        ['Shri A. Biswas',            'General Manager',       '14.07.2003', '31.01.2006'],
        ['Shri A. N. Prasad',         'General Manager',       '27.02.2006', '31.12.2007'],
        ['Shri S. N. Uqba',           'General Manager',       '12.01.2008', '01.01.2009'],
        ['Shri Kiran Prakash',        'General Manager',       '02.01.2009', '23.09.2009'],
        ['Shri S. Asthana',           'General Manager',       '24.09.2009', '14.06.2011'],
        ['Shri R. Ravishankar',       'General Manager',       '15.06.2011', '30.11.2012'],
        ['Shri Kailash Chand',        'General Manager',       '14.12.2012', '31.10.2015'],
        ['Shri Kailash Chand',        'Chief General Manager', '01.11.2015', '18.05.2017'],
        ['Shri G. C. Raut',           'General Manager',       '19.05.2017', '15.06.2019'],
        ['Shri A. K. Shukla',         'General Manager (OIC)', '16.06.2019', '18.06.2019'],
        ['Shri D. K. Bangotra',       'General Manager',       '19.06.2019', '31.05.2021'],
        ['Shri Apurba Majumdar',      'General Manager',       '15.06.2021', '02.02.2022'],
        ['Shri Sushil Sinha',         'General Manager (OIC)', '03.02.2022', '20.03.2022'],
        ['Shri Sushil Sinha',         'General Manager',       '21.03.2022', '28.02.2023'],
        ['Shri M. C. Balasubramaniam','General Manager',       '16.03.2023', '23.01.2025'],
        ['Shri B. L. Meena',          'General Manager',       '24.02.2025', '07.10.2025'],
        ['Shri B. L. Meena',          'Chief General Manager', '08.10.2025', null],
    ];

    private array $palette = [
        '#0b2a5b', '#1c4a8a', '#2e6b9e', '#3a7d6e',
        '#5a5a9e', '#8a5a2b', '#7a3b5e',
    ];

    public function up(): void
    {
        // Carry any admin-uploaded photos across the roster rebuild, matched by name.
        $imagesByName = [];
        foreach (DB::table('legacy_leaders')->where('type', 'opf')->get() as $existing) {
            if (!empty($existing->image)) {
                $imagesByName[$this->nameKey($existing->name)] = $existing->image;
            }
        }

        // The previous 'opf' rows were placeholder copies of the Gliders India CMD list.
        DB::table('legacy_leaders')->where('type', 'opf')->delete();

        $rows = [];
        foreach ($this->roster as $i => [$name, $role, $start, $end]) {
            $startDate = $this->parseDate($start);
            $endDate = $end ? $this->parseDate($end) : null;
            $isCurrent = $endDate === null;

            $startLong = $startDate->format('d M Y');
            $endLong = $isCurrent ? 'Till Date' : $endDate->format('d M Y');
            $duration = $this->duration($startDate, $endDate ?? new DateTime());

            $rows[] = [
                'name' => $name,
                'role' => $role,
                'type' => 'opf',
                'tenure_start' => $startDate->format('Y'),
                'tenure_end' => $isCurrent ? '' : $endDate->format('Y'),
                'tenure_text' => 'Tenure: ' . $startLong . ' - ' . $endLong,
                'initials' => $this->initials($name),
                'color' => $this->palette[$i % count($this->palette)],
                'image' => $imagesByName[$this->nameKey($name)] ?? null,
                'description' => $isCurrent
                    ? $name . ' assumed charge as ' . $role . ' of the Ordnance Parachute Factory, Kanpur, on ' . $startLong . ' and continues to head the Factory.'
                    : $name . ' served as ' . $role . ' of the Ordnance Parachute Factory, Kanpur, from ' . $startLong . ' to ' . $endLong . '.',
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
                    ['icon' => 'calendar', 'number' => $isCurrent ? 'Ongoing' : $duration, 'label' => 'Length of Tenure'],
                    ['icon' => 'flag', 'number' => $startDate->format('Y'), 'label' => 'Assumed Office'],
                ]),
                'timeline' => json_encode([
                    [
                        'year' => $startDate->format('Y'),
                        'title' => 'Assumed charge as ' . $role,
                        'icon' => 'flag',
                    ],
                    [
                        'year' => $isCurrent ? 'Present' : $endDate->format('Y'),
                        'title' => $isCurrent ? 'Currently in office' : 'Completed tenure',
                        'icon' => 'star',
                    ],
                ]),
                'display_order' => $i + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach (array_chunk($rows, 20) as $chunk) {
            DB::table('legacy_leaders')->insert($chunk);
        }
    }

    public function down(): void
    {
        DB::table('legacy_leaders')->where('type', 'opf')->delete();
    }

    private function parseDate(string $value): DateTime
    {
        $date = DateTime::createFromFormat('d.m.Y', $value);
        $date->setTime(0, 0, 0);

        return $date;
    }

    /** Normalised key used to match a leader across name spellings ("M C" vs "M. C."). */
    private function nameKey(string $name): string
    {
        $name = strtolower($name);
        $name = preg_replace('/^(shri|smt|dr|major|col|lt|capt)\.?\s+/', '', $name);
        $name = str_replace(['.', '-'], ' ', $name);

        return trim(preg_replace('/\s+/', ' ', $name));
    }

    private function initials(string $name): string
    {
        $parts = preg_split('/\s+/', trim(preg_replace('/^(Shri|Smt|Dr|Major|Col|Lt|Capt)\.?\s+/i', '', $name)));

        return strtoupper(substr($parts[0], 0, 1) . substr(end($parts), 0, 1));
    }

    private function duration(DateTime $start, DateTime $end): string
    {
        $diff = $start->diff($end);

        if ($diff->y > 0) {
            return $diff->m > 0
                ? $diff->y . ' yr ' . $diff->m . ' mo'
                : $diff->y . ' yr';
        }

        if ($diff->m > 0) {
            return $diff->m . ' mo';
        }

        // Short tenures are counted inclusively (16 Jun - 18 Jun reads as 3 days).
        return ($diff->days + 1) . ' days';
    }
};
