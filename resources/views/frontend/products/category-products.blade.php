@extends('frontend.layouts.app')

@section('content')

    <!-- CATEGORY HERO BANNER -->
    <section class="category-hero" style="background-image: url('{{ asset('uploads/category/' . $category->image) }}')">

        <div class="category-overlay"></div>

        <div class="container">
            <div class="category-hero-content">
                <!-- <p class="breadcrumb-text">
                                Home / Products / <span>{{ $category->name }}</span>
                            </p> -->

                <h1>{{ $category->name }}</h1>
            </div>
        </div>
    </section>

    <!-- PRODUCTS GRID -->
    <section class="category-products-section">
        <div class="container">

            <div class="section-title text-center mb-5">
                <h2>Our Products</h2>
            </div>

            <div class="row g-4">

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

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="premium-product-card {{ $themeClass }}" style="margin: 0 auto;">
                            <!-- Full background photo -->
                            <div class="card-bg-image">
                                <img src="{{ asset('uploads/products/' . optional($product->images->first())->image) }}" alt="{{ $product->title }}">
                            </div>

                            <!-- Top Right corner floating badge -->
                            <div class="floating-icon-badge">
                                {!! $iconSvg !!}
                            </div>

                            <!-- Background index number -->
                            <div class="card-index-num">
                                {{ sprintf('%02d', $loop->iteration) }}
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
        </div>
    </section>

@endsection