<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">
            Information under RTI Act 2005
        </h5>
        @if(auth()->guard('admin')->user()->can('rti_information.create'))
            <a href="javascript:void(0)" class="btn btn-theme openInfoAdd"
                data-url="{{ url('admin/rti/information/add') }}">

                Add New Information

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

                                    <td>{!! \Str::limit(strip_tags($item->info_text), 120) !!}</td>

                                    <td>

                                        @if($item->pdf)

                                            <a href="{{ asset('uploads/rti/' . $item->pdf) }}" target="_blank">
                                                View PDF
                                            </a>

                                        @endif

                                    </td>

                                    <td>

                                        <ul class="table-action">
                                            @if(auth()->guard('admin')->user()->can('rti_information.edit'))
                                                <li>

                                                    <a href="javascript:void(0)" class="btn btn-edit openInfoEdit"
                                                        data-url="{{ url('admin/rti/information/edit/' . $item->id) }}">

                                                        Edit

                                                    </a>

                                                </li>
                                            @endif
                                            @if(auth()->guard('admin')->user()->can('rti_information.delete'))
                                                <li>

                                                    <a href="{{ url('admin/rti/information/delete/' . $item->id) }}"
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