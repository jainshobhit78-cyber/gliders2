<style>
    .sidebar-list {
        margin: 0 13px;
    }
</style>

<!-- Page Body Start-->

<!-- Page Sidebar Start-->
<div class="sidebar-wrapper">
    <div class="">
        <div class="logo-wrapper logo-wrapper-center">
            <a href="{{ url('admin/dashboard') }}">
                <img src="{{ url('backend/assets/images/logo/gliders.png') }}" alt="">


            </a>
        </div>

        <nav class="sidebar-main">


            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"></li>
                    @if(auth()->guard('admin')->user()->can('dashboard.view'))
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav
                                                                                                                    @if(Request::is('admin/dashboard')) active @endif"
                                href="{{ url('admin/dashboard') }}">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14 21C13.4477 21 13 20.5523 13 20V12C13 11.4477 13.4477 11 14 11H20C20.5523 11 21 11.4477 21 12V20C21 20.5523 20.5523 21 20 21H14ZM4 13C3.44772 13 3 12.5523 3 12V4C3 3.44772 3.44772 3 4 3H10C10.5523 3 11 3.44772 11 4V12C11 12.5523 10.5523 13 10 13H4ZM9 11V5H5V11H9ZM4 21C3.44772 21 3 20.5523 3 20V16C3 15.4477 3.44772 15 4 15H10C10.5523 15 11 15.4477 11 16V20C11 20.5523 10.5523 21 10 21H4ZM5 19H9V17H5V19ZM15 19H19V13H15V19ZM13 4C13 3.44772 13.4477 3 14 3H20C20.5523 3 21 3.44772 21 4V8C21 8.55228 20.5523 9 20 9H14C13.4477 9 13 8.55228 13 8V4ZM15 5V7H19V5H15Z" />
                                </svg>
                                <span>Dashboard</span>
                            </a>
                        </li>
                    @endif

                    @if(auth()->guard('admin')->user()->can('about.view'))
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav
                                                                                                                    @if(Request::is('admin/about*')) active @endif"
                                href="{{ url('admin/about') }}">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M3 6H21V18H3V6ZM2 4C1.44772 4 1 4.44772 1 5V19C1 19.5523 1.44772 20 2 20H22C22.5523 20 23 19.5523 23 19V5C23 4.44772 22.5523 4 22 4H2ZM13 9H19V11H13V9ZM18 13H13V15H18V13ZM6 13H7V16H9V11H6V13ZM9 8H7V10H9V8Z" />
                                </svg>
                                <span>About</span>
                            </a>
                        </li>
                    @endif

                    @if(auth()->guard('admin')->user()->can('legacy.view'))
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav
                                @if(Request::is('admin/legacy*')) active @endif"
                                href="{{ url('admin/legacy') }}">
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M12 2l2.7 5.9 6.3.7-4.8 4.3 1.4 6.2L12 17l-5.6 3.1 1.4-6.2-4.8-4.3 6.3-.7Z"/></svg>
                                <span>Gliders Legacy</span>
                            </a>
                        </li>
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav
                                @if(Request::is('admin/opf-legacy*')) active @endif"
                                href="{{ url('admin/opf-legacy') }}">
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M12 2l2.7 5.9 6.3.7-4.8 4.3 1.4 6.2L12 17l-5.6 3.1 1.4-6.2-4.8-4.3 6.3-.7Z"/></svg>
                                <span>OPF Legacy</span>
                            </a>
                        </li>
                    @endif


                    @if(auth()->guard('admin')->user()->can('news.view'))
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav
                                                                                                            @if(Request::is('admin/news*')) active @endif"
                                href="{{ url('admin/news') }}">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20 22H4C3.44772 22 3 21.5523 3 21V3C3 2.44772 3.44772 2 4 2H20C20.5523 2 21 2.44772 21 3V21C21 21.5523 20.5523 22 20 22ZM19 20V4H5V20H19ZM7 6H11V10H7V6ZM7 12H17V14H7V12ZM7 16H17V18H7V16ZM13 7H17V9H13V7Z" />
                                </svg>

                                <span>News</span>

                            </a>
                        </li>
                    @endif

                    @if(auth()->guard('admin')->user()->canAny(['media.view', 'manuals_and_policies.view']))
                        <li class="sidebar-list">
                            <a class="linear-icon-link sidebar-link sidebar-title has-sub
                                @if(Request::is('admin/media*') || Request::is('admin/vigilance*') && request('tab') == 'manuals') open @endif">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                                    <path d="M20 2H4C2.9 2 2 2.9 2 4V20C2 21.1 2.9 22 4 22H20C21.1 22 22 21.1 22 20V4C22 2.9 21.1 2 20 2ZM20 20H4V4H20V20ZM6 7H18V9H6V7ZM6 11H18V13H6V11ZM6 15H14V17H6V15Z" fill="currentColor"/>
                                </svg>
                                <span>Resources</span>
                                <i class="arrow" data-feather="chevron-right"></i>
                            </a>
                            <ul class="sidebar-submenu
                                @if(Request::is('admin/media*') || Request::is('admin/vigilance*') && request('tab') == 'manuals') open @endif">
                                @if(auth()->guard('admin')->user()->can('media.view'))
                                    <li>
                                        <a href="{{ url('admin/media') }}"
                                            class="{{ Request::is('admin/media*') ? 'active' : '' }}">
                                            Media
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->guard('admin')->user()->can('manuals_and_policies.view'))
                                    <li>
                                        <a href="{{ url('admin/vigilance?tab=manuals') }}"
                                            class="{{ Request::is('admin/vigilance*') && request('tab') == 'manuals' ? 'active' : '' }}">
                                            Manuals and Policies
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if(auth()->guard('admin')->user()->canAny(['product_categories.view', 'product.view']))
                        <li class="sidebar-list">

                            <a
                                class="linear-icon-link sidebar-link sidebar-title has-sub
                                                                                                                                                            @if(
                                                                                                                                                                Request::is('admin/category*') ||
                                                                                                                                                                Request::is('admin/product*')
                                                                                                                                                            ) open @endif">

                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 1L21.5 6.5V17.5L12 23L2.5 17.5V6.5L12 1ZM5.49388 7.0777L12.0001 10.8444L18.5062 7.07774L12 3.311L5.49388 7.0777ZM4.5 8.81329V16.3469L11.0001 20.1101V12.5765L4.5 8.81329ZM13.0001 20.11L19.5 16.3469V8.81337L13.0001 12.5765V20.11Z"
                                        fill="" />
                                </svg>
                                <span>Products</span>
                                <i class="arrow" data-feather="chevron-right"></i>
                            </a>

                            <ul
                                class="sidebar-submenu
                                                                                                                @if(
                                                                                                                    Request::is('admin/category*') ||
                                                                                                                    Request::is('admin/product*')
                                                                                                                ) open @endif">
                                @if(auth()->guard('admin')->user()->can('product_categories.view'))
                                    <li>
                                        <a href="{{ url('admin/category/list') }}"
                                            class="{{ Request::is('admin/category*') ? 'active' : '' }}">
                                            All Categories
                                        </a>
                                    </li>
                                @endif

                                @if(auth()->guard('admin')->user()->can('product.view'))
                                    <li>
                                        <a href="{{ url('admin/product/list') }}"
                                            class="{{ Request::is('admin/product*') ? 'active' : '' }}">
                                            All Products
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if(auth()->guard('admin')->user()->can('vigilance.view'))
                        <li class="sidebar-list">

                            <a class="sidebar-link sidebar-title link-nav
                                                                                                                                                    @if(Request::is('admin/vigilance*')) active @endif"
                                href="{{ url('admin/vigilance') }}">

                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20 22H6C4.34315 22 3 20.6569 3 19V5C3 3.34315 4.34315 2 6 2H20C20.5523 2 21 2.44772 21 3V21C21 21.5523 20.5523 22 20 22ZM19 20V18H6C5.44772 18 5 18.4477 5 19C5 19.5523 5.44772 20 6 20H19ZM5 16.1707C5.31278 16.0602 5.64936 16 6 16H19V4H6C5.44772 4 5 4.44772 5 5V16.1707ZM12 10C10.8954 10 10 9.10457 10 8C10 6.89543 10.8954 6 12 6C13.1046 6 14 6.89543 14 8C14 9.10457 13.1046 10 12 10ZM9 14C9 12.3431 10.3431 11 12 11C13.6569 11 15 12.3431 15 14H9Z" />
                                </svg>
                                <span>Vigilance</span>
                            </a>
                        </li>
                    @endif

                    @if(auth()->guard('admin')->user()->can('rti.view'))
                        <li class="sidebar-list">

                            <a class="sidebar-link sidebar-title link-nav
                                                                                                                                                @if(Request::is('admin/rti*')) active @endif"
                                href="{{ url('admin/rti') }}">

                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M16.7574 2.99715L14.7574 4.99715H5V18.9972H19V9.2398L21 7.2398V19.9972C21 20.5495 20.5523 20.9972 20 20.9972H4C3.44772 20.9972 3 20.5495 3 19.9972V3.99715C3 3.44487 3.44772 2.99715 4 2.99715H16.7574ZM20.4853 2.09766L21.8995 3.51187L12.7071 12.7043L11.2954 12.7068L11.2929 11.2901L20.4853 2.09766Z" />
                                </svg>
                                <span>RTI</span>
                            </a>
                        </li>
                    @endif

                    @if(auth()->guard('admin')->user()->can('careers.view'))
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav
                                                                                                                                            @if(Request::is('admin/careers*')) active @endif"
                                href="{{ url('admin/careers') }}">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M3 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3ZM4 5V19H20V5H4ZM7 13H9V17H7V13ZM11 7H13V17H11V7ZM15 10H17V17H15V10Z" />
                                </svg>
                                <span>Careers</span>
                            </a>
                        </li>
                    @endif

                    @if(auth()->guard('admin')->user()->can('finance.view'))
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav
                                                                                                                                        @if(Request::is('admin/finance*')) active @endif"
                                href="{{ url('admin/finance') }}">

                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5.00488 9.00195C5.55717 9.00195 6.00488 9.44966 6.00488 10.0019C7.63965 10.0019 9.14352 10.5623 10.3349 11.5014L12.5049 11.5019C13.8375 11.5019 15.0348 12.0812 15.8588 13.0016L19.0049 13.0019C20.9972 13.0019 22.7173 14.1672 23.521 15.8533C21.1562 18.9739 17.3268 21.0019 13.0049 21.0019C10.2142 21.0019 7.85466 20.3987 5.944 19.344C5.80557 19.7275 5.43727 20.0019 5.00488 20.0019H2.00488C1.4526 20.0019 1.00488 19.5542 1.00488 19.0019V10.0019C1.00488 9.44966 1.4526 9.00195 2.00488 9.00195H5.00488ZM6.00589 12.0019L6.00488 17.0239L6.05024 17.0564C7.84406 18.3168 10.183 19.0019 13.0049 19.0019C16.0089 19.0019 18.8035 17.8463 20.84 15.8725L20.9729 15.7389L20.8537 15.6385C20.3897 15.2755 19.8205 15.0503 19.2099 15.0088L19.0049 15.0019H16.8934C16.9664 15.3235 17.0049 15.6582 17.0049 16.0019V17.0019H8.00488V15.0019L14.7949 15.0009L14.7605 14.9224C14.38 14.1288 13.593 13.5672 12.6693 13.5072L12.5049 13.5019L9.57547 13.5018C8.66823 12.5764 7.40412 12.0022 6.00589 12.0019ZM4.00488 11.0019H3.00488V18.0019H4.00488V11.0019ZM18.0049 5.00195C19.6617 5.00195 21.0049 6.34509 21.0049 8.00195C21.0049 9.6588 19.6617 11.0019 18.0049 11.0019C16.348 11.0019 15.0049 9.6588 15.0049 8.00195C15.0049 6.34509 16.348 5.00195 18.0049 5.00195ZM18.0049 7.00195C17.4526 7.00195 17.0049 7.44966 17.0049 8.00195C17.0049 8.55423 17.4526 9.00195 18.0049 9.00195C18.5572 9.00195 19.0049 8.55423 19.0049 8.00195C19.0049 7.44966 18.5572 7.00195 18.0049 7.00195ZM11.0049 2.00195C12.6617 2.00195 14.0049 3.34509 14.0049 5.00195C14.0049 6.6588 12.6617 8.00195 11.0049 8.00195C9.34803 8.00195 8.00488 6.6588 8.00488 5.00195C8.00488 3.34509 9.34803 2.00195 11.0049 2.00195ZM11.0049 4.00195C10.4526 4.00195 10.0049 4.44966 10.0049 5.00195C10.0049 5.55423 10.4526 6.00195 11.0049 6.00195C11.5572 6.00195 12.0049 5.55423 12.0049 5.00195C12.0049 4.44966 11.5572 4.00195 11.0049 4.00195Z" />
                                </svg>
                                <span>Finance</span>
                            </a>
                        </li>
                    @endif

                    @if(auth()->guard('admin')->user()->can('rajshabha.view'))
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav
                                                                                                                                @if(Request::is('admin/rajshabha*')) active @endif"
                                href="{{ url('admin/rajshabha') }}">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5 7H7V17H5V7ZM1 10H3V14H1V10ZM9 2H11V20H9V2ZM13 4H15V22H13V4ZM17 7H19V17H17V7ZM21 10H23V14H21V10Z" />
                                </svg>
                                <span>Rajshabha</span>
                            </a>
                        </li>
                    @endif

                    @if(auth()->guard('admin')->user()->can('vendors.view'))
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav
                                                                                                                            @if(Request::is('admin/vendors*')) active @endif"
                                href="{{ url('admin/vendors') }}">

                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-truck" viewBox="0 0 16 16">
                                    <path
                                        d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2" />
                                </svg>


                                <span>Vendors</span>
                            </a>
                        </li>
                    @endif

                    @if(auth()->guard('admin')->user()->can('profile.view'))
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav
                                                                                                @if(Request::is('admin/profile*')) active @endif"
                                href="{{ url('admin/profile') }}">

                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                    <path fill-rule="evenodd"
                                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                </svg>
                                <span>Profile</span>
                            </a>
                        </li>
                    @endif

                    @if(auth()->guard('admin')->user()->can('home_page.view'))
                        <li class="sidebar-list">
                            <a class="linear-icon-link sidebar-link sidebar-title has-sub
                                @if(
                                    Request::is('admin/home*') ||
                                    Request::is('admin/video_banner*') ||
                                    Request::is('admin/state_counter*') ||
                                    Request::is('admin/our_units*')
                                ) open @endif">

                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-house-door" viewBox="0 0 16 16">
                                    <path
                                        d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4z" />
                                </svg>

                                <span>Home Page</span>
                                <i class="arrow" data-feather="chevron-right"></i>
                            </a>

                            <ul class="sidebar-submenu
                                @if(
                                    Request::is('admin/home*') ||
                                    Request::is('admin/video_banner*') ||
                                    Request::is('admin/state_counter*') ||
                                    Request::is('admin/our_units*')
                                ) open @endif">
                                <li>
                                    <a href="{{ url('admin/home') }}"
                                        class="{{ Request::is('admin/home') ? 'active' : '' }}">
                                        General Layout
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/home/video_banner/edit') }}"
                                        class="{{ Request::is('admin/home/video_banner*') ? 'active' : '' }}">
                                        Video Banner / Slider
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/home/key_offerings') }}"
                                        class="{{ Request::is('admin/home/key_offerings*') ? 'active' : '' }}">
                                        Key Offerings
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/home/our_units/edit') }}"
                                        class="{{ Request::is('admin/home/our_units*') ? 'active' : '' }}">
                                        Our Units
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/home/state_counter/edit') }}"
                                        class="{{ Request::is('admin/home/state_counter*') ? 'active' : '' }}">
                                        State Counter
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/home/marquee/edit') }}"
                                        class="{{ Request::is('admin/home/marquee*') ? 'active' : '' }}">
                                        Ticker & Marquee
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/home/image_gallery') }}"
                                        class="{{ Request::is('admin/home/image_gallery*') ? 'active' : '' }}">
                                        Image Gallery / Slider
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/home/partner_logo') }}"
                                         class="{{ Request::is('admin/home/partner_logo*') ? 'active' : '' }}">
                                         Partner Logos
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/home/our_partner') }}"
                                         class="{{ Request::is('admin/home/our_partner*') ? 'active' : '' }}">
                                         Our Partners
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if(auth()->guard('admin')->user()->can('inquiry.view'))
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav
                                @if(Request::is('admin/inquiry*')) active @endif" href="{{ url('admin/inquiry') }}">

                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M4 4H20C20.5523 4 21 4.44772 21 5V19C21 19.5523 20.5523 20 20 20H4C3.44772 20 3 19.5523 3 19V5C3 4.44772 3.44772 4 4 4ZM5 6V18H19V6H5ZM7 8H17V10H7V8ZM7 12H14V14H7V12Z" />
                                </svg>

                                <span>Contact Inquiry</span>
                            </a>
                        </li>
                    @endif

                    @if(auth()->guard('admin')->user()->can('chatbot.view'))
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav
                                @if(Request::is('chatbot*')) active @endif" href="{{ route('chatbot.index') }}">

                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-chat-dots" viewBox="0 0 16 16">
                                    <path
                                        d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                    <path
                                        d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2" />
                                </svg>

                                <span>Chatbot FAQ</span>
                            </a>
                        </li>
                    @endif

                    @if(auth()->guard('admin')->user()->hasRole('admin'))
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav
                                                                                            @if(Request::is('admin/role*')) active @endif"
                                href="{{ url('admin/role') }}">

                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.96456 18C8.72194 19.6961 7.26324 21 5.5 21C3.73676 21 2.27806 19.6961 2.03544 18H1V6C1 5.44772 1.44772 5 2 5H16C16.5523 5 17 5.44772 17 6V8H20L23 12.0557V18H20.9646C20.7219 19.6961 19.2632 21 17.5 21C15.7368 21 14.2781 19.6961 14.0354 18H8.96456ZM15 7H3V15.0505C3.63526 14.4022 4.52066 14 5.5 14C6.8962 14 8.10145 14.8175 8.66318 16H14.3368C14.5045 15.647 14.7296 15.3264 15 15.0505V7ZM17 13H21V12.715L18.9917 10H17V13ZM17.5 19C18.1531 19 18.7087 18.5826 18.9146 18C18.9699 17.8436 19 17.6753 19 17.5C19 16.6716 18.3284 16 17.5 16C16.6716 16 16 16.6716 16 17.5C16 17.6753 16.0301 17.8436 16.0854 18C16.2913 18.5826 16.8469 19 17.5 19ZM7 17.5C7 16.6716 6.32843 16 5.5 16C4.67157 16 4 16.6716 4 17.5C4 17.6753 4.03008 17.8436 4.08535 18C4.29127 18.5826 4.84689 19 5.5 19C6.15311 19 6.70873 18.5826 6.91465 18C6.96992 17.8436 7 17.6753 7 17.5Z" />
                                </svg>
                                <span>Role & Permission</span>
                            </a>
                        </li>

                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav
                                @if(Request::is('admin/approvals*')) active @endif"
                                href="{{ route('admin.approvals.index') }}">
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg" class="align-middle me-2" style="width:16px; height:16px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                <span>Pending Approvals</span>
                            </a>
                        </li>

                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav
                                @if(Request::is('admin/settings*')) active @endif"
                                href="{{ route('admin.settings.index') }}">
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg" class="align-middle me-2" style="width:16px; height:16px;"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                                <span>System Settings</span>
                            </a>
                        </li>
                    @endif

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="#"
                            onclick="event.preventDefault(); if(confirm('Are you sure you want to logout?')) { document.getElementById('logout-form').submit(); }">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M17 16L21 12L17 8V11H9V13H17V16ZM5 5H13V3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H13V19H5V5Z" fill="currentColor"/>
                            </svg>
                            <span>Logout</span>
                        </a>
                    </li>



                </ul>
            </div>


            <div class="right-arrow" id="right-arrow">
                <i data-feather="arrow-right"></i>
            </div>
        </nav>

        <!-- Sidebar Custom Status Widget and Faded Illustration -->
        <div class="sidebar-status-widget-container d-none d-lg-block">
            <!-- Faded Illustration background -->
            <div class="sidebar-faded-illustration"></div>
            
            <div class="sidebar-status-card">
                <div class="status-card-header">
                    <span class="status-title">SYSTEM STATUS</span>
                    <span class="status-badge {{ $systemStatus['healthy'] ? '' : 'status-badge-warning' }}">
                        {{ $systemStatus['healthy'] ? 'HEALTHY' : 'ATTENTION' }}
                    </span>
                </div>
                <div class="status-row">
                    <span class="row-label">
                        <svg class="row-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path><path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line></svg>
                        NETWORK
                    </span>
                    <span class="row-value {{ $systemStatus['secure'] ? 'status-value-online' : 'status-value-warning' }}"
                        title="{{ $systemStatus['tls_protocol'] }}">
                        {{ $systemStatus['connection_label'] }}
                    </span>
                </div>
                <div class="status-row">
                    <span class="row-label">
                        <svg class="row-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path><path d="M3 12c0 1.66 4 3 9 3s9-1.34 9-3"></path></svg>
                        DATABASE
                    </span>
                    <span class="row-value {{ $systemStatus['database_online'] ? 'status-value-online' : 'status-value-offline' }}">
                        {{ $systemStatus['database_online'] ? 'Online' : 'Offline' }}
                    </span>
                </div>
                <div class="status-row">
                    <span class="row-label">
                        <svg class="row-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        LAST DEPLOY
                    </span>
                    <span class="row-value" id="sidebar-last-deploy"
                        title="{{ $systemStatus['deployed_at_title'] }}">
                        {{ $systemStatus['deployed_at_label'] }}
                    </span>
                </div>
            </div>
        </div>

        <div class="sidebar-collapse-toggle" id="sidebarToggle">
            <i class="fa fa-angle-left"></i>
        </div>




    </div>
