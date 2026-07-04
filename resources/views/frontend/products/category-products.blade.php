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
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="{{ route('products.detail', [$category->id, $product->id]) }}" class="solution-card-link">
                            <div class="premium-solution-card">
                                <!-- Upper Half: Image Wrap -->
                                <div class="solution-card-image-wrap">
                                    <img src="{{ asset('uploads/products/' . optional($product->images->first())->image) }}"
                                         alt="{{ $product->title }}">
                                </div>

                                <!-- Lower Half: Dark blue container with centered overlapping circle and description -->
                                <div class="solution-card-content-wrap">
                                    <!-- Centered decorative circle badge containing the title -->
                                    <div class="solution-card-circle-container">
                                        <div class="solution-card-circle-bg">
                                            <h3>{{ $product->title }}</h3>
                                        </div>
                                    </div>
                                    
                                    <!-- Product short description text -->
                                    <p class="solution-card-desc">
                                        {!! \Illuminate\Support\Str::limit(strip_tags($product->description), 80) !!}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

@endsection