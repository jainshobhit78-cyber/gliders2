<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $table = 'general_settings';

    protected $fillable = [
        'maintenance_mode',
        'maintenance_until',
        'election_mode',
        'ip_whitelist',
        'footer_description',
        'footer_address',
        'footer_phone',
        'footer_email',
        'visitor_count',
        'ticker_speed',
        'google_analytics_id',
        'products_title_prefix',
        'products_title_suffix',
        'products_subtitle',
        'solutions_title',
        'products_font_family',
        'headings_font_family',
    ];

    public static function isElectionMode()
    {
        $settings = self::first();
        return $settings ? (bool)$settings->election_mode : false;
    }

    public static function isMaintenanceMode()
    {
        $settings = self::first();
        return $settings ? (bool)$settings->maintenance_mode : false;
    }

    public static function getIpWhitelist()
    {
        $settings = self::first();
        if ($settings && $settings->ip_whitelist) {
            return array_map('trim', explode(',', $settings->ip_whitelist));
        }
        return [];
    }
}
