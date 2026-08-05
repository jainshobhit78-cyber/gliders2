<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Attaches the official portrait of Shri B. L. Meena, the serving Chief
     * General Manager, to his OPF legacy entry.
     *
     * The image itself lives in shared upload storage
     * (public/uploads/category/bl_meena_cgm.webp) rather than in the repo,
     * the same as any photo uploaded through the admin panel.
     */
    private const IMAGE = 'bl_meena_cgm.webp';

    public function up(): void
    {
        DB::table('legacy_leaders')
            ->where('type', 'opf')
            ->where('name', 'like', '%Meena%')
            ->update(['image' => self::IMAGE, 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('legacy_leaders')
            ->where('type', 'opf')
            ->where('image', self::IMAGE)
            ->update(['image' => null, 'updated_at' => now()]);
    }
};
