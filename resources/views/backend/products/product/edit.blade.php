@extends('backend.layout.app')

@section('content')

    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
        rel="stylesheet">

    <div class="title-header d-flex align-items-center gap-3">

        <a href="{{ url('admin/product/list') }}" class="back-btn">

            <svg width="24" height="24" viewBox="0 0 24 24">
                <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" />
            </svg>

            <span>Back</span>

        </a>

        <h5>Edit Product</h5>

    </div>


    <div class="container-fluid">

        <div class="card">

            <div class="card-body">

                <form method="POST" action="{{ url('admin/product/update/' . $product->id) }}" class="theme-form"
                    enctype="multipart/form-data">

                    @csrf


                    <div class="mb-3">

                        <label>Title</label>

                        <input type="text" name="title" value="{{ $product->title }}" class="form-control" required>

                    </div>


                    <div class="mb-3">

                        <label>Category</label>

                        <select name="category_id" class="form-control" required>

                            @foreach($categories as $cat)

                                <option value="{{ $cat->id }}" @if($product->category_id == $cat->id) selected @endif>

                                    {{ $cat->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="mb-3">

                        <label>Description</label>

                        <textarea name="description" class="editor form-control">

                                        {{ $product->description }}

                                        </textarea>

                    </div>

                    <div class="mb-3">
                        <label>Wallpaper</label>
                        <input type="file" name="wallpaper" class="form-control" accept="image/*">

                        @if($product->wallpaper)
                            <div class="mt-2">
                                <img src="{{ asset('uploads/products/' . $product->wallpaper) }}" width="150">
                            </div>
                        @endif
                    </div>


                    <div class="mb-3">

                        <label>Images</label>

                        <input type="file" class="filepond" name="filepond[]" multiple data-max-files="10"
                            data-allow-reorder="true">

                    </div>


                    <input type="hidden" name="removed_images" id="removedImages">


                    <div class="panel-footer mb-4">

                        <button class="btn btn-primary" id="submitBtn">

                            <span class="btnText">
                                Update Product
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
        src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js"></script>

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

        setTimeout(function () {

            const input = document.querySelector('.filepond');

            if (!input) return;

            FilePond.registerPlugin(
                FilePondPluginImagePreview,
                FilePondPluginImageExifOrientation,
                FilePondPluginFileValidateType
            );

            const pond = FilePond.create(input, {
                allowMultiple: true,
                allowReorder: true,
                storeAsFile: true,
                name: "filepond[]",

                acceptedFileTypes: [
                    'image/jpeg',
                    'image/png',
                    'image/webp',
                    'image/svg+xml'
                ],

                labelFileTypeNotAllowed: 'Only JPG, PNG, WEBP, SVG allowed',

                server: {
                    load: (source, load, error) => {
                        fetch(source)
                            .then(res => res.blob())
                            .then(load)
                            .catch(() => error('Load error'));
                    }
                }
            });

            let removed = [];

            pond.on('removefile', (error, file) => {

                if (file.getMetadata('image_id')) {

                    removed.push(file.getMetadata('image_id'));

                    document.getElementById('removedImages').value = removed.join(',');

                }

            });


            @foreach($product->images as $img)

                pond.addFile("{{ asset('uploads/products/' . $img->image) }}", {

                    type: 'local',

                    metadata: {
                        image_id: "{{ $img->id }}"
                    }

                });

            @endforeach


                                    }, 300);

    </script>


    <script>

        $(document).on('submit', '.theme-form', function () {

            $('#submitBtn').prop('disabled', true)

            $('.btnText').addClass('d-none')
            $('.btnLoader').removeClass('d-none')

        })

    </script>

@endsection