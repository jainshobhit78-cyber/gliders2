<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('product_categories')->nullOnDelete();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('wallpaper')->nullable();
            $table->timestamps();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('key_offerings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_home')->default(false);
            $table->timestamps();
        });

        Schema::create('video_banner', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('banner_video')->nullable();
            $table->string('mid_video')->nullable();
            $table->timestamps();
        });

        Schema::create('our_units', function (Blueprint $table) {
            $table->id();
            $table->string('heading')->nullable();
            $table->string('sub_heading')->nullable();
            $table->longText('description')->nullable();
            $table->string('video')->nullable();
            $table->timestamps();
        });

        Schema::create('state_counter', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('years_of_legacy')->default(0);
            $table->unsignedInteger('parachutes_manufactured')->default(0);
            $table->unsignedInteger('indigenous_manufacturing')->default(0);
            $table->unsignedInteger('annual_production_value')->default(0);
            $table->timestamps();
        });

        Schema::create('image_gallery', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('partner_logo', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('playlists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('heading')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
        });

        Schema::create('playlist_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('playlist_id')->constrained('playlists')->cascadeOnDelete();
            $table->string('image');
            $table->string('sub_heading')->nullable();
            $table->string('caption')->nullable();
            $table->timestamps();
        });

        Schema::create('playlist_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('playlist_id')->constrained('playlists')->cascadeOnDelete();
            $table->string('video');
            $table->string('caption')->nullable();
            $table->timestamps();
        });

        Schema::create('about_leadership', function (Blueprint $table) {
            $table->id();
            $table->string('leader_name');
            $table->string('role')->nullable();
            $table->string('sub_title')->nullable();
            $table->longText('bio')->nullable();
            $table->string('milestone1')->nullable();
            $table->string('milestone2')->nullable();
            $table->unsignedInteger('position')->default(999);
            $table->string('picture')->nullable();
            $table->timestamps();
        });

        Schema::create('leadership_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leadership_id')->constrained('about_leadership')->cascadeOnDelete();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('heading')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('news_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('news_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('news_categories')->nullOnDelete();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('author')->nullable();
            $table->string('wallpaper')->nullable();
            $table->longText('content')->nullable();
            $table->date('publish_date')->nullable();
            $table->string('status')->default('Draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_articles');
        Schema::dropIfExists('news_categories');
        Schema::dropIfExists('leadership_milestones');
        Schema::dropIfExists('about_leadership');
        Schema::dropIfExists('playlist_videos');
        Schema::dropIfExists('playlist_images');
        Schema::dropIfExists('playlists');
        Schema::dropIfExists('partner_logo');
        Schema::dropIfExists('image_gallery');
        Schema::dropIfExists('state_counter');
        Schema::dropIfExists('our_units');
        Schema::dropIfExists('video_banner');
        Schema::dropIfExists('key_offerings');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_categories');
    }
};