</div>

<div class="sidebar-overlay"></div>




<script>
    (function () {
        const btn = document.getElementById('userFooterToggle');
        const menu = document.getElementById('userFooterMenu');

        if (!btn || !menu) return;

        // Toggle when clicking button (stop propagation so document click doesn't immediately close it)
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const opened = menu.classList.contains('show');

            // Close any other open footer menus (optional)
            document.querySelectorAll('#userFooterMenu.show').forEach(m => {
                if (m !== menu) m.classList.remove('show');
            });

            if (opened) {
                menu.classList.remove('show');
                btn.setAttribute('aria-expanded', 'false');
            } else {
                menu.classList.add('show');
                btn.setAttribute('aria-expanded', 'true');
            }
        });

        // Prevent clicks inside menu from closing it
        menu.addEventListener('click', function (e) {
            e.stopPropagation();
        });

        // Close when clicking anywhere else on the page
        document.addEventListener('click', function () {
            if (menu.classList.contains('show')) {
                menu.classList.remove('show');
                btn.setAttribute('aria-expanded', 'false');
            }
        });

        // Optional: Close on ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && menu.classList.contains('show')) {
                menu.classList.remove('show');
                btn.setAttribute('aria-expanded', 'false');
            }
        });
    })();

</script>


<!-- Page Sidebar Ends-->

<!-- <div class="sidebar-footer p-3" style="background:#1e1e2d;">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0 text-white" style="font-size:14px;"></h6>
                    <small class="text-muted"></small>
                </div>

                <div class="ms-auto user-footer-dropdown" style="position:relative;">
                    <button id="userFooterToggle" class="dropdown-toggle-btn" aria-expanded="false" type="button">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>

                    <ul id="userFooterMenu" class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ url('admin/profile') }}"><i class="fa fa-user"></i>
                                Profile</a></li>

                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i
                                    class="fa fa-power-off"></i> Logout</a></li>
                    </ul>

                </div>
            </div>
        </div> -->
