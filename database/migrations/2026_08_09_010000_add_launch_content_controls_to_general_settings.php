<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->string('launch_brand_title')->nullable();
            $table->string('launch_brand_subtitle')->nullable();
            $table->string('launch_intro_date_label')->nullable();
            $table->string('launch_intro_overline')->nullable();
            $table->string('launch_intro_whisper')->nullable();
            $table->string('launch_ribbon_overline')->nullable();
            $table->string('launch_ribbon_title')->nullable();
            $table->string('launch_ribbon_highlight')->nullable();
            $table->string('launch_ribbon_caption')->nullable();
            $table->string('launch_countdown_overline')->nullable();
            $table->string('launch_countdown_text_5')->nullable();
            $table->string('launch_countdown_text_4')->nullable();
            $table->string('launch_countdown_text_3')->nullable();
            $table->string('launch_countdown_text_2')->nullable();
            $table->string('launch_countdown_text_1')->nullable();
            $table->string('launch_finale_overline')->nullable();
            $table->string('launch_finale_title')->nullable();
            $table->string('launch_finale_subtitle')->nullable();
            $table->string('launch_finale_badge_text')->nullable();
            $table->boolean('launch_animation_show_skip_button')->default(true);
            $table->boolean('launch_animation_fireworks_enabled')->default(true);
            $table->boolean('launch_animation_confetti_enabled')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropColumn([
                'launch_brand_title', 'launch_brand_subtitle', 'launch_intro_date_label',
                'launch_intro_overline', 'launch_intro_whisper', 'launch_ribbon_overline',
                'launch_ribbon_title', 'launch_ribbon_highlight', 'launch_ribbon_caption',
                'launch_countdown_overline', 'launch_countdown_text_5', 'launch_countdown_text_4',
                'launch_countdown_text_3', 'launch_countdown_text_2', 'launch_countdown_text_1',
                'launch_finale_overline', 'launch_finale_title', 'launch_finale_subtitle',
                'launch_finale_badge_text', 'launch_animation_show_skip_button',
                'launch_animation_fireworks_enabled', 'launch_animation_confetti_enabled',
            ]);
        });
    }
};
