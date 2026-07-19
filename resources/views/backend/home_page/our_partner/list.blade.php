<style>
    .user-table {
        text-align: center;
    }

    .badge {
        padding: 11px 13px !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: transparent !important;
        border: none;
    }
</style>
<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">Our Partners</h5>
        <a href="javascript:void(0)" class="btn btn-theme openLogoAdd"
            data-url="{{ url('admin/home/our_partner/form') }}">
            <i data-feather="plus-square"></i>
            Add New Partner
        </a>
    </div>


    <div class="container-fluid">

        <div class="card">

            <div class="card-body">

                @include('_message')

                <div class="table-responsive">

                    <table id="logoTable" class="user-table table table-striped">

                        <thead>

                            <tr>
                                <th>#</th>
                                <th>Partner Name</th>
                                <th>Partner Logo</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($logo as $key => $offer)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    {{-- NAME --}}
                                    <td>
                                        <strong>{{ $offer->name }}</strong>
                                    </td>

                                    {{-- IMAGE --}}
                                    <td>
                                        @if($offer->image)
                                            <div
                                                style="width:130px;  height:90px; display:flex; align-items:center; justify-content:center;  border:1px solid #eee;  border-radius:12px; ">

                                                <img src="{{ asset($offer->image) }}"
                                                    style="max-width:100%; max-height:80px; object-fit:contain;">
                                            </div>
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>


                                    {{-- ACTION --}}
                                    <td>

                                        <ul class="table-action">

                                            <li>
                                                <a href="javascript:void(0)" class="btn btn-edit openLogoEdit"
                                                    data-url="{{ url('admin/home/our_partner/form/' . $offer->id) }}">
                                                    Edit
                                                </a>
                                            </li>

                                            <li>
                                                <x-delete-form :action="url('admin/home/our_partner/delete/' . $offer->id)" class="btn btn-delete" confirm="Delete this record?" />
                                            </li>

                                        </ul>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4">No Data Found</td>
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
        $('#logoTable').DataTable({
            paging: true,
            searching: false,
            info: true,
            lengthChange: false,
            pageLength: 10, // optional
            ordering: false
        });
    });
</script>
