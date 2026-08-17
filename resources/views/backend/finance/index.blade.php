@extends('backend.layout.app')

@section('content')

    <div class="title-header title-header-1 d-flex align-items-center justify-content-between">

        <div class="d-flex align-items-center gap-3">

            <h5 class="mb-0 page-title">
                Finance
            </h5>

        </div>

        <div class="d-flex align-items-center gap-2">
            <span style="font-weight: 500; font-size: 14px;">EOI for Banks Tab:</span>
            <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" role="switch" id="toggleEoiStatus" 
                       {{ $eoiEnabled ? 'checked' : '' }} style="cursor: pointer; width: 45px; height: 22px;">
                <label class="form-check-label" for="toggleEoiStatus" id="eoiStatusLabel" style="font-size: 14px; font-weight: 600; margin-left: 8px;">
                    {{ $eoiEnabled ? 'Enabled' : 'Disabled' }}
                </label>
            </div>
        </div>

    </div>



    <div class="container-fluid">

        <div class="card">

            <div class="tabs-menu">
                @if(auth()->guard('admin')->user()->can('annual_reports.view'))
                    <button class="tab-btn active" data-url="{{ url('admin/finance/reports') }}">

                        Annual Report

                    </button>

                    <button class="tab-btn" data-url="{{ url('admin/finance/returns') }}">

                        Annual Returns

                    </button>
                @endif

                @if(auth()->guard('admin')->user()->can('eoi_for_banks.view'))

                    <button class="tab-btn" data-url="{{ url('admin/finance/eoi') }}">

                        EOI for Banks

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

                let url = "{{ url('admin/finance') }}/" + tab

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
        $(document).on("click", ".openReportAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })


        $(document).on("click", ".openReportEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })


        $(document).on("click", ".backReport", function () {

            $.get("{{ url('admin/finance/reports') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })

        $(document).on("click", ".openReturnAdd, .openReturnEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

            })

        })

        $(document).on("click", ".backReturn", function () {

            $.get("{{ url('admin/finance/returns') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })
    </script>

    <script>
        $(document).on("click", ".openEoiAdd", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })


        $(document).on("click", ".openEoiEdit", function () {

            let url = $(this).data("url")

            $.get(url, function (res) {

                $("#ajaxContent").html(res)

                initLeadershipScripts()

            })

        })


        $(document).on("click", ".backEoi", function () {

            $.get("{{ url('admin/finance/eoi') }}", function (res) {

                $("#ajaxContent").html(res)

            })

        })

        // Persist the EOI visibility switch and only show a new state after the
        // server confirms it. A failed or expired request restores the old state.
        $(document)
            .off("change.financeEoi", "#toggleEoiStatus")
            .on("change.financeEoi", "#toggleEoiStatus", async function () {
                const checkbox = this;
                const requestedState = checkbox.checked;
                const previousState = !requestedState;
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                checkbox.disabled = true;

                try {
                    const response = await fetch("{{ route('admin.finance.toggle-eoi') }}", {
                        method: "POST",
                        credentials: "same-origin",
                        headers: {
                            "Accept": "application/json",
                            "Content-Type": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": csrfToken || "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ enabled: requestedState })
                    });

                    const data = await response.json().catch(() => ({}));

                    if (!response.ok || data.status !== 'success') {
                        throw new Error(response.status === 419 ? 'session-expired' : 'save-failed');
                    }

                    checkbox.checked = Boolean(data.enabled);
                    const statusText = checkbox.checked ? "Enabled" : "Disabled";
                    $("#eoiStatusLabel").text(statusText);
                    toastr.success('EOI for Banks tab ' + statusText.toLowerCase() + ' successfully.');
                } catch (error) {
                    checkbox.checked = previousState;
                    $("#eoiStatusLabel").text(previousState ? "Enabled" : "Disabled");

                    if (error.message === 'session-expired') {
                        toastr.error('Your admin session has expired. Please sign in again.');
                    } else {
                        toastr.error('EOI setting could not be saved. The previous state has been restored.');
                    }
                } finally {
                    checkbox.disabled = false;
                }
            });
    </script>


@endsection
