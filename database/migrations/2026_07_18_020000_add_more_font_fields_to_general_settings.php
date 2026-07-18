<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('general_settings', 'main_menu_font_family')) {
                $table->string('main_menu_font_family')->nullable()->default('Outfit');
            }
            if (!Schema::hasColumn('general_settings', 'submenu_font_family')) {
                $table->string('submenu_font_family')->nullable()->default('Outfit');
            }
            if (!Schema::hasColumn('general_settings', 'body_font_family')) {
                $table->string('body_font_family')->nullable()->default('Outfit');
            }
        });
    }

    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropColumn(['main_menu_font_family', 'submenu_font_family', 'body_font_family']);
        });
    }
};
