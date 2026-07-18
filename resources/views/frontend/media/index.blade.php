@extends('frontend.layouts.app')

@section('content')

    <div class="container py-5 media-page-wrapper">
        
        <!-- MODERN PLAYLISTS TABS SECTION -->
        <div class="playlists-pill-header mb-5">
            <h2 class="media-section-main-title text-center mb-4">Media Library</h2>
            <div class="playlists-scroller d-flex align-items-center justify-content-center gap-3">
                @foreach($playlists as $playlist)
                    <a href="{{ route('media', $playlist->id) }}"
                       class="playlist-pill {{ $selectedPlaylist && $selectedPlaylist->id == $playlist->id ? 'active' : '' }}">
                        <span class="pill-play-icon">▶</span>
                        {{ $playlist->name }}
                    </a>
                @endforeach
            </div>
        </div>

        @if($selectedPlaylist)
            <!-- SELECTED PLAYLIST BANNER -->
            <div class="playlist-details-banner text-center mb-5 p-4 rounded-4">
                <h1 class="playlist-heading">{{ $selectedPlaylist->name }}</h1>
                @if($selectedPlaylist->heading)
                    <h5 class="playlist-subheading text-muted mt-2">{{ $selectedPlaylist->heading }}</h5>
                @endif
                @if($selectedPlaylist->description)
                    <div class="playlist-desc mt-3 mx-auto" style="max-width: 800px; color: #555;">
                        {!! \App\Support\Security::cleanHtml($selectedPlaylist->description) !!}
                    </div>
                @endif

                <!-- MEDIA TYPE TABS -->
                <div class="media-filter-tabs d-flex align-items-center justify-content-center gap-3 mt-4">
                    <button class="filter-tab-btn active" onclick="filterMedia('all', this)">All Content</button>
                    @if($selectedPlaylist->images->count())
                        <button class="filter-tab-btn" onclick="filterMedia('photo', this)">Photos</button>
                    @endif
                    @if($selectedPlaylist->videos->count())
                        <button class="filter-tab-btn" onclick="filterMedia('video', this)">Videos</button>
                    @endif
                </div>
            </div>

            <!-- INSTAGRAM/DRIBBBLE STYLE MEDIA FEED GRID -->
            <div class="row g-4 media-feed-grid">
                
                <!-- IMAGES FEED -->
                @foreach($selectedPlaylist->images as $image)
                    <div class="col-lg-4 col-md-6 media-feed-item" data-type="photo">
                        <div class="media-feed-card">
                            <div class="media-card-header d-flex align-items-center gap-2">
                                <span class="badge bg-primary-soft text-primary">Photo</span>
                                <small class="text-muted">{{ $image->sub_heading ?: 'Gallery Image' }}</small>
                            </div>

                            <!-- Image Container -->
                            <div class="media-card-display-box">
                                <a href="/uploads/media/images/{{ $image->image }}" class="glightbox" data-gallery="playlist_gallery">
                                    <img src="/uploads/media/images/{{ $image->image }}" alt="{{ $image->caption }}">
                                    <div class="media-card-hover-overlay">
                                        <span class="hover-overlay-icon">🔍 View Fullscreen</span>
                                    </div>
                                </a>
                            </div>

                            <!-- Content Area -->
                            <div class="media-card-body">
                                @if($image->caption)
                                    <p class="media-card-caption">{{ $image->caption }}</p>
                                @else
                                    <p class="media-card-caption text-muted italic">No caption provided.</p>
                                @endif

                                <!-- SOCIAL ACTIONS BAR -->
                                <div class="media-card-actions-bar d-flex align-items-center justify-content-between mt-3 pt-3 border-top">
                                    <!-- WhatsApp Direct Share -->
                                    @php
                                        $shareText = rawurlencode(($image->caption ?: $selectedPlaylist->name) . "\nView it here: " . request()->url());
                                        $whatsappUrl = "https://api.whatsapp.com/send?text=" . $shareText;
                                    @endphp
                                    <a href="{{ $whatsappUrl }}" target="_blank" class="action-btn btn-share-wa">
                                        <svg viewBox="0 0 24 24" fill="currentColor" style="width: 18px; height: 18px; color: #25d366;"><path d="M12.012 2c-5.506 0-9.989 4.478-9.99 9.984a9.96 9.96 0 0 0 1.333 4.993L2 22l5.19-1.354a9.95 9.95 0 0 0 4.82 1.233h.005c5.502 0 9.99-4.478 9.99-9.986 0-2.67-1.037-5.178-2.92-7.062C17.182 3.036 14.685 2 12.012 2zm0 1.697c2.215 0 4.296.863 5.86 2.428s2.427 3.645 2.427 5.862c0 4.567-3.717 8.286-8.286 8.286a8.23 8.23 0 0 1-4.22-1.155l-.303-.18-3.138.82.836-3.06-.197-.314A8.23 8.23 0 0 1 3.71 11.68c0-4.568 3.717-8.287 8.287-8.287z"/></svg>
                                        Share
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- VIDEOS FEED -->
                @foreach($selectedPlaylist->videos as $video)
                    <div class="col-lg-4 col-md-6 media-feed-item" data-type="video">
                        <div class="media-feed-card">
                            <div class="media-card-header d-flex align-items-center gap-2">
                                <span class="badge bg-success-soft text-success">Video</span>
                                <small class="text-muted">Interactive Player</small>
                            </div>

                            <!-- Video Container with Custom Controls Overlay -->
                            <div class="media-card-display-box video-display-box">
                                <video preload="metadata" id="player-video-{{ $video->id }}">
                                    <source src="{{ asset('uploads/media/videos/' . $video->video) }}" type="video/mp4">
                                </video>
                                <div class="video-custom-overlay" onclick="togglePlayVideo('{{ $video->id }}')">
                                    <button class="custom-video-play-btn" id="play-btn-video-{{ $video->id }}">▶</button>
                                </div>
                            </div>

                            <!-- Content Area -->
                            <div class="media-card-body">
                                @if($video->caption)
                                    <p class="media-card-caption">{{ $video->caption }}</p>
                                @else
                                    <p class="media-card-caption text-muted italic">No caption provided.</p>
                                @endif

                                <!-- SOCIAL ACTIONS BAR -->
                                <div class="media-card-actions-bar d-flex align-items-center justify-content-between mt-3 pt-3 border-top">
                                    <!-- Like Button (Server-side) -->
                                    <button class="action-btn btn-like {{ session('liked_video_' . $video->id) ? 'liked' : '' }}"
                                            data-video-id="{{ $video->id }}"
                                            onclick="toggleLikeVideo({{ $video->id }}, this)">
                                        <svg class="heart-icon" viewBox="0 0 24 24" fill="{{ session('liked_video_' . $video->id) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                        <span class="like-label">{{ session('liked_video_' . $video->id) ? 'Liked' : 'Like' }}</span> (<span class="like-count">{{ $video->likes }}</span>)
                                    </button>

                                    <!-- WhatsApp Direct Share -->
                                    @php
                                        $shareText = rawurlencode(($video->caption ?: $selectedPlaylist->name) . "\nView it here: " . request()->url());
                                        $whatsappUrl = "https://api.whatsapp.com/send?text=" . $shareText;
                                    @endphp
                                    <a href="{{ $whatsappUrl }}" target="_blank" class="action-btn btn-share-wa">
                                        <svg viewBox="0 0 24 24" fill="currentColor" style="width: 18px; height: 18px; color: #25d366;"><path d="M12.012 2c-5.506 0-9.989 4.478-9.99 9.984a9.96 9.96 0 0 0 1.333 4.993L2 22l5.19-1.354a9.95 9.95 0 0 0 4.82 1.233h.005c5.502 0 9.99-4.478 9.99-9.986 0-2.67-1.037-5.178-2.92-7.062C17.182 3.036 14.685 2 12.012 2zm0 1.697c2.215 0 4.296.863 5.86 2.428s2.427 3.645 2.427 5.862c0 4.567-3.717 8.286-8.286 8.286a8.23 8.23 0 0 1-4.22-1.155l-.303-.18-3.138.82.836-3.06-.197-.314A8.23 8.23 0 0 1 3.71 11.68c0-4.568 3.717-8.287 8.287-8.287z"/></svg>
                                        Share
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        @else
            <div class="playlist-details-banner text-center py-5 rounded-4">
                <img src="{{ asset('frontend/images/logo/play-button.png') }}" alt="" class="img-fluid mb-3" style="height: 60px; opacity: 0.5;">
                <h3 class="text-muted">No Playlists Configured</h3>
                <p class="text-muted">Add playlists inside the Admin panel CMS to view media files.</p>
            </div>
        @endif

    </div>

