@extends('frontend.layouts.app')

@section('content')

    <!-- HERO BANNER -->
    <section class="product-hero" style="background-image: url('{{ asset('uploads/products/' . $product->wallpaper) }}')">

        <div class="hero-overlay"></div>

        <div class="container">
            <div class="detail-hero-content">
                <h1>{{ $product->title }}</h1>
            </div>
        </div>
    </section>

    <!-- PRODUCT DETAILS -->
    <section class="product-detail-section">
        <div class="container">
            <div class="row align-items-start g-5">

                <div class="col-lg-6">
                    <div class="product-info">
                        <h2>{{ $product->title }}</h2>

                        <div class="product-description">
                            {!! $product->description !!}
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="main-product-image">
                        <img src="{{ asset('uploads/products/' . optional($product->images->first())->image) }}"
                            alt="{{ $product->title }}">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- IMAGE GALLERY SLIDER -->
    <section class="gallery-section-full">

        <h2 class="gallery-title">Product Gallery</h2>

        <div class="swiper gallerySwiper">
            <div class="swiper-wrapper">

                @foreach($product->images as $image)
                    <div class="swiper-slide">
                        <div class="gallery-item">
                            <img src="{{ asset('uploads/products/' . $image->image) }}" alt="{{ $product->title }}">
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Pagination -->
            <div class="swiper-pagination"></div>

            <!-- Navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

    </section>

    <!-- EXPLORE MORE SECTION -->
    <section class="explore-more-section">
        <div class="container ">
            <h2 class="explore-title">Explore More</h2>

            <div class="swiper exploreSwiper">
                <div class="swiper-wrapper">

                    @foreach($categories as $item)
                        <div class="swiper-slide">
                            <a href="{{ route('products.category', $item->id) }}" class="explore-item">

                                <div class="explore-image">
                                    <img src="{{ asset('uploads/category/' . $item->image) }}" alt="{{ $item->name }}">
                                </div>

                                <div class="explore-text">
                                    {{ $item->name }}
                                </div>

                            </a>
                        </div>
                    @endforeach

                </div>

                <!-- Pagination -->
                <div class="swiper-pagination explore-pagination"></div>
            </div>
        </div>
    </section>

    <section class="contact-news-section-2 py-5">
        <div class="container">
            <div class="row g-4">

                <!-- LEFT CONTACT FORM -->
                <div class="col-lg-12">
                    <div class="contact-box">
                        <h2>Enquire About This Product</h2>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf

                            <input type="text" name="name" placeholder="Your Name" required>
                            <input type="email" name="email" placeholder="Your Email" required>
                            <input type="text" name="phone" placeholder="Phone Number" required>
                            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>

                            @error('captcha')
                                <div class="alert alert-danger p-2" style="font-size: 13px; margin-bottom: 10px; background: rgba(220, 53, 69, 0.2); border: 1px solid rgba(220, 53, 69, 0.4); color: #ff8080;">{{ $message }}</div>
                            @enderror
                            <div class="captcha-wrapper mb-3" style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                                <span style="color: #333; white-space: nowrap; font-weight: 600;">Security Check: What is {{ session('captcha_num1') }} + {{ session('captcha_num2') }}?</span>
                                <input type="number" name="captcha" placeholder="Answer" required style="margin: 0; width: 100px; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                            </div>

                            <button type="submit">Send message</button>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </section>

@endsection



@section('scripts')
    <script>
        var swiper = new Swiper(".gallerySwiper", {
            slidesPerView: 3,
            spaceBetween: 20,
            loop: true,
            speed: 800,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },

            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
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
    </script>

    <script>
        var exploreSwiper = new Swiper(".exploreSwiper", {
            slidesPerView: 5,
            spaceBetween: 30,
            loop: true,
            // centeredSlides: true,
            speed: 900,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },

            pagination: {
                el: ".explore-pagination",
                clickable: true,
            },

            breakpoints: {
                320: {
                    slidesPerView: 1
                },
                576: {
                    slidesPerView: 2
                },
                992: {
                    slidesPerView: 3
                },
                1200: {
                    slidesPerView: 4
                }
            }
        });
    </script>

@endsection