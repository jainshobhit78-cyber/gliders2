<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('legacy_leaders', function (Blueprint $table) {
            $table->string('type')->default('gliders')->after('role');
        });

        // Set all existing pre-2021 seeded leaders to 'opf' type
        DB::table('legacy_leaders')
            ->whereIn('name', [
                'Shri A. K. Srivastava',
                'Dr. M. R. Bhardwaj',
                'Shri P. K. Agarwal',
                'Shri V. K. Kapoor',
                'Shri N. B. Singh',
                'Shri M C Balasubramaniam'
            ])
            ->update(['type' => 'opf']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('legacy_leaders', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
