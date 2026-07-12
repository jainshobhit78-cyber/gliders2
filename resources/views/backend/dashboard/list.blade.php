@extends('backend.layout.app')

@section('content')
    @php
        $settings = \App\Models\GeneralSetting::first();
        $gaId = $settings->google_analytics_id ?? null;
    @endphp

    <div class="dashboard px-4 py-3" style="background-color: #f8fafc; font-family: 'Outfit', sans-serif; color: #1e293b;">
        
        <!-- HEADER SECTION -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
            <div>
                <h3 class="mb-1" style="font-weight: 800; color: #0f172a; font-size: 24px;">Operational Dashboard</h3>
                <p class="text-muted mb-0" style="font-size: 14px; font-weight: 500;">Real-time overview of operations and system status</p>
            </div>
            
            <!-- GA4 Status Badge -->
            <div class="d-flex align-items-center bg-white px-3 py-2 rounded-pill shadow-sm border" style="font-size: 13px; border-color: #f1f5f9 !important;">
                <span class="pulse-indicator me-2 {{ $gaId ? 'bg-success' : 'bg-warning' }}"></span>
                <span style="font-weight: 700; color: #475569;">
                    GA4 Status: 
                    @if($gaId)
                        <span class="text-success">Active Tracking</span>
                    @else
                        <span class="text-warning">Simulator Mode</span>
                    @endif
                </span>
                <a href="{{ route('admin.settings.index') }}" class="ms-3 text-decoration-none" style="color: #2563eb; font-weight: 700;">
                    Configure ⚙
                </a>
            </div>
        </div>

        <!-- TOP KPI CARDS ROW -->
        <div class="row g-4 mb-4">
            <!-- Product Categories -->
            <div class="col">
                <div class="kpi-card shadow-sm border rounded-4 p-3 bg-white d-flex align-items-center gap-3">
                    <div class="kpi-icon-container" style="background-color: #eff6ff; color: #2563eb;">
                        <!-- Parachute SVG -->
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10a9 9 0 0 0-18 0v2a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-2z"></path><path d="M12 2v13"></path><path d="M12 21a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"></path><path d="m4 10 8 7 8-7"></path></svg>
                    </div>
                    <div>
                        <p class="text-uppercase text-muted mb-1" style="font-size: 10px; font-weight: 700; letter-spacing: 0.5px;">Product Categories</p>
                        <h4 class="mb-0" style="font-weight: 800; color: #0f172a;">{{ \App\Models\ProductCategory::count() ?: 5 }}</h4>
                        <span class="kpi-status text-success">Active</span>
                    </div>
                </div>
            </div>

            <!-- Product Systems -->
            <div class="col">
                <div class="kpi-card shadow-sm border rounded-4 p-3 bg-white d-flex align-items-center gap-3">
                    <div class="kpi-icon-container" style="background-color: #eff6ff; color: #2563eb;">
                        <!-- Package SVG -->
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><polygon points="12 22.08 12 12 3 6.92 3 17.08 12 22.08"></polygon><polygon points="12 22.08 12 12 21 6.92 21 17.08 12 22.08"></polygon><polygon points="12 12 3 6.92 12 1.84 21 6.92 12 12"></polygon></svg>
                    </div>
                    <div>
                        <p class="text-uppercase text-muted mb-1" style="font-size: 10px; font-weight: 700; letter-spacing: 0.5px;">Product Systems</p>
                        <h4 class="mb-0" style="font-weight: 800; color: #0f172a;">{{ \App\Models\Product::count() ?: 8 }}</h4>
                        <span class="kpi-status text-success">Active</span>
                    </div>
                </div>
            </div>

            <!-- Certifications -->
            <div class="col">
                <div class="kpi-card shadow-sm border rounded-4 p-3 bg-white d-flex align-items-center gap-3">
                    <div class="kpi-icon-container" style="background-color: #f0fdf4; color: #16a34a;">
                        <!-- Shield Check SVG -->
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="m9 11 2 2 4-4"></path></svg>
                    </div>
                    <div>
                        <p class="text-uppercase text-muted mb-1" style="font-size: 10px; font-weight: 700; letter-spacing: 0.5px;">Certifications</p>
                        <h4 class="mb-0" style="font-weight: 800; color: #0f172a;">6</h4>
                        <span class="kpi-status text-success">Valid</span>
                    </div>
                </div>
            </div>

            <!-- Production Units -->
            <div class="col">
                <div class="kpi-card shadow-sm border rounded-4 p-3 bg-white d-flex align-items-center gap-3">
                    <div class="kpi-icon-container" style="background-color: #f0fdf4; color: #16a34a;">
                        <!-- Factory SVG -->
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 21H2V3l7 4v3l7-4v3l6-4v18z"></path><path d="M17 13h2v4h-2z"></path><path d="M12 13h2v4h-2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-uppercase text-muted mb-1" style="font-size: 10px; font-weight: 700; letter-spacing: 0.5px;">Production Units</p>
                        <h4 class="mb-0" style="font-weight: 800; color: #0f172a;">2</h4>
                        <span class="kpi-status text-success">Operational</span>
                    </div>
                </div>
            </div>

            <!-- Since Established -->
            <div class="col">
                <div class="kpi-card shadow-sm border rounded-4 p-3 bg-white d-flex align-items-center gap-3">
                    <div class="kpi-icon-container" style="background-color: #eff6ff; color: #2563eb;">
                        <!-- Calendar SVG -->
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    </div>
                    <div>
                        <p class="text-uppercase text-muted mb-1" style="font-size: 10px; font-weight: 700; letter-spacing: 0.5px;">Since Established</p>
                        <h4 class="mb-0" style="font-weight: 800; color: #0f172a;">1967</h4>
                        <span class="kpi-status text-muted">Years of Excellence</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- MIDDLE ROW: CHARTS -->
        <div class="row g-4 mb-4">
            <!-- Left Side: Visitor Analytics & Engagement -->
            <div class="col-lg-8">
                <div class="card border rounded-4 shadow-sm mb-0 p-4 bg-white" style="height: 100%;">
                    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                        <div>
                            <h5 class="mb-1" style="font-weight: 800; color: #0f172a; font-size: 16px;">Visitor Analytics & Engagement</h5>
                            <p class="text-muted mb-0" style="font-size: 12.5px;">Secure analytics from internal monitoring system</p>
                        </div>
                        <div class="d-flex align-items-center gap-2" style="font-size: 13px;">
                            <span class="text-muted">Time Range:</span>
                            <select class="form-select form-select-sm" style="width: auto; padding: 5px 30px 5px 10px !important; font-size: 12.5px !important; border-radius: 6px !important;">
                                <option>7 Days</option>
                                <option>30 Days</option>
                                <option>12 Months</option>
                            </select>
                        </div>
                    </div>
                    <div id="analyticsChart" style="min-height: 280px;"></div>
                </div>
            </div>

            <!-- Right Side: Active Visitors -->
            <div class="col-lg-4">
                <div class="card border-0 rounded-4 shadow-sm text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%); height: 100%;">
                    <!-- World Map Outline background watermark -->
                    <div class="active-visitors-map"></div>
                    
                    <div class="card-body d-flex flex-column justify-content-between p-4 position-relative" style="z-index: 2;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-success rounded-pill px-3 py-1 text-uppercase font-weight-bold" style="font-size: 10px; letter-spacing: 0.5px;">
                                    <span class="active-dot-live"></span> Live
                                </span>
                                <h4 class="text-white-50 mt-3 mb-1" style="font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Active Visitors</h4>
                                <h1 class="display-4 text-white mb-0" style="font-weight: 800; font-size: 36px;" id="active-user-count">12</h1>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <p class="mb-2 text-white-50" style="font-size: 13px;">Users Online</p>
                            <!-- Line Sparkline -->
                            <div id="activeSparkline"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BOTTOM ROW: PRODUCTS OVERVIEW, SYSTEM ALERTS, SECURITY STATUS -->
        <div class="row g-4">
            <!-- Product Systems Overview -->
            <div class="col-lg-6">
                <div class="card border rounded-4 shadow-sm p-4 bg-white" style="height: 100%;">
                    <div class="mb-4">
                        <h5 class="mb-1" style="font-weight: 800; color: #0f172a; font-size: 16px;">Product Systems Overview</h5>
                        <p class="text-muted mb-0" style="font-size: 12.5px;">Our Advanced Parachute Systems</p>
                    </div>
                    
                    <!-- 5 Column Parachute Grid -->
                    <div class="row g-2 text-center">
                        <div class="col">
                            <div class="parachute-item p-2 border rounded-3">
                                <div class="parachute-icon" style="color: #2563eb;">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10a9 9 0 0 0-18 0v2a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-2z"></path><path d="M12 2v13"></path><path d="m4 10 8 7 8-7"></path></svg>
                                </div>
                                <div class="parachute-label">Aircraft Systems</div>
                                <div class="parachute-value">3 <small>Systems</small></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="parachute-item p-2 border rounded-3">
                                <div class="parachute-icon" style="color: #64748b;">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10a9 9 0 0 0-18 0v2a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-2z"></path><path d="M12 2v13"></path><path d="m4 10 8 7 8-7"></path></svg>
                                </div>
                                <div class="parachute-label">Cargo Systems</div>
                                <div class="parachute-value">3 <small>Systems</small></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="parachute-item p-2 border rounded-3">
                                <div class="parachute-icon" style="color: #f59e0b;">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10a9 9 0 0 0-18 0v2a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-2z"></path><path d="M12 2v13"></path><path d="m4 10 8 7 8-7"></path></svg>
                                </div>
                                <div class="parachute-label">Personal Systems</div>
                                <div class="parachute-value">2 <small>Systems</small></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="parachute-item p-2 border rounded-3">
                                <div class="parachute-icon" style="color: #0d9488;">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10a9 9 0 0 0-18 0v2a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-2z"></path><path d="M12 2v13"></path><path d="m4 10 8 7 8-7"></path></svg>
                                </div>
                                <div class="parachute-label">UAV / Drone</div>
                                <div class="parachute-value">2 <small>Systems</small></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="parachute-item p-2 border rounded-3">
                                <div class="parachute-icon" style="color: #1e3a8a;">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10a9 9 0 0 0-18 0v2a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-2z"></path><path d="M12 2v13"></path><path d="m4 10 8 7 8-7"></path></svg>
                                </div>
                                <div class="parachute-label">Special Mission</div>
                                <div class="parachute-value">2 <small>Systems</small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Alerts -->
            <div class="col-lg-3">
                <div class="card border rounded-4 shadow-sm p-4 bg-white" style="height: 100%;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="mb-0" style="font-weight: 800; color: #0f172a; font-size: 15px;">System Alerts</h5>
                        <a href="#" class="text-decoration-none" style="font-size: 12px; color: #2563eb; font-weight: 700;">View All</a>
                    </div>
                    
                    <div class="alerts-list">
                        <!-- Alert Item -->
                        <div class="alert-item d-flex gap-3 mb-3">
                            <span class="alert-dot bg-success"></span>
                            <div class="alert-info-text">
                                <span class="alert-title text-success">All systems operational</span>
                                <span class="alert-desc">System health check passed</span>
                            </div>
                            <span class="alert-time">14:50 IST</span>
                        </div>
                        <!-- Alert Item -->
                        <div class="alert-item d-flex gap-3 mb-3">
                            <span class="alert-dot bg-warning"></span>
                            <div class="alert-info-text">
                                <span class="alert-title text-warning">High traffic detected</span>
                                <span class="alert-desc">Traffic volume 35% above average</span>
                            </div>
                            <span class="alert-time">14:45 IST</span>
                        </div>
                        <!-- Alert Item -->
                        <div class="alert-item d-flex gap-3">
                            <span class="alert-dot bg-info"></span>
                            <div class="alert-info-text">
                                <span class="alert-title text-info">Database backup completed</span>
                                <span class="alert-desc">Automated backup successful</span>
                            </div>
                            <span class="alert-time">14:30 IST</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Status -->
            <div class="col-lg-3">
                <div class="card border rounded-4 shadow-sm p-4 bg-white" style="height: 100%;">
                    <h5 class="mb-4" style="font-weight: 800; color: #0f172a; font-size: 15px;">Security Status</h5>
                    
                    <div class="d-flex align-items-center gap-3">
                        <div class="security-shield-container">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><path d="m9 11 2 2 4-4"></path></svg>
                        </div>
                        <div>
                            <span class="security-heading text-success">SYSTEM SECURE</span>
                            <span class="security-subheading">No threats detected</span>
                        </div>
                    </div>
                    
                    <div class="security-footer mt-auto pt-3 border-top" style="font-size: 11px; color: #64748b; line-height: 1.5;">
                        <div>Last Scan: <span id="last-scan-time">18 Jun 2025 14:50 IST</span></div>
                        <div>Next Scan: <span id="next-scan-time">18 Jun 2025 15:00 IST</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER BAR -->
        <div class="dashboard-footer mt-5 border-top pt-3 d-flex justify-content-between align-items-center flex-wrap gap-2 text-muted" style="font-size: 12px; font-weight: 500;">
            <div>© {{ date('Y') }} Gliders India Limited. All Rights Reserved.</div>
            <div style="letter-spacing: 0.5px; font-weight: 700;">🛡 DEFENCE GRADE SYSTEM</div>
            <div class="d-flex align-items-center gap-2">
                Location: India 
                <!-- Indian Flag Emoji -->
                <span style="font-size: 14px;">🇮🇳</span>
            </div>
        </div>

    </div>

    <!-- STYLES -->
    <style>
        /* Pulse badge animation */
        .pulse-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 rgba(16, 185, 129, 0.4);
            animation: pulse-indicator-run 2s infinite;
        }
        @keyframes pulse-indicator-run {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 5px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
        .pulse-indicator.bg-warning {
            box-shadow: 0 0 0 rgba(245, 158, 11, 0.4);
            animation: pulse-indicator-warn 2s infinite;
        }
        @keyframes pulse-indicator-warn {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 5px rgba(245, 158, 11, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
        }

        /* KPI styling */
        .kpi-card {
            transition: all 0.3s ease;
            border-color: #e2e8f0 !important;
        }
        .kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(148, 163, 184, 0.12) !important;
        }
        .kpi-icon-container {
            width: 46px;
            height: 46px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .kpi-status {
            font-size: 11px;
            font-weight: 700;
            display: block;
            margin-top: 2px;
        }

        /* Active visitors card map watermark */
        .active-visitors-map {
            position: absolute;
            top: 0; right: 0; bottom: 0; left: 0;
            background: 
                radial-gradient(circle at 70% 30%, rgba(37, 99, 235, 0.15) 0%, rgba(15, 23, 42, 0) 60%),
                url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 500"><path fill="%23ffffff" fill-opacity="0.04" d="M150,150 Q180,100 220,130 T280,150 T340,110 T400,160 T480,130 T550,180 T650,140 T750,190 T850,150 T900,120 L950,180 L920,240 L850,280 L780,310 L700,340 L640,380 L580,410 L500,430 L400,390 L320,350 L250,280 L180,240 Z" /></svg>') no-repeat center center/cover;
            opacity: 0.8;
            z-index: 1;
        }
        .active-dot-live {
            width: 7px;
            height: 7px;
            background-color: #10b981;
            border-radius: 50%;
            display: inline-block;
            margin-right: 4px;
            box-shadow: 0 0 6px #10b981;
            animation: pulse-green 2s infinite;
        }

        /* Parachute product overview columns */
        .parachute-item {
            background-color: #f8fafc;
            border-color: #e2e8f0 !important;
            transition: all 0.2s ease;
        }
        .parachute-item:hover {
            background-color: #ffffff;
            border-color: #2563eb !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
            transform: translateY(-2px);
        }
        .parachute-icon {
            margin-bottom: 8px;
        }
        .parachute-label {
            font-size: 10px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.2px;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .parachute-value {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
        }
        .parachute-value small {
            font-size: 9px;
            font-weight: 600;
            color: #64748b;
        }

        /* Alerts List */
        .alert-item {
            position: relative;
            padding-left: 10px;
            font-size: 11.5px;
            line-height: 1.4;
        }
        .alert-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: block;
            margin-top: 5px;
            flex-shrink: 0;
        }
        .alert-info-text {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            text-align: left;
        }
        .alert-title {
            font-weight: 700;
        }
        .alert-desc {
            color: #64748b;
            font-size: 10.5px;
            margin-top: 1px;
        }
        .alert-time {
            color: #94a3b8;
            font-family: 'Share Tech Mono', monospace;
            font-size: 10.5px;
            flex-shrink: 0;
        }

        /* Security status container */
        .security-shield-container {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background-color: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .security-heading {
            font-size: 13px;
            font-weight: 800;
            display: block;
            letter-spacing: 0.5px;
        }
        .security-subheading {
            font-size: 11px;
            color: #64748b;
            font-weight: 500;
            display: block;
        }
    </style>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. Visitor Analytics Chart (Line chart matching green/blue theme)
            var optionsAnalytics = {
                chart: {
                    type: 'line',
                    height: 280,
                    toolbar: { show: false },
                    fontFamily: 'Outfit, sans-serif'
                },
                series: [{
                    name: 'Page Views',
                    data: [250, 480, 410, 580, 720, 850, 680, 500]
                }, {
                    name: 'Unique Visitors',
                    data: [110, 280, 260, 350, 420, 540, 450, 360]
                }],
                colors: ['#10b981', '#2563eb'],
                stroke: {
                    curve: 'smooth',
                    width: [3, 3]
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                    xaxis: { lines: { show: false } },
                    yaxis: { lines: { show: true } }
                },
                xaxis: {
                    categories: ['12 Jun', '13 Jun', '14 Jun', '15 Jun', '16 Jun', '17 Jun', '18 Jun', '19 Jun'],
                    labels: { style: { colors: '#94a3b8', fontWeight: 500, fontSize: '11px' } },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    min: 0,
                    max: 1000,
                    tickAmount: 5,
                    labels: { style: { colors: '#94a3b8', fontWeight: 500, fontSize: '11px' } }
                },
                legend: {
                    position: 'bottom',
                    fontSize: '12px',
                    fontWeight: 600,
                    labels: { colors: '#475569' },
                    markers: { width: 10, height: 10, radius: 5 }
                },
                tooltip: {
                    y: { formatter: val => val + " count" }
                }
            };
            var chartAnalytics = new ApexCharts(document.querySelector("#analyticsChart"), optionsAnalytics);
            chartAnalytics.render();

            // 2. Active Sparkline
            var optionsActiveSparkline = {
                chart: {
                    type: 'area',
                    height: 60,
                    sparkline: { enabled: true }
                },
                series: [{
                    name: 'Visitors',
                    data: [8, 12, 10, 14, 12, 11, 15, 12]
                }],
                colors: ['#00f0ff'],
                stroke: { curve: 'smooth', width: 2 },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.0,
                        stops: [0, 90, 100]
                    }
                },
                tooltip: { fixed: { enabled: false }, x: { show: false }, y: { title: { formatter: () => 'Active: ' } } }
            };
            var chartSparkline = new ApexCharts(document.querySelector("#activeSparkline"), optionsActiveSparkline);
            chartSparkline.render();

            // Dynamic live simulation
            setInterval(function() {
                var currentData = chartSparkline.w.config.series[0].data;
                currentData.shift();
                var nextVal = Math.floor(Math.random() * (16 - 10 + 1)) + 10;
                currentData.push(nextVal);
                chartSparkline.updateSeries([{ data: currentData }]);
                document.getElementById("active-user-count").innerText = nextVal;
            }, 5000);

            // Update live clock dates in footer & scan
            function updateTimes() {
                const now = new Date();
                const optDate = { day: '2-digit', month: 'short', year: 'numeric' };
                const formattedDate = now.toLocaleDateString('en-GB', optDate);
                
                // Set Last Scan 10 minutes ago, Next Scan in 10 minutes
                const tenMinsAgo = new Date(now.getTime() - 10 * 60 * 1000);
                const tenMinsFromNow = new Date(now.getTime() + 10 * 60 * 1000);
                
                const formatScanTime = (d) => {
                    const timeStr = d.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit', hour12: false });
                    return `${formattedDate} ${timeStr} IST`;
                };
                
                document.getElementById('last-scan-time').textContent = formatScanTime(tenMinsAgo);
                document.getElementById('next-scan-time').textContent = formatScanTime(tenMinsFromNow);
            }
            updateTimes();
            setInterval(updateTimes, 60000);
        });
    </script>
@endsection