@php
    $footerSetting = \App\Models\GeneralSetting::first();
    $footerDesc = $footerSetting->footer_description ?? 'Gliders India Limited is a defence manufacturing organization specializing in parachute system and aerial delivery equipment.';
    $footerAddress = $footerSetting->footer_address ?? 'Headquarters kanpur, Uttar pradesh';
    $footerPhone = $footerSetting->footer_phone ?? 'Corporate: +91 512 2984548';
    $footerEmail = $footerSetting->footer_email ?? 'support@glidersindia.in';
    $visitorCount = $footerSetting->visitor_count ?? 1025;

    // Calculate dynamic last updated time based on newest record
    $lastUpdated = collect([
        \App\Models\NewsArticle::latest('updated_at')->first()?->updated_at,
        \App\Models\Product::latest('updated_at')->first()?->updated_at,
        \App\Models\AboutLeadership::latest('updated_at')->first()?->updated_at,
        \App\Models\GeneralSetting::latest('updated_at')->first()?->updated_at,
    ])->filter()->max();

    $lastUpdatedStr = $lastUpdated ? $lastUpdated->format('d-M, Y H:i:s') : '02-Mar, 2026 03:29:38';
@endphp
<style>
    .contact-list .contact-item {
        display: flex !important;
        align-items: flex-start !important;
        gap: 12px !important;
        margin-bottom: 16px !important;
    }
    .contact-list .contact-icon {
        flex-shrink: 0 !important;
        margin-top: 3px !important;
        color: #111 !important;
    }
    .contact-list .contact-text {
        font-size: 15px !important;
        line-height: 1.5 !important;
        word-break: break-word !important;
        color: rgba(0, 0, 0, 0.75) !important;
    }
    .contact-list .phone-number {
        font-weight: 600 !important;
        color: #111 !important;
    }
