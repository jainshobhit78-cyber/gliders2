@extends('backend.layout.app')

@section('content')
    @php
        // Fetch real count values from the database
        $productCategoriesCount = \App\Models\ProductCategory::count();
        $productSystemsCount = \App\Models\Product::count();
        $productionUnitsCount = \App\Models\AboutProductionUnit::count();
        $messagesCount = \App\Models\ContactMessage::count();
        $newsCount = \App\Models\NewsArticle::count();

        // Get dynamic category-wise product counts
        $categories = \App\Models\ProductCategory::withCount('products')->get();

        // Get real daily contact messages volume for the last 7 days
        $chartCategories = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartCategories[] = $date->format('d M');
            $count = \App\Models\ContactMessage::whereDate('created_at', $date->format('Y-m-d'))->count();
            $chartData[] = $count;
        }

        $settings = \App\Models\GeneralSetting::first();
        $gaId = $settings->google_analytics_id ?? null;
    @endphp

    <div class="dashboard px-4 py-3" style="background-color: #f8fafc; font-family: 'Outfit', sans-serif; color: #1e293b;">
        
        <!-- HEADER SECTION -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
            <div>
                <h3 class="mb-1" style="font-weight: 800; color: #0f172a; font-size: 24px;">Operational Dashboard</h3>
                <p class="text-muted mb-0" style="font-size: 14px; font-weight: 500;">Real-time overview of database records and system status</p>
            </div>
            
            <!-- GA4 Status Badge -->
            <div class="d-flex align-items-center bg-white px-3 py-2 rounded-pill shadow-sm border" style="font-size: 13px; border-color: #f1f5f9 !important;">
                <span class="pulse-indicator me-2 {{ $gaId ? 'bg-success' : 'bg-warning' }}"></span>
                <span style="font-weight: 700; color: #475569;">
                    GA4 Status: 
                    @if($gaId)
                        <span class="text-success">Active Tracking</span>
                    @else
                        <span class="text-warning">Inactive</span>
                    @endif
                </span>
                <a href="{{ route('admin.settings.index') }}" class="ms-3 text-decoration-none" style="color: #2563eb; font-weight: 700;">
                    Configure ⚙
                </a>
            </div>
        </div>

        <!-- REAL KPI CARDS ROW -->
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4 mb-4">
            <!-- Product Categories -->
            <div class="col">
                <div class="kpi-card shadow-sm border rounded-4 p-3 bg-white d-flex align-items-center gap-3">
                    <div class="kpi-icon-container" style="background-color: #eff6ff; color: #2563eb;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10a9 9 0 0 0-18 0v2a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-2z"></path><path d="M12 2v13"></path><path d="M12 21a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"></path><path d="m4 10 8 7 8-7"></path></svg>
                    </div>
                    <div>
                        <p class="text-uppercase text-muted mb-1" style="font-size: 10px; font-weight: 700; letter-spacing: 0.5px;">Categories</p>
                        <h4 class="mb-0" style="font-weight: 800; color: #0f172a;">{{ $productCategoriesCount }}</h4>
                        <span class="kpi-status text-success">Active Categories</span>
                    </div>
                </div>
            </div>

            <!-- Product Systems -->
            <div class="col">
                <div class="kpi-card shadow-sm border rounded-4 p-3 bg-white d-flex align-items-center gap-3">
                    <div class="kpi-icon-container" style="background-color: #eff6ff; color: #2563eb;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><polygon points="12 22.08 12 12 3 6.92 3 17.08 12 22.08"></polygon><polygon points="12 22.08 12 12 21 6.92 21 17.08 12 22.08"></polygon><polygon points="12 12 3 6.92 12 1.84 21 6.92 12 12"></polygon></svg>
                    </div>
                    <div>
                        <p class="text-uppercase text-muted mb-1" style="font-size: 10px; font-weight: 700; letter-spacing: 0.5px;">Products</p>
                        <h4 class="mb-0" style="font-weight: 800; color: #0f172a;">{{ $productSystemsCount }}</h4>
                        <span class="kpi-status text-success">Total Listed</span>
                    </div>
                </div>
            </div>

            <!-- Production Units -->
            <div class="col">
                <div class="kpi-card shadow-sm border rounded-4 p-3 bg-white d-flex align-items-center gap-3">
                    <div class="kpi-icon-container" style="background-color: #f0fdf4; color: #16a34a;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 21H2V3l7 4v3l7-4v3l6-4v18z"></path><path d="M17 13h2v4h-2z"></path><path d="M12 13h2v4h-2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-uppercase text-muted mb-1" style="font-size: 10px; font-weight: 700; letter-spacing: 0.5px;">Production Units</p>
                        <h4 class="mb-0" style="font-weight: 800; color: #0f172a;">{{ $productionUnitsCount }}</h4>
                        <span class="kpi-status text-success">Active Facilities</span>
                    </div>
                </div>
            </div>

            <!-- Inquiries -->
            <div class="col">
                <div class="kpi-card shadow-sm border rounded-4 p-3 bg-white d-flex align-items-center gap-3">
                    <div class="kpi-icon-container" style="background-color: #eff6ff; color: #2563eb;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    </div>
                    <div>
                        <p class="text-uppercase text-muted mb-1" style="font-size: 10px; font-weight: 700; letter-spacing: 0.5px;">Messages</p>
                        <h4 class="mb-0" style="font-weight: 800; color: #0f172a;">{{ $messagesCount }}</h4>
                        <span class="kpi-status text-success">Contact Inquiries</span>
                    </div>
                </div>
            </div>

            <!-- News Articles -->
            <div class="col">
                <div class="kpi-card shadow-sm border rounded-4 p-3 bg-white d-flex align-items-center gap-3">
                    <div class="kpi-icon-container" style="background-color: #f0fdf4; color: #16a34a;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><line x1="9" y1="9" x2="15" y2="9"></line><line x1="9" y1="13" x2="15" y2="13"></line><line x1="9" y1="17" x2="13" y2="17"></line></svg>
                    </div>
                    <div>
                        <p class="text-uppercase text-muted mb-1" style="font-size: 10px; font-weight: 700; letter-spacing: 0.5px;">News Articles</p>
                        <h4 class="mb-0" style="font-weight: 800; color: #0f172a;">{{ $newsCount }}</h4>
                        <span class="kpi-status text-success">Published Posts</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAIN CHART SECTION -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border rounded-4 shadow-sm p-4 bg-white">
                    <div class="mb-4 text-start">
                        <h5 class="mb-1" style="font-weight: 800; color: #0f172a; font-size: 16px;">Inquiry & Message Activity</h5>
                        <p class="text-muted mb-0" style="font-size: 12.5px;">Real-time contact form submissions over the last 7 days</p>
                    </div>
                    <div id="analyticsChart" style="min-height: 280px;"></div>
                </div>
            </div>
        </div>

        <!-- DYNAMIC PRODUCT SYSTEMS OVERVIEW -->
        <div class="row">
            <div class="col-12">
                <div class="card border rounded-4 shadow-sm p-4 bg-white">
                    <div class="mb-4 text-start">
                        <h5 class="mb-1" style="font-weight: 800; color: #0f172a; font-size: 16px;">Product Systems Overview</h5>
                        <p class="text-muted mb-0" style="font-size: 12.5px;">Active Parachute Categories & Products</p>
                    </div>
                    
                    <!-- Dynamic Product Category Grid -->
                    @if($categories->count() > 0)
                        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3 text-center">
                            @foreach($categories as $category)
                                <div class="col">
                                    <div class="parachute-item p-3 border rounded-3 d-flex flex-column align-items-center justify-content-between" style="height: 100%;">
                                        <div class="parachute-icon" style="color: #2563eb;">
                                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10a9 9 0 0 0-18 0v2a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-2z"></path><path d="M12 2v13"></path><path d="m4 10 8 7 8-7"></path></svg>
                                        </div>
                                        <div class="parachute-label" style="font-weight: 700; font-size: 12px; margin-top: 10px; color: #1e293b;">
                                            {{ $category->name }}
                                        </div>
                                        <div class="parachute-value" style="font-size: 18px; font-weight: 800; color: #2563eb; margin-top: 5px;">
                                            {{ $category->products_count }} <small style="font-size: 10px; color: #64748b; font-weight: 600;">Systems</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted" style="font-size: 14px;">
                            No active product categories found in database.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- FOOTER BAR -->
        <div class="dashboard-footer mt-5 border-top pt-3 d-flex justify-content-between align-items-center flex-wrap gap-2 text-muted" style="font-size: 12px; font-weight: 500;">
            <div>© {{ date('Y') }} Gliders India Limited. All Rights Reserved.</div>
            <div style="letter-spacing: 0.5px; font-weight: 700;">🛡 DEFENCE GRADE PORTAL</div>
            <div class="d-flex align-items-center gap-2">
                Location: India 
                <span style="font-size: 14px;">🇮🇳</span>
            </div>
        </div>

    </div>

    <!-- STYLES -->
    <style>
        /* Pulse indicator */
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
            height: 100%;
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
            flex-shrink: 0;
        }
        .kpi-status {
            font-size: 11px;
            font-weight: 700;
            display: block;
            margin-top: 2px;
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
    </style>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Real Database-driven Message submissions line chart
            var optionsAnalytics = {
                chart: {
                    type: 'area',
                    height: 280,
                    toolbar: { show: false },
                    fontFamily: 'Outfit, sans-serif'
                },
                series: [{
                    name: 'Received Inquiries',
                    data: {!! json_encode($chartData) !!}
                }],
                colors: ['#2563eb'],
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.25,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                    xaxis: { lines: { show: false } },
                    yaxis: { lines: { show: true } }
                },
                xaxis: {
                    categories: {!! json_encode($chartCategories) !!},
                    labels: { style: { colors: '#94a3b8', fontWeight: 500, fontSize: '11px' } },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    tickAmount: 4,
                    labels: { style: { colors: '#94a3b8', fontWeight: 500, fontSize: '11px' } }
                },
                legend: {
                    show: false
                },
                tooltip: {
                    y: { formatter: val => val + " inquiries" }
                }
            };
            var chartAnalytics = new ApexCharts(document.querySelector("#analyticsChart"), optionsAnalytics);
            chartAnalytics.render();
        });
    </script>
@endsection