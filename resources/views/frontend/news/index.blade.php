@extends('frontend.layouts.app')

@section('content')

    <style>
        .safran-news-section {
            padding: 80px 0;
            background-color: #fafafa;
        }

        .safran-news-heading {
            font-size: 38px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: -0.5px;
            color: #111;
            margin-bottom: 50px;
        }

        .safran-news-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px 30px;
        }

        .safran-news-card {
            display: block;
            text-decoration: none;
            background: transparent;
            cursor: pointer;
            transition: none;
        }

        .safran-news-img-wrap {
            width: 100%;
            height: 240px;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            background-color: #eee;
        }

        .safran-news-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.25, 1, 0.3, 1);
        }

        .safran-news-card:hover .safran-news-img {
            transform: scale(1.05);
        }

        .safran-news-meta {
            font-size: 13px;
            color: #777;
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .safran-news-title {
            font-size: 17px;
            font-weight: 700;
            color: #111;
            line-height: 1.45;
            margin: 0;
            transition: color 0.3s ease;
        }

        .safran-news-card:hover .safran-news-title {
            color: #EE6802;
        }

        @media (max-width: 991px) {
            .safran-news-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 30px 20px;
            }
        }

        @media (max-width: 576px) {
            .safran-news-grid {
                grid-template-columns: 1fr;
            }
            .safran-news-heading {
                font-size: 28px;
                margin-bottom: 30px;
            }
        }
    </style>

    <div class="safran-news-section">
        <div class="container">
            <h1 class="safran-news-heading">Latest News - {{ $selectedCategory->name }}</h1>

            <div class="safran-news-grid">
                @foreach($articles as $article)
                    <a href="{{ route('news.show', $article->id) }}" class="safran-news-card">
                        <div class="safran-news-img-wrap">
                            @if($article->wallpaper)
                                <img src="/uploads/news/{{ $article->wallpaper }}" class="safran-news-img" alt="{{ $article->title }}">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-secondary text-white">
                                    <span>No Image</span>
                                </div>
                            @endif
                        </div>
                        <div class="safran-news-meta">
                            {{ \Carbon\Carbon::parse($article->publish_date)->format('m.d.Y') }}
                        </div>
                        <h4 class="safran-news-title">
                            {{ $article->title }}
                        </h4>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

@endsection