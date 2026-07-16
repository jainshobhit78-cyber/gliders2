<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SystemSettingsController extends Controller
{
    public function index()
    {
        $setting = GeneralSetting::firstOrCreate([]);
        return view('backend.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = GeneralSetting::firstOrCreate([]);

        $request->validate([
            'ip_whitelist' => 'nullable|string',
            'maintenance_until' => 'nullable|date',
            'otp_recipient_email' => 'nullable|email',
            'footer_description' => 'nullable|string',
            'footer_address' => 'nullable|string',
            'footer_phone' => 'nullable|string',
            'footer_email' => 'nullable|email',
            'visitor_count' => 'nullable|integer|min:0',
            'google_analytics_id' => 'nullable|string|max:40',
            'products_title_prefix' => 'nullable|string|max:255',
            'products_title_suffix' => 'nullable|string|max:255',
            'products_subtitle' => 'nullable|string',
            'solutions_title' => 'nullable|string',
            'products_font_family' => 'nullable|string|max:255',
            'headings_font_family' => 'nullable|string|max:255',
            'products_page_tagline' => 'nullable|string|max:255',
            'products_page_title' => 'nullable|string|max:255',
            'products_page_subtitle' => 'nullable|string',
            'products_page_wallpaper' => 'nullable|image|mimes:jpeg,png,jpg,webp',
            'social_facebook' => 'nullable|string|max:255',
            'social_twitter' => 'nullable|string|max:255',
            'social_instagram' => 'nullable|string|max:255',
            'social_linkedin' => 'nullable|string|max:255',
            'social_youtube' => 'nullable|string|max:255',
            'twitter_feed_url' => 'nullable|string|max:255',
            'launch_animation_target_at' => 'nullable|date_format:Y-m-d\TH:i',
            'launch_animation_title' => 'nullable|string|max:120',
            'launch_animation_message' => 'nullable|string|max:300',
            'launch_animation_button_text' => 'nullable|string|max:40',
            'launch_animation_auto_reveal_seconds' => 'nullable|integer|min:10|max:30',
        ]);

        $launchTargetAt = $request->filled('launch_animation_target_at')
            ? Carbon::createFromFormat('Y-m-d\TH:i', $request->launch_animation_target_at, 'Asia/Kolkata')->utc()
            : null;

        $data = [
            'maintenance_mode' => $request->has('maintenance_mode'),
            'maintenance_until' => $request->maintenance_until,
            'election_mode' => $request->has('election_mode'),
            'ip_whitelist' => $request->ip_whitelist,
            'otp_recipient_email' => $request->otp_recipient_email,
            'footer_description' => $request->footer_description,
            'footer_address' => $request->footer_address,
            'footer_phone' => $request->footer_phone,
            'footer_email' => $request->footer_email,
            'visitor_count' => $request->filled('visitor_count') ? $request->visitor_count : 1025,
            'google_analytics_id' => $request->google_analytics_id,
            'products_title_prefix' => $request->products_title_prefix,
            'products_title_suffix' => $request->products_title_suffix,
            'products_subtitle' => $request->products_subtitle,
            'solutions_title' => $request->solutions_title,
            'products_font_family' => $request->products_font_family,
            'headings_font_family' => $request->headings_font_family,
            'products_page_tagline' => $request->products_page_tagline,
            'products_page_title' => $request->products_page_title,
            'products_page_subtitle' => $request->products_page_subtitle,
            'social_facebook' => $request->social_facebook,
            'social_twitter' => $request->social_twitter,
            'social_instagram' => $request->social_instagram,
            'social_linkedin' => $request->social_linkedin,
            'social_youtube' => $request->social_youtube,
            'twitter_feed_url' => $request->twitter_feed_url,
            'launch_animation_enabled' => $request->has('launch_animation_enabled'),
            'launch_animation_target_at' => $launchTargetAt,
            'launch_animation_title' => $request->launch_animation_title ?: 'Happy Independence Day',
            'launch_animation_message' => $request->launch_animation_message ?: 'Honouring the spirit of freedom, courage and self-reliance.',
            'launch_animation_button_text' => $request->launch_animation_button_text ?: 'Enter the Website',
            'launch_animation_auto_reveal_seconds' => $request->launch_animation_auto_reveal_seconds ?: 10,
        ];

        if ($request->hasFile('products_page_wallpaper')) {
            $file = $request->file('products_page_wallpaper');
            $filename = 'products_bg_custom_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('frontend/images'), $filename);
            $data['products_page_wallpaper'] = $filename;
        }

        $setting->update($data);

        return back()->with('success', 'System settings updated successfully.');
    }
}
