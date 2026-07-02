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
                        <a href="{{ route('products.detail', [$category->id, $product->id]) }}" class="product-link-box">
                            <div class="solution-card">

                                <div class="solution-image">
                                    <img src="{{ asset('uploads/products/' . optional($product->images->first())->image) }}"
                                        alt="{{ $product->title }}">
                                </div>

                                <div class="solution-content">
                                    <div class="solution-circle">
                                        <h4>
                                            {{ \Illuminate\Support\Str::limit($product->title, 28) }}
                                        </h4>
                                    </div>

                                    <p>
                                        {!! \Illuminate\Support\Str::limit(strip_tags($product->description), 110) !!}
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