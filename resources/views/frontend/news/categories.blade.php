@extends('frontend.layouts.app')

@section('content')

    <style>
        /* ===== PAGE HERO ===== */
        .news-hero {
            background: linear-gradient(135deg, #0a1f44, #163b7a);
            padding: 70px 0;
            color: #fff;
            text-align: center;
            border-radius: 0 0 30px 30px;
            margin-bottom: 60px;
        }

        .news-hero h1 {
            font-size: 52px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .news-hero p {
            font-size: 18px;
            opacity: .9;
            margin: 0;
        }

        /* ===== CATEGORY SECTION ===== */
        .news-category-section {
            padding-bottom: 80px;
        }

        .category-card {
            position: relative;
            overflow: hidden;
            border-radius: 22px;
            min-height: 260px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
            transition: all .35s ease;
            cursor: pointer;
            background: #fff;
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 18px 40px rgba(0, 0, 0, .15);
        }

        .category-image {
            height: 260px;
            width: 100%;
            object-fit: cover;
            transition: transform .4s ease;
        }

        .category-card:hover .category-image {
            transform: scale(1.08);
        }

        .category-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top,
                    rgba(0, 0, 0, .75),
                    rgba(0, 0, 0, .2));
            display: flex;
            align-items: end;
            padding: 25px;
        }

        .category-content {
            width: 100%;
        }

        .category-title {
            color: #fff;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .category-desc {
            color: rgba(255, 255, 255, .85);
            font-size: 14px;
            margin-bottom: 15px;
        }

        .category-btn {
            display: inline-block;
            background: #fff;
            color: #111;
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: .3s;
        }

        .category-btn:hover {
            background: #ff7a00;
            color: #fff;
        }

        /* ===== RESPONSIVE ===== */
        @media(max-width:768px) {
            .news-hero h1 {
                font-size: 34px;
            }

            .category-title {
                font-size: 22px;
            }

            .category-card {
                min-height: 220px;
            }

            .category-image {
                height: 220px;
            }
        }
    </style>

    <!-- HERO -->
    <div class="news-hero">
        <div class="container">
            <h1>News & Updates</h1>
            <p>Explore latest press releases, updates, and breaking news</p>
        </div>
    </div>

    <!-- CATEGORY GRID -->
    <div class="container news-category-section">
        <div class="row g-4">

            @foreach($categories as $category)
                <div class="col-lg-4 col-md-6">

                    <a href="{{ route('news.category', $category->id) }}" class="text-decoration-none">

                        <div class="category-card">

                            <img src="{{ $category->articles->first() && $category->articles->first()->wallpaper
                ? asset('uploads/news/' . $category->articles->first()->wallpaper)
                : asset('frontend/images/default-news.jpg') }}" class="category-image" alt="{{ $category->name }}">

                            <div class="category-overlay">
                                <div class="category-content">
                                    <div class="category-title">
                                        {{ $category->name }}
                                    </div>

                                    <div class="category-desc">
                                        Read latest updates and official news related to {{ $category->name }}
                                    </div>

                                    <span class="category-btn">
                                        Explore News →
                                    </span>
                                </div>
                            </div>

                        </div>

                    </a>

                </div>
            @endforeach

        </div>
    </div>

@endsection