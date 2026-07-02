<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">Vision</h5>
        @if(auth()->guard('admin')->user()->can('vision.create'))
            <a href="javascript:void(0)" class="btn btn-theme openVisionAdd" data-url="{{ url('admin/about/vision/add') }}">
                <i data-feather="plus-square"></i>
                Add Vision
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

                            @forelse($visions as $key => $vision)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>{{ $vision->title }}</td>

                                    <td>

                                        {!! \Str::limit(strip_tags($vision->description), 100) !!}

                                    </td>

                                    <td>

                                        <ul class="table-action">
                                            @if(auth()->guard('admin')->user()->can('vision.edit'))
                                                <li>

                                                    <a href="javascript:void(0)" class="btn btn-edit openVisionEdit"
                                                        data-url="{{ url('admin/about/vision/edit/' . $vision->id) }}">
                                                        Edit
                                                    </a>

                                                </li>
                                            @endif


                                            @if(auth()->guard('admin')->user()->can('vision.delete'))
                                                <li>

                                                    <a href="{{ url('admin/about/vision/delete/' . $vision->id) }}"
                                                        class="btn btn-delete" onclick="return confirm('Delete this vision?')">
                                                        Delete
                                                    </a>

                                                </li>
                                            @endif

                                        </ul>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4">No Vision Found</td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>