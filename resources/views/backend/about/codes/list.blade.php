<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">Codes of Conduct</h5>
        @if(auth()->guard('admin')->user()->can('codes_of_conduct.create'))
            <a href="javascript:void(0)" class="btn btn-theme openCodesAdd" data-url="{{ url('admin/about/codes/add') }}">
                <i data-feather="plus-square"></i>
                Add Code
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
                                <th>PDF</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($codes as $key => $code)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>{{ $code->title }}</td>

                                    <td>{{ \Str::limit(strip_tags($code->description), 100) }}</td>

                                    <td>

                                        @if($code->pdf)

                                            <a href="{{ asset('uploads/codes/' . $code->pdf) }}" target="_blank"
                                                class="btn btn-sm btn-info">

                                                View PDF

                                            </a>

                                        @endif

                                    </td>

                                    <td>

                                        <ul class="table-action">
                                            @if(auth()->guard('admin')->user()->can('codes_of_conduct.edit'))
                                                <li>
                                                    <a href="javascript:void(0)" class="btn btn-edit openCodesEdit"
                                                        data-url="{{ url('admin/about/codes/edit/' . $code->id) }}">
                                                        Edit
                                                    </a>
                                                </li>
                                            @endif
                                            @if(auth()->guard('admin')->user()->can('codes_of_conduct.delete'))
                                                <li>
                                                    <x-delete-form :action="url('admin/about/codes/delete/' . $code->id)" />
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
