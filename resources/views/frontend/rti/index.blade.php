@extends('frontend.layouts.app')

@section('content')

    <div class="container py-5">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-lg-3">
                <div class="about-sidebar">

                    <a href="{{ route('rti', 'officers') }}" class="sidebar-item {{ $tab == 'officers' ? 'active' : '' }}">
                        RTI Officers
                    </a>

                    <a href="{{ route('rti', 'information') }}"
                        class="sidebar-item {{ $tab == 'information' ? 'active' : '' }}">
                        RTI Information
                    </a>



                </div>
            </div>

            <!-- CONTENT -->
            <div class="col-lg-9">

                <!-- RTI OFFICERS -->
                @if($tab == 'officers')

                    <div class="rti-card shadow-sm border rounded p-4 bg-white">

                        <h2 class="rti-main-title">
                            RTI Officers
                        </h2>

                        <!-- INNER TABS -->
                        <ul class="nav nav-pills mb-4 officer-tabs" id="rtiOfficerTabs" role="tablist">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#gliders-officers"
                                    type="button">
                                    GLIDERS
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#opf-officers" type="button">
                                    OPF
                                </button>
                            </li>

                        </ul>

                        <div class="tab-content">

                            <!-- GLIDERS TAB -->
                            <div class="tab-pane fade show active" id="gliders-officers">

                                @foreach($officersGliders as $item)

                                    <div class="officer-card mb-4">

                                        <div class="row align-items-start">

                                            <div class="col-md-3">
                                                @if($item->image)
                                                    <img src="{{ asset('uploads/rti/' . $item->image) }}"
                                                        class="img-fluid rounded officer-img">
                                                @else
                                                    <img src="{{ asset('backend/images/no-image.png') }}"
                                                        class="img-fluid rounded officer-img">
                                                @endif
                                            </div>

                                            <div class="col-md-9">

                                                <h4 class="officer-name">
                                                    {{ $item->name }}
                                                </h4>

                                                <p><strong>Post:</strong> {{ $item->post }}</p>
                                                <p><strong>Email:</strong> {{ $item->email }}</p>
                                                <p><strong>Phone:</strong> {{ $item->phone }}</p>
                                                <p><strong>Role:</strong> {{ $item->role }}</p>

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>


                            <!-- OPF TAB -->
                            <div class="tab-pane fade" id="opf-officers">

                                @foreach($officersOpf as $item)

                                    <div class="officer-card mb-4">

                                        <div class="row align-items-start">

                                            <div class="col-md-3">
                                                @if($item->image)
                                                    <img src="{{ asset('uploads/rti/' . $item->image) }}"
                                                        class="img-fluid rounded officer-img">
                                                @else
                                                    <img src="{{ asset('backend/images/no-image.png') }}"
                                                        class="img-fluid rounded officer-img">
                                                @endif
                                            </div>

                                            <div class="col-md-9">

                                                <h4 class="officer-name">
                                                    {{ $item->name }}
                                                </h4>

                                                <p><strong>Post:</strong> {{ $item->post }}</p>
                                                <p><strong>Email:</strong> {{ $item->email }}</p>
                                                <p><strong>Phone:</strong> {{ $item->phone }}</p>
                                                <p><strong>Role:</strong> {{ $item->role }}</p>

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                @endif

                <!-- RTI INFORMATION -->

                @if($tab == 'information')

                    <div class="rti-info-card shadow-sm border rounded p-4 bg-white">

                        <div class="text-center mb-4">
                            <h2 class="rti-main-title">
                                RTI Information
                            </h2>
                        </div>

                        @foreach($information as $item)

                            <div class="rti-info-item mb-4">

                                <div class="rti-info-content">
                                    {!! $item->info_text !!}
                                </div>

                                @if($item->pdf)
                                    <div class="pdf-link-wrapper">
                                        <span class="pdf-icon">📄</span>

                                        <a href="{{ asset('uploads/rti/' . $item->pdf) }}" target="_blank" class="pdf-link">
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
@endsection