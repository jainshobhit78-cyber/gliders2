@extends('frontend.layouts.app')

@section('content')

    <div class="container py-5">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-lg-3">
                <div class="about-sidebar">

                    <a href="{{ route('finance', 'annual-report') }}"
                        class="sidebar-item {{ $tab == 'annual-report' ? 'active' : '' }}">
                        Annual Reports
                    </a>

                    <a href="{{ route('finance', 'annual-return') }}"
                        class="sidebar-item {{ $tab == 'annual-return' ? 'active' : '' }}">
                        Annual Returns
                    </a>

                    @if($eoiEnabled)
                        <a href="{{ route('finance', 'eoi') }}" class="sidebar-item {{ $tab == 'eoi' ? 'active' : '' }}">
                            EOI for Banks
                        </a>
                    @endif

                </div>
            </div>

            <!-- CONTENT -->
            <div class="col-lg-9">

                {{-- ANNUAL REPORT --}}
                @if($tab == 'annual-report')

                    <div class="finance-card shadow-sm border rounded p-4 bg-white">

                        <h2 class="finance-main-title">
                            Annual Reports
                        </h2>

                        <div class="finance-document-list">
                            @forelse($reports as $item)
                                @foreach($item->files as $file)
                                    <div class="report-card mb-3">
                                        <h4 class="report-title mb-0">
                                            <a href="{{ asset('uploads/finance/' . $file->pdf) }}"
                                               download="{{ \App\Support\DocumentLink::annualReportDownloadName($file->pdf) }}"
                                               class="document-heading-link">
                                                {{ \App\Support\DocumentLink::annualReportHeading($file->pdf) }}
                                            </a>
                                        </h4>
                                    </div>
                                @endforeach
                            @empty
                                <p class="text-muted mb-0">No annual reports are currently available.</p>
                            @endforelse
                        </div>

                    </div>

                @endif

                {{-- ANNUAL RETURNS --}}
                @if($tab == 'annual-return')

                    <div class="finance-card shadow-sm border rounded p-4 bg-white">

                        <h2 class="finance-main-title">
                            Annual Returns
                        </h2>

                        <div class="finance-document-list">
                            @forelse($returns as $item)
                                <div class="report-card mb-3">
                                    <h4 class="report-title mb-0">
                                        @if($item->pdf)
                                            <a href="{{ asset('uploads/finance/' . $item->pdf) }}"
                                               download="Annual Return Year {{ $item->fiscal_year }}.pdf"
                                               class="document-heading-link">
                                                ANNUAL RETURN YEAR {{ $item->fiscal_year }}
                                            </a>
                                        @else
                                            <span>ANNUAL RETURN YEAR {{ $item->fiscal_year }}</span>
                                        @endif
                                    </h4>
                                </div>
                            @empty
                                <p class="text-muted mb-0">No annual returns are currently available.</p>
                            @endforelse
                        </div>

                    </div>

                @endif


                {{-- EOI --}}
                @if($tab == 'eoi')

                    <div class="finance-card shadow-sm border rounded p-4 bg-white">

                        <h2 class="finance-main-title">
                            EOI for Banks
                        </h2>

                        @foreach($eois as $item)

                            <div class="eoi-card mb-4">

                                <h4 class="report-title">{{ $item->title }}</h4>

                                <div class="report-description">
                                    {!! \App\Support\Security::cleanHtml($item->description) !!}
                                </div>

                                @if($item->pdf)
                                    <a href="{{ asset('uploads/finance/' . $item->pdf) }}"
                                       download="{{ \App\Support\DocumentLink::downloadName($item->pdf, 'EOI Document') }}"
                                       class="document-heading-link d-inline-flex align-items-center gap-2 mt-3">
                                        <i class="bi bi-file-earmark-pdf" aria-hidden="true"></i>
                                        Download EOI Document (PDF)
                                    </a>
                                @endif

                            </div>

                        @endforeach

                    </div>

                @endif

            </div>
        </div>
    </div>

@endsection
