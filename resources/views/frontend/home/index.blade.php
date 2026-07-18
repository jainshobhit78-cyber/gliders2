@extends('frontend.layouts.app')

@section('content')

    <section class="hero-banner">
        @if($videoBanner?->banner_video)
            <video id="heroVideo" class="hero-video" autoplay muted loop playsinline>
                <source src="{{ asset('uploads/video_banner/' . $videoBanner->banner_video) }}" type="video/mp4">
            </video>
        @endif


        <div class="hero-overlay"></div>

        <!-- VIDEO CONTROL -->
        @if($videoBanner?->banner_video)
            <button id="videoToggleBtn" class="video-toggle-btn" type="button">Play</button>
        @endif

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
                        <h2 class="counter" data-target="{{ $stateCounter->parachutes_manufactured ?? 0 }}" data-suffix="+">
                            0</h2>
                        <p>Parachutes Manufactured</p>
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
                                $tagText = $product->delivery_tag ?: 'Aerial Delivery';
                                $dotColor = '#f5821f';
                                $iconSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px;"><circle cx="12" cy="12" r="10"></circle><line x1="22" y1="12" x2="18" y2="12"></line><line x1="6" y1="12" x2="2" y2="12"></line><line x1="12" y1="6" x2="12" y2="2"></line><line x1="12" y1="22" x2="12" y2="18"></line></svg>';

                                if ($index == 1) {
                                    $themeClass = 'theme-green';
                                    $tagText = $product->delivery_tag ?: 'Tactical Operations';
                                    $dotColor = '#48bb78';
                                    $iconSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px;"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>';
                                } elseif ($index == 2) {
                                    $themeClass = 'theme-blue';
                                    $tagText = $product->delivery_tag ?: 'Military Grade';
                                    $dotColor = '#4299e1';
                                    $iconSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px;"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>';
                                } elseif ($index == 3) {
                                    $themeClass = 'theme-purple';
                                    $tagText = $product->delivery_tag ?: 'Heavy Load';
                                    $dotColor = '#9f7aea';
                                    $iconSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px;"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>';
                                }
                            @endphp

                            <div class="swiper-slide">
                                <div class="premium-product-card {{ $themeClass }}">
                                    <!-- Full background photo -->
                                    <div class="card-bg-image">
                                        <img src="{{ asset('uploads/products/' . optional($product->images->first())->image) }}" alt="{{ $product->title }}">
                                    </div>

                                    <!-- Top Right corner floating badge -->
                                    <div class="floating-icon-badge">
                                        {!! $iconSvg !!}
                                    </div>

                                    <!-- Inner card content -->
                                    <div class="premium-card-content">
                                        <!-- Category Tag -->
                                        <div class="category-tag-pill">
                                            <span class="tag-dot" style="background-color: {{ $dotColor }};"></span>
                                            <span class="tag-label">{{ $tagText }}</span>
                                        </div>

                                        <!-- Title (H3) -->
                                        <h3 class="product-title-h3">
                                            {{ $product->title }}
                                        </h3>

                                        <!-- Short Description -->
                                        <p class="product-desc-p">
                                            {!! \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($product->description)), 90) !!}
                                        </p>

                                        <!-- Action view details pill button -->
                                        <div class="d-flex align-items-center gap-3">
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
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>

                    <!-- pagination -->
                    <div class="swiper-pagination"></div>
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
                <div class="row g-4">

                    <!-- KEY OFFERINGS -->
                    <div class="col-lg-5">
                        <div class="content-box">
                            <h2 class="section-heading">
                                Our <span>Offerings</span>
                            </h2>

                            <div class="swiper offeringSlider">
                                <div class="swiper-wrapper">

                                    @foreach($businessOfferings as $offering)
                                        <div class="swiper-slide">
                                            <div class="offering-card">
                                                <a href="{{ route('products.index', ['offering' => $offering['slug']]) }}">
                                                    @if($offering['image'])
                                                        <img src="{{ $offering['image'] }}" alt="{{ $offering['title'] }}">
                                                    @else
                                                        <div class="offering-coming-soon-art" aria-hidden="true">
                                                            <svg viewBox="0 0 64 64" fill="none">
                                                                <path d="M22 13 32 18l10-5 10 9-8 9v23H20V31l-8-9 10-9Z" stroke="currentColor" stroke-width="3" stroke-linejoin="round"/>
                                                                <path d="M27 16c0 4 2 7 5 7s5-3 5-7M20 31h24" stroke="currentColor" stroke-width="3"/>
                                                            </svg>
                                                            <span>Coming Soon</span>
                                                        </div>
                                                    @endif

                                                    <div class="offering-content">
                                                        <div class="offering-title">
                                                            {{ $offering['title'] }}
                                                        </div>
                                                    </div>
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
                    </div>

                    <!-- LATEST UPDATES -->
                    <div class="col-lg-3 content-border-box">
                        <div class="content-box">
                            <h2 class="section-heading">
                                Latest <span>Updates</span>
                            </h2>

                            <ul class="latest-list">
                                @foreach($latestNews as $news)
                                    <li>
                                        <a href="{{ route('news.category', $news->category_id) }}" class="news-link">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M7.75194 5.4392L18.2596 11.5687C18.4981 11.7078 18.5787 12.014 18.4396 12.2525C18.3961 12.327 18.3341 12.389 18.2596 12.4325L7.75194 18.562C7.51341 18.7011 7.20725 18.6205 7.06811 18.382C7.0235 18.3055 7 18.2186 7 18.1301V5.87109C7 5.59494 7.22386 5.37109 7.5 5.37109C7.58853 5.37109 7.67547 5.39459 7.75194 5.4392Z"
                                                    fill="#EE6802" />
                                            </svg>

                                            <span>{{ \Illuminate\Support\Str::limit($news->title, 120) }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="news-btn-wrap">
                                <a href="{{ route('news.categories') }}" class="view-news-btn">
                                    View All News
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- STATIC BLOCK -->
                    <div class="col-lg-4">
                        <a href="{{ route('news.categories') }}">
                            <div class="innovation-box">
                                <img src="{{ asset('frontend/images/innovation.png') }}" alt="Innovation">

                                <div class="innovation-overlay">
                                    <h2>
                                        Innovation & <span>Expertise</span>
                                    </h2>

                                    <p>
                                        Driving the Future of
                                        Defence Technology
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <div class="container">
            <div class="horizontal-row"></div>
        </div>

        <section class="media-release-section">
            <div class="container">
                <h2 class="section-title">
                    Media <span>Releases</span>
                </h2>
                <div class="row g-4">

                    <!-- LEFT LIVE TWITTER -->
                    <div class="col-lg-3">
                        <div class="twitter-box">
                            <h5 class="d-flex align-items-center">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <rect width="24" height="24" fill="url(#pattern0_2613_200)" />
                                    <defs>
                                        <pattern id="pattern0_2613_200" patternContentUnits="objectBoundingBox" width="1"
                                            height="1">
                                            <use xlink:href="#image0_2613_200" transform="scale(0.00195312)" />
                                        </pattern>
                                        <image id="image0_2613_200" width="512" height="512" preserveAspectRatio="none"
                                            xlink:href="data:image/png;base64,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" />
                                    </defs>
                                </svg>
                                <span class="ps-2">Latest Tweets</span>
                            </h5>
                            <div style="max-height: 440px; overflow-y: auto; border-radius: 8px;">
                                @php
                                    $twitterFeedUrl = $settings->twitter_feed_url ?? 'https://twitter.com/Twitter';
                                    $twitterFeedUrl = trim($twitterFeedUrl);
                                    if (!empty($twitterFeedUrl)) {
                                        if (str_starts_with($twitterFeedUrl, '@')) {
                                            $twitterFeedUrl = substr($twitterFeedUrl, 1);
                                        }
                                        if (!str_starts_with($twitterFeedUrl, 'http://') && !str_starts_with($twitterFeedUrl, 'https://')) {
                                            $twitterFeedUrl = 'https://twitter.com/' . $twitterFeedUrl;
                                        }
                                        $twitterFeedUrl = str_replace('x.com', 'twitter.com', $twitterFeedUrl);
                                    } else {
                                        $twitterFeedUrl = 'https://twitter.com/Twitter';
                                    }
                                @endphp
                                <a class="twitter-timeline" data-chrome="noheader nofooter transparent" href="{{ $twitterFeedUrl }}" data-height="430" data-theme="dark">Tweets</a>
                                <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                                
                                <div class="mt-2 py-3 border-top text-center">
                                    <a href="{{ str_replace('twitter.com', 'x.com', $twitterFeedUrl) }}" target="_blank" class="btn btn-outline-light btn-sm rounded-pill px-4" style="border-color: rgba(255,255,255,0.3); font-size: 14px; font-weight: 500;">
                                        View on X (Twitter)
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div><!-- RIGHT VIDEO -->
                    @if($playlists->count() > 0)
                        <div class="col-lg-9 media-box">
                            <div class="main-video-box" id="mainVideoBox">
                                <video id="mediaMainVideo" preload="metadata" autoplay muted playsinline>
                                    <source
                                        src="{{ asset('uploads/media/videos/' . ($playlists->first()?->videos?->first()?->video ?? '')) }}"
                                        type="video/mp4">
                                </video>

                                <button id="mediaPlayBtn" class="video-play-btn"><span class="me-2">▶</span></button>

                                <div class="video-overlay-text">
                                    <h3 id="mainHeading">{{ $playlists->first()?->heading ?? '' }}</h3>
                                </div>
                            </div>

                            <!-- PLAYLIST THUMBNAILS -->
                            <div class="swiper playlistSlider mt-3">
                                <div class="swiper-wrapper">

                                    @foreach($playlists as $playlist)
                                        <div class="swiper-slide">
                                            <div class="playlist-thumb"
                                                onclick="changeVideo(
                                                    '{{ asset('uploads/media/videos/' . ($playlist->videos?->first()?->video ?? '')) }}',
                                                    '{{ addslashes($playlist->heading) }}'
                                                )">

                                                <img src="{{ asset('uploads/media/images/' . ($playlist->images?->first()?->image ?? '')) }}"
                                                    alt="{{ $playlist->name }}">

                                                <div class="thumb-title">
                                                    {{ $playlist->name }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-lg-9 media-box">
                            <div class="main-video-box d-flex align-items-center justify-content-center" style="background: #111; height: 350px; border-radius: 8px;">
                                <div class="text-center text-muted">
                                    <p>No featured media available.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </section>
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

                <div class="trusted-forces-grid">

                    <div class="force-card">
                        <div class="force-logo">
                            <img src="{{ asset('frontend/images/section/4.png') }}" alt="India Army">
                        </div>
                        <h4>India Army</h4>
                    </div>

                    <div class="force-card">
                        <div class="force-logo">
                            <img src="{{ asset('frontend/images/section/3.png') }}" alt="Indian Air Force">
                        </div>
                        <h4>Indian Air Force</h4>
                    </div>

                    <div class="force-card">
                        <div class="force-logo">
                            <img src="{{ asset('frontend/images/section/2.png') }}" alt="DRDO">
                        </div>
                        <h4>DRDO</h4>
                    </div>

                    <div class="force-card">
                        <div class="force-logo">
                            <img src="{{ asset('frontend/images/section/1.png') }}" alt="Vietnam Air Force">
                        </div>
                        <h4>Vietnam Air Force</h4>
                    </div>

                </div>
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

                <div class="certification-grid">

                    <div class="cert-card">
                        <div class="cert-logo">
                            <img src="{{ asset('frontend/images/section/5.png') }}" alt="Quality Management System">
                        </div>
                        <h4>Quality Management System</h4>
                    </div>

                    <div class="cert-card">
                        <div class="cert-logo">
                            <img src="{{ asset('frontend/images/section/6.png') }}" alt="Directorate General of Assurance">
                        </div>
                        <h4>Directorate General of Assurance</h4>
                    </div>

                    <div class="cert-card">
                        <div class="cert-logo">
                            <img src="{{ asset('frontend/images/section/7.png') }}" alt="International Accreditation Forum">
                        </div>
                        <h4>International Accreditation Forum</h4>
                    </div>

                    <div class="cert-card">
                        <div class="cert-logo">
                            <img src="{{ asset('frontend/images/section/8.png') }}" alt="Directorate General AQPR">
                        </div>
                        <h4>Directorate General AQPR:Q9000</h4>
                    </div>

                    <div class="cert-card">
                        <div class="cert-logo">
                            <img src="{{ asset('frontend/images/section/9.png') }}" alt="Environmental Management System">
                        </div>
                        <h4>Environmental Management System</h4>
                    </div>

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

                                <input type="text" name="name" placeholder="Your Name" value="{{ old('name') }}" required>
                                <input type="text" name="company_name" placeholder="Company Name" value="{{ old('company_name') }}">
                                <input type="text" name="location" placeholder="Location" value="{{ old('location') }}">
                                <input type="email" name="email" placeholder="Your Email" value="{{ old('email') }}" required>
                                <input type="text" name="phone" placeholder="Phone Number" value="{{ old('phone') }}" required>
                                <textarea name="message" rows="5" placeholder="Your Message" required>{{ old('message') }}</textarea>

                                @error('captcha')
                                    <div class="alert alert-danger p-2" style="font-size: 13px; margin-bottom: 10px; background: rgba(220, 53, 69, 0.2); border: 1px solid rgba(220, 53, 69, 0.4); color: #ff8080;">{{ $message }}</div>
                                @enderror
                                <div class="captcha-wrapper mb-3" style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                                    <span style="color: #fff; white-space: nowrap; font-weight: 600;">Security Check: What is {{ session('captcha_num1') }} + {{ session('captcha_num2') }}?</span>
                                    <input type="number" name="captcha" placeholder="Answer" required style="margin: 0; width: 100px; padding: 8px; background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.3); border-radius: 4px;">
                                </div>

                                <button type="submit">Send message</button>
                            </form>
                        </div>
                    </div>

                    <!-- RIGHT NEWS SLIDER -->
                    <div class="col-lg-6">
                        <div class="activities-box">
                            <h2>Our <span>Activities</span></h2>

                            <div class="swiper newsSlider">
                                <div class="swiper-wrapper">

                                    @foreach($latestNews as $news)
                                        <div class="swiper-slide">
                                            <div class="news-card">
                                                <img src="{{ asset('uploads/news/' . $news->wallpaper) }}"
                                                    alt="{{ $news->title }}">

                                                <div class="news-card-body">
                                                    <h4>{{ Str::limit(strip_tags($news->title), 20) }}</h4>


                                                    <div class="news-meta">
                                                        <span class="news-date">
                                                            {{ \Carbon\Carbon::parse($news->publish_date)->format('d M Y') }}
                                                        </span>
                                                        <span class="news-author">
                                                            (By {{ $news->author }})
                                                        </span>
                                                    </div>

                                                    <p>{{ Str::limit(strip_tags($news->content), 120) }}</p>

                                                    <a href="{{ route('news.category', $news->category_id) }}" class="news-btn">
                                                        View More →
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                        </div>
                    </div>

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
        var autoSliderEnabled = {{ ($homeSetting->product_slider_auto ?? true) ? 'true' : 'false' }};

        var swiperOptions = {
            slidesPerView: 4,
            spaceBetween: 25,
            loop: autoSliderEnabled,

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },

            pagination: {
                el: ".swiper-pagination",
                clickable: true,
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

        if (autoSliderEnabled) {
            swiperOptions.autoplay = {
                delay: 2500,
                disableOnInteraction: false,
            };
        }

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
        function changeVideo(videoUrl, heading) {
            let video = document.getElementById('mediaMainVideo');
            let source = video.querySelector("source");
            let headingBox = document.getElementById('mainHeading');
            let btn = document.getElementById("mediaPlayBtn");
            let box = document.getElementById("mainVideoBox");

            source.src = videoUrl;
            video.load();

            video.play().then(() => {
                btn.innerHTML = "❚❚";
                box.classList.add("playing");
            }).catch(err => {
                console.log(err);
            });

            headingBox.innerText = heading;
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const video = document.getElementById("mediaMainVideo");
            const btn = document.getElementById("mediaPlayBtn");
            const box = document.getElementById("mainVideoBox");

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
        new Swiper(".playlistSlider", {
            slidesPerView: 4,
            spaceBetween: 15,
            loop: true,
            breakpoints: {
                320: { slidesPerView: 1 },
                576: { slidesPerView: 2 },
                768: { slidesPerView: 3 },
                1200: { slidesPerView: 4 }
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
            slidesPerView: 3,
            spaceBetween: 15,
            loop: true,
            autoplay: {
                delay: 2500
            },
            breakpoints: {
                320: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1200: { slidesPerView: 3 }
            }
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
            const btn = document.getElementById("videoToggleBtn");
            const heroSection = document.querySelector(".hero-banner");

            let userPaused = false;

            // 🔥 FORCE AUTOPLAY ON LOAD
            video.play().catch(() => { });

            // =========================
            // BUTTON CONTROL
            // =========================
            btn.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopPropagation();

                if (video.paused) {
                    video.play();
                    btn.innerHTML = '❚❚';
                    userPaused = false;
                } else {
                    video.pause();
                    btn.innerHTML = '▶';
                    userPaused = true;
                }
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

                        video.muted = false; // 🔊 unmute when visible

                    } else {

                        video.muted = true;  // 🔇 mute
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
