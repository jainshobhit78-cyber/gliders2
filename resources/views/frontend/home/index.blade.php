@extends('frontend.layouts.app')

@section('content')

    <section class="hero-banner">
        @if($videoBanner?->banner_video)
            <video id="heroVideo" class="hero-video" autoplay muted loop playsinline tabindex="0"
                aria-label="Homepage background video. Click to enable audio and play or pause.">
                <source src="{{ asset('uploads/video_banner/' . $videoBanner->banner_video) }}" type="video/mp4">
            </video>
            <button type="button" id="heroVideoStop" class="hero-video-stop" aria-label="Stop homepage video" title="Stop video">
                <span aria-hidden="true">■</span>
            </button>
        @endif


        <div class="hero-overlay"></div>

        <div class="container hero-content">
            <div class="row align-items-center">

                <!-- <div class="col-lg-6 col-md-12 text-content">
                                                <h1><span>PRECISION</span> <br> PARACHUTE SYSTEMS</h1>
                                                <h3>FOR DEFENCE & AEROSPACE MISSIONS</h3>

                                                <div class="hero-line"></div>

                                                <p><span>ENGINEERING</span> SAFETY • ENABLING EXCELLENCE</p>

                                                <div class="hero-buttons">
                                                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg me-3">
                                                        Explore Products ↗
                                                    </a>
                                                    <a href="{{ route('about', ['tab' => 'production']) }}" class="btn btn-outline-light btn-lg">
                                                        What We Do
                                                    </a>
                                                </div>
                                            </div> -->

                <!-- <div class="col-lg-6 text-center play-section">
                                                                    <button class="play-btn">
                                                                        ▶
                                                                    </button>
                                                                </div> -->

            </div>
            <div class="py-5 my-5"></div>
            <div class="stats-wrapper" style="padding-top: 150px;">
                <div class="stats-box">

                    <div class="stat-item">
                        <h2 class="counter" data-target="{{ $stateCounter->years_of_legacy ?? 0 }}" data-suffix="+">0</h2>
                        <p>Years of Legacy</p>
                    </div>

                    <div class="stat-divider"></div>

                    <div class="stat-item">
                        <h2 class="counter" data-target="{{ $stateCounter->indigenous_manufacturing ?? 0 }}"
                            data-suffix="%">0</h2>
                        <p>Indigenous Manufacturing</p>
                    </div>

                    <div class="stat-divider"></div>

                    <div class="stat-item">
                        <h2 class="counter" data-target="{{ $stateCounter->annual_production_value ?? 0 }}" data-prefix="₹"
                            data-suffix="Cr+">0</h2>
                        <p>Annual Production Value</p>
                    </div>

                </div>
            </div>
        </div>

        <div class="announcement-bar">
            <div class="announce-left">
                📢 IMPORTANT ANNOUNCEMENTS
            </div>

            <div class="announce-right">
                <div class="ticker-wrap">
                    <div class="ticker-scroll" style="animation-duration: {{ $settings->ticker_speed ?? 20 }}s;">
                        @foreach($tickerItems as $item)
                            @if($item->link)
                                <a href="{{ $item->link }}" target="_blank" class="ticker-item link-item">{{ $item->text }}</a>
                            @else
                                <span class="ticker-item">{{ $item->text }}</span>
                            @endif
                            <span class="ticker-divider">★</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="linear-background">
        <section class="our-products-section">
            <div class="container-fluid px-3 px-md-5">
                
                @php
                    $homeSetting = \App\Models\GeneralSetting::first();
                    $productsPrefix = $homeSetting->products_title_prefix ?? 'Our';
                    $productsSuffix = $homeSetting->products_title_suffix ?? 'Products';
                    $productsSubtitleText = $homeSetting->products_subtitle ?? 'Advanced parachute systems and specialized aerial delivery equipment engineered for absolute precision, safety, and mission success.';
                    $solutionsTitleText = $homeSetting->solutions_title ?? 'Parachute Solutions that Ensure';
                @endphp
                
                <!-- TOP HEADER ROW -->
                <div class="products-header-row mb-5">
                    <div class="header-left-col">
                        <div class="products-title-line">
                            <h2 class="section-title">
                                {{ $productsPrefix }} <span>{{ $productsSuffix }}</span>
                            </h2>
                            <a href="{{ route('products.index') }}" class="btn-explore-all">
                                <span>Explore All Products</span>
                                <span class="explore-arrow">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                </span>
                            </a>
                        </div>
                        <p class="section-subtitle-text">
                            {{ $productsSubtitleText }}
                        </p>
                    </div>
                </div>

                <div class="swiper productSlider">
                    <div class="swiper-wrapper">

                        @foreach($products as $product)
                            @php
                                $index = $loop->index % 4;
                                $themeClass = 'theme-orange';

                                if ($index == 1) {
                                    $themeClass = 'theme-green';
                                } elseif ($index == 2) {
                                    $themeClass = 'theme-blue';
                                } elseif ($index == 3) {
                                    $themeClass = 'theme-purple';
                                }
                            @endphp

                            <div class="swiper-slide">
                                <div class="premium-product-card {{ $themeClass }}" tabindex="0">
                                    <!-- Full background photo -->
                                    <div class="card-bg-image">
                                        @if($product->profile_pic)
                                            <img src="/uploads/products/{{ $product->profile_pic }}" alt="{{ $product->title }}">
                                        @else
                                            <img src="/uploads/products/{{ optional($product->images->first())->image }}" alt="{{ $product->title }}">
                                        @endif
                                    </div>

                                    <!-- Inner card content -->
                                    <div class="premium-card-content">
                                        <!-- Title (H3) -->
                                        <h3 class="product-title-h3">
                                            {{ $product->title }}
                                        </h3>

                                        <!-- Short Description -->
                                        <p class="product-desc-p">
                                            {!! \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($product->description)), 90) !!}
                                        </p>

                                        <!-- Action view details pill button -->
                                        <div class="product-card-action">
                                            <a href="{{ route('products.detail', ['categoryId' => $product->category_id, 'productId' => $product->id]) }}" class="btn-view-details">
                                                <span>View Details</span>
                                                <span class="details-arrow">→</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <!-- arrows -->
                    <div class="swiper-button-prev product-slider-prev"></div>
                    <div class="swiper-button-next product-slider-next"></div>
                </div>

                <h2 class="section-title section-title-2 premium-heading"
                    style="margin-top: 90px; font-size: 60px; line-height: 1.2;">

                    {{ $solutionsTitleText }}
                    <span class="typing-wrapper">
                        <span id="animated-word"></span>
                        <span class="cursor">|</span>
                    </span>
                </h2>
            </div>
        </section>

        <section class="mid-gallery-section">
            <div class="swiper midGallerySlider">
                <div class="swiper-wrapper">

                    @foreach($galleryImages as $image)
                        <div class="swiper-slide">
                            <div class="gallery-slide">
                                <img src="{{ asset($image->image) }}" alt="Gallery Image">
                            </div>
                        </div>
                    @endforeach

                </div>

                <!-- navigation -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>

                <!-- pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </section>
        <section class="updates-section">
            <div class="container-fluid px-5">
                <div class="mb-4 text-start">
                    <h2 class="section-heading activities-main-heading">
                        Our Key <span>Offerings</span>
                    </h2>
                </div>

                <div class="safran-activities-wrapper">
                    <!-- CARD 1: PARACHUTES -->
                    <a href="{{ route('products.index', ['offering' => 'parachutes']) }}" class="safran-activity-card">
                        <div class="card-bg" style="background-image: url('/uploads/media/images/hd_su30_brake_parachute.jpg');"></div>
                        <div class="card-overlay"></div>
                        <div class="card-content">
                            <h3 class="card-title">Parachutes & Aerial Delivery</h3>
                            <div class="card-details">
                                <p class="card-description">Pioneers in manufacturing state-of-the-art paratrooper, brake, cargo, and heavy platform recovery parachute systems for global defense forces.</p>
                                <span class="card-action-btn">Explore Parachutes</span>
                            </div>
                        </div>
                    </a>

                    <!-- CARD 2: RUBBER INFLATABLES -->
                    <a href="{{ route('products.index', ['offering' => 'rubber-inflatables']) }}" class="safran-activity-card">
                        <div class="card-bg" style="background-image: url('/uploads/media/images/hd_baplw_assault_boat.jpg');"></div>
                        <div class="card-overlay"></div>
                        <div class="card-content">
                            <h3 class="card-title">Tactical Inflatable Systems</h3>
                            <div class="card-details">
                                <p class="card-description">High-durability military assault boats, Gemini crafts, and pneumatic float assemblies designed for tactical crossings and riverine operations.</p>
                                <span class="card-action-btn">Explore Inflatables</span>
                            </div>
                        </div>
                    </a>

                    <!-- CARD 3: TECHNICAL CLOTHING -->
                    <a href="{{ route('products.index', ['offering' => 'technical-clothing']) }}" class="safran-activity-card">
                        <div class="card-bg" style="background-image: url('/uploads/media/images/hd_indian_clothing.jpg');"></div>
                        <div class="card-overlay"></div>
                        <div class="card-content">
                            <h3 class="card-title">Technical Clothing & Equipment</h3>
                            <div class="card-details">
                                <p class="card-description">Advanced protective combat clothing, nuclear-biological-chemical (NBC) suits, and extreme cold climate survival gear built to save lives.</p>
                                <span class="card-action-btn">Explore Equipment</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <div class="container">
            <div class="horizontal-row"></div>
        </div>

    </section>

    <section class="our-unit-section">
        <div class="container">
            <h2 class="unit-title">
                Our <span>Unit</span>
            </h2>

            <div class="row align-items-start g-4 mt-4">

                <!-- LEFT VIDEO -->
                <div class="col-lg-7 mt-0">
                    <div class="unit-video-box" id="unitVideoBox">
                        @if($ourUnit?->video)
                            <video id="unitMainVideo" preload="metadata" autoplay muted playsinline>
                                <source src="{{ asset('uploads/our_units/' . $ourUnit->video) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>

                            <button id="unitPlayBtn" class="unit-play-btn" aria-label="Play Video">Play</button>
                        @endif
                    </div>
                </div>

                <!-- RIGHT CONTENT -->
                <div class="col-lg-5 mt-0">
                    <div class="unit-content">
                        <small>{{ $ourUnit?->heading }}</small>

                        <h3>{{ $ourUnit?->sub_heading }}</h3>

                        <div class="unit-description">
                            {!! \App\Support\Security::cleanHtml($ourUnit?->description) !!}
                        </div>

                        <div class="unit-points">
                            <p>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17 19H19V14H10V5H5V7H7V9H5V11H8V13H5V15H7V17H5V19H7V17H9V19H11V16H13V19H15V17H17V19ZM12 12H20C20.5523 12 21 12.4477 21 13V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V4C3 3.44772 3.44772 3 4 3H11C11.5523 3 12 3.44772 12 4V12Z"
                                        fill="#EE6802" />
                                </svg>
                                <span>
                                    <strong>Scale:</strong> Massive production floor for large-scale military orders.
                                </span>
                            </p>

                            <p>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 20.8995L16.9497 15.9497C19.6834 13.2161 19.6834 8.78392 16.9497 6.05025C14.2161 3.31658 9.78392 3.31658 7.05025 6.05025C4.31658 8.78392 4.31658 13.2161 7.05025 15.9497L12 20.8995ZM12 23.7279L5.63604 17.364C2.12132 13.8492 2.12132 8.15076 5.63604 4.63604C9.15076 1.12132 14.8492 1.12132 18.364 4.63604C21.8787 8.15076 21.8787 13.8492 18.364 17.364L12 23.7279ZM12 13C13.1046 13 14 12.1046 14 11C14 9.89543 13.1046 9 12 9C10.8954 9 10 9.89543 10 11C10 12.1046 10.8954 13 12 13ZM12 15C9.79086 15 8 13.2091 8 11C8 8.79086 9.79086 7 12 7C14.2091 7 16 8.79086 16 11C16 13.2091 14.2091 15 12 15Z"
                                        fill="#EE6802" />
                                </svg>
                                <span>
                                    <strong>Location:</strong> Kanpur, Uttar Pradesh (Industrial Hub)

                                </span>
                            </p>

                            <p>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17.0027 1.21094L18.3215 3.68377L20.7943 5.00261L18.3215 6.32145L17.0027 8.79428L15.6838 6.32145L13.211 5.00261L15.6838 3.68377L17.0027 1.21094ZM10.6693 9.33594L15.6693 12.0026L10.6693 14.6693L8.0026 19.6693L5.33593 14.6693L0.335938 12.0026L5.33593 9.33594L8.0026 4.33594L10.6693 9.33594ZM11.4193 12.0026L9.191 10.8142L8.0026 8.58594L6.81419 10.8142L4.58593 12.0026L6.81419 13.191L8.0026 15.4193L9.191 13.191L11.4193 12.0026ZM19.6693 16.336L18.0027 13.211L16.336 16.336L13.211 18.0026L16.336 19.6693L18.0027 22.7943L19.6693 19.6693L22.7943 18.0026L19.6693 16.336Z"
                                        fill="#EE6802" />
                                </svg>
                                <span>
                                    <strong>Heritage:</strong> Over 8 decades of serving the Indian Armed Forces.
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="linear-background-2">
        <section class="management-section">
            <div class="container">

                <h2 class="management-title">
                    Leadership and <span>Command</span>
                </h2>

                <div class="swiper managementSlider">
                    <div class="swiper-wrapper">

                        <!-- @foreach($leaders as $index => $leader)
                                                    <div class="swiper-slide">

                                                        <div id="leader-{{ $leader->id }}" class="leader-card 
                                                                                {{ $index == 1 ? 'center-card' : 'side-card' }}">

                                                            <div class="top-badge {{ $index == 1 ? 'center-badge' : 'side-badge' }}">
                                                                {{ strtoupper(\Illuminate\Support\Str::limit($leader->role, 36, '...')) }}
                                                            </div>

                                                            <div class="leader-img">
                                                                <img src="{{ asset('uploads/milestones/' . optional($leader->milestones->first())->image) }}"
                                                                    alt="{{ $leader->leader_name }}"
                                                                    onerror="this.src='{{ asset('images/default-user.png') }}'">
                                                            </div>

                                                            <h3>{{ $leader->leader_name }}</h3>

                                                            <h5>{{ $leader->sub_title }}</h5>

                                                            <div class="milestone-box">
                                                                @foreach($leader->milestones->take(2) as $milestone)
                                                                    <div class="milestone-item">
                                                                        <strong>{{ $milestone->heading }}</strong>
                                                                        <p>
                                                                            {!! Str::limit(strip_tags($milestone->description), 60) !!}
                                                                        </p>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            <a href="{{ route('about', ['tab' => 'leadership']) }}#leader-{{ $leader->id }}"
                                                                class="profile-btn">
                                                                View Profile
                                                            </a>

                                                        </div>

                                                    </div>
                                                @endforeach -->


                        @foreach($leaders as $index => $leader)
                            <div class="swiper-slide">

                                <div id="leader-{{ $leader->id }}" class="leader-card center-card">

                                    <div class="top-badge center-badge">
                                        {{ strtoupper(\Illuminate\Support\Str::limit($leader->role, 36, '...')) }}
                                    </div>

                                    <div class="leader-img">
                                        <img src="{{ $leader->picture ? asset('uploads/leadership/' . $leader->picture) : asset('frontend/images/avatar/user-account.jpg') }}"
                                            alt="{{ $leader->leader_name }}"
                                            onerror="this.src='{{ asset('frontend/images/avatar/user-account.jpg') }}'">
                                    </div>

                                    <h3>{{ $leader->leader_name }}</h3>

                                    <h5>{{ $leader->sub_title }}</h5>

                                    <a href="{{ route('about', ['tab' => 'leadership']) }}#leader-{{ $leader->id }}"
                                        class="profile-btn">
                                        View Profile
                                    </a>

                                </div>

                            </div>
                        @endforeach

                    </div>
                    
                    <!-- Navigation Buttons & Pagination -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>
        </section>

        <!-- <div class="section-divider">
                                                            <span></span>
                                                        </div> -->

        <!-- <div class="section-divider">
                                                            <span></span>
                                                        </div> -->

        <section class="trusted-forces-section">
            <div class="container">
                <div class="section-heading-wrap">
                    <h2 class="trusted-title">
                        <span class="text-white">Our Business</span> <span>Partners</span>
                    </h2>
                </div>

                @if($ourPartners->count() > 4)
                    <!-- Slider Layout for Business Partners -->
                    <div class="swiper trustedForcesSlider py-3" style="overflow: hidden;">
                        <div class="swiper-wrapper">
                            @foreach($ourPartners as $partner)
                                <div class="swiper-slide">
                                    <div class="force-card-container">
                                        @include('frontend.home.partials.partner-card', ['partner' => $partner])
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination forces-swiper-pagination mt-4 text-center"></div>
                    </div>
                @else
                    <!-- Static Grid Layout for Business Partners -->
                    <div class="trusted-forces-grid">
                        @foreach($ourPartners as $partner)
                            <div class="force-card-container">
                                @include('frontend.home.partials.partner-card', ['partner' => $partner])
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <!-- <div class="section-divider">
                                                                                            <span></span>
                                                                                        </div> -->

        <section class="certification-section">
            <div class="container">
                <div class="certification-heading-wrap">
                    <h2 class="certification-title">
                        Certification & <span>Quality Assurance</span>
                    </h2>
                </div>

                @php
                    $qualityCertificates = [
                        ['image' => 'opf-quality-certificate-01.png', 'page' => 1, 'title' => 'ISO 9001:2015 Quality Management System'],
                        ['image' => 'opf-quality-certificate-02.png', 'page' => 2, 'title' => 'ISO 14001:2015 Environmental Management System'],
                        ['image' => 'opf-quality-certificate-03.png', 'page' => 3, 'title' => 'ISO 45001:2018 Occupational Health & Safety'],
                        ['image' => 'opf-quality-certificate-04.png', 'page' => 4, 'title' => 'AS 9100D & ISO 9001:2015 Aerospace Quality'],
                        ['image' => 'opf-quality-certificate-05.png', 'page' => 5, 'title' => 'DGAQA-AFQMS-2018 Approval'],
                    ];
                @endphp

                <div class="certification-grid certification-document-grid">
                    @foreach($qualityCertificates as $certificate)
                        <a class="cert-card cert-document-card"
                           href="{{ asset('frontend/documents/OPF-Quality-Certificates-2026.pdf') }}#page={{ $certificate['page'] }}"
                           target="_blank" rel="noopener"
                           aria-label="View {{ $certificate['title'] }} certificate">
                            <div class="cert-logo cert-document-preview">
                                <img src="{{ asset('frontend/images/certificates/' . $certificate['image']) }}"
                                     alt="{{ $certificate['title'] }} certificate">
                            </div>
                            <h4>{{ $certificate['title'] }}</h4>
                            <span class="cert-view-link">View certificate</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- <div class="section-divider py-3">
                                                                                            <span></span>
                                                                                        </div> -->

        <section class="contact-news-section" id="contact-support-section">
            <div class="container">
                <div class="row g-4">

                    <!-- LEFT CONTACT FORM -->
                    <div class="col-lg-6">
                        <div class="contact-box">
                            <h2>Contact <span>Us</span></h2>

                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('contact.store') }}" method="POST">
                                @csrf
                                {{-- Honeypot: hidden from humans; bots that fill it are rejected --}}
                                <div style="position:absolute; left:-9999px; top:-9999px;" aria-hidden="true">
                                    <label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                                </div>

                                <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
                                <input type="text" name="company_name" placeholder="Company Name" value="{{ old('company_name') }}">
                                <input type="text" name="location" placeholder="Location" value="{{ old('location') }}">
                                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                                <input type="text" name="phone" placeholder="Phone Number" value="{{ old('phone') }}" required>
                                <textarea name="message" rows="5" placeholder="Message" required>{{ old('message') }}</textarea>

                                <x-visual-captcha context="public" :dark="true" />

                                <button type="submit">Send message</button>
                            </form>
                        </div>
                    </div>

                    <!-- RIGHT NEWS SLIDER (BLOGS) -->
                    <div class="col-lg-6">
                        <div class="activities-box">
                            <h2>Our <span>Blogs</span></h2>

                            <div class="swiper newsSlider">
                                <div class="swiper-wrapper">

                                    @forelse($blogArticles as $news)
                                        <div class="swiper-slide">
                                            <div class="news-card">
                                                <div class="news-card-img-wrap">
                                                    <img src="/uploads/news/{{ $news->wallpaper }}" alt="{{ $news->title }}">
                                                </div>

                                                <div class="news-card-body">
                                                    <h4>{{ Str::limit(strip_tags($news->title), 60) }}</h4>

                                                    <div class="news-meta">
                                                        <span class="news-date">
                                                            {{ \Carbon\Carbon::parse($news->publish_date)->format('d M Y') }}
                                                        </span>
                                                        <span class="news-author">
                                                            By {{ $news->author }}
                                                        </span>
                                                    </div>

                                                    <p>{{ Str::limit(strip_tags($news->content), 120) }}</p>

                                                    <a href="{{ route('news.show', $news->id) }}" class="news-btn">
                                                        Read Article →
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="swiper-slide">
                                            <div class="news-card">
                                                <div class="news-card-body">
                                                    <h4>No blog posts yet</h4>
                                                    <p>New blogs will appear here as soon as they are published.</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse

                                </div>
                                <!-- Add Pagination -->
                                <div class="swiper-pagination news-swiper-pagination mt-3"></div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- SAFRAN-STYLE NEWS CATEGORIES SECTION -->
        <section class="news-categories-section py-5">
            <div class="container-fluid px-5">
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <h2 class="section-heading activities-main-heading m-0">
                        News
                    </h2>
                    <!-- Category Swiper Navigation -->
                    <div class="cat-swiper-nav d-flex gap-2">
                        <div class="swiper-button-prev cat-swiper-prev" style="position: static; margin: 0; width: 44px; height: 44px; border-radius: 50%; background: #fff; border: 1px solid rgba(0,0,0,0.1); color: #EE6802;"></div>
                        <div class="swiper-button-next cat-swiper-next" style="position: static; margin: 0; width: 44px; height: 44px; border-radius: 50%; background: #fff; border: 1px solid rgba(0,0,0,0.1); color: #EE6802;"></div>
                    </div>
                </div>

                @php
                    // Drop the empty duplicate "latest" category (kept resilient by name in case the
                    // DB row still lingers in production); the real "Latest Updates" drives Recent Updates.
                    // Blogs is excluded here because it now has its own section beside "Contact Us".
                    $newsCategories = \App\Models\NewsCategory::whereRaw('LOWER(TRIM(name)) NOT IN (?, ?)', ['latest', 'blogs'])->get();

                    // Respect election mode so the homepage never surfaces an article the detail page
                    // hides (which would 404). Mirrors FNewsController.
                    $isElectionMode = \App\Models\GeneralSetting::isElectionMode();
                    $catBackgrounds = [
                        1 => '/uploads/media/images/hd_indian_parachute.jpg',   // Breaking
                        3 => '/uploads/media/images/hd_news_events.jpg',       // Blogs
                        5 => '/uploads/media/images/hd_news_press.jpg',        // Latest Updates -> Recent Updates
                        6 => '/uploads/media/images/hd_indian_inflatable.jpg',  // Press Releases
                    ];
                @endphp

                <div class="swiper newsCategorySlider">
                    <div class="swiper-wrapper">
                        @foreach($newsCategories as $cat)
                            @php
                                $fallbackBg = $catBackgrounds[$cat->id] ?? '/uploads/media/images/hd_news_breaking.jpg';
                                $displayName = in_array(strtolower(trim($cat->name)), ['latest', 'latest updates'])
                                    ? 'Recent Updates'
                                    : ($cat->name == 'Breaking' ? 'Breaking News' : $cat->name);

                                // The "Recent Updates" card aggregates the newest articles across ALL
                                // categories; every other card shows the latest articles of its own category.
                                $isLatestCard = strtolower(trim($cat->name)) === 'latest updates';

                                if ($isLatestCard) {
                                    $catArticles = \App\Models\NewsArticle::where('status', 'Published')
                                        ->when($isElectionMode, fn($q) => $q->where('hide_during_election', false))
                                        ->latest()
                                        ->take(2)
                                        ->get();
                                    $cardHref = url('/news');
                                } else {
                                    $catArticles = \App\Models\NewsArticle::where('category_id', $cat->id)
                                        ->where('status', 'Published')
                                        ->when($isElectionMode, fn($q) => $q->where('hide_during_election', false))
                                        ->latest()
                                        ->take(2)
                                        ->get();
                                    $cardHref = url('/news/category/' . $cat->id);
                                }

                                // Use the newest article's wallpaper for the card background. Keep the
                                // category artwork as a resilient fallback when an article has no image.
                                $defaultArticle = $catArticles->first();
                                $bg = $defaultArticle?->wallpaper
                                    ? asset('uploads/news/' . $defaultArticle->wallpaper)
                                    : asset($fallbackBg);
                            @endphp
                            <div class="swiper-slide">
                                <div class="safran-cat-card" data-href="{{ $cardHref }}" onclick="if(!event.target.closest('.cat-thumbnail-item')) { window.location.href = this.getAttribute('data-href'); }">
                                    <div class="card-bg" style="background-image: url('{{ $bg }}');" aria-hidden="true"></div>
                                    <div class="card-overlay"></div>
                                    <div class="card-content">
                                        <h3 class="card-title">{{ $displayName }}</h3>
                                        
                                        <!-- News thumbnails section inside card -->
                                        <div class="cat-thumbnails-wrapper">
                                            @if(isset($catArticles[0]))
                                                <a href="{{ route('news.show', $catArticles[0]->id) }}" class="cat-thumbnail-item is-active" data-wallpaper="{{ $catArticles[0]->wallpaper ? asset('uploads/news/' . $catArticles[0]->wallpaper) : '' }}" aria-current="true">
                                                    <div class="cat-thumbnail-img" style="background-image: url('{{ $catArticles[0]->wallpaper ? asset('uploads/news/' . $catArticles[0]->wallpaper) : $bg }}');"></div>
                                                    <span class="cat-thumbnail-title">{{ Str::limit($catArticles[0]->title, 32) }}</span>
                                                </a>
                                            @endif
                                            @if(isset($catArticles[1]))
                                                <a href="{{ route('news.show', $catArticles[1]->id) }}" class="cat-thumbnail-item" data-wallpaper="{{ $catArticles[1]->wallpaper ? asset('uploads/news/' . $catArticles[1]->wallpaper) : '' }}">
                                                    <div class="cat-thumbnail-img" style="background-image: url('{{ $catArticles[1]->wallpaper ? asset('uploads/news/' . $catArticles[1]->wallpaper) : $bg }}');"></div>
                                                    <span class="cat-thumbnail-title">{{ Str::limit($catArticles[1]->title, 32) }}</span>
                                                </a>
                                            @endif
                                        </div>

                                        <div class="see-more-wrap">
                                            <div class="vertical-line"></div>
                                            <span class="see-more-text">VIEW MORE</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination cat-swiper-pagination mt-4 text-center"></div>
                </div>
            </div>
        </section>

        <section class="partner-slider-section">
            <div class="container">
                <div class="partner-slider-wrapper">
                    <!-- SLIDER -->
                    <div class="swiper partnerSlider">
                        <div class="swiper-wrapper">
                            @foreach($partnerLogos as $logo)
                                <div class="swiper-slide">
                                    <div class="partner-logo-box">
                                        <img src="{{ asset($logo->image) }}" alt="Partner Logo">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- navigation -->
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>

                <!-- PLAY PAUSE -->
                <div class="slider-control-wrap">
                    <button id="partnerPlayPause" class="slider-play-btn">
                        ❚❚
                    </button>
                </div>

            </div>
        </section>

    </section>