@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    <script>
        // Init Lightbox
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            zoomable: true
        });

        // Filter tabs script
        function filterMedia(type, btn) {
            // Remove active from all buttons
            document.querySelectorAll('.filter-tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Toggle grid items
            document.querySelectorAll('.media-feed-item').forEach(item => {
                if (type === 'all') {
                    item.style.display = 'block';
                } else if (item.getAttribute('data-type') === type) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Custom video toggling player
        function togglePlayVideo(id) {
            const video = document.getElementById('player-video-' + id);
            const playBtn = document.getElementById('play-btn-video-' + id);

            if (video.paused) {
                // Pause all other playing videos first
                document.querySelectorAll('video').forEach(vid => {
                    if (vid !== video) {
                        vid.pause();
                        const otherBtnId = vid.id.replace('player-', 'play-btn-');
                        const otherBtn = document.getElementById(otherBtnId);
                        if (otherBtn) otherBtn.style.display = 'flex';
                    }
                });

                video.play();
                video.setAttribute('controls', 'true');
                playBtn.style.display = 'none';
            } else {
                video.pause();
                playBtn.style.display = 'flex';
            }
        }

        // Server-side Like toggle for videos
        function toggleLikeVideo(videoId, btn) {
            // Disable button during request
            btn.disabled = true;

            fetch('/media/like-video/' + videoId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const countEl = btn.querySelector('.like-count');
                const labelEl = btn.querySelector('.like-label');
                const heartIcon = btn.querySelector('.heart-icon');
                
                countEl.innerText = data.count;

                if (data.liked) {
                    btn.classList.add('liked');
                    labelEl.innerText = 'Liked';
                    heartIcon.setAttribute('fill', 'currentColor');
                    // Pulse animation
                    btn.style.transform = 'scale(1.15)';
                    setTimeout(() => btn.style.transform = '', 250);
                } else {
                    btn.classList.remove('liked');
                    labelEl.innerText = 'Like';
                    heartIcon.setAttribute('fill', 'none');
                }
            })
            .catch(err => {
                console.error('Like failed:', err);
            })
            .finally(() => {
                btn.disabled = false;
            });
        }
    </script>
@endsection
