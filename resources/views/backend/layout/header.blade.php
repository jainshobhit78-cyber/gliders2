<div class="tap-top">
    <span class="lnr lnr-chevron-up"></span>
</div>

<div class="page-wrapper compact-wrapper dark-sidebar" id="pageWrapper">


    <!-- Mobile Header -->
    <div class="mobile-header d-lg-none d-flex align-items-center justify-content-between px-3 py-2">


        <button id="mobileSidebarToggle" class="mobile-menu-btn">
            <i class="fa fa-bars"></i>
        </button>


        <div class="mobile-logo">
            <a href="{{ url('admin/dashboard') }}" style="font-size:25px; font-weight: 900;">
                GlidersIndia
            </a>
        </div>


        <div class="mobile-profile dropdown">
            <img src="{{ asset('backend/assets/images/profile/user.png') }}" class="rounded-circle mobile-profile-img"
                width="32" height="32" style="cursor:pointer; object-fit:cover;" data-bs-toggle="dropdown"
                data-bs-display="static">

            <ul class="dropdown-menu dropdown-menu-end mobile-profile-menu">
                <li><a class="dropdown-item" href="{{ url('admin/profile') }}"><i class="fa fa-user"></i> Profile</a>
                </li>

                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i
                            class="fa fa-power-off"></i> Logout</a></li>
            </ul>
        </div>

    </div>



    <script>
        // $(window).on("scroll", function () {
        //     if ($(this).scrollTop() > 80) {
        //         $(".mobile-header").addClass("sticky");
        //     } else {
        //         $(".mobile-header").removeClass("sticky");
        //     }
        // });

        window.addEventListener("scroll", function () {
            const head = document.querySelector(".mobile-header");
            if (window.scrollY > 10) {
                head.classList.add("scrolled");
            } else {
                head.classList.remove("scrolled");
            }
        });

        document.addEventListener("click", function (e) {
            const dropdown = document.querySelector(".mobile-profile .dropdown-menu");
            const toggle = document.querySelector(".mobile-profile img");

            // If clicked outside
            if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove("show");
            }
        });

        // Toggle dropdown on profile click
        document.querySelector(".mobile-profile img").addEventListener("click", function (e) {
            e.stopPropagation();
            document.querySelector(".mobile-profile .dropdown-menu").classList.toggle("show");
        });


    </script>