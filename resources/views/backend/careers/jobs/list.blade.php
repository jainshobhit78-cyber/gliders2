<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0 page-title">All {{ ucfirst($type) }} Entries</h5>
        @if(auth()->guard('admin')->user()->can('careers.create'))
            <a href="javascript:void(0)" class="btn btn-theme openCareerAdd"
                data-url="{{ url('admin/careers/jobs/add?type=' . $type) }}">
                Add New {{ ucfirst($type) }}
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
                                <th>Job Details / Info</th>
                                <th>Eligibility Criteria</th>
                                <th>Date of Last Apply</th>
                                <th>PDF Attachment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><strong>{{ $item->title }}</strong></td>
                                    <td>{!! \Str::limit(strip_tags($item->job_info), 120) !!}</td>
                                    <td>{{ \Str::limit(strip_tags($item->eligibility), 120) }}</td>
                                    <td>
                                        @if($item->last_date)
                                            <span class="text-danger fw-bold">{{ \Carbon\Carbon::parse($item->last_date)->format('d M Y') }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->pdf)
                                            <a href="{{ asset('uploads/careers/' . $item->pdf) }}" target="_blank" class="btn btn-sm btn-outline-primary py-1">
                                                <i class="bi bi-file-earmark-pdf-fill"></i> View PDF
                                            </a>
                                        @else
                                            <span class="text-muted">No PDF</span>
                                        @endif
                                    </td>
                                    <td>
                                        <ul class="table-action">
                                            @if(auth()->guard('admin')->user()->can('careers.edit'))
                                                <li>
                                                    <a href="javascript:void(0)" class="btn btn-edit openCareerEdit"
                                                        data-url="{{ url('admin/careers/jobs/edit/' . $item->id) }}">
                                                        Edit
                                                    </a>
                                                </li>
                                            @endif
                                            @if(auth()->guard('admin')->user()->can('careers.delete'))
                                                <li>
                                                    <x-delete-form :action="url('admin/careers/jobs/delete/' . $item->id)" class="btn btn-delete" confirm="Delete this record?" />
                                                </li>
                                            @endif
                                        </ul>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">No data found in this category</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
