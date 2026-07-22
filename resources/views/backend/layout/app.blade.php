<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="pixelstrap">
    <!-- <link rel="icon" href="" type="image/x-icon"> -->
    <!-- <link rel="shortcut icon" href="" type="image/x-icon"> -->
    <title>{{ !empty($meta_title) ? $meta_title : '' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200&amp;family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet"> -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <!-- Linear Icon css -->
    <link rel="stylesheet" href="{{ url('backend/assets/css/linearicon.css') }}">

    <!-- fontawesome css -->
    <link rel="stylesheet" type="text/css" href="{{ url(path: 'backend/assets/css/vendors/font-awesome.css') }}">

    <!-- Themify icon css-->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/vendors/themify.css') }}">

    <!-- ratio css -->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/ratio.css') }}">

    <!-- Feather icon css-->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/vendors/feather-icon.css') }}">

    <!-- Plugins css -->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/vendors/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/vendors/animate.css') }}">

    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- vector map css -->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/vector-map.css') }}">

    <!-- slick slider css -->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/slick-theme.css') }}">

    <!-- App css -->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/style.css') }}">

    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/responsive.css') }}">
    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
        rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.min.css"
        rel="stylesheet">
    <script
        src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>


    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />


    <!-- Toster Start-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        .toast-top-right {
            right: 50%;
            transform: translateX(50%);
        }

        #toast-container>div {
            opacity: 1;
            border-radius: 10px;
            box-shadow: none;
        }

        #toast-container>div:hover {
            box-shadow: none;
        }

        .toast-close-button:hover {
            color: #fff;
        }

        /* --- Premium Aesthetic & Uncluttered Styling --- */
        body {
            font-family: 'Outfit', sans-serif !important;
            background-color: #f6f8fb !important;
        }
        
        .card {
            border: none !important;
            border-radius: 16px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03) !important;
            background-color: #ffffff !important;
            margin-bottom: 25px !important;
            transition: all 0.3s ease;
        }
        
        .card-body {
            padding: 30px !important;
        }
        
        /* Clean and Unclutter form controls */
        .form-control, .form-select {
            border-radius: 10px !important;
            border: 1px solid #e2e8f0 !important;
            padding: 11px 16px !important;
            font-size: 14.5px !important;
            color: #334155 !important;
            background-color: #ffffff !important;
            transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #f5821f !important;
            box-shadow: 0 0 0 4px rgba(245, 130, 31, 0.12) !important;
        }
        
        .form-label-title, label {
            font-weight: 600 !important;
            color: #1e293b !important;
            font-size: 14.5px !important;
            letter-spacing: 0.2px;
            display: inline-flex;
            align-items: center;
        }

        .btn {
            border-radius: 10px !important;
            padding: 10px 20px !important;
            font-weight: 600 !important;
            font-size: 14.5px !important;
            transition: all 0.2s ease !important;
        }
        
        /* Modern popover styling */
        .popover {
            font-family: 'Outfit', sans-serif !important;
            border-radius: 14px !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12) !important;
            background: #ffffff !important;
            max-width: 280px !important;
            z-index: 1060 !important;
        }
        .popover-header {
            background-color: #f8fafc !important;
            border-bottom: 1px solid #f1f5f9 !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            border-top-left-radius: 14px !important;
            border-top-right-radius: 14px !important;
            padding: 12px 16px !important;
            font-size: 14px !important;
        }
        .popover-body {
            color: #475569 !important;
            font-size: 13px !important;
            line-height: 1.6 !important;
            padding: 14px 16px !important;
        }
        
        /* Floating question mark helper icon */
        .helper-tooltip-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
            background: #f1f5f9;
            color: #64748b;
            border-radius: 50%;
            font-size: 11px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            margin-left: 6px;
            border: 1px solid #e2e8f0;
            user-select: none;
        }
        
        .helper-tooltip-btn:hover {
            background: #f5821f;
            color: #ffffff;
            border-color: #f5821f;
            transform: scale(1.15);
        }

        /* --- Premium Layout Desktop Theme Overrides --- */
        @media (min-width: 992px) {
            .page-wrapper.compact-wrapper .page-body-wrapper .sidebar-wrapper {
                background: #ffffff !important;
                border-right: 1px solid #eef2f6 !important;
                box-shadow: none !important;
                width: 270px !important;
                z-index: 99 !important;
                height: 100vh !important;
                position: fixed !important;
            }
            
            .logo-wrapper {
                padding: 25px !important;
                border-bottom: 1px solid #f1f5f9 !important;
            }
            
            .logo-wrapper img {
                height: 40px !important;
                width: auto !important;
                object-fit: contain !important;
            }
            
            .page-wrapper.compact-wrapper .page-body-wrapper .page-body {
                margin-left: 270px !important;
                background-color: #f8fafc !important;
                padding: 0 !important;
                display: flex;
                flex-direction: column;
                min-height: 100vh !important;
            }
            
            /* Styles for our custom Desktop Top Header */
            .desktop-header {
                height: 70px;
                background: #ffffff;
                border-bottom: 1px solid #eef2f6;
                padding: 0 35px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                position: sticky;
                top: 0;
                z-index: 90;
            }
            
            .secure-node-indicator {
                font-family: 'Outfit', sans-serif;
                font-size: 12.5px;
                font-weight: 700;
                color: #475569;
                display: flex;
                align-items: center;
                gap: 8px;
                background: #f1f5f9;
                padding: 6px 14px;
                border-radius: 99px;
            }
            
            .secure-dot {
                width: 7px;
                height: 7px;
                background-color: #10b981;
                border-radius: 50%;
                box-shadow: 0 0 6px #10b981;
                animation: pulse-green 2s infinite;
            }
            
            @keyframes pulse-green {
                0% { opacity: 0.4; }
                50% { opacity: 1; }
                100% { opacity: 0.4; }
            }
            
            .desktop-header-right {
                display: flex;
                align-items: center;
                gap: 25px;
            }
            
            .notification-btn {
                background: none;
                border: none;
                color: #64748b;
                position: relative;
                cursor: pointer;
                padding: 5px;
                transition: color 0.2s;
            }
            
            .notification-btn:hover {
                color: #0f172a;
            }
            
            .notification-badge {
                position: absolute;
                top: -5px;
                right: -5px;
                background: #ef4444;
                color: #ffffff;
                font-size: 8.5px;
                font-weight: 800;
                border-radius: 99px;
                padding: 2px 5px;
                line-height: 1;
                display: inline-block;
                min-width: 15px;
                text-align: center;
                box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4);
            }
            
            .profile-trigger {
                display: flex;
                align-items: center;
                gap: 12px;
                cursor: pointer;
                padding: 5px;
            }
            
            .profile-avatar {
                width: 36px;
                height: 36px;
                background: #eff6ff;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #2563eb;
            }
            
            .profile-info {
                display: flex;
                flex-direction: column;
                line-height: 1.2;
                text-align: left;
            }
            
            .profile-name {
                font-size: 13px;
                font-weight: 700;
                color: #1e293b;
            }
            
            .profile-role {
                font-size: 11px;
                color: #64748b;
            }
            
            .profile-chevron {
                color: #64748b;
                transition: transform 0.2s;
            }
            
            /* Sidebar navigation list styling */
            .sidebar-main {
                height: calc(100vh - 250px) !important;
                overflow-y: auto !important;
                padding-bottom: 20px !important;
            }
            
            .sidebar-main .sidebar-links {
                padding: 20px 0 !important;
            }
            
            .sidebar-main .sidebar-links .sidebar-list {
                margin: 2px 15px !important;
                padding: 0 !important;
            }
            
            .sidebar-main .sidebar-links .sidebar-link {
                color: #475569 !important;
                border-radius: 10px !important;
                padding: 11px 16px !important;
                transition: all 0.2s ease !important;
                font-weight: 600 !important;
                font-size: 13.5px !important;
                display: flex !important;
                align-items: center !important;
                gap: 12px !important;
                text-decoration: none !important;
                border: none !important;
                background: transparent !important;
            }
            
            .sidebar-main .sidebar-links .sidebar-link svg {
                width: 18px !important;
                height: 18px !important;
                fill: none !important;
                stroke: #64748b !important;
                stroke-width: 1.8 !important;
                stroke-linecap: round !important;
                stroke-linejoin: round !important;
                transition: all 0.2s ease !important;
            }
            
            .sidebar-main .sidebar-links .sidebar-link:hover {
                background: #f1f5f9 !important;
                color: #0f172a !important;
            }
            
            .sidebar-main .sidebar-links .sidebar-link:hover svg {
                stroke: #0f172a !important;
                transform: translateX(2px);
            }
            
            .sidebar-main .sidebar-links .sidebar-link.active {
                background: #2563eb !important;
                color: #ffffff !important;
                box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15) !important;
            }
            
            .sidebar-main .sidebar-links .sidebar-link.active svg {
                stroke: #ffffff !important;
            }
            
            /* Sidebar Submenu */
            .sidebar-submenu {
                padding-left: 30px !important;
                margin-top: 5px !important;
                margin-bottom: 10px !important;
            }
            
            .sidebar-submenu li a {
                color: #64748b !important;
                font-size: 13px !important;
                font-weight: 500 !important;
                padding: 8px 0 !important;
                display: block !important;
                text-decoration: none !important;
                transition: color 0.2s !important;
            }
            
            .sidebar-submenu li a:hover, .sidebar-submenu li a.active {
                color: #2563eb !important;
            }
            
            /* Sidebar Status Widget & Watermark styling */
            .sidebar-status-widget-container {
                position: absolute !important;
                bottom: 20px !important;
                left: 15px !important;
                right: 15px !important;
                border-radius: 12px !important;
                background: #f8fafc !important;
                border: 1px solid #e2e8f0 !important;
                padding: 14px !important;
                overflow: hidden !important;
                z-index: 10 !important;
            }
            
            .sidebar-faded-illustration {
                position: absolute !important;
                bottom: 0 !important;
                left: 0 !important;
                right: 0 !important;
                height: 100% !important;
                background: 
                    linear-gradient(to top, rgba(248, 250, 252, 0.98) 30%, rgba(248, 250, 252, 0.6) 100%),
                    url('{{ asset('uploads/products/1778848830_HEAVY DROP  P7.jpg') }}') no-repeat center center/cover !important;
                opacity: 0.12 !important;
                pointer-events: none !important;
                z-index: 1 !important;
            }
            
            .sidebar-status-card {
                position: relative !important;
                z-index: 2 !important;
            }
            
            .status-card-header {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                margin-bottom: 10px !important;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
                padding-bottom: 6px !important;
            }
            
            .status-title {
                font-family: 'Share Tech Mono', monospace !important;
                font-size: 10px !important;
                font-weight: 700 !important;
                color: #64748b !important;
                letter-spacing: 0.5px !important;
            }
            
            .status-badge {
                font-size: 8.5px !important;
                font-weight: 700 !important;
                color: #ffffff !important;
                background: #10b981 !important;
                padding: 1px 8px !important;
                border-radius: 99px !important;
            }

            .status-badge.status-badge-warning {
                background: #f59e0b !important;
            }
            
            .status-row {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                margin-bottom: 5px !important;
                font-size: 10.5px !important;
            }
            
            .row-label {
                color: #64748b !important;
                font-weight: 600 !important;
                display: flex !important;
                align-items: center !important;
                gap: 5px !important;
            }
            
            .row-icon {
                color: #94a3b8 !important;
            }
            
            .row-value {
                color: #334155 !important;
                font-weight: 700 !important;
            }

            .row-value.status-value-online {
                color: #059669 !important;
            }

            .row-value.status-value-warning {
                color: #d97706 !important;
            }

            .row-value.status-value-offline {
                color: #dc2626 !important;
            }
            
            #sidebar-last-deploy {
                font-family: 'Share Tech Mono', monospace !important;
                color: #2563eb !important;
            }
            
            /* General page layout overrides */
            .page-body {
                padding: 30px !important;
            }
            
            .title-header {
                margin-bottom: 25px !important;
                border-bottom: none !important;
                padding-bottom: 0 !important;
            }
            
            .title-header h5 {
                font-size: 20px !important;
                font-weight: 700 !important;
                color: #0f172a !important;
            }
        }
    </style>
