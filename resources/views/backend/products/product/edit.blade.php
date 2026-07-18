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
                        <label>Display Order</label>
                        <input type="number" name="display_order" class="form-control" value="{{ old('display_order', $product->display_order ?? 999) }}" min="1" required>
                        <small class="text-muted">Set to 1, 2, 3, etc. Products will be sorted by this order on the website (ascending).</small>
                    </div>


                    <div class="mb-3">

                        <label>Description</label>

                        <textarea name="description" class="editor form-control">

                                        {{ $product->description }}

                                        </textarea>

                    </div>

                    <div class="mb-3">
                        <label>Product Badge / Tag (Optional)</label>
                        <input type="text" name="delivery_tag" class="form-control" list="badge-suggestions" placeholder="Choose from list or type custom value..." value="{{ old('delivery_tag', $product->delivery_tag) }}">
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

                    <!-- TECHNICAL SPECIFICATIONS TAB/CARD -->
                    <div class="card mt-4 mb-4 border-info">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0 text-white"><i class="fa fa-cogs"></i> Technical Specifications Section</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Specifications Section Subheading / Intro Info</label>
                                <input type="text" name="specs_subtext" value="{{ old('specs_subtext', $product->specs_subtext) }}" class="form-control" placeholder="e.g. Designed for precision, built for performance...">
                                <small class="text-muted">Displays as the paragraph text below the Specifications section heading.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Specifications Photo / Image (Right Side)</label>
                                <input type="file" name="specs_image" class="form-control" accept="image/*">
                                @if($product->specs_image)
                                    <div class="mt-2">
                                        <img src="{{ asset('uploads/products/' . $product->specs_image) }}" width="150" class="border rounded">
                                    </div>
                                @endif
                                <small class="text-muted">Displays on the right-hand side of the Technical Specifications section.</small>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered align-middle" id="specsTable">
                                    <thead>
                                        <tr class="table-light">
                                            <th style="width: 15%;">Icon SVG Code</th>
                                            <th style="width: 25%;">Parameter</th>
                                            <th style="width: 25%;">Value / Unit / Rate</th>
                                            <th style="width: 30%;">Expanded Details / Description</th>
                                            <th style="width: 5%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($product->technical_specs && is_array($product->technical_specs))
                                            @foreach($product->technical_specs as $index => $spec)
                                                <tr>
                                                    <td>
                                                        <textarea name="technical_specs[{{ $index }}][icon]" class="form-control form-control-sm" rows="2" placeholder="e.g. <svg>...</svg>">{{ $spec['icon'] ?? '' }}</textarea>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="technical_specs[{{ $index }}][parameter]" value="{{ $spec['parameter'] ?? '' }}" class="form-control form-control-sm" required placeholder="e.g. Span of Main Parachute">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="technical_specs[{{ $index }}][value]" value="{{ $spec['value'] ?? '' }}" class="form-control form-control-sm" required placeholder="e.g. 7 sqm">
                                                    </td>
                                                    <td>
                                                        <textarea name="technical_specs[{{ $index }}][description]" class="form-control form-control-sm" rows="2" placeholder="Detail notes (shown when expanded)">{{ $spec['description'] ?? '' }}</textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btn-xs remove-row"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="btn btn-outline-info btn-sm mt-2" id="addSpecRow">
                                <i class="fa fa-plus"></i> Add Specification Row
                            </button>
                        </div>
                    </div>

                    <!-- MAIN CAPABILITIES TAB/CARD -->
                    <div class="card mt-4 mb-4 border-primary">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0 text-white"><i class="fa fa-rocket"></i> Main Capabilities Section</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Capabilities Background Image / Wallpaper</label>
                                <input type="file" name="caps_image" class="form-control" accept="image/*">
                                @if($product->caps_image)
                                    <div class="mt-2">
                                        <img src="{{ asset('uploads/products/' . $product->caps_image) }}" width="150" class="border rounded">
                                    </div>
                                @endif
                                <small class="text-muted">Background image for the Main Capabilities section.</small>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered align-middle" id="capsTable">
                                    <thead>
                                        <tr class="table-light">
                                            <th style="width: 35%;">Heading / Question</th>
                                            <th style="width: 60%;">Description / Answer</th>
                                            <th style="width: 5%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($product->main_capabilities && is_array($product->main_capabilities))
                                            @foreach($product->main_capabilities as $index => $cap)
                                                <tr>
                                                    <td>
                                                        <input type="text" name="main_capabilities[{{ $index }}][heading]" value="{{ $cap['heading'] ?? '' }}" class="form-control form-control-sm" required placeholder="e.g. Aerodynamic Deceleration">
                                                    </td>
                                                    <td>
                                                        <textarea name="main_capabilities[{{ $index }}][description]" class="form-control form-control-sm" rows="2" required placeholder="e.g. Generates extreme drag force..."></textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btn-xs remove-row"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="addCapRow">
                                <i class="fa fa-plus"></i> Add Capability Row
                            </button>
                        </div>
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

    <script>
        let specIndex = {{ $product->technical_specs ? count($product->technical_specs) : 0 }};
        let capIndex = {{ $product->main_capabilities ? count($product->main_capabilities) : 0 }};

        // Add Spec Row
        $('#addSpecRow').click(function() {
            let row = `
                <tr>
                    <td>
                        <textarea name="technical_specs[${specIndex}][icon]" class="form-control form-control-sm" rows="2" placeholder="e.g. <svg>...</svg>"></textarea>
                    </td>
                    <td>
                        <input type="text" name="technical_specs[${specIndex}][parameter]" class="form-control form-control-sm" required placeholder="e.g. Span of Main Parachute">
                    </td>
                    <td>
                        <input type="text" name="technical_specs[${specIndex}][value]" class="form-control form-control-sm" required placeholder="e.g. 7 sqm">
                    </td>
                    <td>
                        <textarea name="technical_specs[${specIndex}][description]" class="form-control form-control-sm" rows="2" placeholder="Detail notes (shown when expanded)"></textarea>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-xs remove-row"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            `;
            $('#specsTable tbody').append(row);
            specIndex++;
        });

        // Add Cap Row
        $('#addCapRow').click(function() {
            let row = `
                <tr>
                    <td>
                        <input type="text" name="main_capabilities[${capIndex}][heading]" class="form-control form-control-sm" required placeholder="e.g. Aerodynamic Deceleration">
                    </td>
                    <td>
                        <textarea name="main_capabilities[${capIndex}][description]" class="form-control form-control-sm" rows="2" required placeholder="e.g. Generates extreme drag force..."></textarea>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-xs remove-row"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            `;
            $('#capsTable tbody').append(row);
            capIndex++;
        });

        // Remove Row
        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });
    </script>
@endsection