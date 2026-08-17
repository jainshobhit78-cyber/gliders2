<div class="about-section">
    <div class="title-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0 page-title">Annual Returns</h5>
        @if(auth()->guard('admin')->user()->can('annual_reports.create'))
            <a href="javascript:void(0)" class="btn btn-theme openReturnAdd"
               data-url="{{ url('admin/finance/returns/add') }}">Add New</a>
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
                                <th>Financial Year</th>
                                <th>PDF</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td>ANNUAL RETURN {{ $item->fiscal_year }}</td>
                                    <td>
                                        @if($item->pdf)
                                            <a href="{{ asset('uploads/finance/' . $item->pdf) }}" target="_blank">View PDF</a>
                                        @else
                                            <span class="text-muted">Pending upload</span>
                                        @endif
                                    </td>
                                    <td>
                                        <ul class="table-action mb-0">
                                            @if(auth()->guard('admin')->user()->can('annual_reports.edit'))
                                                <li>
                                                    <a href="javascript:void(0)" class="btn btn-edit openReturnEdit"
                                                       data-url="{{ url('admin/finance/returns/edit/' . $item->id) }}">Edit</a>
                                                </li>
                                            @endif
                                            @if(auth()->guard('admin')->user()->can('annual_reports.delete'))
                                                <li>
                                                    <x-delete-form :action="url('admin/finance/returns/delete/' . $item->id)" class="btn btn-delete" confirm="Delete this annual return?" />
                                                </li>
                                            @endif
                                        </ul>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center">No Data Found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
