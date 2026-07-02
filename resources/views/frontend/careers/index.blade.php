@extends('frontend.layouts.app')

@section('content')

    <div class="container py-5">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-lg-3">
                <div class="about-sidebar">

                    <a href="{{ route('careers', 'notifications') }}"
                        class="sidebar-item {{ $tab == 'notifications' ? 'active' : '' }}">
                        Notifications
                    </a>

                </div>
            </div>

            <!-- CONTENT -->
            <div class="col-lg-9">

                @if($tab == 'notifications')

                    <div class="career-card shadow-sm border rounded p-4 bg-white">

                        <h2 class="career-main-title">
                            Career Notifications
                        </h2>

                        @foreach($notifications as $item)

                            <div class="notification-card mb-4">

                                <h4 class="notification-title">
                                    {{ $item->title }}
                                </h4>

                                <div class="notification-description">
                                    {!! $item->description !!}
                                </div>

                                @if($item->files && count($item->files))
                                    <div class="pdf-list mt-3">

                                        @foreach($item->files as $file)
                                            <div class="pdf-link-wrapper">
                                                <span class="pdf-icon">📄</span>

                                                <a href="{{ asset('uploads/careers/' . $file->pdf) }}" target="_blank" class="pdf-link">
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

            </div>
        </div>
    </div>

@endsection