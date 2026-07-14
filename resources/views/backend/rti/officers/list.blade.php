<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">

            RTI Officers

        </h5>
        @if(auth()->guard('admin')->user()->can('rti_officers.create'))
            <a href="javascript:void(0)" class="btn btn-theme openOfficerAdd"
                data-url="{{ url('admin/rti/officers/add') }}">
                Add RTI Officer
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
                                <th>Name</th>
                                <th>Post</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Image</th>
                                <th>Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($items as $key => $item)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>{{ $item->name }}</td>

                                    <td>{{ $item->post }}</td>

                                    <td>{{ $item->email }}</td>

                                    <td>{{ $item->phone }}</td>

                                    <td>

                                        @if($item->image)

                                            <img src="{{ asset('uploads/rti/' . $item->image) }}" width="60">

                                        @endif

                                    </td>

                                    <td>

                                        <ul class="table-action">
                                            @if(auth()->guard('admin')->user()->can('rti_officers.edit'))
                                                <li>

                                                    <a href="javascript:void(0)" class="btn btn-edit openOfficerEdit"
                                                        data-url="{{ url('admin/rti/officers/edit/' . $item->id) }}">

                                                        Edit

                                                    </a>

                                                </li>
                                            @endif
                                            @if(auth()->guard('admin')->user()->can('rti_officers.delete'))
                                                <li>

                                                    <x-delete-form :action="url('admin/rti/officers/delete/' . $item->id)" class="btn btn-delete" confirm="Delete this record?" />

                                                </li>
                                            @endif

                                        </ul>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7">No Data Found</td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>