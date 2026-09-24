<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('products', 'homepage_order')) {
            Schema::table('products', function (Blueprint $table): void {
                $table->unsignedSmallInteger('homepage_order')->nullable()->after('display_order');
                $table->index('homepage_order');
            });
        }

        $selectedIds = [];
        if (Schema::hasTable('general_settings')) {
            $settings = DB::table('general_settings')->first();
            if ($settings) {
                foreach (range(1, 4) as $position) {
                    $column = "homepage_product_{$position}";
                    $id = $settings->{$column} ?? null;
                    if ($id && ! in_array((int) $id, $selectedIds, true)) {
                        $selectedIds[] = (int) $id;
                    }
                }
            }
        }

        if ($selectedIds === []) {
            $selectedIds = DB::table('products')
                ->orderBy('display_order')
                ->orderBy('id')
                ->limit(4)
                ->pluck('id')
                ->map(fn ($id) => (int) $id)
                ->all();
        }

        foreach ($selectedIds as $index => $id) {
            DB::table('products')->where('id', $id)->update(['homepage_order' => $index + 1]);
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('products', 'homepage_order')) {
            Schema::table('products', function (Blueprint $table): void {
                $table->dropIndex(['homepage_order']);
                $table->dropColumn('homepage_order');
            });
        }
    }
};