</head>

<body>

    <div class="page-wrapper">

        {{-- Header --}}
        @include('backend.layout.header')

        <div class="page-body-wrapper">

            {{-- Sidebar --}}
            @include('backend.layout.sidebar')

            {{-- Page Content --}}
            <div class="page-body">

                <!-- Desktop top header bar -->
                <div class="desktop-header d-none d-lg-flex">
                    <div class="desktop-header-left">
                        <span class="secure-node-indicator">
                            <span class="secure-dot"></span>
                            SECURE NODE: GLD-89
                        </span>
                    </div>
                    <div class="desktop-header-right">
                        @php
                            $pendingInquiries = \App\Models\ContactMessage::where('status', 'pending')->count();
                            $pendingNews = \App\Models\NewsArticle::where('status', 'Pending')->count();
                            $pendingMedia = \App\Models\Playlist::where('status', 'Pending')->count();
                            $totalNotifications = $pendingInquiries + $pendingNews + $pendingMedia;
                        @endphp
                        <div class="header-notification-dropdown dropdown" style="position: relative;">
                            <button class="notification-btn" data-bs-toggle="dropdown" aria-expanded="false" style="background: none; border: none; padding: 5px; position: relative; color: #64748b; display: flex; align-items: center; justify-content: center;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                @if($totalNotifications > 0)
                                    <span class="notification-badge">{{ $totalNotifications }}</span>
                                @endif
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm py-2" style="min-width: 280px; border-radius: 12px; border-color: #f1f5f9;">
                                <li class="dropdown-header text-dark font-weight-bold text-start" style="font-size: 13px; border-bottom: 1px solid #f1f5f9; padding: 8px 16px; margin-bottom: 8px;">
                                    System Alerts
                                </li>
                                @if($totalNotifications > 0)
                                    @if($pendingInquiries > 0)
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center justify-content-between py-2 text-start" href="{{ route('admin.inquiry') }}">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span style="font-size: 15px;">✉</span>
                                                    <span style="font-size: 12.5px; font-weight: 500;">New Contact Inquiries</span>
                                                </div>
                                                <span class="badge bg-primary rounded-pill">{{ $pendingInquiries }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($pendingNews > 0)
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center justify-content-between py-2 text-start" href="{{ url('admin/approvals') }}">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span style="font-size: 15px;">📄</span>
                                                    <span style="font-size: 12.5px; font-weight: 500;">News Pending Approval</span>
                                                </div>
                                                <span class="badge bg-warning text-dark rounded-pill">{{ $pendingNews }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($pendingMedia > 0)
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center justify-content-between py-2 text-start" href="{{ url('admin/approvals') }}">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span style="font-size: 15px;">🎥</span>
                                                    <span style="font-size: 12.5px; font-weight: 500;">Media Pending Approval</span>
                                                </div>
                                                <span class="badge bg-warning text-dark rounded-pill">{{ $pendingMedia }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @else
                                    <li class="px-3 py-3 text-muted text-center" style="font-size: 12px; font-weight: 500;">
                                        No pending notifications
                                    </li>
                                @endif
                            </ul>
                        </div>
                        
                        <!-- User profile card -->
                        <div class="header-profile-dropdown dropdown">
                            <div class="profile-trigger" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="profile-avatar" style="overflow: hidden;">
                                    @php $adminUser = auth()->guard('admin')->user(); @endphp
                                    @if($adminUser && !empty($adminUser->profile_photo) && file_exists(public_path('uploads/profile/' . $adminUser->profile_photo)))
                                        <img src="{{ asset('uploads/profile/' . $adminUser->profile_photo) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                    @endif
                                </div>
                                <div class="profile-info">
                                    <span class="profile-name">{{ auth()->guard('admin')->user()->name ?? 'Administrator' }}</span>
                                    <span class="profile-role">Super Admin</span>
                                </div>
                                <svg class="profile-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </div>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                <li>
                                    <a class="dropdown-item" href="{{ url('admin/profile') }}">
                                        <svg class="dropdown-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        Profile
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); if(confirm('Are you sure you want to logout?')) { document.getElementById('logout-form').submit(); }">
                                        <svg class="dropdown-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                @yield('content')


            </div>

        </div>

    </div>




    <!-- latest js -->
    <script src="{{ url('backend/assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Toster Start-->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->

    <script src="{{ url('backend/assets/tinymce/tinymce.min.js') }}"></script>
    <!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script
        src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js"></script>
    <script
        src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
    <script
        src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>

    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            newestOnTop: true,
            preventDuplicates: true,

            showMethod: "fadeIn",
            hideMethod: "fadeOut",

            timeOut: 3000,
            extendedTimeOut: 1000,
            positionClass: "toast-top-right",
            showDuration: 300,
            hideDuration: 300
        };



    </script>

    @include('_message')


    <!-- Bootstrap js -->
    <script src="{{ url('backend/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>

    <!-- feather icon js -->
    <script src="{{ url('backend/assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ url('backend/assets/js/icons/feather-icon/feather-icon.js') }}"></script>

    <!-- scrollbar simplebar js -->
    <!-- <script src="{{ url('backend/assets/js/scrollbar/simplebar.js') }}"></script> -->
    <script src="{{ url('backend/assets/js/scrollbar/custom.js') }}"></script>

    <!-- Sidebar jquery -->
    <script src="{{ url('backend/assets/js/config.js') }}"></script>

    <!-- tooltip init js -->
    <script src="{{ url('backend/assets/js/tooltip-init.js') }}"></script>

    <!-- Plugins JS -->
    <!-- <script src="{{ url('backend/assets/js/sidebar-menu.js') }}"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>



    <script src="{{ url('backend/assets/js/notify/bootstrap-notify.min.js') }}"></script>


    <!-- Apexchar js -->
    <script src="{{ url('backend/assets/js/chart/apex-chart/apex-chart1.js') }}"></script>
    <script src="{{ url('backend/assets/js/chart/apex-chart/moment.min.js') }}"></script>
    <script src="{{ url('backend/assets/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{ url('backend/assets/js/chart/apex-chart/stock-prices.js') }}"></script>
    <script src="{{ url('backend/assets/js/chart/apex-chart/chart-custom1.js') }}"></script>


    <!-- customizer js -->
    <script src="{{ url('backend/assets/js/customizer.js') }}"></script>



    <!-- customizer js -->

    <!-- ratio js -->
    <script src="{{ url('backend/assets/js/ratio.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Theme js -->
    <script src="{{ url('backend/assets/js/script.js') }}"></script>

    @yield('script')
    <script type="text/javascript">

    </script>

    <script>
        $(document).ready(function () {
            const sidebar = $('.sidebar-wrapper');

            $('#mobileSidebarToggle').on("click", function () {
                $('.sidebar-wrapper').toggleClass('open');
                $('body').toggleClass('sidebar-open');
                $('.sidebar-overlay').toggleClass('show');
            });

            $('.sidebar-overlay').on("click", function () {
                $('.sidebar-wrapper').removeClass('open');
                $('body').removeClass('sidebar-open');
                $(this).removeClass('show');
            });





            $(window).on('resize', function () {
                if ($(window).width() > 991) {
                    sidebar.removeClass('open');
                    $('body').removeClass('sidebar-open');
                }
            });
        });


    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const dropdownLinks = document.querySelectorAll(".sidebar-link.has-sub");
            const submenus = document.querySelectorAll(".sidebar-submenu");

            function slideToggle(element, show) {
                element.style.overflow = "hidden";
                element.style.transition = "height 0.3s ease";

                if (show) {
                    element.classList.add("open");
                    const height = element.scrollHeight + "px";
                    element.style.height = "0px";
                    setTimeout(() => { element.style.height = height; }, 10);
                    setTimeout(() => { element.style.height = "auto"; element.style.overflow = "visible"; }, 300);
                } else {
                    const height = element.scrollHeight + "px";
                    element.style.height = height;
                    setTimeout(() => { element.style.height = "0px"; }, 10);
                    setTimeout(() => { element.classList.remove("open"); element.style.overflow = "visible"; }, 300);
                }
            }

            dropdownLinks.forEach(link => {
                link.addEventListener("click", function (e) {
                    e.preventDefault();
                    const parent = link.closest(".sidebar-list");
                    const submenu = parent.querySelector(".sidebar-submenu");
                    if (!submenu) return;

                    const isOpen = submenu.classList.contains("open");

                    submenus.forEach(menu => {
                        if (menu !== submenu && menu.classList.contains("open")) {
                            slideToggle(menu, false);
                            menu.previousElementSibling?.classList.remove("open");
                        }
                    });

                    slideToggle(submenu, !isOpen);
                    link.classList.toggle("open", !isOpen);
                });
            });

            // Auto-open active submenu
            document.querySelectorAll(".sidebar-submenu .active").forEach(a => {
                const submenu = a.closest(".sidebar-submenu");
                submenu.classList.add("open");
                submenu.style.height = "auto";
                submenu.previousElementSibling?.classList.add("open");
            });

        });
    </script>



    <!-- <script>
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            const sidebar = document.querySelector('.sidebar-wrapper');
            const page = document.querySelector('.page-body-wrapper');
            const icon = this.querySelector('i');

            sidebar.classList.toggle('sidebar-collapsed');
            page.classList.toggle('sidebar-collapsed');

            // Rotate arrow
            icon.classList.toggle('fa-angle-left');
            icon.classList.toggle('fa-angle-right');
        });
    </script> -->


    <script>
        $(document).ready(function () {
            $(document).on('submit', '.js-delete-form', function (event) {
                const isSuperAdmin = {{ auth()->guard('admin')->user()->hasRole('admin') ? 'true' : 'false' }};

                if (!isSuperAdmin) {
                    event.preventDefault();
                    alert('Action Denied: Sub-admins are not authorized to delete records. This action is restricted to Super Admins only.');
                    return;
                }

                const message = this.dataset.confirm || 'Delete this record? This action cannot be undone.';
                if (!confirm(message)) {
                    event.preventDefault();
                }
            });

            const sidebar = document.querySelector('.sidebar-wrapper');
            const page = document.querySelector('.page-body-wrapper');
            const toggleBtn = document.getElementById('sidebarToggle');

            function setCollapsed(collapsed) {
                sidebar.classList.toggle('sidebar-collapsed', collapsed);
                page.classList.toggle('sidebar-collapsed', collapsed);
            }

            /* -----------------------------
               ✅ DEFAULT = OPEN
            ----------------------------- */
            const savedMode = localStorage.getItem('sidebarMode');

            if (savedMode === 'collapsed') {
                setCollapsed(true);
            } else {
                setCollapsed(false); // 👈 open by default
            }

            /* -----------------------------
               Toggle button
            ----------------------------- */
            toggleBtn.addEventListener('click', function () {

                const isCollapsed = sidebar.classList.contains('sidebar-collapsed');

                if (isCollapsed) {
                    localStorage.setItem('sidebarMode', 'open');
                    setCollapsed(false);
                } else {
                    localStorage.setItem('sidebarMode', 'collapsed');
                    setCollapsed(true);
                }

            });

            // 1. Tooltip Dictionary for Admin Fields
            const fieldTooltips = {
                // Leadership
                'role': 'Enter the primary administrative designation of the employee or officer (e.g. Chairman & Managing Director).',
                'sub_title': 'Secondary title or additional department description under the main role.',
                'leader_name': 'Provide the full name of the leader (e.g. Shri ...).',
                'bio': 'A short professional biography highlighting the leader\'s background, achievements, and credentials.',
                'position': 'Display priority sorting number. Enter <strong>1</strong> to prioritize this leader as the primary focus (CMD).',
                'picture': 'Select a professional photo. Recommended formats: JPEG, PNG, WEBP.',
                'profile_photo': 'Select a professional portrait image for the directory entry.',
                
                // Products
                'wallpaper': 'The main banner image displayed at the top of the details page.',
                'specs_image': 'Upload the technical specifications drawing or chart image for this product.',
                'caps_image': 'Upload the capability, testing, or performance data sheet image.',
                'filepond': 'Select and upload multiple gallery images for the showcase slider.',
                'delivery_tag': 'Status badge text displayed on the product card (e.g. \'In Stock\', \'Made to Order\').',
                
                // News
                'title': 'Enter the main heading or title for this entry.',
                'category_id': 'Select the category under which this record should be listed.',
                'content': 'Provide the detailed text content for this page. Rich formatting is supported.',
                'publish_date': 'Choose the date when this content is officially marked as published.',
                'status': 'Set to Active to show on the live website, or Pending to save as a draft.',
                'hide_during_election': 'Check this box to temporarily hide the record from public view during official election periods.',
                
                // Directory
                'sr_no': 'Display sorting number (lower numbers appear first on the list).',
                'org': 'The department, division, or unit name (e.g. OPF, GCF).',
                'designation': 'Official work designation or job title.',
                'sub_designation': 'Detailed department or field of duty designation.',
                'deals_in': 'Enter products or subjects handled by this division.',
                'telephone_number': 'Direct office landline telephone number.',
                'fax': 'Office fax number.',
                'email': 'Office email address.',
                'mobile_no': 'Mobile phone number.',
                'mobiles': 'Add one or more mobile contact numbers.',
                'emails': 'Add one or more email addresses for direct contact.',
                
                // General settings
                'ip_whitelist': 'Comma-separated list of IP addresses allowed to bypass the site maintenance screen.',
                'maintenance_until': 'The date and time until which maintenance mode remains active.',
                'google_analytics_id': 'Google Analytics 4 Measurement ID (e.g., G-XXXXXX).',
                'products_title_prefix': 'Text prefix displayed before product titles in the store grid.',
                'products_title_suffix': 'Text suffix displayed after product titles in the store grid.',
                'products_subtitle': 'Subtitle text shown on the products page header.',
                'headings_font_family': 'Choose the font typeface used for titles and headings.',
                'products_font_family': 'Choose the font typeface used for product listings.',
                'visitor_count': 'Initial visitor count offset shown on the homepage counter.',
                'ticker_speed': 'Scrolling speed of the home announcement marquee in seconds (lower is faster, e.g. 20s).',
                
                // Vigilance & RTI
                'pdf': 'Upload the official PDF document (max size 10MB).',
                'info_text': 'Explanatory information text shown to visitors.',
                'address': 'Complete office/unit postal address details.',
                'name': 'The display name for this record.',
                
                // Category
                'category_title': 'Page banner main header title for this category.',
                'category_subtitle': 'Page banner secondary tagline text for this category.',
                'display_order': 'Number representing the sorting order (lower values display first).',
                'wallpaper_image': 'Select a background wallpaper banner image for this category page.'
            };

            // 2. Scan form elements and inject question marks
            if (typeof $ !== 'undefined') {
                $('form :input').each(function() {
                    const input = $(this);
                    const inputName = input.attr('name');
                    if (!inputName || input.attr('type') === 'hidden') return;

                    // Find label
                    const formGroup = input.closest('.mb-4, .mb-3, .form-group, .row');
                    let label = formGroup.find('.form-label-title, .form-label, label').first();

                    if (label.length === 0) {
                        label = input.parent().prev('label');
                    }

                    if (label.length > 0 && label.find('.helper-tooltip-btn').length === 0) {
                        const cleanName = inputName.replace(/[\[\]\s\d]/g, '').toLowerCase();
                        const labelText = label.text().trim().replace(/[:*]/g, '');
                        
                        let helpText = fieldTooltips[cleanName] || fieldTooltips[inputName];
                        if (!helpText) {
                            // Fallback matching
                            for (const key in fieldTooltips) {
                                if (cleanName.includes(key)) {
                                    helpText = fieldTooltips[key];
                                    break;
                                }
                            }
                        }
                        if (!helpText) {
                            helpText = 'Fill in the <strong>' + labelText + '</strong> field for this record.';
                        }

                        // Create popover button
                        const helpBtn = $('<span class="helper-tooltip-btn ms-2" ' +
                                          'data-bs-toggle="popover" ' +
                                          'data-bs-trigger="hover focus click" ' +
                                          'data-bs-placement="top" ' +
                                          'data-bs-html="true" ' +
                                          'title="Field Help: ' + labelText + '" ' +
                                          'data-bs-content="' + helpText.replace(/"/g, '&quot;') + '">' +
                                          '<i class="fa fa-question-circle"></i>' +
                                          '</span>');
                        
                        helpBtn.on('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                        });
                        
                        label.append(helpBtn);
                    }
                });

                // Initialize Bootstrap Popovers
                if (typeof bootstrap !== 'undefined' && bootstrap.Popover) {
                    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
                    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                        return new bootstrap.Popover(popoverTriggerEl, {
                            sanitize: false
                        });
                    });
                }
            }

        });
    </script>
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

</body>

</html>
