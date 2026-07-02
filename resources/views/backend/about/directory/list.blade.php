<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0;
    }

    #newsTable_filter {
        display: none !important;
    }
</style>
<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">Directory</h5>
        @if(auth()->guard('admin')->user()->can('directory.create'))
            <a href="javascript:void(0)" class="btn btn-theme openDirectoryAdd"
                data-url="{{ url('admin/about/directory/add') }}">

                <i data-feather="plus-square"></i>
                Add Directory

            </a>
        @endif

    </div>


    <div class="container-fluid">

        <div class="card">

            <div class="card-body">

                @include('_message')

                <div class="table-responsive">

                    <table id="directoryTable" class="user-table table table-striped">

                        <thead>

                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>Units</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Deals In</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($directories as $key => $dir)

                                <tr>

                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @if($dir->profile_photo)
                                            <img src="{{ asset('uploads/directory/' . $dir->profile_photo) }}"
                                                style="height:50px; width:50px; object-fit:cover; border-radius:50%;">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $dir->role }}</td>
                                    <td>{{ $dir->name }}</td>
                                    <td>{{ $dir->designation }}</td>
                                    <td>
                                        @php
                                            $mobiles = $dir->mobile_no ?? [];
                                            $visibleMobiles = array_slice($mobiles, 0, 3);
                                            $remainingMobiles = count($mobiles) - 3;
                                        @endphp

                                        @foreach($visibleMobiles as $mobile)
                                            <span class="badge bg-primary me-1 mb-1">{{ $mobile }}</span>
                                        @endforeach

                                        @if($remainingMobiles > 0)
                                            <span class="badge bg-secondary" style="color: black;">+{{ $remainingMobiles }}
                                                more</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $emails = $dir->email ?? [];
                                            $visibleEmails = array_slice($emails, 0, 3);
                                            $remainingEmails = count($emails) - 3;
                                        @endphp

                                        @foreach($visibleEmails as $email)
                                            <span class="badge bg-success me-1 mb-1">{{ $email }}</span>
                                        @endforeach

                                        @if($remainingEmails > 0)
                                            <span class="badge bg-secondary" style="color: black;">+{{ $remainingEmails }}
                                                more</span>
                                        @endif
                                    </td>
                                    <td>{{ $dir->deals_in }}</td>
                                    <td>
                                        <ul class="table-action">
                                            @if(auth()->guard('admin')->user()->can('directory.edit'))
                                                <li>

                                                    <a href="javascript:void(0)" class="btn btn-edit openDirectoryEdit"
                                                        data-url="{{ url('admin/about/directory/edit/' . $dir->id) }}">
                                                        Edit
                                                    </a>
                                                </li>
                                            @endif
                                            @if(auth()->guard('admin')->user()->can('directory.delete'))
                                                <li>

                                                    <a href="{{ url('admin/about/directory/delete/' . $dir->id) }}"
                                                        class="btn btn-delete" onclick="return confirm('Delete this record?')">
                                                        Delete
                                                    </a>
                                                </li>
                                            @endif

                                        </ul>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8">No Directory Found</td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
    $(document).ready(function () {

        $('#directoryTable').DataTable({
            paging: true,
            searching: true,
            info: true,
            lengthChange: false,
            pageLength: 10, // optional
            ordering: false
        });

    })
</script>