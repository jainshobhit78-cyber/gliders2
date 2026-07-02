@extends('frontend.layouts.app')

@section('content')

    <div class="container py-5">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-lg-3">
                <div class="about-sidebar">

                    <a href="{{ route('vendors', 'portal') }}" class="sidebar-item {{ $tab == 'portal' ? 'active' : '' }}">
                        Online Portal
                    </a>

                </div>
            </div>

            <!-- CONTENT -->
            <div class="col-lg-9">

                @if($tab == 'portal')

                    <div class="vendor-card shadow-sm border rounded p-4 bg-white">

                        <h2 class="vendor-main-title">
                            Vendor Registration Portal
                        </h2>

                        @foreach($portals as $item)

                            <div class="portal-card mb-4">

                                <h4 class="portal-title">
                                    {{ $item->title }}
                                </h4>

                                @if($item->pdf)
                                    <div class="pdf-link-wrapper mt-3">
                                        <span class="pdf-icon">📄</span>

                                        <a href="{{ asset('uploads/vendors/' . $item->pdf) }}" target="_blank" class="portal-pdf-link">
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