@endsection


@section('scripts')
    <!-- <script>
                                                        new Swiper(".productSlider", {
                                                        slidesPerView: 4,
                                                        spaceBetween: 20,
                                                        loop: true,
                                                        effect: "coverflow",
                                                        coverflowEffect: {
                                                            rotate: 12,
                                                            stretch: 0,
                                                            depth: 120,
                                                            modifier: 1,
                                                            slideShadows: false,
                                                        },
                                                        navigation: {
                                                            nextEl: ".swiper-button-next",
                                                            prevEl: ".swiper-button-prev",
                                                        },
                                                        breakpoints: {
                                                            320: { slidesPerView: 1 },
                                                            768: { slidesPerView: 2 },
                                                            1200: { slidesPerView: 4 }
                                                        }
                                                    });
                                                    </script> -->

    <script>
        var swiperOptions = {
            slidesPerView: 4,
            spaceBetween: 25,
            loop: false,
            allowTouchMove: true,

            navigation: {
                nextEl: ".product-slider-next",
                prevEl: ".product-slider-prev",
            },

            breakpoints: {
                320: {
                    slidesPerView: 1
                },
                576: {
                    slidesPerView: 2
                },
                768: {
                    slidesPerView: 3
                },
                1200: {
                    slidesPerView: 4
                }
            }
        };

        var swiper = new Swiper(".productSlider", swiperOptions);
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const counters = document.querySelectorAll(".counter");

            const animateCounter = (counter) => {
                const target = +counter.getAttribute("data-target");
                const prefix = counter.getAttribute("data-prefix") || "";
                const suffix = counter.getAttribute("data-suffix") || "";
                let count = 0;

                const speed = target / 300;

                const updateCounter = () => {
                    count += speed;

                    if (count < target) {
                        counter.innerText = prefix + Math.ceil(count) + suffix;
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.innerText = prefix + target + suffix;
                    }
                };

                updateCounter();
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.5
            });

            counters.forEach(counter => {
                observer.observe(counter);
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const video = document.getElementById("midVideo");
            const section = document.querySelector(".mid-video-section");
            const btn = document.getElementById("videoControlBtn");

            function updateButton() {
                if (video.paused) {
                    btn.innerHTML = "▶";
                    section.classList.remove("playing");
                } else {
                    btn.innerHTML = "❚❚";
                    section.classList.add("playing");
                }
            }

            btn.addEventListener("click", function (e) {
                e.stopPropagation();

                if (video.paused) {
                    video.play();
                } else {
                    video.pause();
                }

                updateButton();
            });

            section.addEventListener("click", function () {
                if (video.paused) {
                    video.play();
                } else {
                    video.pause();
                }

                updateButton();
            });

            video.addEventListener("play", updateButton);
            video.addEventListener("pause", updateButton);

            updateButton();
        });
    </script>

    <script>
        new Swiper(".offeringSlider", {
            slidesPerView: 3,
            spaceBetween: 15,
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false
            },
            navigation: {
                nextEl: ".offeringSlider .swiper-button-next",
                prevEl: ".offeringSlider .swiper-button-prev",
            },
            pagination: {
                el: ".offeringSlider .swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                320: { slidesPerView: 1 },
                576: { slidesPerView: 2 },
                992: { slidesPerView: 3 }
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            new Swiper(".managementSlider", {
                slidesPerView: 3,
                spaceBetween: 30,
                centeredSlides: false,
                loop: false,
                navigation: {
                    nextEl: ".management-section .swiper-button-next",
                    prevEl: ".management-section .swiper-button-prev",
                },
                pagination: {
                    el: ".management-section .swiper-pagination",
                    clickable: true,
                },
                breakpoints: {
                    320: {
                        slidesPerView: 1
                    },
                    768: {
                        slidesPerView: 2
                    },
                    1200: {
                        slidesPerView: 3
                    }
                }
            });
        });
    </script>

    <script>
        new Swiper(".newsSlider", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false
            },
            pagination: {
                el: '.news-swiper-pagination',
                clickable: true
            }
        });

        // Facebook embedded-post slider (one post at a time). loop:false to avoid
        // Swiper cloning the fb-post embeds; autoHeight for varying post sizes.
        if (document.querySelector(".fbPostSlider")) {
            const fbSwiper = new Swiper(".fbPostSlider", {
                slidesPerView: 1,
                spaceBetween: 12,
                loop: false,
                autoHeight: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false
                },
                navigation: {
                    nextEl: ".fbp-next",
                    prevEl: ".fbp-prev"
                },
                pagination: {
                    el: ".fbp-pagination",
                    clickable: true
                }
            });

            // Facebook embeds load asynchronously; recalc slider height once they render.
            if (window.FB && window.FB.Event) {
                window.FB.Event.subscribe('xfbml.render', function () {
                    setTimeout(function () { fbSwiper.update(); }, 300);
                });
            }
        }

        // Initialize Safran-style Category Slider
        new Swiper(".newsCategorySlider", {
            slidesPerView: 3,
            spaceBetween: 25,
            loop: false,
            navigation: {
                nextEl: ".cat-swiper-next",
                prevEl: ".cat-swiper-prev"
            },
            pagination: {
                el: ".cat-swiper-pagination",
                clickable: true
            },
            breakpoints: {
                320: { slidesPerView: 1, spaceBetween: 15 },
                768: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 3, spaceBetween: 25 }
            }
        });

        // Article thumbnails act as wallpaper selectors. The active article remains a normal
        // link, while selecting another article first updates the card background.
        document.querySelectorAll('.safran-cat-card').forEach(function (card) {
            const background = card.querySelector('.card-bg');
            const articles = Array.from(card.querySelectorAll('.cat-thumbnail-item'));

            articles.forEach(function (article) {
                article.addEventListener('click', function (event) {
                    if (article.classList.contains('is-active')) {
                        return;
                    }

                    event.preventDefault();
                    articles.forEach(function (item) {
                        item.classList.remove('is-active');
                        item.removeAttribute('aria-current');
                    });
                    article.classList.add('is-active');
                    article.setAttribute('aria-current', 'true');

                    const wallpaper = article.getAttribute('data-wallpaper');
                    if (wallpaper && background) {
                        // Brief fade-out, swap the image, then fade back in.
                        background.classList.add('is-swapping');
                        window.setTimeout(function () {
                            background.style.backgroundImage = `url("${wallpaper}")`;
                            background.classList.remove('is-swapping');
                        }, 180);
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const video = document.getElementById("unitMainVideo");
            const btn = document.getElementById("unitPlayBtn");
            const box = document.getElementById("unitVideoBox");

            video.muted = true;

            video.play().then(() => {
                btn.innerHTML = "❚❚";
                box.classList.add("playing");
            }).catch(err => {
                console.log("Autoplay blocked:", err);
            });

            function updateUI() {
                if (video.paused) {
                    btn.innerHTML = "▶";
                    box.classList.remove("playing");
                } else {
                    btn.innerHTML = "❚❚";
                    box.classList.add("playing");
                }
            }

            btn.addEventListener("click", function (e) {
                e.stopPropagation();
                video.paused ? video.play() : video.pause();
            });

            box.addEventListener("click", function () {
                video.paused ? video.play() : video.pause();
            });

            video.addEventListener("play", updateUI);
            video.addEventListener("pause", updateUI);

            updateUI();
        });
    </script>



    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const video = document.getElementById("heroVideo");
            const heroSection = document.querySelector(".hero-banner");

            if (!video || !heroSection) {
                return;
            }

            let userPaused = false;

            video.muted = true;
            video.play().catch(() => { });

            const stopButton = document.getElementById("heroVideoStop");

            function activateHeroVideo() {
                heroSection.classList.add("video-interacted");

                // Browsers block audible autoplay; the first direct interaction
                // with the video is the user's signal to turn the soundtrack on.
                if (video.muted) {
                    video.muted = false;
                    video.volume = 1;
                    userPaused = false;
                    if (video.paused) video.play().catch(() => { });
                    return;
                }

                if (video.paused) {
                    video.play().catch(() => { });
                    userPaused = false;
                } else {
                    video.pause();
                    userPaused = true;
                }
            }

            // The decorative overlay sits above the video in the hero stack,
            // so handle clicks at the section level while leaving links/buttons alone.
            heroSection.addEventListener("click", function (event) {
                if (event.target.closest("a, button, input, select, textarea")) return;
                activateHeroVideo();
            });
            video.addEventListener("keydown", function (event) {
                if (event.key === "Enter" || event.key === " ") {
                    event.preventDefault();
                    activateHeroVideo();
                }
            });

            stopButton?.addEventListener("click", function (event) {
                event.stopPropagation();
                video.pause();
                userPaused = true;
            });

            // =========================
            // SCROLL CONTROL
            // =========================
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {

                    if (entry.isIntersecting) {

                        if (!userPaused) {
                            video.play();
                        }

                    } else {
                        video.pause();
                    }

                });
            }, { threshold: 0.5 });

            observer.observe(heroSection);

        });
    </script>

    <script>
        new Swiper('.midGallerySlider', {
            loop: true,
            margin: 0,
            // autoplay: {
            //     delay: 3000,
            //     disableOnInteraction: false
            // },
            speed: 900,
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const partnerSwiper = new Swiper(".partnerSlider", {
                loop: true,
                slidesPerView: 5,
                spaceBetween: 30,
                speed: 1200,
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                },
                // navigation: {
                //     nextEl: ".partner-next",
                //     prevEl: ".partner-prev",
                // },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                breakpoints: {
                    320: {
                        slidesPerView: 2
                    },
                    576: {
                        slidesPerView: 3
                    },
                    768: {
                        slidesPerView: 4
                    },
                    992: {
                        slidesPerView: 5
                    }
                }
            });

            const playPauseBtn = document.getElementById("partnerPlayPause");
            let isPlaying = true;

            if (playPauseBtn) {
                playPauseBtn.addEventListener("click", function () {
                    if (isPlaying) {
                        partnerSwiper.autoplay.stop();
                        playPauseBtn.innerHTML = "▶";
                    } else {
                        partnerSwiper.autoplay.start();
                        playPauseBtn.innerHTML = "❚❚";
                    }
                    isPlaying = !isPlaying;
                });
            }

            if (document.querySelector(".trustedForcesSlider")) {
                new Swiper(".trustedForcesSlider", {
                    slidesPerView: 3,
                    spaceBetween: 26,
                    loop: true,
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: ".forces-swiper-pagination",
                        clickable: true
                    },
                    breakpoints: {
                        320: { slidesPerView: 1 },
                        576: { slidesPerView: 2 },
                        768: { slidesPerView: 2 },
                        992: { slidesPerView: 3 }
                    }
                });
            }

        });
    </script>

    <script>
        const words = ["Safety", "Efficiency", "Value"];
        let wordIndex = 0;
        let charIndex = 0;
        let isDeleting = false;

        const animatedWord = document.getElementById("animated-word");

        function typeEffect() {
            const currentWord = words[wordIndex];

            if (!isDeleting) {
                animatedWord.textContent = currentWord.substring(0, charIndex + 1);
                charIndex++;

                if (charIndex === currentWord.length) {
                    isDeleting = true;
                    setTimeout(typeEffect, 1200); // pause after full word
                    return;
                }
            } else {
                animatedWord.textContent = currentWord.substring(0, charIndex - 1);
                charIndex--;

                if (charIndex === 0) {
                    isDeleting = false;
                    wordIndex = (wordIndex + 1) % words.length;
                }
            }

            const speed = isDeleting ? 60 : 120;
            setTimeout(typeEffect, speed);
        }

        typeEffect();
    </script>

@endsection
