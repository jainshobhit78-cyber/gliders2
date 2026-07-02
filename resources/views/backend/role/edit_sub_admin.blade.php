@extends('backend.layout.app')
<style>
    .user-table th,
    .user-table td {
        padding: 8px 10px;
        /* reduce spacing */
        vertical-align: middle;
    }

    .user-table td:first-child {
        width: 220px;
        /* fix module column width */
        white-space: nowrap;
    }

    .user-table input[type="checkbox"] {
        transform: scale(1.1);
    }

    .user-table td:not(:first-child),
    .user-table th:not(:first-child) {
        text-align: center;
    }
</style>
@section('content')

    <div class="title-header d-flex justify-content-between align-items-center">
       <h5>Edit Sub Admin</h5>

        <a href="{{ route('admin.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="card mt-3">
        <div class="card-body">

            <form action="{{ route('admin.update', $admin->id) }}" method="POST">
                @csrf

                {{-- FLEX FIELDS --}}
                <div class="d-flex gap-3 mb-3">
                    <div class="w-100">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ $admin->name }}" class="form-control">
                    </div>

                    <div class="w-100">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $admin->email }}" class="form-control">
                    </div>

                    <div class="w-100">
                        <label>Password (optional)</label>
                        <input type="password" name="password" class="form-control" minlength="6">
                    </div>
                </div>

                {{-- PERMISSION TABLE --}}
                <table class="user-table table table-bordered">
                    <thead>
                        <tr>
                            <th>Module</th>
                            <th>View</th>
                            <th>Create</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($permissions as $module => $modulePermissions)
                            <tr>
                                <td>{{ ucwords(str_replace('_', ' ', $module)) }}</td>

                               

                                @php $actions = ['view', 'create', 'edit', 'delete']; @endphp

                                @foreach($actions as $action)
                                    <td>
                                        @php
                                            $permName = $module . '.' . $action;
                                        @endphp

                                        @if($modulePermissions->where('name', $permName)->first())
                                            <input type="checkbox" name="permissions[]" value="{{ $permName }}"
                                                class="permission-checkbox" {{ in_array($permName, $adminPermissions) ? 'checked' : '' }}>
                                        @else
                                            —
                                        @endif
                                    </td>
                                @endforeach

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button class="btn btn-primary">Update</button>

            </form>


        </div>
    </div>

@endsection
@section('script')
    <script>
        document.querySelector('form').addEventListener('submit', function (e) {
            let checked = document.querySelectorAll('input[name="permissions[]"]:checked');

            if (checked.length === 0) {
                e.preventDefault();
                alert('Please select at least one permission');
            }
        });
    </script>
@endsection