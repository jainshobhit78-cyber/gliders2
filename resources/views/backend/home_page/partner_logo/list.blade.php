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

        <h5 class="mb-0 page-title">Partner Logos</h5>
        {{-- @if(auth()->guard('admin')->user()->can('vision.create')) --}}
        <a href="javascript:void(0)" class="btn btn-theme openLogoAdd"
            data-url="{{ url('admin/home/partner_logo/form') }}">
            <i data-feather="plus-square"></i>
            Add New Logo
        </a>
        {{-- @endif --}}
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
                                <th>Partner Logo</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($logo as $key => $offer)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

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

                                            {{-- @if(auth()->guard('admin')->user()->can('key_offering.edit')) --}}
                                            <li>
                                                <a href="javascript:void(0)" class="btn btn-edit openLogoEdit"
                                                    data-url="{{ url('admin/home/partner_logo/form/' . $offer->id) }}">
                                                    Edit
                                                </a>
                                            </li>
                                            {{-- @endif --}}

                                            {{-- @if(auth()->guard('admin')->user()->can('key_offering.delete')) --}}
                                            <li>
                                                <a href="{{ url('admin/home/partner_logo/delete/' . $offer->id) }}"
                                                    class="btn btn-delete" onclick="return confirm('Delete this record?')">
                                                    Delete
                                                </a>
                                            </li>
                                            {{-- @endif --}}

                                        </ul>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5">No Data Found</td>
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