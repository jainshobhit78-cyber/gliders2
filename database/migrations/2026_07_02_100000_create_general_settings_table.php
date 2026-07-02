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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('maintenance_mode')->default(false);
            $table->boolean('election_mode')->default(false);
            $table->text('ip_whitelist')->nullable();
            $table->timestamps();
        });

        // Insert default setting
        DB::table('general_settings')->insert([
            'maintenance_mode' => false,
            'election_mode' => false,
            'ip_whitelist' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Schema::table('playlists', function (Blueprint $table) {
            $table->string('status')->default('Pending')->after('description');
            $table->boolean('hide_during_election')->default(false)->after('status');
        });

        Schema::table('news_articles', function (Blueprint $table) {
            $table->boolean('hide_during_election')->default(false)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');

        Schema::table('playlists', function (Blueprint $table) {
            $table->dropColumn(['status', 'hide_during_election']);
        });

        Schema::table('news_articles', function (Blueprint $table) {
            $table->dropColumn('hide_during_election');
        });
    }
};
