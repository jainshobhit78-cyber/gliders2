@extends('frontend.layouts.app')

@section('content')

    <div class="container py-5">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-lg-3">
                <div class="about-sidebar">

                    @foreach($playlists as $playlist)
                        <a href="{{ route('media', $playlist->id) }}"
                            class="sidebar-item {{ $selectedPlaylist && $selectedPlaylist->id == $playlist->id ? 'active' : '' }}">
                            {{ $playlist->name }}
                        </a>
                    @endforeach

                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="col-lg-9">

                @if($selectedPlaylist)
                    <div class="media-card">

                        <!-- PLAYLIST NAME -->
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('frontend/images/logo/play-button.png') }}" alt="" class="img-fluid me-3"
                                style="height: 50px;">
                            <div>
                                <h2 class="media-main-title">
                                    {{ $selectedPlaylist->name }}
                                </h2>

                                <!-- HEADING -->
                                <h4>
                                    {{ $selectedPlaylist->heading }}
                                </h4>
                            </div>
                        </div>


                        <!-- DESCRIPTION -->
                        <div class="media-description pb-3 mb-3 mt-3">
                            {!! $selectedPlaylist->description !!}
                        </div>

                        <!-- IMAGES -->
                        @if($selectedPlaylist->images->count())
                            <section class="gallery-slider-section">
                                <h4 class="gallery-heading">Gallery</h4>

                                <div class="swiper gallerySlider">
                                    <div class="swiper-wrapper">

                                        @foreach($selectedPlaylist->images as $image)
                                            <div class="swiper-slide">
                                                <div class="gallery-card">

                                                    <a href="{{ asset('uploads/media/images/' . $image->image) }}" class="glightbox"
                                                        data-gallery="playlist_gallery">

                                                        <div class="gallery-image-box">
                                                            <img src="{{ asset('uploads/media/images/' . $image->image) }}"
                                                                class="gallery-image" alt="">
                                                        </div>
                                                    </a>

                                                    <div class="gallery-content">
                                                        @if($image->sub_heading)
                                                            <h6>{{ $image->sub_heading }}</h6>
                                                        @endif

                                                        @if($image->caption)
                                                            <p>{{ $image->caption }}</p>
                                                        @endif
                                                    </div>

                                                    <div class="gallery-arrow">
                                                        ▶
                                                    </div>

                                                </div>
                                            </div>
                                        @endforeach

                                    </div>

                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                </div>
                            </section>
                        @endif

                        <!-- VIDEOS -->
                        @if($selectedPlaylist->videos->count())
                            <section class="video-slider-section">
                                <h4 class="gallery-heading mt-3">Videos</h4>

                                <div class="swiper videoSlider">
                                    <div class="swiper-wrapper">

                                        @foreach($selectedPlaylist->videos as $video)
                                            <div class="swiper-slide">
                                                <div class="video-card">

                                                    <div class="video-box">
                                                        <video preload="metadata">
                                                            <source src="{{ asset('uploads/media/videos/' . $video->video) }}"
                                                                type="video/mp4">
                                                        </video>

                                                        <button class="video-play-btn">
                                                            ▶
                                                        </button>
                                                    </div>

                                                    @if($video->caption)
                                                        <div class="video-content">
                                                            <p>{{ $video->caption }}</p>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>
                                        @endforeach

                                    </div>

                                    <div class="swiper-button-next video-next"></div>
                                    <div class="swiper-button-prev video-prev"></div>
                                </div>
                            </section>
                        @endif

                    </div>
                @else
                    <div class="media-card text-center py-5">
                        <img src="{{ asset('frontend/images/logo/play-button.png') }}" alt="" class="img-fluid mb-3" style="height: 60px; opacity: 0.5;">
                        <h3 class="text-muted">No Media Playlists Available</h3>
                        <p class="text-muted">Please check back later or add media from the admin panel.</p>
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

    <script>
        var gallerySwiper = new Swiper(".gallerySlider", {
            slidesPerView: 4,
            spaceBetween: 20,
            loop: true,
            navigation: {
                nextEl: ".gallerySlider .swiper-button-next",
                prevEl: ".gallerySlider .swiper-button-prev",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1
                },
                768: {
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

    <script>
        var videoSwiper = new Swiper(".videoSlider", {
            slidesPerView: 4,
            spaceBetween: 20,
            loop: true,
            navigation: {
                nextEl: ".video-next",
                prevEl: ".video-prev",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1
                },
                768: {
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

    <script>
        document.querySelectorAll('.video-play-btn').forEach(button => {
            button.addEventListener('click', function () {
                let video = this.parentElement.querySelector('video');

                if (video.paused) {
                    video.play();
                    video.setAttribute('controls', true);
                    video.style.pointerEvents = 'auto';
                    this.style.display = 'none';
                }
            });
        });
    </script>

@endsection