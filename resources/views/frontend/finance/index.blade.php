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

                        @foreach($reports as $item)

                            <div class="report-card mb-4">

                                @php($primaryFile = $item->files->first())
                                <h4 class="report-title">
                                    @if($primaryFile)
                                        <a href="{{ asset('uploads/finance/' . $primaryFile->pdf) }}"
                                           download="{{ \App\Support\DocumentLink::downloadName($primaryFile->pdf, $item->heading) }}"
                                           class="document-heading-link">
                                            {{ $item->heading }}
                                        </a>
                                    @else
                                        {{ $item->heading }}
                                    @endif
                                </h4>

                                <div class="report-description">
                                    {!! \App\Support\Security::cleanHtml($item->description) !!}
                                </div>

                                @if($item->files->count() > 1)
                                    <div class="pdf-list mt-3">

                                        @foreach($item->files->skip(1) as $file)
                                            <div class="pdf-link-wrapper">
                                                <span class="pdf-icon">📄</span>

                                                <a href="{{ asset('uploads/finance/' . $file->pdf) }}"
                                                   download="{{ \App\Support\DocumentLink::downloadName($file->pdf, $item->heading) }}"
                                                   class="pdf-link">
                                                    {{ \App\Support\DocumentLink::downloadName($file->pdf, $item->heading) }}
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
                                    @if($item->pdf)
                                        <a href="{{ asset('uploads/finance/' . $item->pdf) }}"
                                           download="{{ \App\Support\DocumentLink::downloadName($item->pdf, $item->title) }}"
                                           class="document-heading-link">
                                            {{ $item->title }}
                                        </a>
                                    @else
                                        {{ $item->title }}
                                    @endif
                                </h4>

                                <div class="report-description">
                                    {!! \App\Support\Security::cleanHtml($item->description) !!}
                                </div>

                            </div>

                        @endforeach

                    </div>

                @endif

            </div>
        </div>
    </div>

@endsection
