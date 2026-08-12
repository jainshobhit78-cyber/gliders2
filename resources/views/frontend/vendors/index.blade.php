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
                                    @if($item->pdf)
                                        <a href="{{ asset('uploads/vendors/' . $item->pdf) }}"
                                           download="{{ \App\Support\DocumentLink::downloadName($item->pdf, $item->title) }}"
                                           class="document-heading-link">
                                            {{ $item->title }}
                                        </a>
                                    @else
                                        {!! preg_replace('!(https?://[^\s]+)!', '<a href="$1" target="_blank" style="word-break: break-all;" class="text-primary text-decoration-underline">$1</a>', e($item->title)) !!}
                                    @endif
                                </h4>

                            </div>

                        @endforeach

                    </div>

                @endif

            </div>
        </div>
    </div>

@endsection
