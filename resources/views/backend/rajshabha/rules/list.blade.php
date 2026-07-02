<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">
            Rajbhasha Rules
        </h5>
        @if(auth()->guard('admin')->user()->can('rajshabha_rules.create'))
            <a href="javascript:void(0)" class="btn btn-theme openRulesAdd"
                data-url="{{ url('admin/rajshabha/rules/add') }}">

                Add New Rule

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
                                <th>Heading</th>
                                <th>PDF</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($items as $key => $item)

                                <tr>

                                    <td>{{$key + 1}}</td>

                                    <td>{{$item->heading}}</td>

                                    <td>

                                        @if($item->pdf)

                                            <a href="{{asset('uploads/rajshabha/' . $item->pdf)}}" target="_blank">

                                                View PDF

                                            </a>

                                        @endif

                                    </td>

                                    <td>

                                        <ul class="table-action">
                                            @if(auth()->guard('admin')->user()->can('rajshabha_rules.edit'))
                                                <li>
                                                    <a href="javascript:void(0)" class="btn btn-edit openRulesEdit"
                                                        data-url="{{ url('admin/rajshabha/rules/edit/' . $item->id) }}">
                                                        Edit
                                                    </a>
                                                </li>
                                            @endif

                                            @if(auth()->guard('admin')->user()->can('rajshabha_rules.delete'))
                                                <li>
                                                    <a href="{{ url('admin/rajshabha/rules/delete/' . $item->id) }}"
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