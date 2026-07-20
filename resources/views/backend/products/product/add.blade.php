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
                        <label>Display Order</label>
                        <input type="number" name="display_order" class="form-control" value="999" min="1" required>
                        <small class="text-muted">Set to 1, 2, 3, etc. Products will be sorted by this order on the website (ascending).</small>
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
                        <label>Profile Pic (Thumbnail/Card Image)</label>
                        <input type="file" name="profile_pic" class="form-control" accept="image/*">
                        <small class="text-muted">Upload an optimized, well-framed photo to be displayed on product cards in lists and homepage.</small>
                    </div>

                    <div class="mb-3">
                        <label>Product Specifications PDF (Optional)</label>
                        <input type="file" name="specification_pdf" class="form-control" accept="application/pdf,.pdf">
                        <small class="text-muted">Upload a finished PDF for the Download PDF button. Leave blank to let the website generate a PDF from this product's image, description, specifications and capabilities.</small>
                    </div>

                    <div class="mb-3">

                        <label>Images</label>

                        <input type="file" class="filepond" name="filepond[]" multiple>

                    </div>

                    <!-- TECHNICAL SPECIFICATIONS TAB/CARD -->
                    <div class="card mt-4 mb-4 border-info">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0 text-white"><i class="fa fa-cogs"></i> Technical Specifications Section</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Specifications Section Subheading / Intro Info</label>
                                <input type="text" name="specs_subtext" class="form-control" placeholder="e.g. Designed for precision, built for performance...">
                                <small class="text-muted">Displays as the paragraph text below the Specifications section heading.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Specifications Photo / Image (Right Side)</label>
                                <input type="file" name="specs_image" class="form-control" accept="image/*">
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
                                        <!-- Dynamic rows will be inserted here -->
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
                                        <!-- Dynamic rows will be inserted here -->
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="addCapRow">
                                <i class="fa fa-plus"></i> Add Capability Row
                            </button>
                        </div>
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

    <script>
        let specIndex = 0;
        let capIndex = 0;

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
                        <textarea name="main_capabilities[${capIndex}][description]" class="form-control form-control-sm" rows="2" required placeholder="e.g. Generates extreme drag force to reduce landing run..."></textarea>
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
