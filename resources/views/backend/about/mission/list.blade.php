<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">Mission</h5>
        @if(auth()->guard('admin')->user()->can('mission.create'))
            <a href="javascript:void(0)" class="btn btn-theme openMissionAdd"
                data-url="{{ url('admin/about/mission/add') }}">

                <i data-feather="plus-square"></i>
                Add Mission

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
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($missions as $key => $mission)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>{{ $mission->title }}</td>

                                    <td>

                                        {{ \Str::limit(strip_tags($mission->description), 100) }}

                                    </td>

                                    <td>

                                        <ul class="table-action">
                                            @if(auth()->guard('admin')->user()->can('mission.edit'))
                                                <li>
                                                    <a href="javascript:void(0)" class="btn btn-edit openMissionEdit"
                                                        data-url="{{ url('admin/about/mission/edit/' . $mission->id) }}">
                                                        Edit
                                                    </a>
                                                </li>
                                            @endif

                                            @if(auth()->guard('admin')->user()->can('mission.delete'))
                                                <li>
                                                    <a href="{{ url('admin/about/mission/delete/' . $mission->id) }}"
                                                        class="btn btn-delete" onclick="return confirm('Delete this mission?')">
                                                        Delete
                                                    </a>
                                                </li>
                                            @endif

                                        </ul>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4">No Mission Found</td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>
