<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Remove the redundant, empty "latest" news category (a duplicate of
     * "Latest Updates"). Only deletes categories named "latest" that have no
     * articles, so no article is ever orphaned.
     */
    public function up(): void
    {
        $ids = DB::table('news_categories')
            ->whereRaw('LOWER(TRIM(name)) = ?', ['latest'])
            ->pluck('id');

        foreach ($ids as $id) {
            $hasArticles = DB::table('news_articles')->where('category_id', $id)->exists();
            if (! $hasArticles) {
                DB::table('news_categories')->where('id', $id)->delete();
            }
        }
    }

    /**
     * No-op: we cannot reliably recreate a category we intentionally removed,
     * and doing so would just reintroduce the empty duplicate.
     */
    public function down(): void
    {
        //
    }
};
