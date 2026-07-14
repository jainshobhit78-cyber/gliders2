@extends('backend.layout.app')
<style>
    .user-table {
        text-align: center;
    }

    .image-card img {
        width: 100%;
        height: 200px;
        object-fit: contain;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .video-card video {
        width: 100%;
        height: 300px;
        object-fit: contain;
        border-radius: 8px;
    }

    .badge {
        padding: 11px 13px !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: transparent !important;
        border: none;
    }
</style>
@section('content')

    <div class="about-section">

        <div class="title-header d-flex justify-content-between">

            <h5>All Media / Playlist</h5>
            @if(auth()->guard('admin')->user()->can('media.create'))
                <a href="{{ url('admin/media/add') }}" class="btn btn-theme">
                    Create Playlist
                </a>
            @endif
        </div>

        <div class="container-fluid">

            <div class="card">

                <div class="card-body">

                    @include('_message')

                    <div class="table-responsive">

                        <table id="mediaTable" class="user-table table table-striped">

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Heading</th>
                                    <th>Images</th>
                                    <th>Videos</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($playlists as $p)

                                    <tr>

                                        <td>{{ $p->id }}</td>

                                        <td>{{ $p->name }}</td>

                                        <td>{{ $p->heading }}</td>

                                        <td>
                                            <span class="badge bg-primary">{{ $p->images->count() }}</span>
                                            <a class="btn btn-primary view-images" data-images='@json($p->images)'
                                                style="cursor:pointer;">
                                                View Images
                                            </a>
                                        </td>

                                        <td>
                                            <span class="badge bg-primary">{{ $p->videos->count() }}</span>
                                            <a class="btn btn-primary view-videos" data-videos='@json($p->videos)'
                                                style="cursor:pointer;">
                                                View Videos
                                            </a>
                                        </td>

                                        <td>

                                            <ul class="table-action">
                                                @if(auth()->guard('admin')->user()->can('media.edit'))
                                                    <li>
                                                        <a href="{{ url('admin/media/edit/' . $p->id) }}" class="btn btn-edit">
                                                            Edit
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(auth()->guard('admin')->user()->hasRole('admin'))
                                                    <li>
                                                        <x-delete-form :action="url('admin/media/delete/' . $p->id)" class="btn btn-delete" confirm="Delete this playlist?" />
                                                    </li>
                                                @endif

                                            </ul>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                        <!-- IMAGE MODAL -->
                        <div class="modal fade" id="imageModal" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5>Images Gallery</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row" id="imageContainer"></div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- VIDEO MODAL -->
                        <div class="modal fade" id="videoModal" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5>Videos</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row" id="videoContainer"></div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>



                </div>

            </div>

        </div>

    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {

            $('#mediaTable').DataTable({
                paging: true,
                searching: true,
                info: true,
                lengthChange: false,
                pageLength: 10, // optional
                ordering: false
            });

        })
    </script>

    <script>

        // IMAGE VIEW
        $(document).on('click', '.view-images', function () {

            let images = $(this).data('images');

            let html = '';

            images.forEach(img => {

                html += `
                            <div class="col-md-4 mb-3">
                                <div class="image-card">
                                        <img src="{{ asset('uploads/media/images') }}/${img.image}">
                                </div>
                            </div>
                            `;

            });

            $('#imageContainer').html(html);

            $('#imageModal').modal('show');

        });


        // VIDEO VIEW
        $(document).on('click', '.view-videos', function () {

            let videos = $(this).data('videos');

            let html = '';

            videos.forEach(video => {

                html += `
                                <div class="col-md-6 mb-3">
                                    <div class="video-card">
                                        <video controls>
                                            <source src="{{ asset('uploads/media/videos') }}/${video.video}">
                                        </video>
                                    </div>
                                </div>
                                `;

            });

            $('#videoContainer').html(html);

            $('#videoModal').modal('show');

        });

    </script>
@endsection