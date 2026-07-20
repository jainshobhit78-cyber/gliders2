@extends('backend.layout.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card mt-5">
                    <div class="card-body text-center p-4">
                        <div class="mb-3" style="font-size:40px; color:#EE6802;">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </div>
                        <h5 class="mb-1">System Tools Locked</h5>
                        <p class="text-muted small mb-4">Enter the access password to continue. This area is protected even for administrators.</p>

                        @include('_message')

                        @if($errors->any())
                            <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
                        @endif

                        <form action="{{ url('admin/system-tools/unlock') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control text-center"
                                       placeholder="Access password" autofocus required
                                       autocomplete="new-password">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Unlock</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
