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
        Schema::table('general_settings', function (Blueprint $table) {
            $table->string('products_page_tagline')->nullable()->after('headings_font_family');
            $table->string('products_page_title')->nullable()->after('products_page_tagline');
            $table->text('products_page_subtitle')->nullable()->after('products_page_title');
            $table->string('products_page_wallpaper')->nullable()->after('products_page_subtitle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropColumn([
                'products_page_tagline',
                'products_page_title',
                'products_page_subtitle',
                'products_page_wallpaper'
            ]);
        });
    }
};
