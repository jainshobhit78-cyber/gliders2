<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">
            Online Portal
        </h5>
        @if(auth()->guard('admin')->user()->can('vendors.create'))
            <a href="javascript:void(0)" class="btn btn-theme openPortalAdd"
                data-url="{{ url('admin/vendors/portal/add') }}">

                Add New Portal

            </a>
        @endif

    </div>


    <div class="container-fluid">

        <div class="card">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="user-table table table-striped">

                        <thead>

                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>PDF</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($items as $key => $item)

                                <tr>

                                    <td>{{$key + 1}}</td>

                                    <td>{{$item->title}}</td>

                                    <td>

                                        @if($item->pdf)

                                            <a href="{{asset('uploads/vendors/' . $item->pdf)}}" target="_blank">

                                                View PDF

                                            </a>

                                        @endif

                                    </td>

                                    <td>

                                        <ul class="table-action">
                                            @if(auth()->guard('admin')->user()->can('vendors.edit'))
                                                <li>

                                                    <a href="javascript:void(0)" class="btn btn-edit openPortalEdit"
                                                        data-url="{{ url('admin/vendors/portal/edit/' . $item->id) }}">

                                                        Edit

                                                    </a>

                                                </li>
                                            @endif

                                            @if(auth()->guard('admin')->user()->can('vendors.delete'))
                                                <li>

                                                    <x-delete-form :action="url('admin/vendors/portal/delete/' . $item->id)" class="btn btn-delete" confirm="Delete this record?" />

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