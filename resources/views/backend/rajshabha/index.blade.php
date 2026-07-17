@extends('backend.layout.app')

@section('content')

    <div class="title-header title-header-1 d-flex align-items-center justify-content-between">

        <div class="d-flex align-items-center gap-3">

            <h5 class="mb-0 page-title">
                Rajshabha
            </h5>

        </div>

    </div>



    <div class="container-fluid">

        <div class="card">

            <div class="tabs-menu">
                @if(auth()->guard('admin')->user()->can('niyam_pustak.view'))
                    <button class="tab-btn active" data-url="{{ url('admin/rajshabha/niyam') }}">
                        Niyam Pustak
                    </button>
                @endif

                @if(auth()->guard('admin')->user()->can('rajshabha_rules.view'))
                    <button class="tab-btn" data-url="{{ url('admin/rajshabha/rules') }}">
                        Rajbhasha Rules
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

                $.get(url, function (res) {

                    $("#ajaxContent").html(res)

                    initLeadershipScripts()
                    initFilepond()

                })

            }


            let params = new URLSearchParams(window.location.search)
            let tab = params.get("tab")

            if (tab) {

                let url = "{{ url('admin/rajshabha') }}/" + tab

                loadTab(url)

                $(".tab-btn").removeClass("active")

                $('.tab-btn[data-url="' + url + '"]').addClass("active")

            }
            else {

                // let first = $(".tab-btn.active").data("url")
                // loadTab(first)

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
        $(document).on("click", ".openAboutAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })

        $(document).on("click", ".openAboutEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })

        $(document).on("click", ".backAbout", function () {

            $.get("{{ url('admin/rajshabha/about') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })
    </script>

    <script>
        $(document).on("click", ".openNiyamAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

            })

        })

        $(document).on("click", ".openNiyamEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

            })

        })

        $(document).on("click", ".backNiyam", function () {

            $.get("{{ url('admin/rajshabha/niyam') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })
    </script>

    <script>
        $(document).on("click", ".openRulesAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

            })

        })

        $(document).on("click", ".openRulesEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

            })

        })

        $(document).on("click", ".backRules", function () {

            $.get("{{ url('admin/rajshabha/rules') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })
    </script>

@endsection