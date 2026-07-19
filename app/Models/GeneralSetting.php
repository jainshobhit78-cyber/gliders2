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
        'otp_recipient_email',
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
        'products_page_tagline',
        'products_page_title',
        'products_page_subtitle',
        'products_page_wallpaper',
        'social_facebook',
        'social_twitter',
        'social_instagram',
        'social_linkedin',
        'social_youtube',
        'twitter_feed_url',
        'instagram_embed_code',
        'launch_animation_enabled',
        'launch_animation_target_at',
        'launch_animation_title',
        'launch_animation_message',
        'launch_animation_button_text',
        'launch_animation_auto_reveal_seconds',
        'eoi_enabled',
        'nav_font_size',
        'main_menu_font_family',
        'submenu_font_family',
        'body_font_family',
        'homepage_product_1',
        'homepage_product_2',
        'homepage_product_3',
        'homepage_product_4',
        'product_slider_auto',
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean',
        'election_mode' => 'boolean',
        'launch_animation_enabled' => 'boolean',
        'launch_animation_target_at' => 'datetime',
        'launch_animation_auto_reveal_seconds' => 'integer',
        'eoi_enabled' => 'boolean',
        'product_slider_auto' => 'boolean',
    ];

    public static function isElectionMode()
    {
        try {
            $settings = self::first();
            return $settings ? (bool)$settings->election_mode : false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function isMaintenanceMode()
    {
        try {
            $settings = self::first();
            return $settings ? (bool)$settings->maintenance_mode : false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function getIpWhitelist()
    {
        try {
            $settings = self::first();
            if ($settings && $settings->ip_whitelist) {
                return array_map('trim', explode(',', $settings->ip_whitelist));
            }
        } catch (\Exception $e) {
            // Fail silently
        }
        return [];
    }
}
