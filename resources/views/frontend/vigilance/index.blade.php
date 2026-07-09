@extends('frontend.layouts.app')

@section('content')

    <div class="container py-5">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-lg-3">
                <div class="about-sidebar">

                    <a href="{{ route('vigilance', 'chief-officer') }}"
                        class="sidebar-item {{ $tab == 'chief-officer' ? 'active' : '' }}">
                        Chief Vigilance Officer
                    </a>

                    <a href="{{ route('vigilance', 'setup') }}" class="sidebar-item {{ $tab == 'setup' ? 'active' : '' }}">
                        Vigilance Setup
                    </a>

                    <a href="{{ route('vigilance', 'contact') }}"
                        class="sidebar-item {{ $tab == 'contact' ? 'active' : '' }}">
                        Contact Details
                    </a>

                    <a href="{{ route('vigilance', 'harassment') }}"
                        class="sidebar-item {{ $tab == 'harassment' ? 'active' : '' }}">
                        Sexual Harassment
                    </a>

                    <a href="{{ route('vigilance', 'monitor') }}"
                        class="sidebar-item {{ $tab == 'monitor' ? 'active' : '' }}">
                        Independent External Monitor
                    </a>

                    <a href="{{ route('vigilance', 'manuals') }}"
                        class="sidebar-item {{ $tab == 'manuals' ? 'active' : '' }}">
                        Manuals and Policies
                    </a>

                    <a href="{{ route('vigilance', 'bulletin') }}"
                        class="sidebar-item {{ $tab == 'bulletin' ? 'active' : '' }}">
                        Vigilance Bulletin
                    </a>

                </div>
            </div>

            <!-- CONTENT -->
            <div class="col-lg-9">

                @if($tab == 'chief-officer')

                    @foreach($chiefOfficers as $item)

                        <div class="leader-card mb-4">

                            <div class="row mb-4">

                                <!-- LEFT IMAGE -->
                                <div class="col-md-4">

                                    @if($item->image)
                                        <a href="{{ asset('uploads/cvo/' . $item->image) }}" class="glightbox"
                                            data-gallery="cvo-gallery-{{ $item->id }}">

                                            <img src="{{ asset('uploads/cvo/' . $item->image) }}" class="img-fluid rounded cvo-main-img"
                                                alt="{{ $item->name }}">
                                        </a>
                                    @else
                                        <img src="{{ asset('backend/images/no-image.png') }}" class="img-fluid rounded cvo-main-img">
                                    @endif

                                </div>

                                <!-- RIGHT CONTENT -->
                                <div class="col-md-8">

                                    <h4>
                                        {{ $item->name }}
                                    </h4>

                                    <h5 class="designation text-start">
                                        {{ $item->title }}
                                    </h5>

                                    <p class="cvo-subtitle">
                                        {{ $item->sub_title }}
                                    </p>

                                    <div class="cvo-description">
                                        {!! \App\Support\Security::cleanHtml($item->description) !!}
                                    </div>

                                    @if($item->pdf)
                                        <div class="mt-4">
                                            <span class="pdf-icon">📄</span>
                                            <a href="{{ asset('uploads/cvo/' . $item->pdf) }}" target="_blank" class="cvo-pdf-link">
                                                Click here to Download ({{ $item->pdf }})
                                            </a>
                                        </div>
                                    @endif



                                </div>

                            </div>

                        </div>

                    @endforeach

                @endif

                @if($tab == 'setup')

                    @foreach($setup as $item)

                        <div class="leader-card mb-4">

                            <div class="row align-items-start">

                                <!-- LEFT IMAGE -->
                                <div class="col-md-4">

                                    @if($item->image)
                                        <a href="{{ asset('uploads/vigilance/' . $item->image) }}" class="glightbox"
                                            data-gallery="setup-gallery-{{ $item->id }}">

                                            <img src="{{ asset('uploads/vigilance/' . $item->image) }}"
                                                class="img-fluid rounded setup-main-img" alt="Vigilance Setup">
                                        </a>
                                    @else
                                        <img src="{{ asset('backend/images/no-image.png') }}" class="img-fluid rounded setup-main-img">
                                    @endif

                                </div>

                                <!-- RIGHT CONTENT -->
                                <div class="col-md-8">
                                    <div class="pb-2">
                                        <h4>
                                            Vigilance Setup
                                        </h4>
                                    </div>

                                    <div class="text-muted">
                                        {!! \App\Support\Security::cleanHtml($item->description) !!}
                                    </div>

                                    @if($item->pdf)
                                        <div class="mt-2">
                                            <span class="pdf-icon">📄</span>
                                            <a href="{{ asset('uploads/vigilance/' . $item->pdf) }}" target="_blank"
                                                class="setup-pdf-link">
                                                Click here to Download ({{ $item->pdf }})
                                            </a>
                                        </div>
                                    @endif

                                </div>

                            </div>

                        </div>

                    @endforeach

                @endif

                @if($tab == 'contact' && $contact->count())

                    @foreach($contact as $item)

                        <div class="leader-card mb-4">

                            <div class="row align-items-start">

                                <!-- LEFT IMAGE -->
                                <div class="col-md-4">

                                    @if(!empty($item->photo))
                                        <a href="{{ asset('uploads/vigilance/' . $item->photo) }}" class="glightbox"
                                            data-gallery="contact-gallery-{{ $item->id }}">

                                            <img src="{{ asset('uploads/vigilance/' . $item->photo) }}"
                                                class="img-fluid rounded contact-main-img" alt="{{ $item->name }}">
                                        </a>
                                    @else
                                        <img src="{{ asset('backend/images/no-image.png') }}"
                                            class="img-fluid rounded contact-main-img">
                                    @endif

                                </div>

                                <!-- RIGHT CONTENT -->
                                <div class="col-md-8">
                                    <div class="pb-2">
                                        <h4>
                                            {{ $item->title }}
                                        </h4>
                                    </div>
                                    <div>
                                        <h4>
                                            {{ $item->name }}
                                        </h4>
                                    </div>

                                    <p class="designation">
                                        {{ $item->sub_title }}
                                    </p>

                                    <!-- EMAILS -->
                                    <div class="contact-section mt-4">
                                        <h6 class="contact-label">Email Address</h6>

                                        @php
                                            $emails = $item->emails;
                                        @endphp

                                        @if(is_array($emails))
                                            @foreach($emails as $email)
                                                <p class="contact-email">
                                                    <a href="mailto:{{ $email }}">
                                                        {{ $email }}
                                                    </a>
                                                </p>
                                            @endforeach
                                        @else
                                            <p class="contact-email">
                                                <a href="mailto:{{ $emails }}">
                                                    {{ $emails }}
                                                </a>
                                            </p>
                                        @endif
                                    </div>

                                    <!-- ADDRESS -->
                                    <div class="contact-section mt-4">
                                        <h6 class="contact-label">Address</h6>
                                        <div class="contact-address">
                                            {!! \App\Support\Security::cleanHtml($item->address) !!}
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                @endif

                @if($tab == 'harassment' && $harassment->count())

                    @foreach($harassment as $item)

                        <div class="leader-card mb-4">

                            <div class="row align-items-start">

                                <!-- LEFT IMAGE -->
                                <div class="col-md-4">

                                    @if(!empty($item->image))
                                        <a href="{{ asset('uploads/vigilance/' . $item->image) }}" class="glightbox"
                                            data-gallery="harassment-gallery-{{ $item->id }}">

                                            <img src="{{ asset('uploads/vigilance/' . $item->image) }}"
                                                class="img-fluid rounded harassment-main-img" alt="Sexual Harassment Policy">
                                        </a>
                                    @else
                                        <img src="{{ asset('backend/images/no-image.png') }}"
                                            class="img-fluid rounded harassment-main-img">
                                    @endif

                                </div>

                                <!-- RIGHT CONTENT -->
                                <div class="col-md-8">
                                    <div class="pb-2">
                                        <h4>
                                            Sexual Harassment Policy
                                        </h4>
                                    </div>

                                    <div class="info-text">
                                        {!! \App\Support\Security::cleanHtml($item->info_text) !!}
                                    </div>

                                    @if($item->pdf)
                                        <div class="mt-2">
                                            <span class="pdf-icon">📄</span>
                                            <a href="{{ asset('uploads/vigilance/' . $item->pdf) }}" target="_blank"
                                                class="harassment-pdf-link">

                                                Click here to Download ({{ $item->pdf }})
                                            </a>
                                        </div>
                                    @endif



                                </div>

                            </div>

                        </div>

                    @endforeach

                @endif

                @if($tab == 'monitor' && $monitor)

                    <div class="leader-card mb-4">

                        <!-- Content Card -->
                            <div class="text-center pb-2">
                                <h4>
                                    {{ $monitor->title }}
                                </h4>
                            </div>

                            <div class="info-text">
                                {!! \App\Support\Security::cleanHtml($monitor->address) !!}
                            </div>


                    </div>

                @endif

                @if($tab == 'manuals' && $manuals->count())

                    <div class="leader-card mb-4">

                        <div class="text-center pb-2">
                            <h4>
                                Manuals & Policies
                            </h4>
                        </div>

                        @foreach($manuals as $item)

                            <div class="manual-item mb-4">

                                <div class="info-text">
                                    {!! \App\Support\Security::cleanHtml($item->info_text) !!}
                                </div>

                                @if($item->pdf)
                                    <div class="mt-3">
                                        <span class="pdf-icon">📄</span>
                                        <a href="{{ asset('uploads/vigilance/' . $item->pdf) }}" target="_blank"
                                            class="manual-pdf-link">

                                            Click here to Download ({{ $item->pdf }})
                                        </a>
                                    </div>
                                @endif

                            </div>

                        @endforeach

                    </div>

                @endif

                @if($tab == 'bulletin' && $bulletins->count())

                    <div class="leader-card mb-4">

                        <div class="text-center pb-2">
                            <h4>
                                Vigilance Bulletin
                            </h4>
                        </div>

                        @foreach($bulletins as $item)

                            <div class="mb-4">

                                <div class="info-text">
                                    {!! \App\Support\Security::cleanHtml($item->info_text) !!}
                                </div>

                                @if($item->pdf)
                                    <div class="mt-3">
                                        <span class="pdf-icon">📄</span>
                                        <a href="{{ asset('uploads/vigilance/' . $item->pdf) }}" target="_blank"
                                            class="bulletin-pdf-link">

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
