<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('general_settings', 'homepage_product_1')) {
                $table->integer('homepage_product_1')->nullable();
                $table->foreign('homepage_product_1')->references('id')->on('products')->nullOnDelete();
            }
            if (!Schema::hasColumn('general_settings', 'homepage_product_2')) {
                $table->integer('homepage_product_2')->nullable();
                $table->foreign('homepage_product_2')->references('id')->on('products')->nullOnDelete();
            }
            if (!Schema::hasColumn('general_settings', 'homepage_product_3')) {
                $table->integer('homepage_product_3')->nullable();
                $table->foreign('homepage_product_3')->references('id')->on('products')->nullOnDelete();
            }
            if (!Schema::hasColumn('general_settings', 'homepage_product_4')) {
                $table->integer('homepage_product_4')->nullable();
                $table->foreign('homepage_product_4')->references('id')->on('products')->nullOnDelete();
            }
            if (!Schema::hasColumn('general_settings', 'product_slider_auto')) {
                $table->boolean('product_slider_auto')->default(true);
            }
        });
    }

    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropForeign(['homepage_product_1']);
            $table->dropForeign(['homepage_product_2']);
            $table->dropForeign(['homepage_product_3']);
            $table->dropForeign(['homepage_product_4']);
            
            $table->dropColumn([
                'homepage_product_1',
                'homepage_product_2',
                'homepage_product_3',
                'homepage_product_4',
                'product_slider_auto'
            ]);
        });
    }
};
