<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('products', 'specification_pdf')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('specification_pdf')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('products', 'specification_pdf')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('specification_pdf');
            });
        }
    }
};
