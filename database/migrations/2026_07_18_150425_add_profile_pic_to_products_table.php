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
        if (!Schema::hasColumn('products', 'profile_pic')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('profile_pic')->nullable()->after('wallpaper');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('products', 'profile_pic')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('profile_pic');
            });
        }
    }
};
