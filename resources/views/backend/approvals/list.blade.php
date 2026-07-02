@extends('backend.layout.app')

@section('content')
<div class="about-section">
    <div class="title-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0 page-title">Pending Content Approvals</h5>
    </div>

    <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-header p-0">
                <ul class="nav nav-tabs" id="approvalTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="news-tab" data-bs-toggle="tab" data-bs-target="#news-content" type="button" role="tab">
                            Pending News ({{ $news->count() }})
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="media-tab" data-bs-toggle="tab" data-bs-target="#media-content" type="button" role="tab">
                            Pending Media ({{ $playlists->count() }})
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                @include('_message')

                <div class="tab-content" id="approvalTabsContent">
                    <!-- Pending News Tab -->
                    <div class="tab-pane fade show active" id="news-content" role="tabpanel">
                        @if($news->isEmpty())
                            <p class="text-muted text-center py-4">No news articles pending approval.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th>Wallpaper</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Publish Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($news as $article)
                                            <tr>
                                                <td style="width: 80px;">
                                                    @if($article->wallpaper)
                                                        <img src="{{ asset('uploads/news/' . $article->wallpaper) }}" class="rounded" style="width: 60px; height: 40px; object-fit: cover;">
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <b>{{ $article->title }}</b>
                                                    @if($article->hide_during_election)
                                                        <span class="badge bg-warning ms-1 text-dark" style="font-size: 10px;">Election Filtered</span>
                                                    @endif
                                                </td>
                                                <td>{{ $article->author }}</td>
                                                <td>{{ $article->publish_date }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('admin.approvals.news.approve', $article->id) }}" class="btn btn-sm btn-success" style="background: #2ecc71; color: #fff;">Approve & Publish</a>
                                                        <a href="{{ url('admin/news/edit/' . $article->id) }}" class="btn btn-sm btn-edit" style="background: #e8f0fb; color: #2A538E;">Edit</a>
                                                        <a href="{{ url('admin/news/delete/' . $article->id) }}" class="btn btn-sm btn-delete" style="background: #fde8e8; color: #c0392b;" onclick="return confirm('Delete this record?')">Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <!-- Pending Media Tab -->
                    <div class="tab-pane fade" id="media-content" role="tabpanel">
                        @if($playlists->isEmpty())
                            <p class="text-muted text-center py-4">No media playlists pending approval.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th>Playlist Name</th>
                                            <th>Heading</th>
                                            <th>Media Counts</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($playlists as $playlist)
                                            <tr>
                                                <td>
                                                    <b>{{ $playlist->name }}</b>
                                                    @if($playlist->hide_during_election)
                                                        <span class="badge bg-warning ms-1 text-dark" style="font-size: 10px;">Election Filtered</span>
                                                    @endif
                                                </td>
                                                <td>{{ $playlist->heading }}</td>
                                                <td>
                                                    <span class="badge bg-info text-white">{{ $playlist->images->count() }} Images</span>
                                                    <span class="badge bg-secondary text-white ms-1">{{ $playlist->videos->count() }} Videos</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('admin.approvals.media.approve', $playlist->id) }}" class="btn btn-sm btn-success" style="background: #2ecc71; color: #fff;">Approve & Publish</a>
                                                        <a href="{{ url('admin/media/edit/' . $playlist->id) }}" class="btn btn-sm btn-edit" style="background: #e8f0fb; color: #2A538E;">Edit</a>
                                                        <a href="{{ url('admin/media/delete/' . $playlist->id) }}" class="btn btn-sm btn-delete" style="background: #fde8e8; color: #c0392b;" onclick="return confirm('Delete this record?')">Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
