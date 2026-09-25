<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const TITLES = [
        'Record $3.7 Million Export Order Secured by Gloders India.',
        'DPSUs get a 340 crore boost',
    ];

    public function up(): void
    {
        if (! Schema::hasTable('news_articles')) {
            return;
        }

        DB::table('news_articles')->whereIn('title', self::TITLES)->delete();
    }

    public function down(): void
    {
        if (! Schema::hasTable('news_articles')) {
            return;
        }

        $now = now();
        $rows = [
            [
                'category_id' => 5,
                'title' => self::TITLES[0],
                'subtitle' => 'India strengthens defence exports as Gliders India wins Vietnam order for critical Su-30 parachute systems',
                'author' => 'Ritik Sharma, Gliders HQ',
                'wallpaper' => '1776005362_430.jpg',
                'content' => '<p>Gliders India Limited has secured an export order worth about ₹30 crore from Vietnam to supply parachutes for Sukhoi Su-30 fighter aircraft.</p>',
                'publish_date' => '2026-04-02',
                'status' => 'Published',
                'hide_during_election' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_id' => 6,
                'title' => self::TITLES[1],
                'subtitle' => 'Government allocates major investment to modernize Gliders India and other defence PSUs',
                'author' => 'Opf Desk',
                'wallpaper' => '1776009386_639.png',
                'content' => '<p>The government allocated around ₹340 crore to defence public sector units in Kanpur, including Gliders India Limited.</p>',
                'publish_date' => '2026-04-08',
                'status' => 'Published',
                'hide_during_election' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($rows as $row) {
            if (! Schema::hasColumn('news_articles', 'hide_during_election')) {
                unset($row['hide_during_election']);
            }

            DB::table('news_articles')->updateOrInsert(['title' => $row['title']], $row);
        }
    }
};
