<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('finance_returns')) {
            Schema::create('finance_returns', function (Blueprint $table) {
                $table->id();
                $table->string('fiscal_year', 7)->unique();
                $table->string('pdf')->nullable();
                $table->unsignedInteger('display_order')->default(999);
                $table->timestamps();
            });
        }

        $now = now();
        DB::table('finance_returns')->insertOrIgnore([
            ['fiscal_year' => '24-25', 'pdf' => null, 'display_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['fiscal_year' => '23-24', 'pdf' => null, 'display_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['fiscal_year' => '22-23', 'pdf' => null, 'display_order' => 3, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('finance_returns');
    }
};
