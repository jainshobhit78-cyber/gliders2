@extends('backend.layout.app')

@section('content')
<div class="about-section">
    <div class="title-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0 page-title">System Settings</h5>
    </div>

    <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-body">
                @include('_message')

                <form method="POST" action="{{ route('admin.settings.update') }}" class="theme-form" enctype="multipart/form-data">
                    @csrf

                    <!-- Maintenance Mode -->
                    <div class="mb-4">
                        <label class="form-label-title" style="font-weight: 700;">Maintenance Mode</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="maintenance_mode" id="maintenance_mode" style="width: 40px; height: 20px; cursor: pointer;" {{ $setting->maintenance_mode ? 'checked' : '' }}>
                            <label class="form-check-label ms-2 align-middle" for="maintenance_mode" style="cursor: pointer;">
                                Enable Maintenance Mode
                            </label>
                        </div>
                        <small class="text-muted d-block mt-2">
                            When active, the public website will show an "Under Maintenance" page. Administrators will still be able to access the admin panel normally.
                        </small>

                        <div class="mt-3" id="maintenance_timer_wrapper" style="display: {{ $setting->maintenance_mode ? 'block' : 'none' }};">
                            <label class="form-label" style="font-weight: 600;">Maintenance Countdown Until (Optional)</label>
                            <input type="datetime-local" name="maintenance_until" class="form-control" style="max-width: 300px;" value="{{ $setting->maintenance_until ? \Carbon\Carbon::parse($setting->maintenance_until)->format('Y-m-d\TH:i') : '' }}">
                            <small class="text-muted d-block mt-1">Select the date and time when the website is expected to be back online.</small>
                        </div>
                    </div>

                    <!-- Election Mode -->
                    <div class="mb-4 mt-4">
                        <label class="form-label-title" style="font-weight: 700;">Election Period Filter</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="election_mode" id="election_mode" style="width: 40px; height: 20px; cursor: pointer;" {{ $setting->election_mode ? 'checked' : '' }}>
                            <label class="form-check-label ms-2 align-middle" for="election_mode" style="cursor: pointer;">
                                Hide politically sensitive content
                            </label>
                        </div>
                        <small class="text-muted d-block mt-2">
                            When active, any news or media post marked as "hide during election periods" will be hidden from public visitors on the website.
                        </small>
                    </div>

                    <!-- IP Whitelist -->
                    <div class="mb-4 mt-4">
                        <label class="form-label-title" style="font-weight: 700;">IP Address Whitelisting</label>
                        <textarea name="ip_whitelist" class="form-control mt-2" rows="3" placeholder="e.g. 127.0.0.1, 192.168.1.100">{{ old('ip_whitelist', $setting->ip_whitelist) }}</textarea>
                        <small class="text-muted d-block mt-2">
                            Enter comma-separated IP addresses that are allowed to access the CMS admin panel. <b>Leave blank to disable IP whitelisting</b> and allow all IPs. Your current IP is: <b>{{ request()->ip() }}</b>.
                        </small>
                    </div>

                    <!-- Dynamic Footer Settings -->
                    <div class="mb-4 mt-4 border-top pt-3">
                        <label class="form-label-title" style="font-weight: 700; font-size: 1.15rem; color: #13235b;">Dynamic Footer Settings</label>
                        
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 600;">Footer Description</label>
                            <textarea name="footer_description" class="form-control mt-1" rows="2" placeholder="Enter footer description text...">{{ old('footer_description', $setting->footer_description) }}</textarea>
                        </div>
                        
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 600;">Footer Address</label>
                            <input type="text" name="footer_address" class="form-control mt-1" placeholder="e.g. Headquarters kanpur, Uttar pradesh" value="{{ old('footer_address', $setting->footer_address) }}">
                        </div>
                        
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 600;">Footer Phone Numbers</label>
                            <input type="text" name="footer_phone" class="form-control mt-1" placeholder="e.g. Corporate: +91 512 2984548" value="{{ old('footer_phone', $setting->footer_phone) }}">
                        </div>
                        
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 600;">Footer Email</label>
                            <input type="email" name="footer_email" class="form-control mt-1" placeholder="e.g. support@glidersindia.in" value="{{ old('footer_email', $setting->footer_email) }}">
                        </div>
                        
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 600;">Visitor Counter Value</label>
                            <input type="number" name="visitor_count" class="form-control mt-1" style="max-width: 250px;" placeholder="e.g. 1025" value="{{ old('visitor_count', $setting->visitor_count) }}">
                            <small class="text-muted d-block mt-1">Directly overrides or initializes the website's live visitor count.</small>
                        </div>
                        
                        <div class="mt-4 border-top pt-3">
                            <label class="form-label-title" style="font-weight: 700; font-size: 1.15rem; color: #13235b; display: block; margin-bottom: 5px;">Google Analytics Integration</label>
                            <label class="form-label" style="font-weight: 600;">Google Analytics Measurement ID (GA4 Tag)</label>
                            <input type="text" name="google_analytics_id" class="form-control mt-1" style="max-width: 400px;" placeholder="e.g. G-XXXXXXXXXX" value="{{ old('google_analytics_id', $setting->google_analytics_id) }}">
                            <small class="text-muted d-block mt-1">
                                Enter your Google Analytics 4 Measurement ID (starting with "G-"). Once saved, the tracking tag will automatically run on the public pages.
                            </small>
                        </div>

                        <div class="mt-4 border-top pt-3">
                            <label class="form-label-title" style="font-weight: 700; font-size: 1.15rem; color: #13235b; display: block; margin-bottom: 5px;">Homepage Headings & Fonts Customization</label>
                            
                            <div class="row mt-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" style="font-weight: 600;">Products Heading Prefix (Blue/Black color)</label>
                                    <input type="text" name="products_title_prefix" class="form-control" placeholder="e.g. Our" value="{{ old('products_title_prefix', $setting->products_title_prefix ?? 'Our') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" style="font-weight: 600;">Products Heading Suffix (Orange color)</label>
                                    <input type="text" name="products_title_suffix" class="form-control" placeholder="e.g. Products" value="{{ old('products_title_suffix', $setting->products_title_suffix ?? 'Products') }}">
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label" style="font-weight: 600;">Products Subtitle text</label>
                                <textarea name="products_subtitle" class="form-control mt-1" rows="3" placeholder="Enter paragraph text beneath products heading...">{{ old('products_subtitle', $setting->products_subtitle ?? 'Advanced parachute systems and specialized aerial delivery equipment engineered for absolute precision, safety, and mission success.') }}</textarea>
                            </div>

                            <div class="mt-3">
                                <label class="form-label" style="font-weight: 600;">Solutions Typing Heading</label>
                                <input type="text" name="solutions_title" class="form-control mt-1" placeholder="e.g. Parachute Solutions that Ensure" value="{{ old('solutions_title', $setting->solutions_title ?? 'Parachute Solutions that Ensure') }}">
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" style="font-weight: 600;">Products Cards Title Font</label>
                                    <select name="products_font_family" class="form-control">
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
                                    <label class="form-label" style="font-weight: 600;">Headings Font Family</label>
                                    <select name="headings_font_family" class="form-control">
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
                    </div>

                    <!-- Products Landing Page Customization -->
                    <div class="mb-4 mt-4 border-top pt-3">
                        <label class="form-label-title" style="font-weight: 700; font-size: 1.15rem; color: #13235b; display: block; margin-bottom: 5px;">Products Landing Page Customization</label>
                        <small class="text-muted d-block mb-3">Customize the tagline, heading, subtitle text, and background wallpaper displayed on the <b>/products</b> category listing page.</small>

                        <div class="row mt-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600;">Page Tagline (Top Badge)</label>
                                <input type="text" name="products_page_tagline" class="form-control" placeholder="e.g. MISSION READY. ALWAYS." value="{{ old('products_page_tagline', $setting->products_page_tagline ?? 'MISSION READY. ALWAYS.') }}">
                                <small class="text-muted d-block mt-1">Small uppercase text shown above the main heading.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600;">Page Title</label>
                                <input type="text" name="products_page_title" class="form-control" placeholder="e.g. Our Products" value="{{ old('products_page_title', $setting->products_page_title ?? 'Our Products') }}">
                                <small class="text-muted d-block mt-1">Main heading displayed prominently on the page.</small>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 600;">Page Subtitle</label>
                            <textarea name="products_page_subtitle" class="form-control mt-1" rows="3" placeholder="Enter descriptive paragraph text...">{{ old('products_page_subtitle', $setting->products_page_subtitle ?? 'Engineered with precision. Trusted by the forces. Built for every mission and environment.') }}</textarea>
                            <small class="text-muted d-block mt-1">Descriptive text shown below the heading on the products page.</small>
                        </div>

                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 600;">Background Wallpaper</label>
                            <input type="file" name="products_page_wallpaper" class="form-control mt-1" accept="image/jpeg,image/png,image/webp">
                            <small class="text-muted d-block mt-1">Upload a high-resolution image (JPEG/PNG/WEBP, max 3 MB). A faded overlay will be applied automatically for readability.</small>
                            @if($setting->products_page_wallpaper)
                                <div class="mt-2 p-2 border rounded d-inline-block" style="background: #f8f9fa;">
                                    <img src="{{ asset('frontend/images/' . $setting->products_page_wallpaper) }}" alt="Current Wallpaper" style="max-height: 120px; border-radius: 8px; display: block;">
                                    <small class="text-muted d-block mt-1 text-center">Current: {{ $setting->products_page_wallpaper }}</small>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- OTP Settings -->
                    <div class="mb-4 mt-4 border-top pt-3">
                        <label class="form-label-title" style="font-weight: 700; font-size: 1.15rem; color: #13235b; display: block; margin-bottom: 5px;">Security & Password Reset OTP</label>
                        <small class="text-muted d-block mb-3">Specify the email address where all password reset OTP verification codes will be sent.</small>
                        
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 600;">OTP Recipient Email</label>
                            <input type="email" name="otp_recipient_email" class="form-control mt-1" placeholder="e.g. security-otp@glidersindia.in" value="{{ old('otp_recipient_email', $setting->otp_recipient_email) }}">
                            <small class="text-muted d-block mt-1">If left empty, OTPs will default to the standard user's email address requesting the reset.</small>
                        </div>
                    </div>

                    <div class="mt-4 border-top pt-3">
                        <button type="submit" class="btn btn-theme">Save Settings</button>
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
    });
</script>
@endsection
