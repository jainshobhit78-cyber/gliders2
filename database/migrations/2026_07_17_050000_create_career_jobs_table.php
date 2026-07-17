<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('recruitment'); // recruitment or internship
            $table->string('title');
            $table->text('job_info')->nullable();
            $table->text('eligibility')->nullable();
            $table->date('last_date')->nullable();
            $table->string('pdf')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_jobs');
    }
};
