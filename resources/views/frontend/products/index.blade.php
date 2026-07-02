@extends('frontend.layouts.app')


@section('content')

    <section class="products-hero-section">
        <div class="products-overlay"></div>

        <div class="container-fluid p-0">
            <div class="row g-0 min-vh-100">

                <!-- LEFT SIDE TITLE -->
                <div class="col-lg-4">
                    <div class="products-left-panel">
                        <div class="products-left-content">
                            <h1>Products</h1>
                            <p>Explore Our Defence Product Categories</p>
                        </div>
                    </div>
                </div>

                <!-- RIGHT SIDE CATEGORY LIST -->
                <div class="col-lg-8">
                    <div class="products-right-panel">
                        <div class="category-list-wrapper">

                            @foreach($categories as $category)
                                <a href="{{ route('products.category', $category->id) }}" class="category-list-item">

                                    <span class="category-dot"></span>
                                    <span class="category-name">
                                        {{ $category->name }}
                                    </span>

                                </a>
                            @endforeach

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection