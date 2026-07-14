<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">History</h5>
        @if(auth()->guard('admin')->user()->can('history.create'))
            <a href="javascript:void(0)" class="btn btn-theme openHistoryAdd"
                data-url="{{ url('admin/about/history/add') }}">

                <i data-feather="plus-square"></i>
                Add History

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

                            @forelse($histories as $key => $history)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>{{ $history->title }}</td>

                                    <td>

                                        {{ \Str::limit(strip_tags($history->description), 80) }}

                                    </td>

                                    <td>

                                        <ul class="table-action">
                                            @if(auth()->guard('admin')->user()->can('history.edit'))
                                                <li>
                                                    <a href="javascript:void(0)" class="btn btn-edit openHistoryEdit"
                                                        data-url="{{ url('admin/about/history/edit/' . $history->id) }}">
                                                        Edit
                                                    </a>
                                                </li>
                                            @endif

                                            @if(auth()->guard('admin')->user()->can('history.delete'))
                                                <li>
                                                    <x-delete-form :action="url('admin/about/history/delete/' . $history->id)"
                                                        confirm="Delete this history?" />
                                                </li>
                                            @endif

                                        </ul>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4">No History Found</td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>
