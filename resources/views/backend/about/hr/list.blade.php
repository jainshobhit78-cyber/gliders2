<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0 page-title">Human Resources</h5>
        @if(auth()->guard('admin')->user()->can('human_resources.create'))
            <a href="javascript:void(0)" class="btn btn-theme openHrAdd"
                data-url="{{ url('admin/about/human-resources/add') }}">
                <i data-feather="plus-square"></i>
                Add Human Resource
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
                                <th>Description Preview</th>
                                <th>HR Vision Preview</th>
                                <th>HR Mission Preview</th>
                                <th>Objectives Preview</th>
                                <th>Strategy Preview</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($hrs as $key => $hr)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $hr->title }}</td>
                                    <td>{!! \Str::limit(strip_tags($hr->description), 60) !!}</td>
                                    <td>{!! \Str::limit(strip_tags($hr->vision), 60) !!}</td>
                                    <td>{!! \Str::limit(strip_tags($hr->mission), 60) !!}</td>
                                    <td>{!! \Str::limit(strip_tags($hr->objectives), 60) !!}</td>
                                    <td>{!! \Str::limit(strip_tags($hr->strategy), 60) !!}</td>
                                    <td>
                                        <ul class="table-action">
                                            @if(auth()->guard('admin')->user()->can('human_resources.edit'))
                                                <li>
                                                    <a href="javascript:void(0)" class="btn btn-edit openHrEdit"
                                                        data-url="{{ url('admin/about/human-resources/edit/' . $hr->id) }}">
                                                        Edit
                                                    </a>
                                                </li>
                                            @endif

                                            @if(auth()->guard('admin')->user()->can('human_resources.delete'))

                                                <li>
                                                    <a href="{{ url('admin/about/human-resources/delete/' . $hr->id) }}"
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
                                    <td colspan="8">No Human Resources Found</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>

</div>