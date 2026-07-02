<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">

            EOI for Banks

        </h5>

        @if(auth()->guard('admin')->user()->can('eoi_for_banks.create'))
            <a href="javascript:void(0)" class="btn btn-theme openEoiAdd" data-url="{{ url('admin/finance/eoi/add') }}">

                Add New EOI

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
                                <th>PDF</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($items as $key => $item)

                                <tr>

                                    <td>{{$key + 1}}</td>

                                    <td>{{$item->title}}</td>

                                    <td>{!! \Str::limit(strip_tags($item->description), 120) !!}</td>

                                    <td>

                                        @if($item->pdf)

                                            <a href="{{asset('uploads/finance/' . $item->pdf)}}" target="_blank">

                                                View PDF

                                            </a>

                                        @endif

                                    </td>

                                    <td>

                                        <ul class="table-action">
                                            @if(auth()->guard('admin')->user()->can('eoi_for_banks.edit'))
                                                <li>

                                                    <a href="javascript:void(0)" class="btn btn-edit openEoiEdit"
                                                        data-url="{{ url('admin/finance/eoi/edit/' . $item->id) }}">

                                                        Edit

                                                    </a>

                                                </li>
                                            @endif

                                            @if(auth()->guard('admin')->user()->can('eoi_for_banks.delete'))
                                                <li>

                                                    <a href="{{ url('admin/finance/eoi/delete/' . $item->id) }}"
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