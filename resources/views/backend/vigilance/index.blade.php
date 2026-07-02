@extends('backend.layout.app')

@section('content')

    <div class="title-header title-header-1 d-flex align-items-center justify-content-between">

        <div class="d-flex align-items-center gap-3">

            <h5 class="mb-0 page-title">
                Vigilance
            </h5>

        </div>

    </div>



    <div class="container-fluid">

        <div class="card">

            <div class="tabs-menu">

                @if(auth()->guard('admin')->user()->can('chief_vigilance_officer.view'))
                    <button class="tab-btn active" data-url="{{ url('admin/vigilance/cvo') }}">
                        Chief Vigilance Officer
                    </button>
                @endif
                @if(auth()->guard('admin')->user()->can('vigilance_setup.view'))
                    <button class="tab-btn" data-url="{{ url('admin/vigilance/setup') }}">
                        Vigilance Setup
                    </button>
                @endif
                @if(auth()->guard('admin')->user()->can('vigilance_contact_details.view'))
                    <button class="tab-btn" data-url="{{ url('admin/vigilance/contact') }}">
                        Contact Details
                    </button>
                @endif
                @if(auth()->guard('admin')->user()->can('sexual_harassment_of_women_at_workplace.view'))
                    <button class="tab-btn" data-url="{{ url('admin/vigilance/harassment') }}">
                        Sexual Harassment of Women at Workplace
                    </button>
                @endif
                @if(auth()->guard('admin')->user()->can('independent_external_monitor.view'))
                    <button class="tab-btn" data-url="{{ url('admin/vigilance/monitor') }}">
                        Independent External Monitor
                    </button>
                @endif
                @if(auth()->guard('admin')->user()->can('manuals_and_policies.view'))
                    <button class="tab-btn" data-url="{{ url('admin/vigilance/manuals') }}">
                        Manuals and Policies
                    </button>
                @endif
                @if(auth()->guard('admin')->user()->can('vigilance_bulletin.view'))
                    <button class="tab-btn" data-url="{{ url('admin/vigilance/bulletin') }}">
                        Vigilance Bulletin
                    </button>
                @endif
            </div>



            <div id="ajaxContent"></div>


        </div>

    </div>

@endsection


@section('script')

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


            let params = new URLSearchParams(window.location.search)
            let tab = params.get("tab")

            if (tab) {

                let url = "{{ url('admin/vigilance') }}/" + tab;

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

                $(".tab-btn").removeClass("active")

                $(this).addClass("active")

                let url = $(this).data("url")

                let tab = url.split('/').pop()

                history.replaceState(null, null, "?tab=" + tab)

                loadTab(url)

            })

        })

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

            FilePond.registerPlugin(
                FilePondPluginImagePreview,
                FilePondPluginImageExifOrientation
            );

            FilePond.setOptions({
                allowMultiple: true,
                allowReorder: true,
                storeAsFile: true
            });

            FilePond.parse(document.body);

        }
    </script>

    <script>
        $(document).on("click", ".openCvoAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()
                initFilepond()

            })

        })


        $(document).on("click", ".openCvoEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()
                initFilepond()

            })

        })


        $(document).on("click", ".backCvo", function () {

            $.get("{{ url('admin/vigilance/cvo') }}", function (res) {

                $("#ajaxContent").html(res)


            })

        })
    </script>

    <script>
        $(document).on("click", ".openSetupAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })


        $(document).on("click", ".openSetupEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })


        $(document).on("click", ".backSetup", function () {

            $.get("{{ url('admin/vigilance/setup') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })
    </script>

    <script>
        $(document).on("click", ".openContactAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })


        $(document).on("click", ".openContactEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })


        $(document).on("click", ".backContact", function () {

            $.get("{{ url('admin/vigilance/contact') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })
    </script>

    <script>
        $(document).on("click", ".openSexualAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })


        $(document).on("click", ".openSexualEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })


        $(document).on("click", ".backSexual", function () {

            $.get("{{ url('admin/vigilance/harassment') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })
    </script>

    <script>
        $(document).on("click", ".openMonitorAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })


        $(document).on("click", ".openMonitorEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })


        $(document).on("click", ".backMonitor", function () {

            $.get("{{ url('admin/vigilance/monitor') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })
    </script>

    <script>
        $(document).on("click", ".openManualAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })


        $(document).on("click", ".openManualEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })


        $(document).on("click", ".backManual", function () {

            $.get("{{ url('admin/vigilance/manuals') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })
    </script>

    <script>
        $(document).on("click", ".openBulletinAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })


        $(document).on("click", ".openBulletinEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })


        $(document).on("click", ".backBulletin", function () {

            $.get("{{ url('admin/vigilance/bulletin') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })
    </script>

@endsection