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
        Schema::table('general_settings', function (Blueprint $table) {
            $table->text('footer_description')->nullable();
            $table->string('footer_address')->nullable();
            $table->string('footer_phone')->nullable();
            $table->string('footer_email')->nullable();
            $table->unsignedInteger('visitor_count')->default(1025);
        });

        // Update default settings with initial footer values
        DB::table('general_settings')->where('id', 1)->update([
            'footer_description' => 'Gliders India Limited is a defence manufacturing organization specializing in parachute system and aerial delivery equipment.',
            'footer_address' => 'Headquarters kanpur, Uttar pradesh',
            'footer_phone' => 'Corporate: +91 512 2984548',
            'footer_email' => 'support@glidersindia.in',
            'visitor_count' => 1025,
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropColumn([
                'footer_description',
                'footer_address',
                'footer_phone',
                'footer_email',
                'visitor_count',
            ]);
        });
    }
};
