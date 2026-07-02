@extends('frontend.layouts.app')

@section('content')

    <style>
        /* ===== HERO ===== */
        .news-list-hero {
            background: linear-gradient(135deg, #0a1f44, #163b7a);
            padding: 60px 0;
            color: #fff;
            margin-bottom: 50px;
            border-radius: 0 0 30px 30px;
        }

        .news-list-hero h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .news-list-hero p {
            font-size: 18px;
            opacity: .9;
            margin: 0;
        }

        /* ===== CARD ===== */
        .premium-news-card {
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 12px 35px rgba(0, 0, 0, .08);
            transition: all .35s ease;
            height: 100%;
        }

        .premium-news-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 18px 45px rgba(0, 0, 0, .14);
        }

        .premium-news-image {
            height: 280px;
            width: 100%;
            object-fit: cover;
            transition: transform .4s ease;
        }

        .premium-news-card:hover .premium-news-image {
            transform: scale(1.05);
        }

        .premium-news-content {
            padding: 25px;
        }

        .news-badge {
            display: inline-block;
            background: #e6efff;
            color: #163b7a;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .premium-news-title {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .premium-news-subtitle {
            color: #6b7280;
            font-size: 15px;
            margin-bottom: 20px;
            line-height: 1.8;
        }

        .read-btn {
            display: inline-block;
            background: linear-gradient(135deg, #0a1f44, #163b7a);
            color: #fff;
            padding: 10px 22px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: .3s;
        }

        .read-btn:hover {
            background: #ff7a00;
            color: #fff;
        }

        /* ===== RESPONSIVE ===== */
        @media(max-width:768px) {
            .news-list-hero h1 {
                font-size: 32px;
            }

            .premium-news-title {
                font-size: 22px;
            }

            .premium-news-image {
                height: 220px;
            }
        }
    </style>

    <!-- HERO -->
    <div class="news-list-hero">
        <div class="container text-center">
            <h1>{{ $selectedCategory->name }}</h1>
            <p>Latest updates, press releases and official news</p>
        </div>
    </div>

    <!-- NEWS GRID -->
    <div class="container pb-5">
        <div class="row g-4">

            @foreach($articles as $article)
                <div class="col-lg-6 col-md-6">

                    <div class="premium-news-card">

                        @if($article->wallpaper)
                            <img src="{{ asset('uploads/news/' . $article->wallpaper) }}" class="premium-news-image"
                                alt="{{ $article->title }}">
                        @endif

                        <div class="premium-news-content">

                            <div class="news-badge">
                                {{ $selectedCategory->name }}
                            </div>

                            <div class="premium-news-title">
                                {{ $article->title }}
                            </div>

                            <div class="premium-news-subtitle">
                                {{ Str::limit(strip_tags($article->subtitle), 120) }}
                            </div>

                            <a href="{{ route('news.show', $article->id) }}" class="read-btn">
                                Read Full News →
                            </a>

                        </div>

                    </div>

                </div>
            @endforeach

        </div>
    </div>

@endsection