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
        $allProducts = \App\Models\Product::orderBy('title', 'asc')->get();
        return view('backend.settings.index', compact('setting', 'allProducts'));
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
            'instagram_embed_code' => 'nullable|string|max:20000',
            'nav_font_size' => 'nullable|string|max:10',
            'main_menu_font_family' => 'nullable|string|max:255',
            'submenu_font_family' => 'nullable|string|max:255',
            'body_font_family' => 'nullable|string|max:255',
            'homepage_product_1' => 'nullable|integer|exists:products,id',
            'homepage_product_2' => 'nullable|integer|exists:products,id',
            'homepage_product_3' => 'nullable|integer|exists:products,id',
            'homepage_product_4' => 'nullable|integer|exists:products,id',
        ]);

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
            'main_menu_font_family' => $request->main_menu_font_family,
            'submenu_font_family' => $request->submenu_font_family,
            'body_font_family' => $request->body_font_family,
            'products_page_tagline' => $request->products_page_tagline,
            'products_page_title' => $request->products_page_title,
            'products_page_subtitle' => $request->products_page_subtitle,
            'social_facebook' => $request->social_facebook,
            'social_twitter' => $request->social_twitter,
            'social_instagram' => $request->social_instagram,
            'social_linkedin' => $request->social_linkedin,
            'social_youtube' => $request->social_youtube,
            'twitter_feed_url' => $request->twitter_feed_url,
            'instagram_embed_code' => $request->instagram_embed_code,
            'nav_font_size' => $request->nav_font_size ?: '14',
            'homepage_product_1' => $request->homepage_product_1,
            'homepage_product_2' => $request->homepage_product_2,
            'homepage_product_3' => $request->homepage_product_3,
            'homepage_product_4' => $request->homepage_product_4,
            'product_slider_auto' => $request->has('product_slider_auto'),
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

    public function updateLaunch(Request $request)
    {
        $validated = $request->validate([
            'launch_animation_target_at' => 'nullable|date_format:Y-m-d\TH:i',
            'launch_animation_auto_reveal_seconds' => 'required|integer|min:14|max:30',
            'launch_brand_title' => 'nullable|string|max:100',
            'launch_brand_subtitle' => 'nullable|string|max:140',
            'launch_intro_date_label' => 'nullable|string|max:80',
            'launch_intro_overline' => 'nullable|string|max:140',
            'launch_animation_title' => 'nullable|string|max:120',
            'launch_animation_message' => 'nullable|string|max:300',
            'launch_intro_whisper' => 'nullable|string|max:160',
            'launch_ribbon_overline' => 'nullable|string|max:120',
            'launch_ribbon_title' => 'nullable|string|max:120',
            'launch_ribbon_highlight' => 'nullable|string|max:80',
            'launch_ribbon_caption' => 'nullable|string|max:100',
            'launch_countdown_overline' => 'nullable|string|max:120',
            'launch_countdown_text_5' => 'nullable|string|max:140',
            'launch_countdown_text_4' => 'nullable|string|max:140',
            'launch_countdown_text_3' => 'nullable|string|max:140',
            'launch_countdown_text_2' => 'nullable|string|max:140',
            'launch_countdown_text_1' => 'nullable|string|max:140',
            'launch_finale_overline' => 'nullable|string|max:120',
            'launch_finale_title' => 'nullable|string|max:120',
            'launch_finale_subtitle' => 'nullable|string|max:160',
            'launch_finale_badge_text' => 'nullable|string|max:180',
            'launch_animation_button_text' => 'nullable|string|max:40',
        ]);

        $defaults = [
            'launch_brand_title' => 'Gliders India Limited',
            'launch_brand_subtitle' => 'A Government of India Enterprise',
            'launch_intro_overline' => 'Celebrating freedom. Building self-reliance.',
            'launch_animation_title' => 'Happy Independence Day',
            'launch_animation_message' => 'Honouring the spirit of freedom, courage and self-reliance.',
            'launch_intro_whisper' => 'A new digital chapter is ready to take flight',
            'launch_ribbon_overline' => 'With pride, we unveil',
            'launch_ribbon_title' => 'A New Era of',
            'launch_ribbon_highlight' => 'Innovation',
            'launch_ribbon_caption' => 'Gliders India Limited',
            'launch_countdown_overline' => 'The future takes flight in',
            'launch_countdown_text_5' => 'Five seconds to a new chapter',
            'launch_countdown_text_4' => 'Innovation moves forward',
            'launch_countdown_text_3' => 'Built on courage and capability',
            'launch_countdown_text_2' => 'Designed for a self-reliant India',
            'launch_countdown_text_1' => 'Ready for take-off',
            'launch_finale_overline' => 'Proudly presenting',
            'launch_finale_title' => 'Our New Digital Home',
            'launch_finale_subtitle' => 'Modern. Accessible. Mission ready.',
            'launch_finale_badge_text' => 'Welcome to the new Gliders India website',
            'launch_animation_button_text' => 'Enter the Website',
        ];

        $data = collect($defaults)->mapWithKeys(function ($default, $key) use ($request) {
            return [$key => $request->filled($key) ? trim((string) $request->input($key)) : $default];
        })->all();

        $data['launch_animation_enabled'] = $request->boolean('launch_animation_enabled');
        $data['launch_animation_show_skip_button'] = $request->boolean('launch_animation_show_skip_button');
        $data['launch_animation_fireworks_enabled'] = $request->boolean('launch_animation_fireworks_enabled');
        $data['launch_animation_confetti_enabled'] = $request->boolean('launch_animation_confetti_enabled');
        $data['launch_animation_auto_reveal_seconds'] = (int) $validated['launch_animation_auto_reveal_seconds'];
        $data['launch_intro_date_label'] = $request->filled('launch_intro_date_label')
            ? trim((string) $request->input('launch_intro_date_label'))
            : null;
        $data['launch_animation_target_at'] = $request->filled('launch_animation_target_at')
            ? Carbon::createFromFormat('Y-m-d\TH:i', $request->input('launch_animation_target_at'), 'Asia/Kolkata')->utc()
            : null;

        GeneralSetting::firstOrCreate([])->update($data);

        return redirect()->route('admin.settings.index', ['tab' => 'launch'])
            ->with('success', 'Launch experience updated successfully.');
    }
}
