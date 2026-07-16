<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->boolean('launch_animation_enabled')->default(false)->after('twitter_feed_url');
            $table->dateTime('launch_animation_target_at')->nullable()->after('launch_animation_enabled');
            $table->string('launch_animation_title')->nullable()->after('launch_animation_target_at');
            $table->text('launch_animation_message')->nullable()->after('launch_animation_title');
            $table->string('launch_animation_button_text')->nullable()->after('launch_animation_message');
            $table->unsignedSmallInteger('launch_animation_auto_reveal_seconds')->default(8)->after('launch_animation_button_text');
        });
    }

    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropColumn([
                'launch_animation_enabled',
                'launch_animation_target_at',
                'launch_animation_title',
                'launch_animation_message',
                'launch_animation_button_text',
                'launch_animation_auto_reveal_seconds',
            ]);
        });
    }
};
