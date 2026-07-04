@extends('backend.layout.app')

@section('content')
    @php
        $settings = \App\Models\GeneralSetting::first();
        $gaId = $settings->google_analytics_id ?? null;
    @endphp

    <div class="dashboard px-4 py-3" style="background-color: #f4f6f9; min-height: 100vh; font-family: 'Outfit', sans-serif;">
        
        <!-- HEADER AND STATUS SECTION -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
            <div>
                <h3 class="mb-1" style="font-weight: 800; color: #081d40;">Operational Dashboard</h3>
                <p class="text-muted mb-0" style="font-size: 14px;">Real-time visitor analytics and system status</p>
            </div>
            
            <!-- GA4 Status Badge -->
            <div class="d-flex align-items-center bg-white px-3 py-2 rounded-pill shadow-sm border" style="font-size: 13.5px;">
                <span class="pulse-indicator me-2 {{ $gaId ? 'bg-success' : 'bg-warning' }}"></span>
                <span style="font-weight: 600; color: #333;">
                    GA4 Status: 
                    @if($gaId)
                        <span class="text-success">Active Tracking ({{ $gaId }})</span>
                    @else
                        <span class="text-warning">Simulator Mode</span>
                    @endif
                </span>
                <a href="{{ route('admin.settings.index') }}" class="ms-3 text-decoration-none btn-settings-link" style="color: #f5821f; font-weight: 700;">
                    Configure <i class="bi bi-gear-fill"></i>
                </a>
            </div>
        </div>

        <!-- TOP KPI CARDS -->
        <div class="row g-4 mb-4">
            <!-- Messages KPI -->
            <div class="col-xl-3 col-sm-6">
                <div class="kpi-card shadow-sm border-0 rounded-4 p-4 bg-white d-flex align-items-center justify-content-between position-relative overflow-hidden">
                    <div>
                        <p class="text-uppercase text-muted mb-1" style="font-size: 12px; font-weight: 700; letter-spacing: 0.5px;">Emails & Messages</p>
                        <h3 class="mb-0" style="font-weight: 800; color: #081d40;">{{ \App\Models\ContactMessage::count() }}</h3>
                    </div>
                    <div class="kpi-icon-bg bg-primary-light">
                        <i class="bi bi-envelope-fill text-primary" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>

            <!-- Queries KPI -->
            <div class="col-xl-3 col-sm-6">
                <div class="kpi-card shadow-sm border-0 rounded-4 p-4 bg-white d-flex align-items-center justify-content-between position-relative overflow-hidden">
                    <div>
                        <p class="text-uppercase text-muted mb-1" style="font-size: 12px; font-weight: 700; letter-spacing: 0.5px;">Support Queries</p>
                        <h3 class="mb-0" style="font-weight: 800; color: #081d40;">{{ \App\Models\ChatbotFaq::count() }}</h3>
                    </div>
                    <div class="kpi-icon-bg bg-info-light">
                        <i class="bi bi-chat-left-text-fill text-info" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>

            <!-- Products KPI -->
            <div class="col-xl-3 col-sm-6">
                <div class="kpi-card shadow-sm border-0 rounded-4 p-4 bg-white d-flex align-items-center justify-content-between position-relative overflow-hidden">
                    <div>
                        <p class="text-uppercase text-muted mb-1" style="font-size: 12px; font-weight: 700; letter-spacing: 0.5px;">Products Listed</p>
                        <h3 class="mb-0" style="font-weight: 800; color: #081d40;">{{ \App\Models\Product::count() }}</h3>
                    </div>
                    <div class="kpi-icon-bg bg-success-light">
                        <i class="bi bi-box-seam-fill text-success" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>

            <!-- Monthly Visitors KPI -->
            <div class="col-xl-3 col-sm-6">
                <div class="kpi-card shadow-sm border-0 rounded-4 p-4 bg-white d-flex align-items-center justify-content-between position-relative overflow-hidden">
                    <div>
                        <p class="text-uppercase text-muted mb-1" style="font-size: 12px; font-weight: 700; letter-spacing: 0.5px;">Monthly Visitors</p>
                        <h3 class="mb-0" style="font-weight: 800; color: #081d40;">{{ $settings->visitor_count ?? 1025 }}</h3>
                    </div>
                    <div class="kpi-icon-bg bg-warning-light">
                        <i class="bi bi-people-fill text-warning" style="font-size: 24px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAIN CHARTS ROW -->
        <div class="row g-4 mb-4">
            <!-- Left Side: Sessions Overview & Heatmap -->
            <div class="col-lg-8">
                <!-- Sessions Overview Area Chart -->
                <div class="card border-0 rounded-4 shadow-sm mb-4 p-4 bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                        <div>
                            <h5 class="mb-1" style="font-weight: 800; color: #081d40;">Visitor Sessions & Pageviews</h5>
                            <p class="text-muted mb-0" style="font-size: 13px;">Daily tracking distribution history</p>
                        </div>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-secondary active">7 Days</button>
                            <button type="button" class="btn btn-outline-secondary">30 Days</button>
                            <button type="button" class="btn btn-outline-secondary">12 Months</button>
                        </div>
                    </div>
                    <div id="sessionsChart" style="min-height: 350px;"></div>
                </div>

                <!-- Geographic/Heatmap breakdown -->
                <div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
                    <div class="mb-4">
                        <h5 class="mb-1" style="font-weight: 800; color: #081d40;">Geographic Traffic Heatmap</h5>
                        <p class="text-muted mb-0" style="font-size: 13px;">Key operational markets and locations</p>
                    </div>
                    <div class="row g-4 align-items-center">
                        <div class="col-md-6">
                            <!-- Vector Heatmap Representation (Clean CSS/SVG) -->
                            <div class="heatmap-map-container p-3 rounded-4 border d-flex align-items-center justify-content-center" style="background-color: #fdfdfd; height: 260px;">
                                <!-- Standard World Outline Icon/SVG -->
                                <svg viewBox="0 0 1000 500" width="100%" height="100%" class="world-map-svg">
                                    <path fill="#e2e8f0" d="M150,150 Q180,100 220,130 T280,150 T340,110 T400,160 T480,130 T550,180 T650,140 T750,190 T850,150 T900,120 L950,180 L920,240 L850,280 L780,310 L700,340 L640,380 L580,410 L500,430 L400,390 L320,350 L250,280 L180,240 Z" />
                                    <!-- Glow points for Heatmap origins -->
                                    <circle cx="580" cy="220" r="14" class="heatmap-glow active-in" />
                                    <circle cx="280" cy="180" r="10" class="heatmap-glow" />
                                    <circle cx="680" cy="140" r="8" class="heatmap-glow" />
                                    <circle cx="750" cy="280" r="6" class="heatmap-glow" />
                                </svg>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="location-list">
                                <div class="location-item mb-3">
                                    <div class="d-flex justify-content-between mb-1" style="font-size: 13.5px; font-weight: 600;">
                                        <span><i class="bi bi-geo-alt-fill text-danger me-1"></i> India (Kanpur HQ / Delhi)</span>
                                        <span class="text-muted">64% (656 visits)</span>
                                    </div>
                                    <div class="progress rounded-pill" style="height: 6px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 64%" aria-valuenow="64" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="location-item mb-3">
                                    <div class="d-flex justify-content-between mb-1" style="font-size: 13.5px; font-weight: 600;">
                                        <span><i class="bi bi-geo-alt-fill text-primary me-1"></i> Germany</span>
                                        <span class="text-muted">14% (143 visits)</span>
                                    </div>
                                    <div class="progress rounded-pill" style="height: 6px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 14%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="location-item mb-3">
                                    <div class="d-flex justify-content-between mb-1" style="font-size: 13.5px; font-weight: 600;">
                                        <span><i class="bi bi-geo-alt-fill text-success me-1"></i> United States</span>
                                        <span class="text-muted">10% (102 visits)</span>
                                    </div>
                                    <div class="progress rounded-pill" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="location-item">
                                    <div class="d-flex justify-content-between mb-1" style="font-size: 13.5px; font-weight: 600;">
                                        <span><i class="bi bi-geo-alt-fill text-warning me-1"></i> United Kingdom</span>
                                        <span class="text-muted">6% (61 visits)</span>
                                    </div>
                                    <div class="progress rounded-pill" style="height: 6px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 6%" aria-valuenow="6" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Active Users, Channels, Devices -->
            <div class="col-lg-4">
                <!-- Real-Time Visitors Card -->
                <div class="card border-0 rounded-4 shadow-sm mb-4 p-4 text-white text-center position-relative overflow-hidden" style="background: linear-gradient(135deg, #0b2a5b 0%, #1e2a78 100%);">
                    <div class="live-pulse-ring"></div>
                    <div class="position-relative z-index-1">
                        <span class="badge bg-danger rounded-pill px-3 py-1 text-uppercase mb-2 font-weight-bold" style="font-size: 11px; letter-spacing: 1px;">
                            <span class="spinner-grow spinner-grow-sm me-1" role="status" aria-hidden="true" style="width: 9px; height: 9px;"></span> Live
                        </span>
                        <h4 class="text-white-50 mb-1" style="font-weight: 600;">Active Visitors</h4>
                        <h1 class="display-3 mb-2" style="font-weight: 800;">14</h1>
                        <p class="mb-3 text-white-50" style="font-size: 13.5px;">active users browsing site now</p>
                        
                        <!-- Real-time Sparkline -->
                        <div id="sparklineChart"></div>
                    </div>
                </div>

                <!-- Acquisition Channels Donut Chart -->
                <div class="card border-0 rounded-4 shadow-sm mb-4 p-4 bg-white">
                    <div class="mb-4">
                        <h5 class="mb-1" style="font-weight: 800; color: #081d40;">Traffic Acquisition</h5>
                        <p class="text-muted mb-0" style="font-size: 13px;">Top marketing channels and refers</p>
                    </div>
                    <div id="acquisitionChart" style="min-height: 250px;"></div>
                </div>

                <!-- Devices breakdown Donut Chart -->
                <div class="card border-0 rounded-4 shadow-sm p-4 bg-white">
                    <div class="mb-4">
                        <h5 class="mb-1" style="font-weight: 800; color: #081d40;">Devices Overview</h5>
                        <p class="text-muted mb-0" style="font-size: 13px;">Visitor technology distribution</p>
                    </div>
                    <div id="deviceChart" style="min-height: 230px;"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- STYLES -->
    <style>
        /* Pulse GA indicator */
        .pulse-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 rgba(0, 0, 0, 0.2);
            animation: pulse-badge 2s infinite;
        }
        @keyframes pulse-badge {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 6px rgba(40, 167, 69, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
            }
        }
        .pulse-indicator.bg-warning {
            animation: pulse-badge-warn 2s infinite;
        }
        @keyframes pulse-badge-warn {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 6px rgba(255, 193, 7, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(255, 193, 7, 0);
            }
        }

        /* KPI cards styling */
        .kpi-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .kpi-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
        }
        .kpi-icon-bg {
            width: 54px;
            height: 54px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .bg-primary-light { background-color: rgba(13, 110, 253, 0.1); }
        .bg-info-light { background-color: rgba(13, 202, 240, 0.1); }
        .bg-success-light { background-color: rgba(25, 135, 84, 0.1); }
        .bg-warning-light { background-color: rgba(255, 193, 7, 0.1); }

        /* Heatmap map container glowing animations */
        .world-map-svg {
            width: 100%;
            height: 100%;
        }
        .heatmap-glow {
            fill: #f5821f;
            fill-opacity: 0.8;
            stroke: #fff;
            stroke-width: 1.5;
            animation: bounce-glow 1.5s infinite alternate;
            transform-origin: center;
        }
        .heatmap-glow.active-in {
            fill: #dc3545;
            fill-opacity: 0.9;
            animation: bounce-glow-in 1.4s infinite alternate;
        }
        @keyframes bounce-glow {
            0% { r: 6px; fill-opacity: 0.6; }
            100% { r: 12px; fill-opacity: 0.9; }
        }
        @keyframes bounce-glow-in {
            0% { r: 8px; fill-opacity: 0.7; }
            100% { r: 16px; fill-opacity: 1; }
        }

        /* Live indicator pulse ring background */
        .live-pulse-ring {
            position: absolute;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
            top: -50px;
            right: -50px;
            animation: spin-pulse 8s linear infinite;
        }
        @keyframes spin-pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.15); }
            100% { transform: scale(1); }
        }

        .btn-settings-link {
            transition: opacity 0.2s;
        }
        .btn-settings-link:hover {
            opacity: 0.8;
        }
    </style>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. Session & Pageviews Area Chart
            var optionsSessions = {
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: { show: false },
                    fontFamily: 'Outfit, sans-serif'
                },
                series: [{
                    name: 'Sessions',
                    data: [142, 280, 245, 310, 480, 390, 520]
                }, {
                    name: 'Pageviews',
                    data: [350, 680, 540, 710, 1100, 940, 1250]
                }],
                colors: ['#0d6efd', '#198754'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.35,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 },
                xaxis: {
                    categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    labels: { style: { colors: '#777', fontWeight: 500 } }
                },
                yaxis: {
                    labels: { style: { colors: '#777', fontWeight: 500 } }
                },
                tooltip: { y: { formatter: val => val + " clicks" } },
                grid: { borderColor: '#e9ecef', strokeDashArray: 4 }
            };
            var chartSessions = new ApexCharts(document.querySelector("#sessionsChart"), optionsSessions);
            chartSessions.render();

            // 2. Sparkline Chart for Live active users
            var optionsSparkline = {
                chart: {
                    type: 'line',
                    height: 60,
                    sparkline: { enabled: true }
                },
                series: [{
                    data: [12, 14, 11, 15, 14, 13, 16, 12, 14]
                }],
                colors: ['#fff'],
                stroke: { curve: 'smooth', width: 2.5 },
                tooltip: { fixed: { enabled: false }, x: { show: false }, y: { title: { formatter: () => 'Visitors: ' } } }
            };
            var chartSparkline = new ApexCharts(document.querySelector("#sparklineChart"), optionsSparkline);
            chartSparkline.render();

            // Dynamic interval updates to simulate real-time live pulse
            setInterval(function() {
                var currentData = chartSparkline.w.config.series[0].data;
                currentData.shift();
                var nextVal = Math.floor(Math.random() * (17 - 10 + 1)) + 10;
                currentData.push(nextVal);
                chartSparkline.updateSeries([{ data: currentData }]);
                document.querySelector(".display-3").innerText = nextVal;
            }, 4000);

            // 3. Traffic Acquisition Donut Chart
            var optionsAcquisition = {
                chart: {
                    type: 'donut',
                    height: 250,
                    fontFamily: 'Outfit, sans-serif'
                },
                series: [45, 30, 15, 10],
                labels: ['Direct Traffic', 'Organic Search', 'Referral', 'Social Media'],
                colors: ['#0d6efd', '#20c997', '#ffc107', '#6f42c1'],
                dataLabels: { enabled: false },
                legend: { position: 'bottom', labels: { colors: '#555' } },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                            labels: {
                                show: true,
                                name: { show: true, fontSize: '14px', fontWeight: 600, color: '#6c757d' },
                                value: { show: true, fontSize: '20px', fontWeight: 800, color: '#081d40', formatter: val => val + "%" },
                                total: { show: true, label: 'Search', formatter: () => '30%' }
                            }
                        }
                    }
                }
            };
            var chartAcquisition = new ApexCharts(document.querySelector("#acquisitionChart"), optionsAcquisition);
            chartAcquisition.render();

            // 4. Devices Distribution Donut Chart
            var optionsDevice = {
                chart: {
                    type: 'donut',
                    height: 230,
                    fontFamily: 'Outfit, sans-serif'
                },
                series: [58, 36, 6],
                labels: ['Desktop', 'Mobile', 'Tablet'],
                colors: ['#081d40', '#f5821f', '#6c757d'],
                dataLabels: { enabled: false },
                legend: { position: 'bottom', labels: { colors: '#555' } },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                            labels: {
                                show: true,
                                name: { show: true, fontSize: '13px', fontWeight: 600, color: '#6c757d' },
                                value: { show: true, fontSize: '18px', fontWeight: 800, color: '#081d40', formatter: val => val + "%" },
                                total: { show: true, label: 'Mobile', formatter: () => '36%' }
                            }
                        }
                    }
                }
            };
            var chartDevice = new ApexCharts(document.querySelector("#deviceChart"), optionsDevice);
            chartDevice.render();
        });
    </script>
@endsection