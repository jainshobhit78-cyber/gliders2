@extends('backend.layout.app')



@section('content')

    <div class="title-header title-header-1 d-flex align-items-center justify-content-between" style="margin-bottom:12px;">
        <div class="d-flex align-items-center gap-3">
            <h5 class="mb-0 page-title">Home Page</h5>
        </div>

    </div>

    <div class="container-fluid">

        <div class="card">

            <div class="tabs-menu">
                {{-- @if(auth()->guard('admin')->user()->can('leadership.view')) --}}
                <button class="tab-btn active" data-url="{{ url('admin/home/key_offerings') }}">
                    Our Key Offerings
                </button>
                {{-- @endif --}}

                <button class="tab-btn" data-url="{{ url('admin/home/image_gallery') }}">
                    Image Gallery
                </button>

                <button class="tab-btn" data-url="{{ url('admin/home/partner_logo') }}">
                   Partner Logo
                </button>

                <button class="tab-btn" data-url="{{ url('admin/home/video_banner/edit') }}">
                    Video Banner
                </button>

                <button class="tab-btn" data-url="{{ url('admin/home/marquee/edit') }}">
                    Marquee Text
                </button>

                <button class="tab-btn" data-url="{{ url('admin/home/state_counter/edit') }}">
                    State Counter
                </button>

                <button class="tab-btn" data-url="{{ url('admin/home/our_units/edit') }}">
                    Our Units
                </button>

            </div>

            <div id="ajaxContent"></div>

        </div>

    </div>

@endsection

@section('script')
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-metadata/dist/filepond-plugin-file-metadata.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script
        src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js"></script>
    <script
        src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>


    <script>
        $(document).ready(function () {

            function loadTab(url) {

                if (!url) {
                    console.warn("No tab URL found ❌");
                    return;
                }

                $.get(url, function (res) {
                    $("#ajaxContent").html(res);
                    initLeadershipScripts();
                    initFilepond();
                });
            }

            let params = new URLSearchParams(window.location.search);
            let tab = params.get("tab");

            if (tab) {

                let url = "{{ url('admin') }}/" + tab;

                // check if button exists
                if ($('.tab-btn[data-url="' + url + '"]').length) {
                    loadTab(url);
                    $(".tab-btn").removeClass("active");
                    $('.tab-btn[data-url="' + url + '"]').addClass("active");
                } else {
                    $(".tab-btn").first().click();
                }
            }
            else {

                let firstTab = $(".tab-btn").first();

                if (firstTab.length) {
                    let url = firstTab.data("url");
                    loadTab(url);
                }

            }

            $(".tab-btn").click(function () {

                $(".tab-btn").removeClass("active");
                $(this).addClass("active");

                let url = $(this).data("url");

                let tab = url.replace("{{ url('admin/') }}/", "");
                history.replaceState(null, null, "?tab=" + tab);

                loadTab(url);

            });

        });


        function initLeadershipScripts() {

            // TinyMCE safe initialization
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

            // Image preview
            const input = document.getElementById("pictureInput");

            if (input) {

                input.addEventListener("change", function (e) {

                    const file = e.target.files[0];
                    if (!file) return;

                    const reader = new FileReader();

                    reader.onload = function (event) {

                        const img = document.getElementById("imagePreview");

                        if (img) {
                            img.src = event.target.result;
                            img.style.display = "block";
                        }

                    };

                    reader.readAsDataURL(file);

                });

            }

        }

    </script>




    <script>
        function initFilepond() {

            if (typeof FilePond === "undefined") {
                console.log("FilePond not loaded ❌");
                return;
            }

            FilePond.registerPlugin(
                FilePondPluginImagePreview,
                FilePondPluginImageExifOrientation,
                FilePondPluginFileMetadata,
                FilePondPluginFileValidateType
            );

            document.querySelectorAll('.filepond').forEach(input => {

                // Prevent duplicate init
                if (input._pond) return;

                const pond = FilePond.create(input, {
                    allowMultiple: true,
                    allowReorder: true,
                    storeAsFile: true,

                    acceptedFileTypes: [
                        'image/jpeg',
                        'image/png',
                        'image/jpg',
                        'image/webp',
                        'image/svg+xml'
                    ],

                    fileValidateTypeLabelExpectedTypes:
                        "Only JPG, PNG, JPEG, WEBP, SVG allowed"
                });

                input._pond = pond; // mark initialized
            });
        }

    </script>

    <script>
        $(document).on("click", ".openKeyAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })

        $(document).on("click", ".openKeyEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })

        $(document).on("click", ".backKey", function () {

            $.get("{{ url('admin/home/key_offerings') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })
    </script>

    <script>
        $(document).on("click", ".openImageAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })

        $(document).on("click", ".openImageEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })

        $(document).on("click", ".backImageList", function () {

            $.get("{{ url('admin/home/image_gallery') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })
    </script>

    <script>
        $(document).on("click", ".openLogoAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })

        $(document).on("click", ".openLogoEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })

        $(document).on("click", ".backLogoList", function () {

            $.get("{{ url('admin/home/partner_logo') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })
    </script>



@endsection