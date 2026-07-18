@extends('backend.layout.app')

<style>
    .filepond--root {
        width: 100%;
    }

    .filepond--panel-root {
        background: #fff !important;
        border: 1px solid #e6e6e6;
        border-radius: 6px;
    }

    .filepond--list {
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 12px;
    }

    .filepond--item {
        width: 180px !important;
    }

    .filepond--image-preview {
        height: 160px !important;
    }

    #videoArea {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 10px;
    }

    .video-upload {
        position: relative;
        /* width: 170px; */
    }

    .video-upload video {
        width: 170px;
        height: 200px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #e6e6e6;
    }

    .video-upload input[type=file] {
        /* width: 170px; */
        font-size: 12px;
        margin-bottom: 6px;
    }

    .removeVideo {
        position: absolute;
        top: 6px;
        right: 6px;
        background: #000;
        color: #fff;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: none;
        font-size: 14px;
        line-height: 20px;
        text-align: center;
        cursor: pointer;
    }

    .removeVideo:hover {
        background: #ff3b3b;
    }

    .video-progress {
        width: 100%;
        height: 6px;
        background: #e6e6e6;
        border-radius: 4px;
        margin-top: 6px;
        overflow: hidden;
        display: none;
    }

    .video-progress-bar {
        height: 6px;
        width: 0%;
        background: #2A538E;
    }
</style>


