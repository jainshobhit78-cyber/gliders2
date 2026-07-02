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

                <form method="POST" action="{{ route('admin.settings.update') }}" class="theme-form">
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
