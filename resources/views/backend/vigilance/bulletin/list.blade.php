<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">
            Vigilance Bulletin
        </h5>
        @if(auth()->guard('admin')->user()->can('vigilance_bulletin.create'))
            <a href="javascript:void(0)" class="btn btn-theme openBulletinAdd"
                data-url="{{ url('admin/vigilance/bulletin/add') }}">

                Add New

            </a>
        @endif

    </div>

    <div class="container-fluid">

        <div class="card">

            <div class="card-body">

                @include('_message')

                <div class="table-responsive">

                    <table class="user-table table table-striped">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Info</th>
                                <th>PDF</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($items as $key => $item)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>{{ \Str::limit(strip_tags($item->info_text), 120) }}</td>

                                    <td>

                                        @if($item->pdf)

                                            <a href="{{ asset('uploads/vigilance/' . $item->pdf) }}" target="_blank">

                                                View PDF

                                            </a>

                                        @endif

                                    </td>

                                    <td>

                                        <ul class="table-action">
                                            @if(auth()->guard('admin')->user()->can('vigilance_bulletin.create'))
                                                <li>
                                                    <a href="javascript:void(0)" class="btn btn-edit openBulletinEdit"
                                                        data-url="{{ url('admin/vigilance/bulletin/edit/' . $item->id) }}">
                                                        Edit
                                                    </a>

                                                </li>
                                            @endif

                                            @if(auth()->guard('admin')->user()->can('vigilance_bulletin.create'))
                                                <li>
                                                    <a href="{{ url('admin/vigilance/bulletin/delete/' . $item->id) }}"
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
