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

        <h5>Add Product</h5>

    </div>

    <div class="container-fluid">

        <div class="card">

            <div class="card-body">

                <form class="theme-form" method="POST" action="{{ url('admin/product/add') }}"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3">

                        <label>Title</label>

                        <input type="text" name="title" class="form-control" required>

                    </div>

                    <div class="mb-3">

                        <label>Category</label>

                        <select name="category_id" class="form-control" required>

                            @foreach($categories as $cat)

                                <option value="{{ $cat->id }}">
                                    {{ $cat->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-3">

                        <label>Description</label>

                        <textarea name="description" class="editor form-control"></textarea>

                    </div>

                    <div class="mb-3">
                        <label>Product Badge / Tag (Optional)</label>
                        <input type="text" name="delivery_tag" class="form-control" list="badge-suggestions" placeholder="Choose from list or type custom value...">
                        <datalist id="badge-suggestions">
                            <option value="Aerial Delivery">
                            <option value="Tactical Operations">
                            <option value="Military Grade">
                            <option value="Heavy Load">
                        </datalist>
                        <small class="text-muted">Displays as a dynamic tag pill at the top of the product card (e.g. "Aerial Delivery").</small>
                    </div>
                    
                    <div class="mb-3">
                        <label>Wallpaper</label>
                        <input type="file" name="wallpaper" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-3">

                        <label>Images</label>

                        <input type="file" class="filepond" name="filepond[]" multiple>

                    </div>

                    <div class="panel-footer mb-4">
                        <button class="btn btn-primary" id="submitBtn">

                            <span class="btnText">Save Product</span>

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

        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType
        );

        FilePond.create(document.querySelector('.filepond'), {
            allowMultiple: true,
            storeAsFile: true,

            acceptedFileTypes: [
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/svg+xml'
            ],

            labelFileTypeNotAllowed: 'Only JPG, PNG, WEBP, SVG allowed',
            fileValidateTypeLabelExpectedTypes: 'Expects JPG, PNG, WEBP, SVG'
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