@section('content')

    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
        rel="stylesheet">

    <div class="title-header d-flex align-items-center gap-3">

        <a href="{{ url('admin/media') }}" class="back-btn">
            <svg width="24" height="24" viewBox="0 0 24 24">
                <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" />
            </svg>
            <span>Back</span>
        </a>

        <h5>Edit Playlist</h5>

    </div>


    <div class="container-fluid">

        <div class="card">

            <div class="card-body">

                <form method="POST" action="{{ url('admin/media/update/' . $playlist->id) }}" enctype="multipart/form-data"
                    class="theme-form">

                    @csrf


                    <div class="mb-3">
                        <label class="form-label-title">Playlist Name</label>
                        <input type="text" name="name" value="{{ $playlist->name }}" class="form-control" required>
                    </div>


                    <div class="mb-3">
                        <label class="form-label-title">Heading</label>
                        <input type="text" name="heading" value="{{ $playlist->heading }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-title">Playlist Thumbnail (Preview Pic)</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                        @if($playlist->thumbnail)
                            <div class="mt-2">
                                <img src="{{ asset('uploads/media/images/' . $playlist->thumbnail) }}" width="120" class="border rounded">
                            </div>
                        @endif
                        <small class="text-muted">Upload a cover image that will be shown as the preview tab pic on the homepage.</small>
                    </div>


                    <div class="mb-3">
                        <label class="form-label-title">Description</label>

                        <textarea name="description" class="editor form-control">
                                {{ $playlist->description }}
                                </textarea>

                    </div>

                    <div class="mb-3">
                        <label class="form-label-title">Add New Images</label>
                        <input type="file" id="imageInput" name="images[]" multiple class="form-control">
                        <div id="imagePreviewAreaNew" class="d-flex flex-wrap gap-3 mt-3"></div>

                    </div>
                    <div class="mb-3">

                        <div id="imagePreviewArea" class="d-flex flex-wrap gap-3 mt-3">

                            @foreach($playlist->images as $img)
                                <div class="border p-2 image-item-existing" style="width:180px">

                                    <img src="{{ asset('uploads/media/images/' . $img->image) }}"
                                        style="width:100%; height:120px; object-fit:cover; border-radius:5px">

                                    <input type="text" name="existing_image_sub_heading[]" value="{{ $img->sub_heading }}"
                                        class="form-control mt-2">

                                    <input type="text" name="existing_image_caption[]" value="{{ $img->caption }}"
                                        class="form-control mt-1">

                                    <button type="button" class="btn btn-danger btn-sm mt-1 removeImageExisting"
                                        data-id="{{ $img->id }}">
                                        Remove
                                    </button>

                                </div>
                            @endforeach

                        </div>

                    </div>
                    <input type="hidden" name="remove_images" id="removeImages">


                    <div class="mb-3">

                        <label class="form-label-title">Videos</label>

                        <div id="videoArea">

                            @foreach($playlist->videos as $video)

                                <div class="video-upload existing-video" data-id="{{ $video->id }}">

                                    <video controls>
                                        <source src="{{ asset('uploads/media/videos/' . $video->video) }}">
                                    </video>

                                    <input type="text" name="video_caption_existing[]" value="{{ $video->caption }}"
                                        class="form-control mt-2">

                                    <button type="button" class="removeVideo">×</button>

                                </div>

                            @endforeach

                        </div>

                        <input type="hidden" name="remove_videos" id="removeVideos">

                        <button type="button" class="btn btn-sm btn-primary mt-2" id="addVideo">
                            Add More Video
                        </button>

                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="hide_during_election" id="hide_during_election" style="cursor:pointer;" {{ $playlist->hide_during_election ? 'checked' : '' }}>
                            <label class="form-check-label" for="hide_during_election" style="cursor:pointer; font-weight:600;">Hide this media playlist during Election Periods</label>
                        </div>
                    </div>

                    @if(auth()->guard('admin')->user()->hasRole('admin'))
                        <div class="mb-3">
                            <label class="form-label-title">Status</label>
                            <select name="status" class="form-control">
                                <option value="Published" {{ $playlist->status == 'Published' ? 'selected' : '' }}>Published</option>
                                <option value="Pending" {{ $playlist->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                    @endif

                    <div class="panel-footer mb-4">

                        <button class="btn btn-primary" id="submitBtn">

                            <span class="btnText">
                                {{ auth()->guard('admin')->user()->hasRole('admin') ? 'Update Playlist' : 'Send to Admin for Approval' }}
                            </span>

                            <span class="btnLoader d-none">
                                <i class="fa fa-spinner fa-spin"></i> Saving...
                            </span>

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection


@section('script')

    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script
        src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>

    <script>
        function initLeadershipScripts() {

            if (typeof tinymce !== "undefined") {

                if (tinymce.editors && tinymce.editors.length > 0) {
                    tinymce.remove();
                }

                if (document.querySelector('.editor')) {

                    tinymce.init({
                        selector: '.editor',
                        height: 400,
                        menubar: false,

                        plugins: [
                            'advlist autolink lists charmap preview anchor paste', // ❌ removed link, image
                            'searchreplace visualblocks code fullscreen',
                            'insertdatetime media table code wordcount'
                        ],

                        toolbar: [
                            "bullist numlist outdent indent | fontsizeselect | undo redo | styleselect | bold italic",
                            "alignleft aligncenter alignright alignjustify | forecolor backcolor | code fullscreen preview"
                        ],

                        elementpath: false,
                        statusbar: false,

                        content_style: `
                                                                body {
                                                                    font-family: Kumbh Sans, sans-serif !important;
                                                                    background: transparent !important;
                                                                }
                                                                p {
                                                                    background: transparent !important;
                                                                }

                                                            `,

                        paste_remove_styles: true,
                        paste_remove_spans: true,
                        paste_strip_class_attributes: "all"
                    });

                }
            }

        }
        initLeadershipScripts();
    </script>

    <script>
        let imageData = [];

        $('#imageInput').on('change', function () {

            let files = Array.from(this.files);

            files.forEach(file => {

                if (imageData.find(f => f.name === file.name && f.size === file.size)) {
                    return;
                }

                imageData.push(file);

                let preview = URL.createObjectURL(file);
                $('#imagePreviewAreaNew').append(`
                                <div class="border p-2 image-item-new" style="width:180px">

                                    <img src="${preview}" style="width:100%; height:120px; object-fit:cover; border-radius:5px">

                                    <input type="text" name="image_sub_heading[]" 
                                        placeholder="Sub Heading"
                                        class="form-control mt-2">

                                    <input type="text" name="image_caption[]" 
                                        placeholder="Caption"
                                        class="form-control mt-1">

                                    <button type="button" class="btn btn-danger btn-sm mt-1 removeImageNew">Remove</button>

                                </div>
                            `);
            });

            const dt = new DataTransfer();
            imageData.forEach(file => dt.items.add(file));
            this.files = dt.files;

        });

        $(document).on('click', '.removeImageNew', function () {

            let index = $(this).closest('.image-item-new').index();

            imageData.splice(index, 1);

            const dt = new DataTransfer();
            imageData.forEach(file => dt.items.add(file));
            document.getElementById('imageInput').files = dt.files;

            $(this).closest('.image-item-new').remove();

        });
        let removedImages = [];
        $(document).on('click', '.removeImageExisting', function () {

            let id = $(this).data('id');

            removedImages.push(id);

            $('#removeImages').val(removedImages.join(','));

            $(this).closest('.image-item-existing').remove();

        });
    </script>



    <script>

        let removedVideos = [];

        $(document).on('click', '.existing-video .removeVideo', function () {

            let parent = $(this).closest('.existing-video');

            let id = parent.data('id');

            removedVideos.push(id);

            $('#removeVideos').val(removedVideos.join(','));

            parent.remove();

        });

    </script>



    <script>

        $('#addVideo').click(function () {

            let html = `
                <div class="video-upload">

                    <input type="file" 
                        name="videos[]" 
                        class="form-control videoFile"
                        accept="video/*">

                    <video class="videoPreview mt-2 d-none" controls></video>

                    <input type="text" 
                        name="video_caption[]" 
                        placeholder="Enter video caption" 
                        class="form-control mt-2">

                    <button type="button" class="removeVideo">×</button>

                </div>
                `;

            $('#videoArea').append(html);

        });

        $(document).on('change', '.videoFile', function () {

            let file = this.files[0];

            if (!file) return;

            let parent = $(this).closest('.video-upload');
            let preview = parent.find('.videoPreview');

            let url = URL.createObjectURL(file);

            preview.attr('src', url);
            preview.removeClass('d-none');

        });

    </script>



    <script>

        $(document).on('click', '.removeVideo', function () {

            $(this).closest('.video-upload').remove();

        });

    </script>



    <script>

        $(document).on('change', '.videoFile', function () {

            let file = this.files[0];

            let parent = $(this).closest('.video-upload');

            let preview = parent.find('.videoPreview');

            let progress = parent.find('.video-progress');

            let bar = parent.find('.video-progress-bar');

            let hidden = parent.find('input[type=hidden]');


            preview.attr('src', URL.createObjectURL(file));
            preview.removeClass('d-none');

            $(this).hide();

            let formData = new FormData();
            formData.append('file', file);

            progress.show();


            $.ajax({

                url: "{{ url('admin/media/upload-video') }}",

                type: 'POST',

                data: formData,

                processData: false,
                contentType: false,

                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },

                xhr: function () {

                    let xhr = new window.XMLHttpRequest();

                    xhr.upload.addEventListener("progress", function (evt) {

                        if (evt.lengthComputable) {

                            let percent = (evt.loaded / evt.total) * 100;

                            bar.css('width', percent + '%');

                        }

                    });

                    return xhr;

                },

                success: function (res) {

                    hidden.val(res.name);

                    progress.fadeOut();

                }

            });

        });

    </script>



    <script>

        $(document).on('submit', '.theme-form', function () {

            $('#submitBtn').prop('disabled', true)

            $('.btnText').addClass('d-none')
            $('.btnLoader').removeClass('d-none')

        })

    </script>

@endsection