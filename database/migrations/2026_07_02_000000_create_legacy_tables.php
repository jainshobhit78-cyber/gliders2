<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legacy_leaders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->string('tenure_start')->nullable();
            $table->string('tenure_end')->nullable();
            $table->string('tenure_text')->nullable();
            $table->string('initials')->nullable();
            $table->string('color')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->text('quote')->nullable();
            $table->text('achievements')->nullable();
            $table->json('focus_areas')->nullable();
            $table->json('stats')->nullable();
            $table->json('timeline')->nullable();
            $table->integer('display_order')->default(999);
            $table->timestamps();
        });

        Schema::create('legacy_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->default('Leadership');
            $table->string('hero_accent')->default('Legacy');
            $table->string('hero_subtitle')->default('Honouring the Visionaries Who Shaped Gliders India');
            $table->string('timeline_title')->default('OUR LEADERSHIP JOURNEY');
            $table->string('footer_line1')->default('From Legacy to Leadership,');
            $table->string('footer_line2')->default('From Leadership to Innovation.');
            $table->timestamps();
        });

        // Insert default settings
        DB::table('legacy_settings')->insert([
            'hero_title' => 'Leadership',
            'hero_accent' => 'Legacy',
            'hero_subtitle' => 'Honouring the Visionaries Who Shaped Gliders India',
            'timeline_title' => 'OUR LEADERSHIP JOURNEY',
            'footer_line1' => 'From Legacy to Leadership,',
            'footer_line2' => 'From Leadership to Innovation.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert default legacy leaders from the HTML file
        $defaultLeaders = [
            [
                'name' => 'Shri A. K. Srivastava',
                'role' => 'Chairman & Managing Director',
                'tenure_start' => '1992',
                'tenure_end' => '1997',
                'tenure_text' => 'Tenure: 1992 – 1997',
                'initials' => 'AS',
                'color' => '#0b2a5b',
                'display_order' => 1,
            ],
            [
                'name' => 'Dr. M. R. Bhardwaj',
                'role' => 'Chairman & Managing Director',
                'tenure_start' => '1997',
                'tenure_end' => '2002',
                'tenure_text' => 'Tenure: 1997 – 2002',
                'initials' => 'MB',
                'color' => '#1c4a8a',
                'display_order' => 2,
            ],
            [
                'name' => 'Shri P. K. Agarwal',
                'role' => 'Chairman & Managing Director',
                'tenure_start' => '2002',
                'tenure_end' => '2007',
                'tenure_text' => 'Tenure: 2002 – 2007',
                'initials' => 'PA',
                'color' => '#2e6b9e',
                'display_order' => 3,
            ],
            [
                'name' => 'Shri V. K. Kapoor',
                'role' => 'Chairman & Managing Director',
                'tenure_start' => '2007',
                'tenure_end' => '2013',
                'tenure_text' => 'Tenure: 2007 – 2013',
                'initials' => 'VK',
                'color' => '#3a7d6e',
                'display_order' => 4,
            ],
            [
                'name' => 'Shri N. B. Singh',
                'role' => 'Chairman & Managing Director',
                'tenure_start' => '2013',
                'tenure_end' => '2019',
                'tenure_text' => 'Tenure: 2013 – 2019',
                'initials' => 'NS',
                'color' => '#5a5a9e',
                'display_order' => 5,
            ],
            [
                'name' => 'Shri M C Balasubramaniam',
                'role' => 'Chairman & Managing Director',
                'tenure_start' => '2019',
                'tenure_end' => '',
                'tenure_text' => 'Tenure: 2019 – Present',
                'initials' => 'MB',
                'color' => '#0b2a5b',
                'display_order' => 6,
            ],
        ];

        foreach ($defaultLeaders as $dl) {
            DB::table('legacy_leaders')->insert(array_merge($dl, [
                'description' => 'Shaped the organization through strategic growth and dedicated service.',
                'quote' => 'Excellence is not an act, but a habit.',
                'achievements' => "Established core manufacturing processes\nExpanded export markets to new regions\nImplemented workforce development programs",
                'focus_areas' => json_encode([
                    ['icon' => 'globe', 'label' => 'Global Expansion'],
                    ['icon' => 'gear', 'label' => 'Process Modernization']
                ]),
                'stats' => json_encode([
                    ['icon' => 'rupee', 'number' => '₹500 Cr+', 'label' => 'Orders Secured'],
                    ['icon' => 'star', 'number' => '10+', 'label' => 'Awards Received']
                ]),
                'timeline' => json_encode([
                    ['year' => $dl['tenure_start'], 'title' => 'Appointed CMD', 'icon' => 'flag'],
                    ['year' => $dl['tenure_start'] + 2, 'title' => 'Commissioned New Plant', 'icon' => 'wrench']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('legacy_leaders');
        Schema::dropIfExists('legacy_settings');
    }
};
