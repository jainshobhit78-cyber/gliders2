@extends('backend.layout.app')

@section('content')
<style>
    .nav-tabs {
        border-bottom: 2px solid #e2e8f0 !important;
        margin-bottom: 30px !important;
        gap: 10px;
    }
    .nav-tabs .nav-link {
        font-weight: 600 !important;
        color: #64748b !important;
        border: none !important;
        padding: 12px 20px !important;
        border-bottom: 3px solid transparent !important;
        background: none !important;
        transition: all 0.2s ease !important;
        border-radius: 0 !important;
    }
    .nav-tabs .nav-link:hover {
        color: #13235b !important;
    }
    .nav-tabs .nav-link.active {
        color: #f5821f !important;
        border-bottom: 3px solid #f5821f !important;
    }
    .tab-pane {
        animation: fadeIn 0.25s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(4px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .settings-section-title {
        font-weight: 700;
        font-size: 1.15rem;
        color: #13235b;
        margin-bottom: 8px;
        display: block;
    }
    .form-group-wrapper {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 25px;
    }
</style>

<div class="about-section">
    <div class="title-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0 page-title">System Settings</h5>
    </div>

    <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-body">
                @include('_message')

                <!-- Settings Tab Menu -->
                <ul class="nav nav-tabs" id="settingsTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">
                            <i class="fa fa-cogs me-2"></i>General & Security
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="homepage-tab" data-bs-toggle="tab" data-bs-target="#homepage" type="button" role="tab" aria-controls="homepage" aria-selected="false">
                            <i class="fa fa-home me-2"></i>Homepage Customize
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="launch-tab" data-bs-toggle="tab" data-bs-target="#launch" type="button" role="tab" aria-controls="launch" aria-selected="false">
                            <i class="fa fa-flag me-2"></i>Launch Experience
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab" aria-controls="products" aria-selected="false">
                            <i class="fa fa-shopping-bag me-2"></i>Products Page
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="footer-tab" data-bs-toggle="tab" data-bs-target="#footer" type="button" role="tab" aria-controls="footer" aria-selected="false">
                            <i class="fa fa-info-circle me-2"></i>Footer Details
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab" aria-controls="social" aria-selected="false">
                            <i class="fa fa-share-alt me-2"></i>Social Media & Feeds
                        </button>
                    </li>
                </ul>

                <form method="POST" action="{{ route('admin.settings.update') }}" class="theme-form" enctype="multipart/form-data">
                    @csrf

                    <!-- Tab Contents -->
                    <div class="tab-content" id="settingsTabContent">
                        
                        <!-- TAB 1: GENERAL & SECURITY -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                            
                            <!-- Maintenance Settings -->
                            <div class="form-group-wrapper">
                                <span class="settings-section-title"><i class="fa fa-wrench me-2"></i>Maintenance Mode</span>
                                <small class="text-muted d-block mb-3">When active, public visitors will see an "Under Maintenance" holding screen. Admin users can access normally.</small>
                                
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="maintenance_mode" id="maintenance_mode" style="width: 40px; height: 20px; cursor: pointer;" {{ $setting->maintenance_mode ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2 align-middle" for="maintenance_mode" style="cursor: pointer; font-weight: 600;">
                                        Enable Maintenance Mode
                                    </label>
                                </div>

                                <div class="mt-3" id="maintenance_timer_wrapper" style="display: {{ $setting->maintenance_mode ? 'block' : 'none' }};">
                                    <label class="form-label">Maintenance Countdown Until (Optional)</label>
                                    <input type="datetime-local" name="maintenance_until" class="form-control" style="max-width: 300px;" value="{{ $setting->maintenance_until ? \Carbon\Carbon::parse($setting->maintenance_until)->format('Y-m-d\TH:i') : '' }}">
                                </div>
                            </div>

                            <!-- Election Mode -->
                            <div class="form-group-wrapper">
                                <span class="settings-section-title"><i class="fa fa-shield me-2"></i>Election Period Filter</span>
                                <small class="text-muted d-block mb-3">Filter politically sensitive items automatically from home page modules.</small>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="election_mode" id="election_mode" style="width: 40px; height: 20px; cursor: pointer;" {{ $setting->election_mode ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2 align-middle" for="election_mode" style="cursor: pointer; font-weight: 600;">
                                        Hide politically sensitive content
                                    </label>
                                </div>
                            </div>

                            <!-- Security Email & Whitelists -->
                            <div class="form-group-wrapper">
                                <span class="settings-section-title"><i class="fa fa-envelope me-2"></i>Security & Password Reset OTP</span>
                                <div class="mb-3">
                                    <label class="form-label">OTP Recipient Email</label>
                                    <input type="email" name="otp_recipient_email" class="form-control" placeholder="e.g. security-otp@glidersindia.in" value="{{ old('otp_recipient_email', $setting->otp_recipient_email) }}">
                                    <small class="text-muted d-block mt-1">If left blank, OTP emails default directly to the requesting administrator's email.</small>
                                </div>
                                
                                <div class="mt-4">
                                    <label class="form-label">IP Address Whitelisting</label>
                                    <textarea name="ip_whitelist" class="form-control" rows="2" placeholder="e.g. 127.0.0.1, 192.168.1.100">{{ old('ip_whitelist', $setting->ip_whitelist) }}</textarea>
                                    <small class="text-muted d-block mt-1">
                                        Enter comma-separated IP addresses that are allowed to access the CMS admin panel. Leave blank to disable filter. Your current IP is: <b>{{ request()->ip() }}</b>
                                    </small>
                                </div>
                            </div>

                            <!-- Google Analytics -->
                            <div class="form-group-wrapper">
                                <span class="settings-section-title"><i class="fa fa-bar-chart me-2"></i>Google Analytics Integration</span>
                                <label class="form-label">Google Analytics Measurement ID (GA4 Tag)</label>
                                <input type="text" name="google_analytics_id" class="form-control" style="max-width: 400px;" placeholder="e.g. G-XXXXXXXXXX" value="{{ old('google_analytics_id', $setting->google_analytics_id) }}">
                                <small class="text-muted d-block mt-1">Enter your GA4 Measurement ID (starting with "G-") to enable tracking live traffic.</small>
                            </div>

                        </div>

                        <!-- TAB 2: HOMEPAGE CUSTOMIZATION -->
                        <div class="tab-pane fade" id="homepage" role="tabpanel" aria-labelledby="homepage-tab">
                            
                            <div class="form-group-wrapper">
                                <span class="settings-section-title"><i class="fa fa-font me-2"></i>Homepage Headers & Fonts</span>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Products Heading Prefix</label>
                                        <input type="text" name="products_title_prefix" class="form-control" placeholder="e.g. Our" value="{{ old('products_title_prefix', $setting->products_title_prefix ?? 'Our') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Products Heading Suffix</label>
                                        <input type="text" name="products_title_suffix" class="form-control" placeholder="e.g. Products" value="{{ old('products_title_suffix', $setting->products_title_suffix ?? 'Products') }}">
                                    </div>
                                </div>

                                <div class="mb-3 mt-2">
                                    <label class="form-label">Products Subtitle Text</label>
                                    <textarea name="products_subtitle" class="form-control" rows="3" placeholder="Enter paragraph text beneath products heading...">{{ old('products_subtitle', $setting->products_subtitle ?? 'Advanced parachute systems and specialized aerial delivery equipment engineered for absolute precision, safety, and mission success.') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Solutions Typing Heading</label>
                                    <input type="text" name="solutions_title" class="form-control" placeholder="e.g. Parachute Solutions that Ensure" value="{{ old('solutions_title', $setting->solutions_title ?? 'Parachute Solutions that Ensure') }}">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Products Card Font Family</label>
                                        <select name="products_font_family" class="form-select">
                                            @php $pFont = $setting->products_font_family ?? 'Outfit'; @endphp
                                            <option value="Outfit" {{ $pFont == 'Outfit' ? 'selected' : '' }}>Outfit (Default Modern)</option>
                                            <option value="Inter" {{ $pFont == 'Inter' ? 'selected' : '' }}>Inter (Sleek Tech)</option>
                                            <option value="Kumbh Sans" {{ $pFont == 'Kumbh Sans' ? 'selected' : '' }}>Kumbh Sans</option>
                                            <option value="Roboto" {{ $pFont == 'Roboto' ? 'selected' : '' }}>Roboto</option>
                                            <option value="Montserrat" {{ $pFont == 'Montserrat' ? 'selected' : '' }}>Montserrat</option>
                                            <option value="Playfair Display" {{ $pFont == 'Playfair Display' ? 'selected' : '' }}>Playfair Display (Serif Elegance)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Headings Font Family</label>
                                        <select name="headings_font_family" class="form-select">
                                            @php $hFont = $setting->headings_font_family ?? 'Outfit'; @endphp
                                            <option value="Outfit" {{ $hFont == 'Outfit' ? 'selected' : '' }}>Outfit (Default Modern)</option>
                                            <option value="Inter" {{ $hFont == 'Inter' ? 'selected' : '' }}>Inter</option>
                                            <option value="Kumbh Sans" {{ $hFont == 'Kumbh Sans' ? 'selected' : '' }}>Kumbh Sans</option>
                                            <option value="Roboto" {{ $hFont == 'Roboto' ? 'selected' : '' }}>Roboto</option>
                                            <option value="Montserrat" {{ $hFont == 'Montserrat' ? 'selected' : '' }}>Montserrat</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Navigation Menu Font Size -->
                            <div class="form-group-wrapper">
                                <span class="settings-section-title"><i class="fa fa-text-height me-2"></i>Navigation Menu Font Size</span>
                                <small class="text-muted d-block mb-3">Adjust the font size of the top navigation menu items (HOME, ABOUT, PRODUCTS, etc.) to ensure all tabs fit on a single line.</small>

                                <div class="row align-items-center">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Menu Font Size: <strong id="navFontSizeValue">{{ old('nav_font_size', $setting->nav_font_size ?? '14') }}px</strong></label>
                                        <input type="range" class="form-range" name="nav_font_size" id="navFontSizeRange"
                                            min="10" max="20" step="0.5"
                                            value="{{ old('nav_font_size', $setting->nav_font_size ?? '14') }}"
                                            oninput="document.getElementById('navFontSizeValue').textContent = this.value + 'px';">
                                        <div class="d-flex justify-content-between text-muted" style="font-size: 12px;">
                                            <span>10px (Compact)</span>
                                            <span>14px (Default)</span>
                                            <span>20px (Large)</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Live Preview</label>
                                        <div class="border rounded p-3 bg-dark text-white d-flex flex-wrap gap-2" id="navFontPreview">
                                            <span>HOME</span><span>|</span>
                                            <span>ABOUT</span><span>|</span>
                                            <span>PRODUCTS</span><span>|</span>
                                            <span>NEWS</span><span>|</span>
                                            <span>RESOURCES</span><span>|</span>
                                            <span>CAREERS</span><span>|</span>
                                            <span>VENDORS</span>
                                        </div>
                                        <script>
                                            document.getElementById('navFontSizeRange').addEventListener('input', function() {
                                                document.getElementById('navFontPreview').style.fontSize = this.value + 'px';
                                            });
                                            document.getElementById('navFontPreview').style.fontSize = document.getElementById('navFontSizeRange').value + 'px';
                                        </script>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- TAB: INDEPENDENCE DAY LAUNCH EXPERIENCE -->
                        <div class="tab-pane fade" id="launch" role="tabpanel" aria-labelledby="launch-tab">
                            <div class="form-group-wrapper" style="background: linear-gradient(135deg, #fff8f1 0%, #ffffff 48%, #f2fbf5 100%); border-color: #f4c89f;">
                                <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-3">
                                    <div>
                                        <span class="settings-section-title"><i class="fa fa-flag me-2"></i>Independence Day Launch Experience</span>
                                        <small class="text-muted">Show an animated tricolour welcome, Gliders India branding and a live countdown before the homepage is revealed.</small>
                                    </div>
                                    <span class="badge {{ $setting->launch_animation_enabled ? 'bg-success' : 'bg-secondary' }} px-3 py-2">
                                        {{ $setting->launch_animation_enabled ? 'LIVE' : 'OFF' }}
                                    </span>
                                </div>

                                <div class="form-check form-switch mb-4">
                                    <input class="form-check-input" type="checkbox" name="launch_animation_enabled" id="launch_animation_enabled" style="width: 48px; height: 24px; cursor: pointer;" {{ old('launch_animation_enabled', $setting->launch_animation_enabled) ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2 align-middle" for="launch_animation_enabled" style="cursor: pointer; font-weight: 700; color: #13235b;">
                                        Start the launch experience on the homepage
                                    </label>
                                </div>

                                <div id="launch_experience_fields">
                                    <div class="alert alert-info py-2 mb-4" role="alert">
                                        Visitors see the experience once per browser session. It automatically reveals the website, and they can enter immediately using the button.
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Countdown Target <span class="text-muted">(India time)</span></label>
                                            <input type="datetime-local" name="launch_animation_target_at" class="form-control"
                                                value="{{ old('launch_animation_target_at', $setting->launch_animation_target_at ? $setting->launch_animation_target_at->copy()->setTimezone('Asia/Kolkata')->format('Y-m-d\TH:i') : '2026-08-15T00:00') }}">
                                            <small class="text-muted d-block mt-1">Recommended: 15 August 2026, 12:00 AM IST.</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Automatically Reveal Website After</label>
                                            <div class="input-group">
                                                <input type="number" min="10" max="30" name="launch_animation_auto_reveal_seconds" class="form-control"
                                                    value="{{ old('launch_animation_auto_reveal_seconds', max(10, (int) ($setting->launch_animation_auto_reveal_seconds ?? 10))) }}">
                                                <span class="input-group-text">seconds</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Main Celebration Heading</label>
                                        <input type="text" name="launch_animation_title" class="form-control" maxlength="120"
                                            value="{{ old('launch_animation_title', $setting->launch_animation_title ?? 'Happy Independence Day') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Celebration Message</label>
                                        <textarea name="launch_animation_message" class="form-control" rows="3" maxlength="300">{{ old('launch_animation_message', $setting->launch_animation_message ?? 'Honouring the spirit of freedom, courage and self-reliance.') }}</textarea>
                                    </div>

                                    <div class="row align-items-end">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Enter Button Text</label>
                                            <input type="text" name="launch_animation_button_text" class="form-control" maxlength="40"
                                                value="{{ old('launch_animation_button_text', $setting->launch_animation_button_text ?? 'Enter the Website') }}">
                                        </div>
                                        <div class="col-md-6 mb-3 text-md-end">
                                            <a href="{{ route('home', ['launch_preview' => 1]) }}" target="_blank" rel="noopener" class="btn btn-outline-primary px-4">
                                                <i class="fa fa-play me-2"></i>Preview Animation
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 3: PRODUCTS PAGE CUSTOMIZATION -->
                        <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
                            
                            <div class="form-group-wrapper">
                                <span class="settings-section-title"><i class="fa fa-shopping-bag me-2"></i>Products Page Header</span>
                                <small class="text-muted d-block mb-3">Customize details shown on the main <b>/products</b> listing template.</small>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Page Tagline (Top Badge)</label>
                                        <input type="text" name="products_page_tagline" class="form-control" placeholder="e.g. MISSION READY. ALWAYS." value="{{ old('products_page_tagline', $setting->products_page_tagline ?? 'MISSION READY. ALWAYS.') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Page Title</label>
                                        <input type="text" name="products_page_title" class="form-control" placeholder="e.g. Our Products" value="{{ old('products_page_title', $setting->products_page_title ?? 'Our Products') }}">
                                    </div>
                                </div>

                                <div class="mb-3 mt-2">
                                    <label class="form-label">Page Subtitle</label>
                                    <textarea name="products_page_subtitle" class="form-control" rows="3" placeholder="Enter description text...">{{ old('products_page_subtitle', $setting->products_page_subtitle ?? 'Engineered with precision. Trusted by the forces. Built for every mission and environment.') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Background Wallpaper Banner</label>
                                    <input type="file" name="products_page_wallpaper" class="form-control" accept="image/jpeg,image/png,image/webp">
                                    <small class="text-muted d-block mt-1">Upload a high-res wallpaper image (JPEG/PNG/WEBP, max 3 MB).</small>
                                    @if($setting->products_page_wallpaper)
                                        <div class="mt-3 p-2 border rounded d-inline-block" style="background: #ffffff; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
                                            <img src="{{ asset('frontend/images/' . $setting->products_page_wallpaper) }}" alt="Current Wallpaper" style="max-height: 110px; border-radius: 8px; display: block;">
                                            <small class="text-muted d-block mt-1 text-center">Current: {{ $setting->products_page_wallpaper }}</small>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <!-- TAB 4: FOOTER DETAILS -->
                        <div class="tab-pane fade" id="footer" role="tabpanel" aria-labelledby="footer-tab">
                            
                            <div class="form-group-wrapper">
                                <span class="settings-section-title"><i class="fa fa-info-circle me-2"></i>Dynamic Footer Customization</span>
                                
                                <div class="mb-3">
                                    <label class="form-label">Footer Description</label>
                                    <textarea name="footer_description" class="form-control" rows="2" placeholder="Enter description details...">{{ old('footer_description', $setting->footer_description) }}</textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Footer Office Address</label>
                                    <input type="text" name="footer_address" class="form-control" placeholder="e.g. Headquarters kanpur, Uttar pradesh" value="{{ old('footer_address', $setting->footer_address) }}">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Footer Phone Numbers</label>
                                        <input type="text" name="footer_phone" class="form-control" placeholder="e.g. +91 512 2984548" value="{{ old('footer_phone', $setting->footer_phone) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Footer Support Email</label>
                                        <input type="email" name="footer_email" class="form-control" placeholder="e.g. info@glidersindia.in" value="{{ old('footer_email', $setting->footer_email) }}">
                                    </div>
                                </div>
                                
                                <div class="mb-3 mt-2">
                                    <label class="form-label">Visitor Counter Offset Value</label>
                                    <input type="number" name="visitor_count" class="form-control" style="max-width: 250px;" placeholder="e.g. 1000" value="{{ old('visitor_count', $setting->visitor_count) }}">
                                    <small class="text-muted d-block mt-1">Sets the initial starting value for the public website hit counter.</small>
                                </div>
                            </div>

                        </div>

                        <!-- TAB 5: SOCIAL MEDIA & FEEDS -->
                        <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                            
                            <div class="form-group-wrapper">
                                <span class="settings-section-title"><i class="fa fa-share-alt me-2"></i>Social Media Handles & Links</span>
                                <small class="text-muted d-block mb-3">Provide the URLs to your official social media pages. These will update the links across the entire website footer and header.</small>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Facebook Page Link</label>
                                        <input type="text" name="social_facebook" class="form-control" placeholder="https://facebook.com/yourpage" value="{{ old('social_facebook', $setting->social_facebook) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Twitter / X Profile Link</label>
                                        <input type="text" name="social_twitter" class="form-control" placeholder="https://twitter.com/yourprofile" value="{{ old('social_twitter', $setting->social_twitter) }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Instagram Link</label>
                                        <input type="text" name="social_instagram" class="form-control" placeholder="https://instagram.com/yourprofile" value="{{ old('social_instagram', $setting->social_instagram) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">LinkedIn Company Page Link</label>
                                        <input type="text" name="social_linkedin" class="form-control" placeholder="https://linkedin.com/company/yourpage" value="{{ old('social_linkedin', $setting->social_linkedin) }}">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">YouTube Channel Link</label>
                                    <input type="text" name="social_youtube" class="form-control" placeholder="https://youtube.com/c/yourchannel" value="{{ old('social_youtube', $setting->social_youtube) }}">
                                </div>
                            </div>

                            <div class="form-group-wrapper">
                                <span class="settings-section-title"><i class="fa fa-twitter me-2"></i>Live Twitter/X Homepage Feed</span>
                                <small class="text-muted d-block mb-3">Provide the Twitter/X username or full profile URL to pull dynamic live posts directly onto the website homepage widget.</small>

                                <div class="mb-3">
                                    <label class="form-label">Twitter/X Username or Feed URL</label>
                                    <input type="text" name="twitter_feed_url" class="form-control" placeholder="e.g. GlidersIndia or https://twitter.com/GlidersIndia" value="{{ old('twitter_feed_url', $setting->twitter_feed_url) }}">
                                    <small class="text-muted d-block mt-1">If left blank, it will default to fetching feeds from the Twitter profile link provided above.</small>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Save Button -->
                    <div class="mt-4 border-top pt-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-theme px-4 py-2" style="font-weight: 600; border-radius: 8px;">Save Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const switchBtn = document.getElementById("maintenance_mode");
        const timerWrapper = document.getElementById("maintenance_timer_wrapper");
        if (switchBtn && timerWrapper) {
            switchBtn.addEventListener("change", function() {
                timerWrapper.style.display = this.checked ? "block" : "none";
            });
        }

        const launchSwitch = document.getElementById("launch_animation_enabled");
        const launchFields = document.getElementById("launch_experience_fields");
        if (launchSwitch && launchFields) {
            const updateLaunchFields = function() {
                launchFields.style.opacity = launchSwitch.checked ? "1" : "0.58";
            };
            launchSwitch.addEventListener("change", updateLaunchFields);
            updateLaunchFields();
        }
    });
</script>
@endsection
