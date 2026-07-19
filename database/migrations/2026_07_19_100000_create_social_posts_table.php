<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('social_posts')) {
            return;
        }

        Schema::create('social_posts', function (Blueprint $table) {
            $table->id();
            $table->string('platform')->default('facebook'); // facebook | linkedin | instagram
            $table->string('author')->nullable();
            $table->date('post_date')->nullable();
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('likes')->default(0);
            $table->unsignedInteger('comments')->default(0);
            $table->unsignedInteger('shares')->default(0);
            $table->string('link')->nullable();
            $table->string('status')->default('Published');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_posts');
    }
};
