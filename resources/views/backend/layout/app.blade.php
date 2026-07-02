<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="pixelstrap">
    <!-- <link rel="icon" href="" type="image/x-icon"> -->
    <!-- <link rel="shortcut icon" href="" type="image/x-icon"> -->
    <title>{{ !empty($meta_title) ? $meta_title : '' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200&amp;family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet"> -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <!-- Linear Icon css -->
    <link rel="stylesheet" href="{{ url('backend/assets/css/linearicon.css') }}">

    <!-- fontawesome css -->
    <link rel="stylesheet" type="text/css" href="{{ url(path: 'backend/assets/css/vendors/font-awesome.css') }}">

    <!-- Themify icon css-->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/vendors/themify.css') }}">

    <!-- ratio css -->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/ratio.css') }}">

    <!-- Feather icon css-->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/vendors/feather-icon.css') }}">

    <!-- Plugins css -->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/vendors/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/vendors/animate.css') }}">

    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- vector map css -->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/vector-map.css') }}">

    <!-- slick slider css -->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/slick-theme.css') }}">

    <!-- App css -->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/style.css') }}">

    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ url('backend/assets/css/responsive.css') }}">
    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
        rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.min.css"
        rel="stylesheet">
    <script
        src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>


    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />


    <!-- Toster Start-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        .toast-top-right {
            right: 50%;
            transform: translateX(50%);
        }

        #toast-container>div {
            opacity: 1;
            border-radius: 10px;
            box-shadow: none;
        }

        #toast-container>div:hover {
            box-shadow: none;
        }

        .toast-close-button:hover {
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="page-wrapper">

        {{-- Header --}}
        @include('backend.layout.header')

        <div class="page-body-wrapper">

            {{-- Sidebar --}}
            @include('backend.layout.sidebar')

            {{-- Page Content --}}
            <div class="page-body">


                @yield('content')


            </div>

        </div>

    </div>




    <!-- latest js -->
    <script src="{{ url('backend/assets/js/jquery-3.6.0.min.js') }}"></script>

    <!-- Toster Start-->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->

    <script src="{{ url('backend/assets/tinymce/tinymce.min.js') }}"></script>
    <!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script
        src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js"></script>
    <script
        src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
    <script
        src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>

    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            newestOnTop: true,
            preventDuplicates: true,

            showMethod: "fadeIn",
            hideMethod: "fadeOut",

            timeOut: 3000,
            extendedTimeOut: 1000,
            positionClass: "toast-top-right",
            showDuration: 300,
            hideDuration: 300
        };



    </script>

    @include('_message')


    <!-- Bootstrap js -->
    <script src="{{ url('backend/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>

    <!-- feather icon js -->
    <script src="{{ url('backend/assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ url('backend/assets/js/icons/feather-icon/feather-icon.js') }}"></script>

    <!-- scrollbar simplebar js -->
    <!-- <script src="{{ url('backend/assets/js/scrollbar/simplebar.js') }}"></script> -->
    <script src="{{ url('backend/assets/js/scrollbar/custom.js') }}"></script>

    <!-- Sidebar jquery -->
    <script src="{{ url('backend/assets/js/config.js') }}"></script>

    <!-- tooltip init js -->
    <script src="{{ url('backend/assets/js/tooltip-init.js') }}"></script>

    <!-- Plugins JS -->
    <!-- <script src="{{ url('backend/assets/js/sidebar-menu.js') }}"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>



    <script src="{{ url('backend/assets/js/notify/bootstrap-notify.min.js') }}"></script>


    <!-- Apexchar js -->
    <script src="{{ url('backend/assets/js/chart/apex-chart/apex-chart1.js') }}"></script>
    <script src="{{ url('backend/assets/js/chart/apex-chart/moment.min.js') }}"></script>
    <script src="{{ url('backend/assets/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{ url('backend/assets/js/chart/apex-chart/stock-prices.js') }}"></script>
    <script src="{{ url('backend/assets/js/chart/apex-chart/chart-custom1.js') }}"></script>


    <!-- customizer js -->
    <script src="{{ url('backend/assets/js/customizer.js') }}"></script>



    <!-- customizer js -->

    <!-- ratio js -->
    <script src="{{ url('backend/assets/js/ratio.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Theme js -->
    <script src="{{ url('backend/assets/js/script.js') }}"></script>

    @yield('script')
    <script type="text/javascript">

    </script>

    <script>
        $(document).ready(function () {
            const sidebar = $('.sidebar-wrapper');

            $('#mobileSidebarToggle').on("click", function () {
                $('.sidebar-wrapper').toggleClass('open');
                $('body').toggleClass('sidebar-open');
                $('.sidebar-overlay').toggleClass('show');
            });

            $('.sidebar-overlay').on("click", function () {
                $('.sidebar-wrapper').removeClass('open');
                $('body').removeClass('sidebar-open');
                $(this).removeClass('show');
            });





            $(window).on('resize', function () {
                if ($(window).width() > 991) {
                    sidebar.removeClass('open');
                    $('body').removeClass('sidebar-open');
                }
            });
        });


    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const dropdownLinks = document.querySelectorAll(".sidebar-link.has-sub");
            const submenus = document.querySelectorAll(".sidebar-submenu");

            function slideToggle(element, show) {
                element.style.overflow = "hidden";
                element.style.transition = "height 0.3s ease";

                if (show) {
                    element.classList.add("open");
                    const height = element.scrollHeight + "px";
                    element.style.height = "0px";
                    setTimeout(() => { element.style.height = height; }, 10);
                    setTimeout(() => { element.style.height = "auto"; element.style.overflow = "visible"; }, 300);
                } else {
                    const height = element.scrollHeight + "px";
                    element.style.height = height;
                    setTimeout(() => { element.style.height = "0px"; }, 10);
                    setTimeout(() => { element.classList.remove("open"); element.style.overflow = "visible"; }, 300);
                }
            }

            dropdownLinks.forEach(link => {
                link.addEventListener("click", function (e) {
                    e.preventDefault();
                    const parent = link.closest(".sidebar-list");
                    const submenu = parent.querySelector(".sidebar-submenu");
                    if (!submenu) return;

                    const isOpen = submenu.classList.contains("open");

                    submenus.forEach(menu => {
                        if (menu !== submenu && menu.classList.contains("open")) {
                            slideToggle(menu, false);
                            menu.previousElementSibling?.classList.remove("open");
                        }
                    });

                    slideToggle(submenu, !isOpen);
                    link.classList.toggle("open", !isOpen);
                });
            });

            // Auto-open active submenu
            document.querySelectorAll(".sidebar-submenu .active").forEach(a => {
                const submenu = a.closest(".sidebar-submenu");
                submenu.classList.add("open");
                submenu.style.height = "auto";
                submenu.previousElementSibling?.classList.add("open");
            });

        });
    </script>



    <!-- <script>
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            const sidebar = document.querySelector('.sidebar-wrapper');
            const page = document.querySelector('.page-body-wrapper');
            const icon = this.querySelector('i');

            sidebar.classList.toggle('sidebar-collapsed');
            page.classList.toggle('sidebar-collapsed');

            // Rotate arrow
            icon.classList.toggle('fa-angle-left');
            icon.classList.toggle('fa-angle-right');
        });
    </script> -->


    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const sidebar = document.querySelector('.sidebar-wrapper');
            const page = document.querySelector('.page-body-wrapper');
            const toggleBtn = document.getElementById('sidebarToggle');

            function setCollapsed(collapsed) {
                sidebar.classList.toggle('sidebar-collapsed', collapsed);
                page.classList.toggle('sidebar-collapsed', collapsed);
            }

            /* -----------------------------
               ✅ DEFAULT = OPEN
            ----------------------------- */
            const savedMode = localStorage.getItem('sidebarMode');

            if (savedMode === 'collapsed') {
                setCollapsed(true);
            } else {
                setCollapsed(false); // 👈 open by default
            }

            /* -----------------------------
               Toggle button
            ----------------------------- */
            toggleBtn.addEventListener('click', function () {

                const isCollapsed = sidebar.classList.contains('sidebar-collapsed');

                if (isCollapsed) {
                    localStorage.setItem('sidebarMode', 'open');
                    setCollapsed(false);
                } else {
                    localStorage.setItem('sidebarMode', 'collapsed');
                    setCollapsed(true);
                }

            });

        });
    </script>

</body>

</html>