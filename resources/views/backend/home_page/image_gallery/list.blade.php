<style>
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

        <h5 class="mb-0 page-title">Image Gallery</h5>
        {{-- @if(auth()->guard('admin')->user()->can('vision.create')) --}}
        <a href="javascript:void(0)" class="btn btn-theme openKeyAdd"
            data-url="{{ url('admin/home/image_gallery/form') }}">
            <i data-feather="plus-square"></i>
            Add New Image
        </a>
        {{-- @endif --}}
    </div>


    <div class="container-fluid">

        <div class="card">

            <div class="card-body">

                @include('_message')

                <div class="table-responsive">

                    <table id="image_gallery" class="user-table table table-striped">

                        <thead>

                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($image_gallery as $key => $offer)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    {{-- IMAGE --}}
                                    <td>
                                        @if($offer->image)
                                            <div
                                                style="width:70px; height:70px; overflow:hidden; border-radius:10px; border:1px solid #eee;">
                                                <img src="{{ asset($offer->image) }}"
                                                    style="width:100%; height:100%; object-fit:cover; transition:0.3s;">
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
                                                <a href="javascript:void(0)" class="btn btn-edit openImageEdit"
                                                    data-url="{{ url('admin/home/image_gallery/form/' . $offer->id) }}">
                                                    Edit
                                                </a>
                                            </li>
                                            {{-- @endif --}}

                                            {{-- @if(auth()->guard('admin')->user()->can('key_offering.delete')) --}}
                                            <li>
                                                <x-delete-form :action="url('admin/home/image_gallery/delete/' . $offer->id)" class="btn btn-delete" confirm="Delete this record?" />
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
        $('#image_gallery').DataTable({
            paging: true,
            searching: false,
            info: true,
            lengthChange: false,
            pageLength: 10, // optional
            ordering: false
        });
    });
</script>