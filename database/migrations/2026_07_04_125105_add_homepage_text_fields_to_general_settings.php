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
            $table->string('products_title_prefix')->nullable()->after('google_analytics_id');
            $table->string('products_title_suffix')->nullable()->after('products_title_prefix');
            $table->text('products_subtitle')->nullable()->after('products_title_suffix');
            $table->text('solutions_title')->nullable()->after('products_subtitle');
            $table->string('products_font_family')->nullable()->after('solutions_title');
            $table->string('headings_font_family')->nullable()->after('products_font_family');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropColumn([
                'products_title_prefix',
                'products_title_suffix',
                'products_subtitle',
                'solutions_title',
                'products_font_family',
                'headings_font_family'
            ]);
        });
    }
};
