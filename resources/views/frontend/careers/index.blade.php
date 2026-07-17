@extends('frontend.layouts.app')

@section('content')

    <div class="container py-5">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="about-sidebar shadow-sm">
                    <a href="{{ route('careers', 'recruitment') }}"
                        class="sidebar-item {{ $tab == 'recruitment' ? 'active' : '' }}">
                        Recruitment
                    </a>
                    <a href="{{ route('careers', 'internship') }}"
                        class="sidebar-item {{ $tab == 'internship' ? 'active' : '' }}">
                        Internships
                    </a>
                    <a href="{{ route('careers', 'notifications') }}"
                        class="sidebar-item {{ $tab == 'notifications' ? 'active' : '' }}">
                        Notifications
                    </a>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="col-lg-9 col-md-8">

                @if($tab == 'recruitment' || $tab == 'internship')
                    <div class="career-card shadow-sm border rounded p-4 bg-white">
                        <h2 class="career-main-title border-bottom pb-3 mb-4 text-primary">
                            {{ $tab == 'recruitment' ? 'Current Job Openings (Recruitment)' : 'Internship Opportunities' }}
                        </h2>

                        @forelse($jobs as $item)
                            @php
                                $isClosed = false;
                                if ($item->last_date) {
                                    $isClosed = \Carbon\Carbon::now()->startOfDay()->gt(\Carbon\Carbon::parse($item->last_date)->startOfDay());
                                }
                            @endphp
                            <div class="job-opening-item border rounded p-4 mb-4 bg-light shadow-sm" style="transition: transform 0.2s;">
                                <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
                                    <h4 class="job-title text-dark mb-0 fw-bold">
                                        {{ $item->title }}
                                    </h4>
                                    <div>
                                        @if($isClosed)
                                            <span class="badge bg-danger px-3 py-2 text-white">Closed</span>
                                        @else
                                            <span class="badge bg-success px-3 py-2 text-white">Active / Open</span>
                                        @endif
                                    </div>
                                </div>

                                @if($item->job_info)
                                    <div class="job-section mb-3">
                                        <h6 class="fw-bold text-secondary mb-1">Job Details & Info:</h6>
                                        <div class="job-info-text text-muted">
                                            {!! \App\Support\Security::cleanHtml($item->job_info) !!}
                                        </div>
                                    </div>
                                @endif

                                @if($item->eligibility)
                                    <div class="job-section mb-3">
                                        <h6 class="fw-bold text-secondary mb-1">Eligibility Criteria:</h6>
                                        <div class="eligibility-text text-muted">
                                            {!! \App\Support\Security::cleanHtml($item->eligibility) !!}
                                        </div>
                                    </div>
                                @endif

                                <div class="row align-items-center mt-3 pt-3 border-top">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        @if($item->last_date)
                                            <div class="last-date-info">
                                                <span class="text-secondary">Last Date to Apply:</span>
                                                <strong class="{{ $isClosed ? 'text-muted' : 'text-danger' }}">
                                                    {{ \Carbon\Carbon::parse($item->last_date)->format('d M Y') }}
                                                </strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-sm-6 text-sm-end">
                                        @if($item->pdf)
                                            <a href="{{ asset('uploads/careers/' . $item->pdf) }}" target="_blank" class="btn btn-outline-primary btn-sm px-4 py-2">
                                                Download Details PDF
                                            </a>
                                        @else
                                            <span class="text-muted">No attachments</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <p class="text-muted fs-5 mb-0">No active postings available at this time. Please check back later.</p>
                            </div>
                        @endforelse
                    </div>
                @endif

                @if($tab == 'notifications')

                    <div class="career-card shadow-sm border rounded p-4 bg-white">

                        <h2 class="career-main-title border-bottom pb-3 mb-4 text-primary">
                            General Career Notifications
                        </h2>

                        @forelse($notifications as $item)

                            <div class="notification-card border-bottom pb-4 mb-4 last-no-border">

                                <h4 class="notification-title fw-bold text-dark mb-2">
                                    {{ $item->title }}
                                </h4>

                                <div class="notification-description text-muted mb-3">
                                    {!! \App\Support\Security::cleanHtml($item->description) !!}
                                </div>

                                @if($item->files && count($item->files))
                                    <div class="pdf-list d-flex flex-column gap-2">

                                        @foreach($item->files as $file)
                                            <div class="pdf-link-wrapper">
                                                <span class="pdf-icon text-danger">📄</span>

                                                <a href="{{ asset('uploads/careers/' . $file->pdf) }}" target="_blank" class="pdf-link text-decoration-none">
                                                    Download Advertisement/Details ({{ $file->pdf }})
                                                </a>
                                            </div>
                                        @endforeach

                                    </div>
                                @endif

                            </div>
                        @empty
                            <div class="text-center py-5">
                                <p class="text-muted fs-5 mb-0">No general notifications posted.</p>
                            </div>
                        @endforelse

                    </div>

                @endif

            </div>
        </div>
    </div>

@endsection
