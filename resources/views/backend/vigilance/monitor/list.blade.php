<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">
            Independent External Monitor
        </h5>
        @if(auth()->guard('admin')->user()->can('independent_external_monitor.create'))
            <a href="javascript:void(0)" class="btn btn-theme openMonitorAdd"
                data-url="{{ url('admin/vigilance/monitor/add') }}">
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
                                <th>Title</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($items as $key => $item)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>{{ $item->title }}</td>

                                    <td>{!! \Str::limit(strip_tags($item->address), 120) !!}</td>

                                    <td>

                                        <ul class="table-action">
                                            @if(auth()->guard('admin')->user()->can('independent_external_monitor.edit'))
                                                <li>
                                                    <a href="javascript:void(0)" class="btn btn-edit openMonitorEdit"
                                                        data-url="{{ url('admin/vigilance/monitor/edit/' . $item->id) }}">
                                                        Edit
                                                    </a>
                                                </li>
                                            @endif

                                            @if(auth()->guard('admin')->user()->can('independent_external_monitor.delete'))
                                                <li>
                                                    <a href="{{ url('admin/vigilance/monitor/delete/' . $item->id) }}"
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