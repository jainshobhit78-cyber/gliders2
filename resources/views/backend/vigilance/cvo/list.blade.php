<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">
            All Chief Vigilance Officer
        </h5>
        @if(auth()->guard('admin')->user()->can('chief_vigilance_officer.create'))
            <a href="javascript:void(0)" class="btn btn-theme openCvoAdd" data-url="{{ url('admin/vigilance/cvo/add') }}">
                Add New Chief Vigilance Officer
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
                                <th>Name</th>
                                <th>Title</th>
                                <th>Sub Title</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Link</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($cvos as $key => $cvo)

                                <tr>

                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $cvo->name }}</td>
                                    <td>{{ $cvo->title }}</td>
                                    <td>{{ $cvo->sub_title }}</td>

                                    <td>{{ \Str::limit(strip_tags($cvo->description), 150) }}</td>

                                    <td>
                                        @if($cvo->image)
                                            <img src="{{ asset('uploads/cvo/' . $cvo->image) }}" width="50">
                                        @endif
                                    </td>

                                    <td>

                                        @if($cvo->pdf)

                                            <a href="{{ asset('uploads/cvo/' . $cvo->pdf) }}" target="_blank">

                                                View PDF

                                            </a>

                                        @endif

                                    </td>

                                    <td>

                                        <ul class="table-action">
                                            @if(auth()->guard('admin')->user()->can('chief_vigilance_officer.edit'))
                                                <li>

                                                    <a href="javascript:void(0)" class="btn btn-edit openCvoEdit"
                                                        data-url="{{ url('admin/vigilance/cvo/edit/' . $cvo->id) }}">
                                                        Edit
                                                    </a>

                                                </li>
                                            @endif

                                            @if(auth()->guard('admin')->user()->can('chief_vigilance_officer.delete'))
                                                <li>

                                                    <a href="{{ url('admin/vigilance/cvo/delete/' . $cvo->id) }}"
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
