@extends('backend.layout.app')
<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: transparent !important;
        border: none;
    }
</style>
@section('content')
    <div class="title-header title-header-1 d-flex align-items-center justify-content-between">
        <h5>
            Role & Permission
        </h5>
        <a href="{{ route('admin.create') }}" class="btn btn-primary">
            + Add Sub Admin
        </a>

    </div>

    <div class="container-fluid">

        <div class="card">
            <div class="card-body">
                @include('_message')
                <div class="table-responsive">
                    <table id="roleTable" class="user-table table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Permissions</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($subAdmins as $admin)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>


                                    <td>{{ ucwords(str_replace('_', ' ', $admin->getRoleNames()->first())) }}</td>

                                    <td>
                                        @php
                                            $permissions = $admin->getAllPermissions();
                                            $visible = $permissions->take(3);
                                            $remaining = $permissions->count() - 3;
                                        @endphp

                                        {{-- Show first 3 --}}
                                        @foreach($visible as $permission)
                                            <span class="badge bg-success">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach

                                        {{-- Show remaining count --}}
                                        @if($remaining > 0)
                                            <span class="badge bg-secondary" style="color: black;">
                                                +{{ $remaining }} more
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.destroy', $admin->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf

                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this sub admin?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                           @empty
                               
                           @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {

            let table = $('#roleTable').DataTable({
                paging: true,
                searching: true,
                info: true,
                lengthChange: false,
                pageLength: 10,
                ordering: false
            });

            table.on('draw.dt', function () {
                let PageInfo = table.page.info();

                table.column(0, { page: 'current' }).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1 + PageInfo.start;
                });
            });

        });

    </script>
    <script>
        $('.delete-btn').click(function (e) {
            e.preventDefault();

            if (confirm('Delete this sub admin?')) {
                let form = $(this).closest('form');

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function () {
                        location.reload();
                    }
                });
            }
        });
    </script>

@endsection