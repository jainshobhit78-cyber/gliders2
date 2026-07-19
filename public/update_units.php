<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

$tables = ['products', 'news_articles', 'our_units', 'ticker_news'];
$units_replacements = [
    // 1. GSM replacement (case-insensitive)
    '/\b(gsm)\b/i' => 'gsm',
    
    // 2. m/s replacement (meter/sec, meters/sec, m/sec, m/secs, etc)
    '/\b(meters?|m)\/(sec|secs|seconds?)\b/i' => 'm/s',
    
    // 3. s replacement (only when preceded by a number, to avoid breaking words like "second")
    '/(\d+)\s*(secs|sec|seconds?)\b/i' => '$1 s',
    
    // 4. kg replacement
    '/\b(kgs?)\b/i' => 'kg',
    '/(\d+)\s*(kgs?)\b/i' => '$1 kg',
    
    // 5. kmph replacement
    '/\b(kmph)\b/i' => 'kmph',
];

echo "<pre>";
foreach ($tables as $table) {
    if (!Schema::hasTable($table)) {
        echo "Table $table does not exist. Skipping.\n";
        continue;
    }
    
    $columns = Schema::getColumnListing($table);
    $text_columns = [];
    foreach ($columns as $column) {
        $type = Schema::getColumnType($table, $column);
        if (in_array($type, ['string', 'text', 'mediumText', 'longText'])) {
            $text_columns[] = $column;
        }
    }
    
    if (empty($text_columns)) {
        continue;
    }
    
    echo "Processing table: $table (columns: " . implode(', ', $text_columns) . ")\n";
    
    $records = DB::table($table)->get();
    $updated_count = 0;
    
    foreach ($records as $record) {
        $primary_key = isset($record->id) ? 'id' : (isset($record->uuid) ? 'uuid' : null);
        if (!$primary_key) continue;
        
        $update_data = [];
        $changed = false;
        
        foreach ($text_columns as $column) {
            $original_value = $record->$column;
            if (empty($original_value)) continue;
            
            $new_value = $original_value;
            foreach ($units_replacements as $pattern => $replacement) {
                $new_value = preg_replace($pattern, $replacement, $new_value);
            }
            
            if ($new_value !== $original_value) {
                $update_data[$column] = $new_value;
                $changed = true;
            }
        }
        
        if ($changed) {
            DB::table($table)->where($primary_key, $record->$primary_key)->update($update_data);
            $updated_count++;
        }
    }
    
    echo "Updated $updated_count records in $table.\n\n";
}

echo "Done!\n";
