<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">All Notifications</h5>
        @if(auth()->guard('admin')->user()->can('careers.create'))
            <a href="javascript:void(0)" class="btn btn-theme openCareerAdd"
                data-url="{{ url('admin/careers/notifications/add') }}">

                Add New Notification

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
                                <th>Title</th>
                                <th>Description</th>
                                <th>Link</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($items as $key => $item)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>{{ $item->title }}</td>

                                    <td>{!! \Str::limit(strip_tags($item->description), 120) !!}</td>

                                    <td>

                                        @foreach($item->files as $file)

                                            <a href="{{ asset('uploads/careers/' . $file->pdf) }}" target="_blank">

                                                View PDF

                                            </a><br>

                                        @endforeach

                                    </td>

                                    <td>

                                        <ul class="table-action">
                                            @if(auth()->guard('admin')->user()->can('careers.edit'))
                                                <li>

                                                    <a href="javascript:void(0)" class="btn btn-edit openCareerEdit"
                                                        data-url="{{ url('admin/careers/notifications/edit/' . $item->id) }}">

                                                        Edit

                                                    </a>

                                                </li>
                                            @endif

                                            @if(auth()->guard('admin')->user()->can('careers.delete'))
                                                <li>

                                                    <a href="{{ url('admin/careers/notifications/delete/' . $item->id) }}"
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