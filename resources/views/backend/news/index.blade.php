@extends('backend.layout.app')

@section('content')

    <div class="title-header title-header-1 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <h5 class="mb-0 page-title">
                News
            </h5>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row">

            <div class="col-lg-8">

                <div class="card">

                    <div class="card-body">

                        <div class="title-header d-flex align-items-center justify-content-between mb-3">

                            <h5 class="mb-0">
                                News Articles
                            </h5>
                            @if(auth()->guard('admin')->user()->can('news.create'))
                                <a href="javascript:void(0)" class="btn btn-theme openNewsAdd"
                                    data-url="{{ url('admin/news/add') }}">

                                    Add News Article

                                </a>
                            @endif

                        </div>

                        <div id="ajaxContent"></div>

                    </div>

                </div>

            </div>


            <div class="col-lg-4">

                @include('backend.news.categories')

            </div>

        </div>

    </div>

@endsection


@section('script')

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
        $(document).on("click", ".backNews", function () {

            loadNews()

        })
    </script>

    <script>

        $(document).ready(function () {

            loadNews()

        })

        function loadNews() {

            $.get("{{ url('admin/news/list') }}", function (res) {

                $("#ajaxContent").html(res)
                initLeadershipScripts()

            })

        }


        $(document).on("click", ".openNewsAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)
                initLeadershipScripts()

            })

        })

        $(document).on("click", ".openNewsEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })

    </script>

    <script>
        $(document).on("click", ".editCategory", function () {

            let id = $(this).data("id")
            let name = $(this).data("name")

            let newName = prompt("Edit Category", name)

            if (newName == null || newName == "") return

            $.post("{{url('admin/news/category/update')}}/" + id, {
                _token: "{{csrf_token()}}",
                name: newName
            }, function () {

                location.reload()

            })

        })
    </script>

@endsection