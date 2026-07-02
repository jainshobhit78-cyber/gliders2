@extends('backend.layout.app')



@section('content')

    <div class="title-header title-header-1 d-flex align-items-center justify-content-between" style="margin-bottom:12px;">
        <div class="d-flex align-items-center gap-3">
            <h5 class="mb-0 page-title">About</h5>
        </div>

    </div>

    <div class="container-fluid">

        <div class="card">

            <div class="tabs-menu">
                @if(auth()->guard('admin')->user()->can('leadership.view'))
                    <button class="tab-btn active" data-url="{{ url('admin/about/leadership') }}">
                        Leadership
                    </button>
                @endif

                @if(auth()->guard('admin')->user()->can('production_unit.view'))
                    <button class="tab-btn" data-url="{{ url('admin/about/production-unit') }}">
                        Production Unit
                    </button>
                @endif

                @if(auth()->guard('admin')->user()->can('history.view'))
                    <button class="tab-btn" data-url="{{ url('admin/about/history') }}">
                        History
                    </button>
                @endif
                @if(auth()->guard('admin')->user()->can('social_responsibility.view'))
                    <button class="tab-btn" data-url="{{ url('admin/about/social-responsibility') }}">
                        Social Responsibility
                    </button>
                @endif
                @if(auth()->guard('admin')->user()->can('human_resources.view'))
                    <button class="tab-btn" data-url="{{ url('admin/about/human-resources') }}">
                        Human Resources
                    </button>
                @endif
                @if(auth()->guard('admin')->user()->can('vision.view'))
                    <button class="tab-btn" data-url="{{ url('admin/about/vision') }}">
                        Vision
                    </button>
                @endif
                @if(auth()->guard('admin')->user()->can('mission.view'))
                    <button class="tab-btn" data-url="{{ url('admin/about/mission') }}">
                        Mission
                    </button>
                @endif
                @if(auth()->guard('admin')->user()->can('directory.view'))
                    <button class="tab-btn" data-url="{{ url('admin/about/directory') }}">
                        Directory
                    </button>
                @endif
                @if(auth()->guard('admin')->user()->can('codes_of_conduct.view'))
                    <button class="tab-btn" data-url="{{ url('admin/about/codes') }}">
                        Codes of Conduct
                    </button>
                @endif
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

                let url = "{{ url('admin/about') }}/" + tab;

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

                let tab = url.split('/').pop();

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

                    // tinymce.init({
                    //     selector: '.editor',
                    //     height: 350,
                    //     menubar: true,
                    //     plugins: [
                    //         'advlist autolink lists charmap preview anchor', // ❌ removed link, image
                    //         'searchreplace visualblocks code fullscreen',
                    //         'insertdatetime media table code wordcount'
                    //     ],
                    //     toolbar:
                    //         'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | forecolor backcolor | code fullscreen preview', // ❌ removed link image
                    //     content_style: `
                    //                 body {
                    //                     background: transparent !important;
                    //                 }
                    //                 p {
                    //                     background: transparent !important;
                    //                 }
                    //             `
                    // });

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
        $(document).on("click", ".openLeadershipAdd", function () {

            let url = $(this).data("url");

            $.get(url, function (res) {

                $("#ajaxContent").html(res);

                initLeadershipScripts(); // IMPORTANT

            });

        });

        $(document).on("click", ".backLeadership", function () {

            $.get("{{ url('admin/about/leadership') }}", function (res) {

                $("#ajaxContent").html(res);

                initLeadershipScripts();

            });

        });

        $(document).on("click", ".openLeadershipEdit", function () {

            let url = $(this).data("url");

            $.get(url, function (res) {

                $("#ajaxContent").html(res);

                initLeadershipScripts(); // re-init editor, preview etc

            });

        });
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
        $(document).on("click", ".openProductionAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()
                initFilepond()

            })

        })

        $(document).on("click", ".openProductionEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()
                initFilepond()
                initEditFilepond();

            })

        })

        $(document).on("click", ".backProduction", function () {

            $.get("{{ url('admin/about/production-unit') }}", function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()
                initFilepond()

            })

        })
    </script>

    <script>
        $(document).on("click", ".openHistoryAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })


        $(document).on("click", ".openHistoryEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })


        $(document).on("click", ".backHistory", function () {

            $.get("{{ url('admin/about/history') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })
    </script>

    <script>
        $(document).on("click", ".openSocialAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })

        $(document).on("click", ".openSocialEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })

        $(document).on("click", ".backSocial", function () {

            $.get("{{ url('admin/about/social-responsibility') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })
    </script>

    <script>
        $(document).on("click", ".openHrAdd", function () {

            let url = $(this).data("url");

            $.get(url, function (res) {

                $("#ajaxContent").html(res);

                initLeadershipScripts();

            });

        });

        $(document).on("click", ".openHrEdit", function () {

            let url = $(this).data("url");

            $.get(url, function (res) {

                $("#ajaxContent").html(res);

                initLeadershipScripts();

            });

        });

        $(document).on("click", ".backHr", function () {

            $.get("{{ url('admin/about/human-resources') }}", function (res) {

                $("#ajaxContent").html(res);

            });

        });
    </script>

    <script>
        $(document).on("click", ".openVisionAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })

        $(document).on("click", ".openVisionEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })

        $(document).on("click", ".backVision", function () {

            $.get("{{ url('admin/about/vision') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })
    </script>

    <script>
        $(document).on("click", ".openMissionAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })

        $(document).on("click", ".openMissionEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })

        $(document).on("click", ".backMission", function () {

            $.get("{{ url('admin/about/mission') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })
    </script>

    <script>
        $(document).on("click", ".openDirectoryAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

            })

        })

        $(document).on("click", ".openDirectoryEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

            })

        })

        $(document).on("click", ".backDirectory", function () {

            $.get("{{ url('admin/about/directory') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })
    </script>

    <script>
        $(document).on("click", ".openCodesAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })

        $(document).on("click", ".openCodesEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })

        $(document).on("click", ".backCodes", function () {

            $.get("{{ url('admin/about/codes') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })
    </script>

@endsection