</style>
<footer class="main-footer">

    <div class="container">

        <div class="footer-wrapper">

            <!-- LEFT SECTION -->
            <div class="footer-col footer-about">
                <img src="{{ asset('frontend/images/logo/gliders.png') }}" class="footer-logo" alt="Gliders India">

                <p class="footer-desc">
                    {{ $footerDesc }}
                </p>

                <div class="footer-map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1786.4271193648403!2d80.36528!3d26.42818!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x399c416675c21d89%3A0x39560d62abfc1a26!2sGLIDERS%20INDIA%20LIMITED!5e0!3m2!1sen!2sus!4v1775735092019!5m2!1sen!2sus"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

            </div>

            <!-- QUICK LINKS -->
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M1.66797 3.33333C1.66797 2.8731 2.04107 2.5 2.5013 2.5H17.5013C17.9615 2.5 18.3346 2.8731 18.3346 3.33333V16.6667C18.3346 17.1269 17.9615 17.5 17.5013 17.5H2.5013C2.04107 17.5 1.66797 17.1269 1.66797 16.6667V3.33333ZM3.33464 15.8333H16.668V7.5H3.33464V15.8333ZM9.16797 10.8333H5.0013V14.1667H9.16797V10.8333Z"
                                fill="black" />
                        </svg>
                        <a href="{{ route('rti', 'officers') }}">RTI</a>
                    </li>
                    <li>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16.6721 1.66797C17.5903 1.66797 18.3346 2.41648 18.3346 3.32697V16.6756C18.3346 17.5919 17.5908 18.3346 16.6721 18.3346H3.33464V15.0013H1.66797V13.3346H3.33464V10.8346H1.66797V9.16797H3.33464V6.66797H1.66797V5.0013H3.33464V1.66797H16.6721ZM6.66797 3.33464H5.0013V16.668H6.66797V3.33464ZM16.668 3.33464H8.33464V16.668H16.668V3.33464Z"
                                fill="black" />
                        </svg>
                        <a href="{{ route('privacy.policy') }}">Privacy Policy</a>
                    </li>
                    <li>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M18.3346 16.6667V5.83333L16.668 2.5H3.33464L1.66797 5.83627V16.6667C1.66797 17.1269 2.04107 17.5 2.5013 17.5H17.5013C17.9616 17.5 18.3346 17.1269 18.3346 16.6667ZM3.33464 7.5H16.668V15.8333H3.33464V7.5ZM4.36464 4.16667H15.638L16.4713 5.83333H3.53214L4.36464 4.16667ZM12.5013 9.16667H7.5013V10.8333H12.5013V9.16667Z"
                                fill="black" />
                        </svg>

                        <a href="{{ route('sitemap') }}">Sitemap</a>
                    </li>
                    <li>

                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16.6721 1.66797C17.5903 1.66797 18.3346 2.41648 18.3346 3.32697V16.6756C18.3346 17.5919 17.5908 18.3346 16.6721 18.3346H3.33464V15.0013H1.66797V13.3346H3.33464V10.8346H1.66797V9.16797H3.33464V6.66797H1.66797V5.0013H3.33464V1.66797H16.6721ZM6.66797 3.33464H5.0013V16.668H6.66797V3.33464ZM16.668 3.33464H8.33464V16.668H16.668V3.33464Z"
                                fill="black" />
                        </svg>

                        <a href="{{ route('terms.conditions') }}">Terms Of Use</a>
                    </li>
                    <!-- <li>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4.16667 3.83565V11.4894C4.16667 12.6039 4.72367 13.6447 5.651 14.2629L10 17.1623L14.349 14.2629C15.2763 13.6447 15.8333 12.6039 15.8333 11.4894V3.83565L10 2.53936L4.16667 3.83565ZM3.15256 2.35368L10 0.832031L16.8474 2.35368C17.2287 2.43841 17.5 2.77659 17.5 3.16717V11.4894C17.5 13.1612 16.6645 14.7224 15.2735 15.6497L10 19.1654L4.7265 15.6497C3.33551 14.7224 2.5 13.1612 2.5 11.4894V3.16717C2.5 2.77659 2.77128 2.43841 3.15256 2.35368ZM10 11.2487L7.55089 12.5363L8.01863 9.80912L6.03727 7.8778L8.77542 7.47991L10 4.9987L11.2246 7.47991L13.9628 7.8778L11.9813 9.80912L12.4491 12.5363L10 11.2487Z"
                                fill="black" />
                        </svg>
                        <a href="#">live vistor counter</a>
                    </li> -->
                    <!-- <li>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_2613_456)">
                                <path
                                    d="M17.2625 6.77212L17.057 7.24352C16.9066 7.58863 16.4293 7.58863 16.2789 7.24352L16.0735 6.77212C15.7072 5.93159 15.0476 5.26237 14.2244 4.89627L13.5913 4.61472C13.2491 4.46247 13.2491 3.96437 13.5913 3.81213L14.189 3.54632C15.0333 3.17079 15.7048 2.47681 16.0647 1.60772L16.2757 1.09831C16.4228 0.743273 16.9131 0.743273 17.0601 1.09831L17.2711 1.60772C17.6311 2.47681 18.3026 3.17079 19.147 3.54632L19.7446 3.81213C20.0869 3.96437 20.0869 4.46247 19.7446 4.61472L19.1116 4.89627C18.2884 5.26237 17.6287 5.93159 17.2625 6.77212ZM1.66797 3.33203C1.66797 2.8718 2.04107 2.4987 2.5013 2.4987H11.668V4.16537H3.33464V15.832H16.668V9.16537H18.3346V16.6654C18.3346 17.1256 17.9616 17.4987 17.5013 17.4987H2.5013C2.04107 17.4987 1.66797 17.1256 1.66797 16.6654V3.33203ZM5.83464 10.832H7.5013V14.1654H5.83464V10.832ZM9.16797 5.83203H10.8346V14.1654H9.16797V5.83203ZM12.5013 8.33203H14.168V14.1654H12.5013V8.33203Z"
                                    fill="black" />
                            </g>
                            <defs>
                                <clipPath id="clip0_2613_456">
                                    <rect width="20" height="20" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <a href="#">Global Presence</a>
                    </li> -->
                    <!-- <li>



                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7.80463 8.90175C8.585 10.274 9.726 11.415 11.0982 12.1953L11.8353 11.1634C12.0804 10.8204 12.543 10.7144 12.913 10.9165C14.0853 11.5569 15.3809 11.9461 16.7324 12.0531C17.1658 12.0874 17.5 12.4491 17.5 12.8838V16.6028C17.5 17.0301 17.1768 17.3881 16.7518 17.4318C16.3102 17.4772 15.8647 17.5 15.4167 17.5C8.28299 17.5 2.5 11.717 2.5 4.58333C2.5 4.13522 2.52285 3.68976 2.56824 3.24813C2.61192 2.82312 2.96995 2.5 3.39721 2.5H7.11618C7.55092 2.5 7.91261 2.8342 7.94692 3.26757C8.05389 4.61907 8.44308 5.9147 9.0835 7.08703C9.28558 7.457 9.17958 7.91962 8.83658 8.16464L7.80463 8.90175ZM5.70354 8.35433L7.28683 7.22341C6.83789 6.25428 6.53023 5.22652 6.37273 4.16667H4.17422C4.16919 4.30527 4.16667 4.44417 4.16667 4.58333C4.16667 10.7965 9.2035 15.8333 15.4167 15.8333C15.5558 15.8333 15.6947 15.8308 15.8333 15.8257V13.6272C14.7735 13.4697 13.7457 13.1621 12.7766 12.7132L11.6457 14.2965C11.1882 14.1187 10.7463 13.9096 10.3228 13.6717L10.2744 13.6442C8.64142 12.7156 7.28445 11.3586 6.35583 9.72558L6.32828 9.67717C6.09041 9.25367 5.88128 8.81183 5.70354 8.35433Z"
                                fill="black" />
                        </svg>

                        <a href="#">Contact</a>
                    </li> -->
                </ul>
            </div>

            <!-- CONTACT INFO -->
            <div class="footer-col">
                <h4>Contact Info</h4>
                <ul class="contact-list">
                    <li class="contact-item">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="contact-icon">
                            <path
                                d="M10 17.4176L14.1248 13.2927C16.4028 11.0147 16.4028 7.32124 14.1248 5.04318C11.8468 2.76512 8.15327 2.76512 5.87521 5.04318C3.59715 7.32124 3.59715 11.0147 5.87521 13.2927L10 17.4176ZM10 19.7746L4.6967 14.4713C1.76777 11.5423 1.76777 6.7936 4.6967 3.86467C7.62563 0.935735 12.3743 0.935735 15.3033 3.86467C18.2323 6.7936 18.2323 11.5423 15.3033 14.4713L10 19.7746ZM10 10.8346C10.9205 10.8346 11.6667 10.0885 11.6667 9.16797C11.6667 8.24749 10.9205 7.5013 10 7.5013C9.0795 7.5013 8.33333 8.24749 8.33333 9.16797C8.33333 10.0885 9.0795 10.8346 10 10.8346ZM10 12.5013C8.15905 12.5013 6.66667 11.0089 6.66667 9.16797C6.66667 7.32702 8.15905 5.83464 10 5.83464C11.8409 5.83464 13.3333 7.32702 13.3333 9.16797C13.3333 11.0089 11.8409 12.5013 10 12.5013Z"
                                fill="black" />
                        </svg>
                        <span class="contact-text">{{ $footerAddress }}</span>
                    </li>
                    
                    @if($footerPhone === 'Corporate: +91 512 2984548')
                        <li class="contact-item">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="contact-icon">
                                <path
                                    d="M7.80463 8.90175C8.585 10.274 9.726 11.415 11.0982 12.1953L11.8353 11.1634C12.0804 10.8204 12.543 10.7144 12.913 10.9165C14.0853 11.5569 15.3809 11.9461 16.7324 12.0531C17.1658 12.0874 17.5 12.4491 17.5 12.8838V16.6028C17.5 17.0301 17.1768 17.3881 16.7518 17.4318C16.3102 17.4772 15.8647 17.5 15.4167 17.5C8.28299 17.5 2.5 11.717 2.5 4.58333C2.5 4.13522 2.52285 3.68976 2.56824 3.24813C2.61192 2.82312 2.96995 2.5 3.39721 2.5H7.11618C7.55092 2.5 7.91261 2.8342 7.94692 3.26757C8.05389 4.61907 8.44308 5.9147 9.0835 7.08703C9.28558 7.457 9.17958 7.91962 8.83658 8.16464L7.80463 8.90175ZM5.70354 8.35433L7.28683 7.22341C6.83789 6.25428 6.53023 5.22652 6.37273 4.16667H4.17422C4.16919 4.30527 4.16667 4.44417 4.16667 4.58333C4.16667 10.7965 9.2035 15.8333 15.4167 15.8333C15.5558 15.8333 15.6947 15.8308 15.8333 15.8257V13.6272C14.7735 13.4697 13.7457 13.1621 12.7766 12.7132L11.6457 14.2965C11.1882 14.1187 10.7463 13.9096 10.3228 13.6717L10.2744 13.6442C8.64142 12.7156 7.28445 11.3586 6.35583 9.72558L6.32828 9.67717C6.09041 9.25367 5.88128 8.81183 5.70354 8.35433Z"
                                    fill="black" />
                            </svg>
                            <span class="contact-text">Corporate:<br><span class="phone-number" style="white-space: nowrap;">+91 512 2984548</span></span>
                        </li>
                        <li class="contact-item">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="contact-icon">
                                <path
                                    d="M7.80463 8.90175C8.585 10.274 9.726 11.415 11.0982 12.1953L11.8353 11.1634C12.0804 10.8204 12.543 10.7144 12.913 10.9165C14.0853 11.5569 15.3809 11.9461 16.7324 12.0531C17.1658 12.0874 17.5 12.4491 17.5 12.8838V16.6028C17.5 17.0301 17.1768 17.3881 16.7518 17.4318C16.3102 17.4772 15.8647 17.5 15.4167 17.5C8.28299 17.5 2.5 11.717 2.5 4.58333C2.5 4.13522 2.52285 3.68976 2.56824 3.24813C2.61192 2.82312 2.96995 2.5 3.39721 2.5H7.11618C7.55092 2.5 7.91261 2.8342 7.94692 3.26757C8.05389 4.61907 8.44308 5.9147 9.0835 7.08703C9.28558 7.457 9.17958 7.91962 8.83658 8.16464L7.80463 8.90175ZM5.70354 8.35433L7.28683 7.22341C6.83789 6.25428 6.53023 5.22652 6.37273 4.16667H4.17422C4.16919 4.30527 4.16667 4.44417 4.16667 4.58333C4.16667 10.7965 9.2035 15.8333 15.4167 15.8333C15.5558 15.8333 15.6947 15.8308 15.8333 15.8257V13.6272C14.7735 13.4697 13.7457 13.1621 12.7766 12.7132L11.6457 14.2965C11.1882 14.1187 10.7463 13.9096 10.3228 13.6717L10.2744 13.6442C8.64142 12.7156 7.28445 11.3586 6.35583 9.72558L6.32828 9.67717C6.09041 9.25367 5.88128 8.81183 5.70354 8.35433Z"
                                    fill="black" />
                            </svg>
                            <span class="contact-text">Marketing:<br><span class="phone-number" style="white-space: nowrap;">+91 78500 06666</span></span>
                        </li>
                        <li class="contact-item">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="contact-icon">
                                <path
                                    d="M7.80463 8.90175C8.585 10.274 9.726 11.415 11.0982 12.1953L11.8353 11.1634C12.0804 10.8204 12.543 10.7144 12.913 10.9165C14.0853 11.5569 15.3809 11.9461 16.7324 12.0531C17.1658 12.0874 17.5 12.4491 17.5 12.8838V16.6028C17.5 17.0301 17.1768 17.3881 16.7518 17.4318C16.3102 17.4772 15.8647 17.5 15.4167 17.5C8.28299 17.5 2.5 11.717 2.5 4.58333C2.5 4.13522 2.52285 3.68976 2.56824 3.24813C2.61192 2.82312 2.96995 2.5 3.39721 2.5H7.11618C7.55092 2.5 7.91261 2.8342 7.94692 3.26757C8.05389 4.61907 8.44308 5.9147 9.0835 7.08703C9.28558 7.457 9.17958 7.91962 8.83658 8.16464L7.80463 8.90175ZM5.70354 8.35433L7.28683 7.22341C6.83789 6.25428 6.53023 5.22652 6.37273 4.16667H4.17422C4.16919 4.30527 4.16667 4.44417 4.16667 4.58333C4.16667 10.7965 9.2035 15.8333 15.4167 15.8333C15.5558 15.8333 15.6947 15.8308 15.8333 15.8257V13.6272C14.7735 13.4697 13.7457 13.1621 12.7766 12.7132L11.6457 14.2965C11.1882 14.1187 10.7463 13.9096 10.3228 13.6717L10.2744 13.6442C8.64142 12.7156 7.28445 11.3586 6.35583 9.72558L6.32828 9.67717C6.09041 9.25367 5.88128 8.81183 5.70354 8.35433Z"
                                    fill="black" />
                            </svg>
                            <span class="contact-text">Vendor Helpline:<br><span class="phone-number" style="white-space: nowrap;">+91 512 2988487</span></span>
                        </li>
                    @else
                        <li class="contact-item">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="contact-icon">
                                <path
                                    d="M7.80463 8.90175C8.585 10.274 9.726 11.415 11.0982 12.1953L11.8353 11.1634C12.0804 10.8204 12.543 10.7144 12.913 10.9165C14.0853 11.5569 15.3809 11.9461 16.7324 12.0531C17.1658 12.0874 17.5 12.4491 17.5 12.8838V16.6028C17.5 17.0301 17.1768 17.3881 16.7518 17.4318C16.3102 17.4772 15.8647 17.5 15.4167 17.5C8.28299 17.5 2.5 11.717 2.5 4.58333C2.5 4.13522 2.52285 3.68976 2.56824 3.24813C2.61192 2.82312 2.96995 2.5 3.39721 2.5H7.11618C7.55092 2.5 7.91261 2.8342 7.94692 3.26757C8.05389 4.61907 8.44308 5.9147 9.0835 7.08703C9.28558 7.457 9.17958 7.91962 8.83658 8.16464L7.80463 8.90175ZM5.70354 8.35433L7.28683 7.22341C6.83789 6.25428 6.53023 5.22652 6.37273 4.16667H4.17422C4.16919 4.30527 4.16667 4.44417 4.16667 4.58333C4.16667 10.7965 9.2035 15.8333 15.4167 15.8333C15.5558 15.8333 15.6947 15.8308 15.8333 15.8257V13.6272C14.7735 13.4697 13.7457 13.1621 12.7766 12.7132L11.6457 14.2965C11.1882 14.1187 10.7463 13.9096 10.3228 13.6717L10.2744 13.6442C8.64142 12.7156 7.28445 11.3586 6.35583 9.72558L6.32828 9.67717C6.09041 9.25367 5.88128 8.81183 5.70354 8.35433Z"
                                    fill="black" />
                            </svg>
                            <span class="contact-text">Contact:<br><span class="phone-number" style="white-space: nowrap;">{{ $footerPhone }}</span></span>
                        </li>
                    @endif
                    
                    <li class="contact-item">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="contact-icon">
                            <g clip-path="url(#clip0_2613_475)">
                                <path
                                    d="M17.5 2.5C17.9603 2.5 18.3333 2.8731 18.3333 3.33333V16.6722C18.3333 17.1293 17.9539 17.5 17.5068 17.5H2.49317C2.03671 17.5 1.66667 17.1292 1.66667 16.6722V15.8333H16.6667V6.08333L10 12.0833L1.66667 4.58333V3.33333C1.66667 2.8731 2.03977 2.5 2.5 2.5H17.5ZM6.66667 12.5V14.1667H0V12.5H6.66667ZM4.16667 8.33333V10H0V8.33333H4.16667ZM16.3049 4.16667H3.69512L10 9.84108L16.3049 4.16667Z"
                                    fill="black" />
                            </g>
                            <defs>
                                <clipPath id="clip0_2613_475">
                                    <rect width="20" height="20" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <span class="contact-text">Email:<br><span class="phone-number">{{ $footerEmail }}</span></span>
                    </li>
                    <li class="contact-item">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="contact-icon">
                            <path
                                d="M10.0013 18.3346C5.39893 18.3346 1.66797 14.6036 1.66797 10.0013C1.66797 5.39893 5.39893 1.66797 10.0013 1.66797C14.6036 1.66797 18.3346 5.39893 18.3346 10.0013C18.3346 14.6036 14.6036 18.3346 10.0013 18.3346ZM10.0013 16.668C13.6832 16.668 16.668 13.6832 16.668 10.0013C16.668 6.3194 13.6832 3.33464 10.0013 3.33464C6.3194 3.33464 3.33464 6.3194 3.33464 10.0013C3.33464 13.6832 6.3194 16.668 10.0013 16.668ZM10.8346 10.0013H14.168V11.668H9.16797V5.83464H10.8346V10.0013Z"
                                fill="black" />
                        </svg>
                        <span class="contact-text">Working Hours:<br><span class="phone-number" style="white-space: nowrap;">Mon - Fri: 09:00 - 17:30</span></span>
                    </li>
                </ul>
            </div>

            <!-- UPDATES -->
            <div class="footer-col">
                <h4>Updates</h4>
                <!-- <ul>
                    <li><a href="{{ route('news.categories') }}">New parachute testing facility inaugurated Apr 2025</a></li>
                    <li><a href="{{ route('news.categories') }}">Participation in Aero India Feb 2025</a></li>
                </ul> -->
                <ul class="latest-list">
                    <?php
