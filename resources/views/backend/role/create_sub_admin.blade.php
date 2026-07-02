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
        <h5>Create Sub Admin</h5>

        <a href="{{ route('admin.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="card mt-3">
        <div class="card-body">

            <form action="{{ route('admin.store') }}" method="POST">
                @csrf

                <div class="d-flex gap-3">

                    <div class="w-100">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="w-100">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="w-100">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" minlength="6" required>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>
                <hr>

                {{-- Permissions --}}
                <div class="mb-3">
                    <label class="mb-2">Permissions</label>
                    @error('permissions')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
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

                                    @php
                                        $actions = ['view', 'create', 'edit', 'delete'];
                                    @endphp

                                    @foreach($actions as $action)
                                        <td>
                                            @php
                                                $permName = $module . '.' . $action;
                                                $permission = $modulePermissions->where('name', $permName)->first();
                                            @endphp

                                            @if($permission)
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                                            @else
                                                —
                                            @endif
                                        </td>
                                    @endforeach

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <button class="btn btn-success">Create Sub Admin</button>

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