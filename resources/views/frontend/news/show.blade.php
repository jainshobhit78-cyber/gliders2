@extends('frontend.layouts.app')

@section('content')

    <style>
        .news-premium-page {
            background: linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%);
            padding: 70px 0;
        }

        .premium-article-card {
            background: #fff;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .premium-image-wrap {
            position: relative;
            overflow: hidden;
        }

        .premium-article-image {
            width: 100%;
            height: 520px;
            object-fit: cover;
            transition: 0.5s ease;
        }

        .premium-article-card:hover .premium-article-image {
            transform: scale(1.03);
        }

        .premium-overlay-badge {
            position: absolute;
            top: 25px;
            left: 25px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 8px 18px;
            border-radius: 40px;
            font-size: 13px;
            font-weight: 700;
            color: #163b7a;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .premium-content {
            padding: 40px;
        }

        .premium-title {
            font-size: 46px;
            font-weight: 800;
            line-height: 1.25;
            color: #0f172a;
            margin-bottom: 18px;
        }

        .premium-subtitle {
            font-size: 19px;
            color: #64748b;
            line-height: 1.9;
            margin-bottom: 5px;
        }

        .premium-meta {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            padding-bottom: 12px;
            margin-bottom: 18px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
            color: #64748b;
        }

        .premium-body {
            font-size: 18px;
            line-height: 2;
            color: #334155;
            font-family: 'Outfit', sans-serif;
        }

        .premium-body p {
            margin-bottom: 24px;
        }

        .premium-body h1, .premium-body h2, .premium-body h3, .premium-body h4, .premium-body h5, .premium-body h6 {
            color: #0f172a;
            margin-top: 1.6em;
            margin-bottom: 0.6em;
            font-weight: 700;
            line-height: 1.3;
            font-family: 'Outfit', sans-serif;
        }

        /* SIDEBAR */
        .premium-sidebar {
            position: sticky;
            top: 120px;
        }

        .sidebar-card {
            background: #fff;
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
        }

        .sidebar-title {
            font-size: 30px;
            font-weight: 800;
            margin-bottom: 25px;
            color: #0f172a;
        }

        .news-side-item {
            display: flex;
            gap: 14px;
            padding: 14px;
            border-radius: 18px;
            transition: 0.3s ease;
            margin-bottom: 14px;
        }

        .news-side-item:hover {
            background: #f8fafc;
            transform: translateX(5px);
        }

        .side-thumb {
            width: 95px;
            height: 85px;
            object-fit: cover;
            border-radius: 16px;
            flex-shrink: 0;
        }

        .side-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .side-news-title {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.6;
            margin-bottom: 6px;
        }

        .side-date {
            font-size: 13px;
            color: #64748b;
        }

        /* SHARE BOX */
        .share-box {
            margin-top: 25px;
            background: #fff;
            border-radius: 22px;
            padding: 22px;
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.05);
        }

        .share-box h6 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .share-icons a {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #f1f5f9;
            margin-right: 10px;
            color: #0f172a;
            text-decoration: none;
            transition: .3s;
        }

        .share-icons a:hover {
            background: #000;
            color: #fff;
        }

        @media screen (max-width:768px) {
            .premium-title {
                font-size: 30px;
            }

            .premium-article-image {
                height: 260px;
            }

            .premium-content {
                padding: 25px;
            }

            .premium-sidebar {
                position: relative;
                top: auto;
                margin-top: 30px;
            }
        }
    </style>

    <div class="news-premium-page">
        <div class="container">
            <div class="row g-4">

                <!-- LEFT ARTICLE -->
                <div class="col-lg-8">
                    <div class="premium-article-card">

                        @if($article->wallpaper)
                            <div class="premium-image-wrap">
                                <img src="{{ asset('uploads/news/' . $article->wallpaper) }}" class="premium-article-image"
                                    alt="{{ $article->title }}">

                                <div class="premium-overlay-badge">
                                    {{ $article->category->name ?? 'News' }}
                                </div>
                            </div>
                        @endif

                        <div class="premium-content">
                            <h1 class="premium-title">{{ $article->title }}</h1>

                            <div class="premium-subtitle">
                                {{ $article->subtitle }}
                            </div>

                            <div class="premium-meta">
                                <span>By <strong>{{ $article->author }}</strong></span>
                                <span>{{ \Carbon\Carbon::parse($article->publish_date)->format('d M Y') }}</span>
                            </div>

                            <div class="premium-body">
                                {!! \App\Support\Security::cleanHtml($article->content) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT SIDEBAR -->
                <div class="col-lg-4">
                    <div class="premium-sidebar">

                        <div class="sidebar-card">
                            <div class="sidebar-title">More News</div>

                            @foreach($relatedArticles as $news)
                                <a href="{{ route('news.show', $news->id) }}" class="text-decoration-none">
                                    <div class="news-side-item">

                                        @if($news->wallpaper)
                                            <img src="{{ asset('uploads/news/' . $news->wallpaper) }}" class="side-thumb"
                                                alt="{{ $news->title }}">
                                        @endif

                                        <div class="side-content">
                                            <div class="side-news-title">
                                                {{ Str::limit($news->title, 60) }}
                                            </div>
                                            <div class="side-date">
                                                {{ \Carbon\Carbon::parse($news->publish_date)->format('d M Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="share-box">
                            <h6>Share News</h6>
                            <div class="share-icons">
                                <a href="#" id="shareFacebook" target="_blank">
                                    <i class="bi bi-facebook"></i>
                                </a>

                                <a href="#" id="shareTwitter" target="_blank">
                                    <i class="bi bi-twitter-x"></i>
                                </a>

                                <a href="#" id="shareWhatsapp" target="_blank">
                                    <i class="bi bi-whatsapp"></i>
                                </a>

                                <a href="#" id="copyLinkBtn">
                                    <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            let pageUrl = window.location.href;
            let pageTitle = document.title;

            document.getElementById("shareFacebook").href =
                `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(pageUrl)}`;

            document.getElementById("shareTwitter").href =
                `https://twitter.com/intent/tweet?url=${encodeURIComponent(pageUrl)}&text=${encodeURIComponent(pageTitle)}`;

            document.getElementById("shareWhatsapp").href =
                `https://wa.me/?text=${encodeURIComponent(pageTitle + ' ' + pageUrl)}`;

            document.getElementById("copyLinkBtn").addEventListener("click", function (e) {
                e.preventDefault();

                navigator.clipboard.writeText(pageUrl).then(() => {
                    alert("Link copied successfully!");
                });
            });

        });
    </script>

@endsection
