<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticker_news', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->string('link')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('position')->default(0);
            $table->timestamps();
        });

        if (Schema::hasTable('general_settings')) {
            Schema::table('general_settings', function (Blueprint $table) {
                if (!Schema::hasColumn('general_settings', 'ticker_speed')) {
                    $table->integer('ticker_speed')->default(20)->after('visitor_count');
                }
            });
        }

        // Seed default ticker messages
        \DB::table('ticker_news')->insert([
            [
                'text' => 'Gliders India Limited Welcomes Shri M C Balasubramaniam as Chairman & Managing Director (CMD).',
                'link' => 'https://gold-heron-926288.hostingersite.com/about/leadership',
                'position' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'text' => 'Important Announcement: Vigilance Awareness Week observed from October 28th to November 3rd.',
                'link' => null,
                'position' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'text' => 'Expression of Interest (EOI) invited for partnership in Defence production and technology projects.',
                'link' => 'https://gold-heron-926288.hostingersite.com/finance/eoi',
                'position' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticker_news');

        if (Schema::hasTable('general_settings')) {
            Schema::table('general_settings', function (Blueprint $table) {
                if (Schema::hasColumn('general_settings', 'ticker_speed')) {
                    $table->dropColumn('ticker_speed');
                }
            });
        }
    }
};
