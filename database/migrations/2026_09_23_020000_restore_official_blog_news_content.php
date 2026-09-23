<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $blogs = $this->categoryId('Blogs');
        $updates = $this->categoryId('Latest Updates');

        $articles = [
            [
                'category_id' => $blogs,
                'title' => 'First Live Jumps Validate Advanced Parachute System',
                'subtitle' => 'High-altitude live jumps demonstrate multi-mode deployment and tactical employability.',
                'wallpaper' => 'advanced-parachute-live-jumps.jpg',
                'publish_date' => '2026-02-24',
                'content' => '<p>Gliders India Limited, in collaboration with ADRDE, developed an advanced parachute system that was inspected by DGAQA and certified by CEMILAC. The first live jumps were conducted on 20 February 2026 at Malpura Drop Zone, Agra.</p><p>The high-altitude jumps by Wg Cdr Rahul Jha and MWO R. J. Singh demonstrated multi-mode deployment and high-altitude tactical employability.</p><p><a href="https://x.com/Gliders_Defence/status/2026206118821916974" target="_blank" rel="noopener noreferrer">Source: Official Gliders India post on X</a></p>',
            ],
            [
                'category_id' => $blogs,
                'title' => 'ADC-150 Completes Deep-Sea Air-Drop Trials',
                'subtitle' => 'The indigenous container is designed to air-drop loads of up to 150 kg in deep-sea operations.',
                'wallpaper' => 'adc-150-sea-trial.jpg',
                'publish_date' => '2026-03-11',
                'content' => '<p>Gliders India Limited, in collaboration with DRDO, produced the Air Droppable Container ADC-150 for deep-sea logistics. The system is capable of air-dropping a payload of up to 150 kg.</p><p>Successful trials were conducted from an Indian Navy aircraft off Goa during the last week of February 2026.</p><p><a href="https://x.com/Gliders_Defence/status/2031732081345040444" target="_blank" rel="noopener noreferrer">Source: Official Gliders India post on X</a></p>',
            ],
            [
                'category_id' => $blogs,
                'title' => 'Parachute Chowk Honours OPF’s Defence Manufacturing Legacy',
                'subtitle' => 'Kanpur landmark recognises the contribution of Ordnance Parachute Factory.',
                'wallpaper' => 'parachute-chowk.jpg',
                'publish_date' => '2026-06-30',
                'content' => '<p>The Tiraha near Cantt Hospital, Kanpur, has been named Parachute Chowk in recognition of the invaluable services rendered by Ordnance Parachute Factory.</p><p>The landmark is a tribute to OPF’s continuing legacy of excellence in defence manufacturing and service to the nation.</p><p><a href="https://www.facebook.com/100076164844134/posts/pfbid02iQtzB9rYsJkm4a4gzTP1NQKQKdbwodmEHLqtb1k7gUkX5btSaoJw6nRQQ3sRxUF5l" target="_blank" rel="noopener noreferrer">Source: Official Gliders India post on Facebook</a></p>',
            ],
            [
                'category_id' => $updates,
                'title' => 'Gliders India at National Defence Industries Conclave 2026',
                'subtitle' => 'GIL participated in the national conclave on advanced manufacturing technologies.',
                'wallpaper' => 'ndic-2026.jpg',
                'publish_date' => '2026-03-19',
                'content' => '<p>Gliders India Limited participated in the National Defence Industries Conclave 2026 at the Manekshaw Centre, New Delhi. The conclave was inaugurated by Raksha Mantri Shri Rajnath Singh and focused on Advanced Manufacturing Technologies.</p><p>Chairman and Managing Director Shri M. C. Balasubramaniam spoke during the thematic session addressing MSMEs, soldier protection and parachute systems.</p><p><a href="https://x.com/Gliders_Defence/status/2034690980923023618" target="_blank" rel="noopener noreferrer">Source: Official Gliders India post on X</a></p>',
            ],
            [
                'category_id' => $updates,
                'title' => 'Gliders India Receives Yoga Sangam Patra',
                'subtitle' => 'Ministry of Ayush recognition for organising the International Day of Yoga demonstration.',
                'wallpaper' => 'yoga-sangam-patra.jpg',
                'publish_date' => '2026-06-23',
                'content' => '<p>Gliders India Limited received the Yoga Sangam Patra from the Ministry of Ayush in recognition of its role as an organiser of the Yoga demonstration held for International Day of Yoga 2026.</p><p>The recognition celebrates the organisation’s contribution to the national observance promoting wellness and unity.</p><p><a href="https://www.facebook.com/100076164844134/posts/pfbid0FaYXrvPQGJSumWD9phz9VQMoRb7nRz2AYiwHmaTr6WrXRbUYKiPAD1DVUJf28rFPl" target="_blank" rel="noopener noreferrer">Source: Official Gliders India post on Facebook</a></p>',
            ],
            [
                'category_id' => $updates,
                'title' => 'International Day of Yoga 2026 Observed Across GIL and OPF',
                'subtitle' => 'Teams marked the occasion under the theme “Yoga for Healthy Ageing”.',
                'wallpaper' => 'international-yoga-day-2026.jpg',
                'publish_date' => '2026-06-21',
                'content' => '<p>Gliders India Limited observed International Day of Yoga 2026 under the theme “Yoga for Healthy Ageing”. The programme at GIL included Chairman and Managing Director Shri M. C. Balasubramaniam, Director Shri S. P. Patnaik and CGM Shri Chander Shekher.</p><p>The celebration at Ordnance Parachute Factory was led by CGM Shri B. L. Meena, with employees joining the nationwide observance.</p><p><a href="https://x.com/Gliders_Defence/status/2068737826443907188" target="_blank" rel="noopener noreferrer">Source: Official Gliders India post on X</a></p>',
            ],
        ];

        foreach ($articles as $article) {
            $values = array_merge($article, [
                'author' => 'Gliders India Communications',
                'status' => 'Published',
                'updated_at' => now(),
            ]);
            if (Schema::hasColumn('news_articles', 'hide_during_election')) {
                $values['hide_during_election'] = false;
            }

            DB::table('news_articles')->updateOrInsert(
                ['title' => $article['title']],
                array_merge($values, ['created_at' => now()])
            );
        }
    }

    public function down(): void
    {
        DB::table('news_articles')->whereIn('title', [
            'First Live Jumps Validate Advanced Parachute System',
            'ADC-150 Completes Deep-Sea Air-Drop Trials',
            'Parachute Chowk Honours OPF’s Defence Manufacturing Legacy',
            'Gliders India at National Defence Industries Conclave 2026',
            'Gliders India Receives Yoga Sangam Patra',
            'International Day of Yoga 2026 Observed Across GIL and OPF',
        ])->delete();
    }

    private function categoryId(string $name): int
    {
        $existing = DB::table('news_categories')->where('name', $name)->value('id');
        if ($existing) {
            return (int) $existing;
        }

        return (int) DB::table('news_categories')->insertGetId([
            'name' => $name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};
