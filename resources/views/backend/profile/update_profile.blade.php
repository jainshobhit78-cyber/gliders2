@extends('backend.layout.app')
@section('content')
    <div class="title-header title-header-1 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <h5 class="mb-0 page-title">
                Update Profile
            </h5>
        </div>
    </div>
    
    @include('_message')
    <form method="POST" action="{{ url('admin/profile/update') }}" class="theme-form" enctype="multipart/form-data">
        @csrf

        <div class="mb-4 d-flex align-items-center gap-4">
            <div>
                <label class="form-label-title d-block">Profile Photo</label>
                @if(!empty($admin->profile_photo) && file_exists(public_path('uploads/profile/' . $admin->profile_photo)))
                    <img src="{{ asset('uploads/profile/' . $admin->profile_photo) }}" alt="Profile Photo" class="rounded-circle border" style="width: 100px; height: 100px; object-fit: cover;">
                @else
                    <img src="{{ asset('backend/assets/images/profile/user.png') }}" alt="Profile Photo" class="rounded-circle border" style="width: 100px; height: 100px; object-fit: cover;">
                @endif
            </div>
            <div class="flex-grow-1">
                <label class="form-label-title">Upload New Photo</label>
                <input type="file" name="profile_photo" class="form-control" accept="image/*">
                <small class="text-muted">Allowed formats: JPG, JPEG, PNG, WEBP (Max: 2MB)</small>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label-title">Name</label>
            <input type="text" name="name" value="{{ $admin->name ?? '' }}" class="form-control" required>
        </div>

        <div class="mb-4">
            <label class="form-label-title">Email</label>
            <input type="email" name="email" value="{{ $admin->email ?? '' }}" class="form-control" required>
        </div>

        <hr>

        <h6>Change Password (Optional)</h6>

        <div class="mb-4">
            <label class="form-label-title">Current Password</label>
            <input type="password" name="current_password" class="form-control">
        </div>

        <div class="mb-4">
            <label class="form-label-title">New Password</label>
            <input type="password" name="new_password" class="form-control">
        </div>

        <div class="mb-4">
            <label class="form-label-title">Confirm Password</label>
            <input type="password" name="new_password_confirmation" class="form-control">
        </div>

        <div class="panel-footer">
            @if(auth()->guard('admin')->user()->can('profile.edit'))
                <button class="btn btn-primary">
                    Update Profile
                </button>
            @endif
        </div>
    </form>
@endsection

@section('script')



@endsection