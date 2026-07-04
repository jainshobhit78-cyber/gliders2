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
        Schema::table('product_categories', function (Blueprint $table) {
            $table->string('wallpaper_image')->nullable()->after('image');
            $table->string('category_title')->nullable()->after('name');
            $table->text('category_subtitle')->nullable()->after('category_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropColumn(['wallpaper_image', 'category_title', 'category_subtitle']);
        });
    }
};
