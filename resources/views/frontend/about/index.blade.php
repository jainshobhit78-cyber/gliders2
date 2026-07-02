@extends('frontend.layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ url('frontend/css/legacy.css') }}">
@endsection

@section('content')

    <div class="container py-5">

        <div class="row">

            <!-- LEFT SIDEBAR -->
            <div class="col-lg-3">
                <div class="about-sidebar">

                    <a href="{{ route('about', 'leadership') }}"
                        class="sidebar-item {{ $tab == 'leadership' ? 'active' : '' }}">Leadership</a>
                    <a href="{{ route('about', 'legacy') }}"
                        class="sidebar-item {{ $tab == 'legacy' ? 'active' : '' }}">Legacy</a>
                    <a href="{{ route('about', 'opf-legacy') }}"
                        class="sidebar-item {{ $tab == 'opf-legacy' ? 'active' : '' }}">OPF Legacy</a>
                    <a href="{{ route('about', 'production') }}"
                        class="sidebar-item {{ $tab == 'production' ? 'active' : '' }}">Production Unit</a>
                    <a href="{{ route('about', 'history') }}"
                        class="sidebar-item {{ $tab == 'history' ? 'active' : '' }}">History</a>
                    <a href="{{ route('about', 'social-responsibility') }}"
                        class="sidebar-item {{ $tab == 'social-responsibility' ? 'active' : '' }}">
                        Social Responsibility
                    </a>
                    <a href="{{ route('about', 'human-resources') }}"
                        class="sidebar-item {{ $tab == 'human-resources' ? 'active' : '' }}">
                        Human Resources
                    </a>
                    <a href="{{ route('about', 'vision') }}" class="sidebar-item {{ $tab == 'vision' ? 'active' : '' }}">
                        Vision
                    </a>

                    <a href="{{ route('about', 'mission') }}" class="sidebar-item {{ $tab == 'mission' ? 'active' : '' }}">
                        Mission
                    </a>
                    <!-- <a href="{{ route('about', 'directory') }}"
                        class="sidebar-item {{ $tab == 'directory' ? 'active' : '' }}">
                        Directory
                    </a> -->
                    <a href="{{ route('about', 'codes-conduct') }}"
                        class="sidebar-item {{ $tab == 'codes-conduct' ? 'active' : '' }}">
                        Codes of Conduct
                    </a>

                </div>
            </div>

            <!-- RIGHT CONTENT -->
            <div class="col-lg-9">

                <!-- ================= LEADERSHIP ================= -->
                @if($tab == 'leadership')

                    <!-- @foreach($leaders as $leader)
                                                        <div class="leader-card mb-4">

                                                            {{-- LEADER BASIC INFO --}}
                                                            <div class="row mb-4">

                                                                @php
                                                                    $firstMilestone = $leader->milestones->first();
                                                                @endphp

                                                                <div class="col-md-3">
                                                                    @if($firstMilestone && $firstMilestone->image)
                                                                        <a href="{{ asset('uploads/milestones/' . $firstMilestone->image) }}" class="glightbox"
                                                                            data-gallery="leaders">

                                                                            <img src="{{ asset('uploads/milestones/' . $firstMilestone->image) }}"
                                                                                class="leader-img img-fluid rounded" alt="{{ $leader->leader_name }}">
                                                                        </a>
                                                                    @else
                                                                        <img src="{{ asset('backend/images/no-image.png') }}" class="leader-img img-fluid rounded"
                                                                            alt="No Image">
                                                                    @endif
                                                                </div>

                                                                <div class="col-md-9">
                                                                    <h4>{{ $leader->leader_name }} ({{ $leader->role }})</h4>

                                                                    <p class="designation">
                                                                        {{ $leader->sub_title }}
                                                                    </p>

                                                                    <div class="bio">
                                                                        {!! $leader->bio !!}
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            {{-- MILESTONES --}}
                                                            @if($leader->milestones->count())

                                                                <div class="milestone-section">
                                                                    <h5>Milestones</h5>

                                                                    @foreach($leader->milestones as $milestone)

                                                                        <div class="milestone-card mb-3">

                                                                            <div class="row">

                                                                                <div class="col-md-3">
                                                                                    @if($milestone->image)
                                                                                        <a href="{{ asset('uploads/milestones/' . $milestone->image) }}" class="glightbox"
                                                                                            data-gallery="milestone-{{ $leader->id }}">

                                                                                            <img src="{{ asset('uploads/milestones/' . $milestone->image) }}"
                                                                                                class="img-fluid rounded" alt="{{ $milestone->heading }}">
                                                                                        </a>
                                                                                    @endif
                                                                                </div>

                                                                                <div class="col-md-9">

                                                                                    <h6>
                                                                                        {{ $milestone->heading }}
                                                                                    </h6>

                                                                                    <p class="date">
                                                                                        {{ $milestone->start_date }}
                                                                                        →
                                                                                        {{ $milestone->end_date }}
                                                                                    </p>

                                                                                    <div class="text-muted">
                                                                                        {!! $milestone->description !!}
                                                                                    </div>

                                                                                </div>

                                                                            </div>

                                                                        </div>

                                                                    @endforeach

                                                                </div>

                                                            @endif

                                                        </div>
                                                    @endforeach -->

                    <div class="leadership-wrapper">
                        <div class="container">

                            <div class="section-title text-center mb-4">
                                <h2>Leadership</h2>
                                <p>Driving Precision. Powering Defence Excellence.</p>
                            </div>

                            {{-- Dynamic Tabs based on the leaders --}}
                            <div class="leader-tabs-container mb-4">
                                @foreach($leaders as $index => $leader)
                                    <button class="leader-tab-btn {{ $index == 0 ? 'active' : '' }}" 
                                            onclick="selectLeaderTab(event, 'leader-{{ $leader->id }}')">
                                        {{-- If role contains Chairman & Managing Director, output CMD, otherwise role --}}
                                        @if(stripos($leader->role, 'Chairman') !== false && stripos($leader->role, 'Managing') !== false)
                                            CMD
                                        @else
                                            {{ $leader->role }}
                                        @endif
                                    </button>
                                @endforeach
                            </div>

                            {{-- Leaders Tab Panels --}}
                            <div class="leader-panels-container">
                                @foreach($leaders as $index => $leader)
                                    <div class="leader-tab-panel {{ $index == 0 ? 'show active' : '' }}" id="leader-{{ $leader->id }}">
                                        
                                        <div class="leader-main-content">
                                            <div class="leader-photo-column">
                                                <div class="leader-photo-wrapper">
                                                    <img src="{{ $leader->picture ? asset('uploads/leadership/' . $leader->picture) : asset('frontend/images/avatar/user-account.jpg') }}" alt="{{ $leader->leader_name }}">
                                                </div>
                                            </div>
                                            
                                            <div class="leader-details-column">
                                                <h3 class="leader-name">{{ $leader->leader_name }}</h3>
                                                <h5 class="leader-title">{{ $leader->role }}</h5>
                                                <p class="leader-subtitle">{{ $leader->sub_title }}</p>
                                                <div class="leader-bio">
                                                    {!! $leader->bio !!}
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Milestones Timeline Section --}}
                                        @if($leader->milestones->count() > 0)
                                            <div class="leader-timeline-section mt-5">
                                                <h3 class="timeline-header-title">Professional Milestones</h3>
                                                <div class="timeline-nodes-list">
                                                    @foreach($leader->milestones as $milestone)
                                                        <div class="timeline-node-card">
                                                            @if($milestone->image)
                                                                <div class="timeline-node-image">
                                                                    <img src="{{ asset('uploads/milestones/' . $milestone->image) }}" alt="">
                                                                </div>
                                                            @endif
                                                            <div class="timeline-node-content">
                                                                <div class="timeline-node-date">
                                                                    {{ $milestone->start_date }} @if($milestone->end_date) → {{ $milestone->end_date }} @else → Present @endif
                                                                </div>
                                                                <h4>{{ $milestone->heading }}</h4>
                                                                <div class="timeline-node-desc">
                                                                    {!! $milestone->description !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>

                @endif


                <!-- ================= LEADERSHIP LEGACY ================= -->
                @if($tab == 'legacy' || $tab == 'opf-legacy')
                    <div class="legacy-page">
                        <!-- ===== HERO ===== -->
                        <section class="legacy-hero">
                            <div class="legacy-deco-mountain"></div>
                            <svg class="legacy-deco-chute" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#0b2a5b" stroke-width="1"><path d="M2 9a10 10 0 0 1 20 0Z"/><path d="M2 9l10 2M22 9l-10 2M7 9l5 2M17 9l-5 2"/><path d="M12 11v7"/><path d="M9 18h6"/></svg>
                            <svg class="legacy-deco-plane" width="70" height="70" viewBox="0 0 24 24" fill="none" stroke="#0b2a5b" stroke-width="1"><path d="M2 13l9-2 4-9 2 1-2 8 6 1v2l-6 1 2 8-2 1-4-9-9-2Z"/></svg>
                            @if($tab == 'opf-legacy')
                                <h1>{{ $legacySetting->hero_title ?? 'OPF GM' }} <span class="legacy-accent">{{ $legacySetting->hero_accent ?? 'Legacy' }}</span></h1>
                                <p class="legacy-sub">{{ $legacySetting->hero_subtitle ?? 'Honouring the General Managers of Ordnance Parachute Factory (OPF)' }}</p>
                            @else
                                <h1>Gliders India <span class="legacy-accent">Legacy</span></h1>
                                <p class="legacy-sub">Honouring the Chairman & Managing Directors (CMDs) who have led Gliders India Limited since 2021</p>
                            @endif
                            <div class="legacy-rule"></div>
                        </section>

                        <!-- ===== SLIDER ===== -->
                        <section class="legacy-slider-section">
                            <div class="legacy-wrap legacy-slider-outer">
                                <button class="legacy-slider-arrow legacy-prev" id="legacyPrevBtn" aria-label="Previous">&#10094;</button>
                                <button class="legacy-slider-arrow legacy-next" id="legacyNextBtn" aria-label="Next">&#10095;</button>
                                <div class="legacy-slider-track" id="legacySliderTrack"></div>
                                <div class="legacy-dots" id="legacyDots"></div>
                            </div>
                        </section>

                        <!-- ===== DETAIL PANEL ===== -->
                        <div class="legacy-wrap" style="padding:0;">
                            <div class="legacy-detail-panel" id="legacyDetailPanel"></div>
                        </div>

                        <!-- ===== ACHIEVEMENTS / FOCUS ===== -->
                        <div class="legacy-wrap" style="padding:0;">
                            <div class="legacy-info-grid">
                                <div class="legacy-info-col">
                                    <h3>KEY ACHIEVEMENTS</h3>
                                    <ul class="legacy-achv-list" id="legacyAchvList"></ul>
                                </div>
                                <div class="legacy-info-col">
                                    <h3>FOCUS AREAS &amp; INITIATIVES</h3>
                                    <div class="legacy-focus-grid" id="legacyFocusGrid"></div>
                                </div>
                            </div>
                        </div>

                        <!-- ===== STATS BAR ===== -->
                        <div class="legacy-wrap" style="padding:0;">
                            <div class="legacy-stats-bar" id="legacyStatsBar"></div>
                        </div>

                        <!-- ===== TIMELINE ===== -->
                        <section class="legacy-timeline-section">
                            <h2>{{ $legacySetting->timeline_title ?? 'OUR LEADERSHIP JOURNEY' }}</h2>
                            <p class="legacy-tl-sub" id="legacyTimelineSub"></p>
                            <div class="legacy-timeline-wrap" id="legacyTimelineWrap">
                                <div class="legacy-timeline" id="legacyTimeline"></div>
                            </div>
                        </section>

                        <!-- ===== FOOTER CTA ===== -->
                        <div class="legacy-footer-cta">
                            <div class="legacy-deco"></div>
                            <p>{{ $legacySetting->footer_line1 ?? 'From Legacy to Leadership,' }}<br><span class="legacy-hi">{{ $legacySetting->footer_line2 ?? 'From Leadership to Innovation.' }}</span></p>
                        </div>
                    </div>
                @endif


                <!-- ================= PRODUCTION ================= -->
                @if($tab == 'production')

                    @foreach($production as $item)

                        <div class="leader-card production-card mb-4">

                            {{-- MAIN UNIT INFO --}}
                            <div class="row mb-4">

                                <div class="col-md-12">
                                    <h4>{{ $item->heading }}</h4>

                                    <p class="designation">
                                        {{ $item->sub_heading }} ~ {{ $item->profile }}
                                    </p>

                                    <div class="bio">
                                        {!! $item->bio !!}
                                    </div>
                                </div>

                            </div>

                            {{-- ALL MILESTONES --}}
                            @if($item->milestones->count())

                                <div class="milestone-section mt-4">
                                    <h5>Production Milestones</h5>

                                    @foreach($item->milestones as $milestone)

                                        <div class="milestone-card border rounded p-3 mb-4">

                                            <div class="row">

                                                {{-- LEFT SIDE IMAGE --}}
                                                <div class="col-md-3">

                                                    @php
                                                        $firstImage = $milestone->images->first();
                                                    @endphp

                                                    @if($firstImage)
                                                        <a href="{{ asset('uploads/production/images/' . $firstImage->image) }}"
                                                            class="glightbox" data-gallery="production_{{ $milestone->id }}">

                                                            <img src="{{ asset('uploads/production/images/' . $firstImage->image) }}"
                                                                class="img-fluid rounded" style="height:200px; width:100%; object-fit:cover;">
                                                        </a>
                                                    @endif

                                                </div>

                                                {{-- RIGHT CONTENT --}}
                                                <div class="col-md-9">

                                                    <h6>
                                                        {{ $milestone->milestone_name }}
                                                    </h6>

                                                    <p class="date">
                                                        {{ \Carbon\Carbon::parse($milestone->milestone_date)->format('d M Y') }}
                                                    </p>

                                                    <div class="text-muted pb-2">
                                                        {!! $milestone->bio !!}
                                                    </div>

                                                    {{-- ALL THUMBNAIL IMAGES --}}
                                                    @if($milestone->images->count())
                                                        <div class="d-flex flex-wrap gap-2">

                                                            @foreach($milestone->images as $img)

                                                                <a href="{{ asset('uploads/production/images/' . $img->image) }}" class="glightbox"
                                                                    data-gallery="production_{{ $milestone->id }}">

                                                                    <img src="{{ asset('uploads/production/images/' . $img->image) }}"
                                                                        style="width:90px; height:90px; object-fit:cover; border-radius:8px;">
                                                                </a>

                                                            @endforeach

                                                        </div>
                                                    @endif

                                                    {{-- VIDEO --}}
                                                    @if($milestone->video)
                                                        <div class="mt-3">
                                                            <a href="{{ asset('uploads/production/videos/' . $milestone->video) }}"
                                                                class="btn btn-sm btn-primary glightbox"
                                                                data-gallery="production_{{ $milestone->id }}" data-type="video">

                                                                ▶ Watch Video
                                                            </a>
                                                        </div>
                                                    @endif

                                                </div>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            @endif

                        </div>

                    @endforeach

                @endif


                <!-- ================= HISTORY ================= -->
                @if($tab == 'history')

                    @foreach($history as $item)
                        <div class="leader-card history-card">
                            <h4>{{ $item->title }}</h4>
                            <p class="text-muted">{!! $item->description !!}</p>
                        </div>
                    @endforeach

                @endif


                <!-- ================= SOCIAL RESPONSIBILITY ================= -->
                @if($tab == 'social-responsibility')

                    @php
                        $mainData = $socialResponsibility->first();
                    @endphp

                    @if($mainData)

                        <!-- TOP CONTENT CARD -->
                        <div class="leader-card mb-4">

                            @foreach($socialResponsibility as $item)
                                <div class="text-center">
                                    <h4>
                                        {{ $item->heading }}
                                    </h4>

                                    <p class="designation">
                                        {{ $item->sub_heading }}
                                    </p>
                                </div>

                                <div class="social-description">
                                    {!! $item->description !!}
                                </div>
                            @endforeach


                        </div>

                        <!-- MEMBERS TABLE -->
                        <div class="social-table-card shadow-sm border rounded p-4 bg-white">
                            <h4>
                                Committee Members
                            </h4>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover social-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Role</th>
                                            <th>Phone Number</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($socialResponsibility as $member)
                                            <tr>
                                                <td width="100">
                                                    <img src="{{ asset('uploads/social/' . $member->photo) }}"
                                                        class="img-fluid rounded-circle social-member-img" alt="{{ $member->name }}">
                                                </td>

                                                <td>{{ $member->name }}</td>
                                                <td>{{ $member->title }}</td>
                                                <td>
                                                    <span class="badge bg-warning text-dark px-3 py-2">
                                                        {{ $member->sub_title }}
                                                    </span>
                                                </td>
                                                <td>{{ $member->phone }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    @endif

                @endif


                <!-- ================= HUMAN RESOURCES ================= -->
                @if($tab == 'human-resources')

                    @if($humanResources)

                        <div class="leader-card mb-4">

                            <!-- MAIN TITLE -->
                            <div class="text-center pb-3">
                                <h4>
                                    {{ $humanResources->title }}
                                </h4>
                            </div>

                            <!-- DESCRIPTION -->
                            <div class="hr-section mb-4">
                                <h4 class="hr-heading">Description</h4>
                                <div class="text-muted">
                                    {!! $humanResources->description !!}
                                </div>
                            </div>

                            <!-- GRID CONTENT -->
                            <div class="row g-4">

                                <div class="col-md-6">
                                    <div class="hr-box">
                                        <h4>Vision</h4>
                                        <div class="text-muted">{!! $humanResources->vision !!}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="hr-box">
                                        <h4>Mission</h4>
                                        <div class="text-muted">{!! $humanResources->mission !!}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="hr-box">
                                        <h4>Objectives</h4>
                                        <div class="text-muted">{!! $humanResources->objectives !!}</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="hr-box">
                                        <h4>Strategy</h4>
                                        <div>{!! $humanResources->strategy !!}</div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    @endif

                @endif


                <!-- ================= VISION ================= -->
                @if($tab == 'vision')

                    @if($vision)

                        <div class="leader-card">

                            <div class="text-center pb-3">
                                <h4>
                                    {{ $vision->title }}
                                </h4>
                            </div>

                            <div class="text-muted">
                                {!! $vision->description !!}
                            </div>

                        </div>

                    @endif

                @endif


                <!-- ================= MISSION ================= -->
                @if($tab == 'mission')

                    @if($mission)

                        <div class="leader-card">

                            <div class="text-center pb-3">
                                <h4>
                                    {{ $mission->title }}
                                </h4>
                            </div>

                            <div class="text-muted">
                                {!! $mission->description !!}
                            </div>

                        </div>

                    @endif

                @endif


                <!-- ================= DIRECTORY ================= -->
                @if($tab == 'directory')

                    <div class="leader-card mb-4">

                        <!-- INNER TABS -->
                        <ul class="nav nav-pills mb-4" id="directoryTabs" role="tablist">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#headquarters"
                                    type="button">
                                    Headquarters
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#opf">
                                    OPF
                                </button>
                            </li>

                        </ul>

                        <div class="tab-content">

                            <!-- HEADQUARTERS -->
                            <div class="tab-pane fade show active" id="headquarters">
                                <div class="text-center pb-3">
                                    <h4>
                                        GLIDERS INDIA LIMITED HQ, KANPUR
                                    </h4>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered directory-table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>S No</th>
                                                <th>Name</th>
                                                <th>Designation</th>
                                                <th>Mobile No.</th>
                                                <th>Telephone</th>
                                                <th>Email</th>
                                                <th>Deals In</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($directoryHQ as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->designation }}</td>
                                                    <td>
                                                        @php
                                                            $mobiles = is_array($item->mobile_no)
                                                                ? $item->mobile_no
                                                                : json_decode($item->mobile_no, true);
                                                        @endphp

                                                        @if(is_array($mobiles))
                                                            @foreach($mobiles as $mobile)
                                                                <div>{{ $mobile }}</div>
                                                            @endforeach
                                                        @else
                                                            {{ $item->mobile_no }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->telephone_number }}</td>
                                                    <td>
                                                        @php
                                                            $emails = is_array($item->email)
                                                                ? $item->email
                                                                : json_decode($item->email, true);
                                                        @endphp

                                                        @if(is_array($emails))
                                                            @foreach($emails as $email)
                                                                <div>{{ $email }}</div>
                                                            @endforeach
                                                        @else
                                                            {{ $item->email }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->deals_in }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <!-- OPF -->
                            <div class="tab-pane fade" id="opf">

                                <div class="text-center pb-3">
                                    <h4>
                                        ORDNANCE PARACHUTE FACTORY, KANPUR
                                    </h4>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered directory-table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>S No</th>
                                                <th>Name</th>
                                                <th>Designation</th>
                                                <th>Mobile No.</th>
                                                <th>Telephone</th>
                                                <th>Email</th>
                                                <th>Deals In</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($directoryOPF as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->designation }}</td>
                                                    <td>
                                                        @php
                                                            $mobiles = is_array($item->mobile_no)
                                                                ? $item->mobile_no
                                                                : json_decode($item->mobile_no, true);
                                                        @endphp

                                                        @if(is_array($mobiles))
                                                            @foreach($mobiles as $mobile)
                                                                <div>{{ $mobile }}</div>
                                                            @endforeach
                                                        @else
                                                            {{ $item->mobile_no }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->telephone_number }}</td>
                                                    <td>
                                                        @php
                                                            $emails = is_array($item->email)
                                                                ? $item->email
                                                                : json_decode($item->email, true);
                                                        @endphp

                                                        @if(is_array($emails))
                                                            @foreach($emails as $email)
                                                                <div>{{ $email }}</div>
                                                            @endforeach
                                                        @else
                                                            {{ $item->email }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->deals_in }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>

                    </div>

                @endif


                <!-- ================= CODES OF CONDUCT ================= -->
                @if($tab == 'codes-conduct')

                    <div class="leader-card mb-4">

                        <div class="text-center pb-3">
                            <h4>
                                Codes of Conduct
                            </h4>
                        </div>

                        @foreach($codesConduct as $item)

                            <div class="conduct-item pb-4 mb-1">

                                <h4 class="pb-2">
                                    {{ $item->title }}
                                </h4>

                                <div class="text-muted pb-2">
                                    {!! $item->description !!}
                                </div>

                                @if($item->pdf)
                                    <div class="pdf-link-wrapper">
                                        <span class="pdf-icon">📄</span>

                                        <a href="{{ asset('uploads/codes/' . $item->pdf) }}" target="_blank" class="pdf-link">
                                            Click here to Download ({{ $item->pdf }})
                                        </a>
                                    </div>
                                @endif

                            </div>

                        @endforeach

                    </div>

                @endif

            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    <script>
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            zoomable: true,
            draggable: true,
            openEffect: 'zoom',
            closeEffect: 'fade'
        });
    </script>

    <script>
        function selectLeaderTab(evt, panelId) {
            // Hide all panels
            const panels = document.querySelectorAll('.leader-tab-panel');
            panels.forEach(p => {
                p.classList.remove('show', 'active');
            });

            // Remove active class from all tab buttons
            const tabs = document.querySelectorAll('.leader-tab-btn');
            tabs.forEach(t => {
                t.classList.remove('active');
            });

            // Show selected panel and add active class to button
            const activePanel = document.getElementById(panelId);
            if (activePanel) {
                activePanel.classList.add('show', 'active');
            }
            evt.currentTarget.classList.add('active');
        }
    </script>

    <script>
    const LEGACY_ICON = {
      check:`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>`,
      calendar:`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 9h18M7 3v4M17 3v4"/></svg>`,
      gear:`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="3.2"/><path d="M12 3v2.2M12 18.8V21M21 12h-2.2M5.2 12H3M18.4 5.6l-1.5 1.5M7.1 16.9l-1.5 1.5M18.4 18.4l-1.5-1.5M7.1 7.1L5.6 5.6"/></svg>`,
      globe:`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a13 13 0 0 1 0 18a13 13 0 0 1 0-18Z"/></svg>`,
      monitor:`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="4" width="18" height="13" rx="1.5"/><path d="M8 21h8M12 17v4"/></svg>`,
      medal:`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="14" r="6"/><path d="M9 8.5L7 2M15 8.5L17 2"/><path d="M12 11.5l1.1 2.3 2.5.3-1.8 1.7.5 2.5-2.3-1.2-2.3 1.2.5-2.5-1.8-1.7 2.5-.3z"/></svg>`,
      people:`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="8.5" cy="8" r="3"/><circle cx="16" cy="9" r="2.4"/><path d="M2.5 19c0-3 2.7-5 6-5s6 2 6 5"/><path d="M13.5 14.3c2.4.2 4.5 1.8 4.5 4.2"/></svg>`,
      bulb:`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M9 18h6M10 21h4"/><path d="M12 3a6 6 0 0 0-3.5 10.9c.5.4.8 1 .8 1.6v.5h5.4v-.5c0-.6.3-1.2.8-1.6A6 6 0 0 0 12 3Z"/></svg>`,
      rupee:`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 4h12M6 9h12M6 4c5 0 8 1.6 8 5s-3 5-8 5M6 14l9 7"/></svg>`,
      chart:`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M4 19V11M10 19V7M16 19V13M21 19H3"/></svg>`,
      wrench:`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M14.7 6.3a4 4 0 1 0-5.4 5.4L3 18l3 3 6.3-6.3a4 4 0 0 0 5.4-5.4l-2.1 2.1-2.6-.6-.6-2.6Z"/></svg>`,
      flag:`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 21V4"/><path d="M5 4h12l-3 4 3 4H5"/></svg>`,
      arrowUp:`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5"/><path d="M5 12l7-7 7 7"/></svg>`,
      star:`<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"><path d="M12 3l2.7 5.9 6.3.7-4.8 4.3 1.4 6.2L12 17l-5.6 3.1 1.4-6.2-4.8-4.3 6.3-.7Z"/></svg>`
    };

    function legacyIcon(key) {
        return LEGACY_ICON[key] || LEGACY_ICON.flag;
    }

    // Data from controller
    const legacyLeaders = @json($tab === 'opf-legacy' ? $opfLegacy : $glidersLegacy);

    let legacyActivePos = 0;

    function legacyAvatarHTML(l) {
        if (l.image) {
            return `<img src="/uploads/category/${l.image}" alt="${l.name}">`;
        }
        return l.initials || '?';
    }

    /* ---------- BUILD SLIDER CARDS ---------- */
    const legacyTrack = document.getElementById('legacySliderTrack');
    if (legacyTrack) {
        legacyLeaders.forEach((l, pos) => {
          const card = document.createElement('div');
          card.className = 'legacy-leader-card';
          card.innerHTML = `
            <div class="legacy-avatar" style="background:${l.color || '#0b2a5b'}">${legacyAvatarHTML(l)}</div>
            <h4>${l.name}</h4>
            <div class="legacy-role">${l.role}</div>
            <div class="legacy-years">${l.tenure_start} – ${l.tenure_end || 'Present'}</div>
          `;
          card.addEventListener('click', () => legacySetActive(pos));
          legacyTrack.appendChild(card);
        });
    }
    const legacyCardEls = legacyTrack ? Array.from(legacyTrack.children) : [];

    /* ---------- DOTS ---------- */
    const legacyDotsWrap = document.getElementById('legacyDots');
    if (legacyDotsWrap) {
        legacyLeaders.forEach((l, pos) => {
          const d = document.createElement('button');
          d.addEventListener('click', () => legacySetActive(pos));
          legacyDotsWrap.appendChild(d);
        });
    }
    const legacyDotEls = legacyDotsWrap ? Array.from(legacyDotsWrap.children) : [];

    /* ---------- TIMELINE ---------- */
    const legacyTimelineEl = document.getElementById('legacyTimeline');
    const legacyTimelineWrapEl = document.getElementById('legacyTimelineWrap');
    const legacyTimelineSubEl = document.getElementById('legacyTimelineSub');

    /* ---------- DETAIL PANEL RENDER ---------- */
    const legacyDetailPanel = document.getElementById('legacyDetailPanel');
    const legacyAchvList = document.getElementById('legacyAchvList');
    const legacyFocusGrid = document.getElementById('legacyFocusGrid');
    const legacyStatsBar = document.getElementById('legacyStatsBar');

    function legacyPaintDetail(l) {
      if (!legacyDetailPanel) return;

      legacyDetailPanel.innerHTML = `
        <div class="legacy-detail-photo">
          <div class="legacy-avatar-lg" style="background:${l.color || '#0b2a5b'}">${legacyAvatarHTML(l)}</div>
        </div>
        <div class="legacy-detail-main">
          <h2>${l.name}</h2>
          <div class="legacy-role-line">${l.role}</div>
          <div class="legacy-tenure">${legacyIcon('calendar')}<span>${l.tenure_text || ''}</span></div>
          <p class="legacy-desc">${l.description || ''}</p>
        </div>
        ${l.quote ? `
        <div class="legacy-quote-box">
          <span class="legacy-qmark legacy-top">&ldquo;</span>
          ${l.quote}
          <span class="legacy-qmark legacy-bottom">&rdquo;</span>
        </div>` : '<div></div>'}
      `;

      // achievements
      let achs = [];
      if (l.achievements) {
          achs = l.achievements.split('\n').map(x => x.trim()).filter(x => x.length > 0);
      }
      legacyAchvList.innerHTML = achs.map(a => `
        <li><span class="legacy-tick">${legacyIcon('check')}</span><span>${a}</span></li>
      `).join('');

      // focus areas
      let focus = l.focus_areas;
      if (typeof focus === 'string') {
          try { focus = JSON.parse(focus); } catch(e) { focus = []; }
      }
      focus = focus || [];
      legacyFocusGrid.innerHTML = focus.map(f => `
        <div class="legacy-focus-item"><div class="legacy-ic">${legacyIcon(f.icon || f[0])}</div><span>${f.label || f[1]}</span></div>
      `).join('');

      // stats
      let stats = l.stats;
      if (typeof stats === 'string') {
          try { stats = JSON.parse(stats); } catch(e) { stats = []; }
      }
      stats = stats || [];
      legacyStatsBar.innerHTML = stats.map(s => `
        <div class="legacy-stat-item">
          <div class="legacy-ic">${legacyIcon(s.icon || s[0])}</div>
          <div><div class="legacy-num">${s.number || s[1]}</div><div class="legacy-lbl">${s.label || s[2]}</div></div>
        </div>
      `).join('');

      if (legacyTimelineSubEl) {
          legacyTimelineSubEl.innerHTML = `Career path of <b>${l.name}</b>`;
      }

      // timeline
      let timeline = l.timeline;
      if (typeof timeline === 'string') {
          try { timeline = JSON.parse(timeline); } catch(e) { timeline = []; }
      }
      timeline = timeline || [];

      if (legacyTimelineEl) {
          legacyTimelineEl.innerHTML = timeline.map((m, mi) => {
            const isLast = mi === timeline.length - 1;
            return `
              <div class="legacy-tnode ${isLast ? 'legacy-active' : ''}">
                <div class="legacy-year">${m.year || m[0] || ''}</div>
                <div class="legacy-dot"></div>
                <div class="legacy-milestone-ic">${legacyIcon(m.icon || m[2])}</div>
                <div class="legacy-tname">${m.title || m[1] || ''}</div>
              </div>
            `;
          }).join('');
      }
    }

    /* ---------- ACTIVE STATE SYNC ---------- */
    function legacySetActive(pos) {
      if (legacyLeaders.length === 0) return;
      legacyActivePos = ((pos % legacyLeaders.length) + legacyLeaders.length) % legacyLeaders.length;

      legacyCardEls.forEach((c, idx) => c.classList.toggle('legacy-active', idx === legacyActivePos));
      legacyDotEls.forEach((d, idx) => d.classList.toggle('legacy-active', idx === legacyActivePos));

      if (legacyCardEls[legacyActivePos]) {
          legacyCardEls[legacyActivePos].scrollIntoView({behavior: 'smooth', inline: 'center', block: 'nearest'});
      }

      if (legacyDetailPanel) {
          legacyDetailPanel.classList.add('legacy-swap');
      }
      if (legacyTimelineWrapEl) {
          legacyTimelineWrapEl.classList.add('legacy-swap');
      }
      setTimeout(() => {
        legacyPaintDetail(legacyLeaders[legacyActivePos]);
        if (legacyDetailPanel) {
            legacyDetailPanel.classList.remove('legacy-swap');
        }
        if (legacyTimelineWrapEl) {
            legacyTimelineWrapEl.classList.remove('legacy-swap');
        }
      }, 180);
    }

    const prevBtn = document.getElementById('legacyPrevBtn');
    const nextBtn = document.getElementById('legacyNextBtn');
    if (prevBtn) {
        prevBtn.addEventListener('click', () => legacySetActive(legacyActivePos - 1));
    }
    if (nextBtn) {
        nextBtn.addEventListener('click', () => legacySetActive(legacyActivePos + 1));
    }

    /* ---------- INIT ---------- */
    if (legacyLeaders.length > 0) {
        legacyPaintDetail(legacyLeaders[legacyActivePos]);
        legacySetActive(legacyActivePos);
    }
    </script>

@endsection