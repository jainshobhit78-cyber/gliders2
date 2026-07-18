@extends('frontend.layouts.app')

@section('content')

    @php
        $wallpaper = ($setting && $setting->products_page_wallpaper)
            ? asset('frontend/images/' . $setting->products_page_wallpaper)
            : asset('frontend/images/products-bg-mockup.jpg');
        $tagline = ($setting && $setting->products_page_tagline) ? $setting->products_page_tagline : 'MISSION READY. ALWAYS.';
        $pageTitle = ($setting && $setting->products_page_title) ? $setting->products_page_title : 'Our Products';
        $pageSubtitle = ($setting && $setting->products_page_subtitle) ? $setting->products_page_subtitle : 'Engineered with precision. Trusted by the forces. Built for every mission and environment.';

        if ($definition) {
            $tagline = 'OUR OFFERINGS';
            $pageTitle = $definition['title'];
            $pageSubtitle = $definition['description'];
        }

        $exploreLabel = $definition ? 'Explore ' . $definition['title'] : 'Explore All Products';
    @endphp

    <section class="products-directory-section py-5" style="background: url('{{ $wallpaper }}?v={{ time() }}') no-repeat center center / cover !important;">
        
        <!-- RIGHT VERTICAL TEXT BORDER -->
        <div class="vertical-text-accent">
            BUILT FOR THE FORCES —
        </div>

        <div class="container py-4">
            
            <!-- HEADER AREA MATCHING MOCKUP -->
            <div class="row mb-5 align-items-end">
                <div class="col-lg-8">
                    <div class="mockup-header-box">
                        <div class="mission-badge mb-3">
                            <span class="badge-dot"></span>
                            {{ $tagline }}
                        </div>
                        <h1 class="mockup-title">{{ $pageTitle }}</h1>
                        <p class="mockup-subtitle">
                            {{ $pageSubtitle }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end mb-3">
                    <a href="#categories-grid" class="mockup-explore-btn">
                        {{ $exploreLabel }}
                        <span class="arrow-circle">→</span>
                    </a>
                </div>
            </div>

            @if($categories->isEmpty() && $definition)
                <div class="products-coming-soon-panel" id="categories-grid">
                    <span class="products-coming-soon-eyebrow">{{ $definition['title'] }}</span>
                    <h2>Coming Soon</h2>
                    <p>New {{ strtolower($definition['title']) }} will appear here when they are added.</p>
                </div>
            @else
                <!-- CATEGORY CARD GRID (MATCHING MOCKUP PIXEL-PERFECT) -->
                <div class="row g-4" id="categories-grid" style="position: relative; z-index: 5;">
                
                @foreach($categories as $category)
                    @php
                        $index = $loop->iteration;
                        // Mockup-matching custom copy and mappings
                        $subheading = 'AIRCRAFT SYSTEMS';
                        $description = 'High-performance braking systems designed for safe landings in critical operations.';
                        $iconSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 22px; height: 22px; color: #fff;"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>';

                        if (str_contains(strtolower($category->name), 'carrying') || str_contains(strtolower($category->name), 'personnel') || str_contains(strtolower($category->name), 'man')) {
                            $subheading = 'PERSONNEL SYSTEMS';
                            $description = 'Lightweight, reliable, and battle-tested parachutes for personnel deployment in any environment.';
                            $iconSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 22px; height: 22px; color: #fff;"><path d="M18 21a6 6 0 0 0-12 0"></path><circle cx="12" cy="10" r="4"></circle><path d="M12 2v2"></path></svg>';
                        } elseif (str_contains(strtolower($category->name), 'cargo') || str_contains(strtolower($category->name), 'delivery') || str_contains(strtolower($category->name), 'heavy')) {
                            $subheading = 'CARGO SYSTEMS';
                            $description = 'Heavy-load parachutes built for secure airdrops in the most demanding conditions.';
                            $iconSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 22px; height: 22px; color: #fff;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="3" x2="9" y2="21"></line><line x1="15" y1="3" x2="15" y2="21"></line><line x1="3" y1="9" x2="21" y2="9"></line><line x1="3" y1="15" x2="21" y2="15"></line></svg>';
                        } elseif (str_contains(strtolower($category->name), 'float') || str_contains(strtolower($category->name), 'boat') || str_contains(strtolower($category->name), 'rubber') || str_contains(strtolower($category->name), 'inflatable')) {
                            $subheading = 'FLOAT SYSTEMS';
                            $description = 'High-performance inflatable float assemblies and marine survival equipment.';
                            $iconSvg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 22px; height: 22px; color: #fff;"><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path><path d="M2 12h20"></path></svg>';
                        }
                    @endphp

                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{ route('products.category', $category->id) }}" class="mockup-card-link-wrapper">
                            <div class="mockup-category-card">
                                
                                <!-- Card Image -->
                                <div class="mockup-card-img-box">
                                    <img src="{{ asset('uploads/category/' . $category->image) }}" alt="{{ $category->name }}">
                                </div>

                                <!-- Dark Gradient overlay -->
                                <div class="mockup-card-overlay-mask"></div>

                                <!-- Top Left Icon badge -->
                                <div class="mockup-card-icon-badge">
                                    {!! $iconSvg !!}
                                </div>

                                <!-- Inner Content Area -->
                                <div class="mockup-card-content-box d-flex flex-column h-100">
                                    
                                    <!-- Uppercase Tag -->
                                    <span class="mockup-card-tag">{{ $subheading }}</span>

                                    <!-- Heading -->
                                    <h3 class="mockup-card-title">{{ $category->name }}</h3>

                                    <!-- Description -->
                                    <p class="mockup-card-desc">{{ $description }}</p>

                                    <!-- Bottom Row Action Elements -->
                                    <div class="mockup-card-action-row d-flex align-items-center justify-content-between mt-auto">
                                        <!-- Index number -->
                                        <div class="mockup-card-index">
                                            {{ sprintf('%02d', $index) }}
                                        </div>
                                        
                                        <!-- View Details pill button -->
                                        <div class="mockup-details-pill">
                                            View Details
                                        </div>

                                        <!-- Arrow circle button -->
                                        <div class="mockup-arrow-circle">
                                            →
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </a>
                    </div>
                @endforeach

                </div>
            @endif

        </div>
    </section>

@endsection