$latestNews = App\Models\NewsArticle::latest()->get();
                    ?>
                    @foreach($latestNews as $news)
                        <li class="mb-0">
                            <a href="{{ route('news.category', $news->category_id) }}" class="news-link">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.75194 5.4392L18.2596 11.5687C18.4981 11.7078 18.5787 12.014 18.4396 12.2525C18.3961 12.327 18.3341 12.389 18.2596 12.4325L7.75194 18.562C7.51341 18.7011 7.20725 18.6205 7.06811 18.382C7.0235 18.3055 7 18.2186 7 18.1301V5.87109C7 5.59494 7.22386 5.37109 7.5 5.37109C7.58853 5.37109 7.67547 5.39459 7.75194 5.4392Z"
                                        fill="#EE6802" />
                                </svg>

                                <span>{{ \Illuminate\Support\Str::limit($news->title, 60) }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>

                <!-- <div class="news-btn-wrap">
                    <a href="{{ route('news.categories') }}" class="view-news-btn">
                        View All News
                    </a>
                </div> -->
            </div>

        </div>

    </div>

    <!-- BOTTOM BAR -->
    <div class="footer-bottom">
        <div class="container footer-bottom-wrap">
            <!-- <p>Privacy Policy | Terms of Use | RTI | Accessibility | Sitemap</p> -->
            <p>Total Visitors: {{ $visitorCount }}</p>
            <p>Last Updated: {{ $lastUpdatedStr }}</p>
        </div>
    </div>

</footer>