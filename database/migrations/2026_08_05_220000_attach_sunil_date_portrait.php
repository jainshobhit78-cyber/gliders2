<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Attaches the official portrait of Shri Sunil Date to his Gliders India
     * Limited legacy entry. The image lives in shared upload storage, like any
     * photo added through the admin panel.
     */
    private const IMAGE = 'sunil_date_cmd.webp';

    public function up(): void
    {
        DB::table('legacy_leaders')
            ->where('type', 'gliders')
            ->where('name', 'like', '%Sunil Date%')
            ->update(['image' => self::IMAGE, 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('legacy_leaders')
            ->where('image', self::IMAGE)
            ->update(['image' => null, 'updated_at' => now()]);
    }
};
