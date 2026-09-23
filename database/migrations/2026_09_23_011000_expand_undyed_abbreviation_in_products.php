<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach (DB::table('products')->get() as $product) {
            $updates = [];

            foreach (['description', 'specs_subtext', 'technical_specs', 'main_capabilities'] as $field) {
                $value = $product->{$field} ?? null;
                if (! is_string($value) || $value === '') {
                    continue;
                }

                $expanded = preg_replace('/\bU\s*\/\s*D\b/iu', 'Undyed', $value);
                if ($expanded !== $value) {
                    $updates[$field] = $expanded;
                }
            }

            if ($updates !== []) {
                $updates['updated_at'] = now();
                DB::table('products')->where('id', $product->id)->update($updates);
            }
        }
    }

    public function down(): void
    {
        // The expanded textile term is intentionally retained.
    }
};
