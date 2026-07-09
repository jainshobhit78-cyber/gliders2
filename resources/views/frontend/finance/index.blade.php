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

                    <a href="{{ route('finance', 'eoi') }}" class="sidebar-item {{ $tab == 'eoi' ? 'active' : '' }}">
                        EOI for Banks
                    </a>

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

                        @foreach($reports as $item)

                            <div class="report-card mb-4">

                                <h4 class="report-title">
                                    {{ $item->heading }}
                                </h4>

                                <div class="report-description">
                                    {!! \App\Support\Security::cleanHtml($item->description) !!}
                                </div>

                                @if($item->files->count())
                                    <div class="pdf-list mt-3">

                                        @foreach($item->files as $file)
                                            <div class="pdf-link-wrapper">
                                                <span class="pdf-icon">📄</span>

                                                <a href="{{ asset('uploads/finance/' . $file->pdf) }}" target="_blank" class="pdf-link">
                                                    Click here to Download
                                                    ({{ $file->pdf }})
                                                </a>
                                            </div>
                                        @endforeach

                                    </div>
                                @endif

                            </div>

                        @endforeach

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

                                <h4 class="report-title">
                                    {{ $item->title }}
                                </h4>

                                <div class="report-description">
                                    {!! \App\Support\Security::cleanHtml($item->description) !!}
                                </div>

                                @if($item->pdf)
                                    <div class="pdf-link-wrapper mt-3">
                                        <span class="pdf-icon">📄</span>

                                        <a href="{{ asset('uploads/finance/' . $item->pdf) }}" target="_blank" class="pdf-link">
                                            Click here to Download
                                            ({{ $item->pdf }})
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
