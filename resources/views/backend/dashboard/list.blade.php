@extends('backend.layout.app')

@section('content')

    <div class="dashboard">
        <div class="title-header title-header-1">
            <div class="need-help-sec">
                <h5 class="mb-0 page-title">Dashboard</h5>

            </div>
        </div>

        <div class="dashboard-container container-fluid">

            <!-- TOP KPI ROW -->
            <div class="kpi-wrapper">
                <div class="kpi-row">
                    <div class="kpi-item">
                        <div class="kpi-title">
                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="36" height="36" rx="4" fill="#4271BC" />
                                <path
                                    d="M25.5 10.5C25.9603 10.5 26.3333 10.8731 26.3333 11.3333V24.6722C26.3333 25.1293 25.9539 25.5 25.5068 25.5H10.4932C10.0367 25.5 9.66667 25.1292 9.66667 24.6722V23.8333H24.6667V14.0833L18 20.0833L9.66667 12.5833V11.3333C9.66667 10.8731 10.0398 10.5 10.5 10.5H25.5ZM14.6667 20.5V22.1667H8V20.5H14.6667ZM12.1667 16.3333V18H8V16.3333H12.1667ZM24.3049 12.1667H11.6951L18 17.8411L24.3049 12.1667Z"
                                    fill="white" />
                            </svg>
                        </div>
                        <div class="kpi-value"><span>{{ \App\Models\ContactMessage::count() }}</span>
                            <p>New Messages / Emails</p>
                        </div>
                    </div>

                    <div class="kpi-item">
                        <div class="kpi-title">
                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="36" height="36" rx="4" fill="#55A0AA" />
                                <path
                                    d="M12.8027 22.1667H24.667V12.1667H11.3337V23.3209L12.8027 22.1667ZM13.3791 23.8333L9.66699 26.75V11.3333C9.66699 10.8731 10.0401 10.5 10.5003 10.5H25.5003C25.9606 10.5 26.3337 10.8731 26.3337 11.3333V23C26.3337 23.4602 25.9606 23.8333 25.5003 23.8333H13.3791ZM17.167 19.6667H18.8337V21.3333H17.167V19.6667ZM15.1398 15.3446C15.4056 14.0077 16.5853 13 18.0003 13C19.6112 13 20.917 14.3058 20.917 15.9167C20.917 17.5275 19.6112 18.8333 18.0003 18.8333H17.167V17.1667H18.0003C18.6907 17.1667 19.2503 16.607 19.2503 15.9167C19.2503 15.2263 18.6907 14.6667 18.0003 14.6667C17.3939 14.6667 16.8883 15.0985 16.7743 15.6715L15.1398 15.3446Z"
                                    fill="white" />
                            </svg>
                        </div>
                        <div class="kpi-value"><span>{{ \App\Models\ChatbotFaq::count() }}</span>
                            <p>New Queries</p>
                        </div>
                    </div>

                    <div class="kpi-item">
                        <div class="kpi-title">
                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="36" height="36" rx="4" fill="#E49F4D" />
                                <path
                                    d="M17.9997 8.83398L25.9163 13.4173V22.584L17.9997 27.1673L10.083 22.584V13.4173L17.9997 8.83398ZM12.5779 13.8987L17.9998 17.0377L23.4215 13.8988L17.9997 10.7598L12.5779 13.8987ZM11.7497 15.3451V21.6231L17.1664 24.7591V18.4811L11.7497 15.3451ZM18.8331 24.759L24.2497 21.6231V15.3451L18.8331 18.4811V24.759Z"
                                    fill="white" />
                            </svg>
                        </div>
                        <div class="kpi-value"><span>{{ \App\Models\Product::count() }}</span>
                            <p>Products Listed</p>
                        </div>
                    </div>

                </div>

                <div class="kpi-divider-horizontal"></div>

                <div class="kpi-row">
                    <div class="kpi-item">
                        <div class="kpi-title">
                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="36" height="36" rx="4" fill="#800080" />
                                <path
                                    d="M23.0262 21.8467L26.5951 25.4156L25.4166 26.5941L21.8477 23.0252C20.5644 24.0518 18.937 24.666 17.167 24.666C13.027 24.666 9.66699 21.306 9.66699 17.166C9.66699 13.026 13.027 9.66602 17.167 9.66602C21.307 9.66602 24.667 13.026 24.667 17.166C24.667 18.936 24.0528 20.5634 23.0262 21.8467ZM21.3542 21.2283C22.3732 20.1782 23.0003 18.7457 23.0003 17.166C23.0003 13.9431 20.3899 11.3327 17.167 11.3327C13.9441 11.3327 11.3337 13.9431 11.3337 17.166C11.3337 20.3889 13.9441 22.9993 17.167 22.9993C18.7467 22.9993 20.1792 22.3723 21.2293 21.3533L21.3542 21.2283ZM18.1486 13.9795C17.5698 14.2409 17.167 14.8231 17.167 15.4993C17.167 16.4198 17.9132 17.166 18.8337 17.166C19.5099 17.166 20.0922 16.7632 20.3535 16.1844C20.4489 16.4948 20.5003 16.8243 20.5003 17.166C20.5003 19.0069 19.0079 20.4993 17.167 20.4993C15.326 20.4993 13.8337 19.0069 13.8337 17.166C13.8337 15.3251 15.326 13.8327 17.167 13.8327C17.5087 13.8327 17.8382 13.8841 18.1486 13.9795Z"
                                    fill="white" />
                            </svg>
                        </div>
                        <div class="kpi-value"><span>{{ \App\Models\GeneralSetting::first()?->visitor_count ?? 1025 }}</span>
                            <p>Monthly Visits</p>
                        </div>
                    </div>

                    <div class="kpi-item">
                        <div class="kpi-title">
                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="36" height="36" rx="4" fill="#FF7272" />
                                <path
                                    d="M24.6663 26.334H22.9997V24.6673C22.9997 23.2866 21.8804 22.1673 20.4997 22.1673H15.4997C14.119 22.1673 12.9997 23.2866 12.9997 24.6673V26.334H11.333V24.6673C11.333 22.3662 13.1985 20.5007 15.4997 20.5007H20.4997C22.8008 20.5007 24.6663 22.3662 24.6663 24.6673V26.334ZM17.9997 18.834C15.2382 18.834 12.9997 16.5954 12.9997 13.834C12.9997 11.0726 15.2382 8.83398 17.9997 8.83398C20.7611 8.83398 22.9997 11.0726 22.9997 13.834C22.9997 16.5954 20.7611 18.834 17.9997 18.834ZM17.9997 17.1673C19.8406 17.1673 21.333 15.6749 21.333 13.834C21.333 11.993 19.8406 10.5007 17.9997 10.5007C16.1587 10.5007 14.6663 11.993 14.6663 13.834C14.6663 15.6749 16.1587 17.1673 17.9997 17.1673Z"
                                    fill="white" />
                            </svg>

                        </div>
                        <div class="kpi-value"><span>{{ \App\Models\Admin::count() }}</span>
                            <p>No. of Admins</p>
                        </div>
                    </div>

                    <div class="kpi-item">
                        <div class="kpi-title">
                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="36" height="36" rx="4" fill="#A667FF" />
                                <path
                                    d="M24.6667 26.3327H11.3333C10.8731 26.3327 10.5 25.9596 10.5 25.4993V10.4993C10.5 10.0391 10.8731 9.66602 11.3333 9.66602H24.6667C25.1269 9.66602 25.5 10.0391 25.5 10.4993V25.4993C25.5 25.9596 25.1269 26.3327 24.6667 26.3327ZM23.8333 24.666V11.3327H12.1667V24.666H23.8333ZM13.8333 12.9993H17.1667V16.3327H13.8333V12.9993ZM13.8333 17.9993H22.1667V19.666H13.8333V17.9993ZM13.8333 21.3327H22.1667V22.9993H13.8333V21.3327ZM18.8333 13.8327H22.1667V15.4993H18.8333V13.8327Z"
                                    fill="white" />
                            </svg>


                        </div>
                        <div class="kpi-value"><span>{{ \App\Models\CareerNotification::count() }}</span>
                            <p>Active Notice</p>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


@endsection