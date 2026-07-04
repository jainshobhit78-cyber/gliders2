<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
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
        ]);

        $setting->update([
            'maintenance_mode' => $request->has('maintenance_mode'),
            'maintenance_until' => $request->maintenance_until,
            'election_mode' => $request->has('election_mode'),
            'ip_whitelist' => $request->ip_whitelist,
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
        ]);

        return back()->with('success', 'System settings updated successfully.');
    }
}
