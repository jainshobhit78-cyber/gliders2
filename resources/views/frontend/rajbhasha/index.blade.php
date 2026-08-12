@extends('frontend.layouts.app')

@section('content')

    <div class="container py-5">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-lg-3">
                <div class="about-sidebar">

                    <a href="{{ route('rajbhasha', 'niyam') }}" class="sidebar-item {{ $tab == 'niyam' ? 'active' : '' }}">
                        Niyam Pustak
                    </a>

                    <a href="{{ route('rajbhasha', 'rules') }}" class="sidebar-item {{ $tab == 'rules' ? 'active' : '' }}">
                        Rajbhasha Rules
                    </a>

                </div>
            </div>

            <!-- CONTENT -->
            <div class="col-lg-9">


                {{-- NIYAM --}}
                @if($tab == 'niyam')

                    <div class="raj-card shadow-sm border rounded p-4 bg-white">

                        <h2 class="raj-main-title">
                            Niyam Pustak
                        </h2>

                        @foreach($niyams as $item)

                            <div class="raj-item-card mb-4">

                                @if($item->pdf)
                                    <h4 class="raj-title">
                                        <a href="{{ asset('uploads/rajshabha/' . $item->pdf) }}"
                                           download="{{ $item->pdf }}"
                                           class="raj-title-download"
                                           aria-label="Download {{ $item->heading }} PDF">
                                            {{ $item->heading }}
                                        </a>
                                    </h4>
                                @else
                                    <h4 class="raj-title">
                                        {{ $item->heading }}
                                    </h4>
                                @endif

                            </div>

                        @endforeach

                    </div>

                @endif


                {{-- RULES --}}
                @if($tab == 'rules')

                    <div class="raj-card shadow-sm border rounded p-4 bg-white">

                        <h2 class="raj-main-title">
                            Rajbhasha Rules
                        </h2>

                        @foreach($rules as $item)

                            <div class="raj-item-card mb-4">

                                @if($item->pdf)
                                    <h4 class="raj-title">
                                        <a href="{{ asset('uploads/rajshabha/' . $item->pdf) }}"
                                           download="{{ $item->pdf }}"
                                           class="raj-title-download"
                                           aria-label="Download {{ $item->heading }} PDF">
                                            {{ $item->heading }}
                                        </a>
                                    </h4>
                                @else
                                    <h4 class="raj-title">
                                        {{ $item->heading }}
                                    </h4>
                                @endif

                            </div>

                        @endforeach

                    </div>

                @endif

            </div>
        </div>
    </div>

@endsection
