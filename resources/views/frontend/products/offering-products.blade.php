@extends('frontend.layouts.app')

@section('content')
    <section class="offering-directory-hero">
        <div class="container text-center">
            <span class="offering-directory-kicker">Our Offerings</span>
            <h1>{{ $definition['title'] }}</h1>
            <p>{{ $definition['description'] }}</p>
        </div>
    </section>

    @if($products->isEmpty())
        <section class="offering-coming-soon-section">
            <div class="container text-center">
                <span class="coming-soon-eyebrow">{{ $definition['title'] }}</span>
                <h2>Coming Soon</h2>
                <p>Our team is preparing this product range. Please check back for future additions.</p>
                <a href="{{ route('products.index') }}" class="coming-soon-back-link">Explore Other Products</a>
            </div>
        </section>
    @else
        <section class="category-products-section offering-products-section">
            <div class="container">
                @if($categories->isNotEmpty())
                    <div class="offering-category-list" aria-label="Included product categories">
                        @foreach($categories as $category)
                            <span>{{ $category->name }}</span>
                        @endforeach
                    </div>
                @endif

                <div class="section-title text-center mb-5">
                    <h2>{{ $definition['title'] }} Products</h2>
                </div>

                <div class="row g-4">
                    @foreach($products as $product)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <a href="{{ route('products.detail', [$product->category_id, $product->id]) }}"
                                class="solution-card-link">
                                <div class="premium-solution-card">
                                    <div class="solution-card-image-wrap">
                                        @if(optional($product->images->first())->image)
                                            <img src="{{ asset('uploads/products/'.optional($product->images->first())->image) }}"
                                                alt="{{ $product->title }}">
                                        @else
                                            <div class="offering-product-image-placeholder">{{ $definition['title'] }}</div>
                                        @endif
                                    </div>

                                    <div class="solution-card-content-wrap">
                                        <div class="solution-card-circle-container">
                                            <div class="solution-card-circle-bg">
                                                <h3>{{ $product->title }}</h3>
                                            </div>
                                        </div>
                                        <p class="solution-card-desc">
                                            {{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($product->description)), 80) }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
