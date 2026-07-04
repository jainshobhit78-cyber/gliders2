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
        Schema::table('products', function (Blueprint $table) {
            $table->text('specs_subtext')->nullable();
            $table->string('specs_image')->nullable();
            $table->longText('technical_specs')->nullable();
            $table->string('caps_image')->nullable();
            $table->longText('main_capabilities')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'specs_subtext',
                'specs_image',
                'technical_specs',
                'caps_image',
                'main_capabilities'
            ]);
        });
    }
};
