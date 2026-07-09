<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">
            Sexual Harassment of Women at Workplace
        </h5>
        @if(auth()->guard('admin')->user()->can('sexual_harassment_of_women_at_workplace.create'))
            <a href="javascript:void(0)" class="btn btn-theme openSexualAdd"
                data-url="{{ url('admin/vigilance/harassment/add') }}">

                Add New

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
                                <th>Image</th>
                                <th>PDF</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($items as $key => $item)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>{{ \Str::limit(strip_tags($item->info_text), 120) }}</td>

                                    <td>

                                        @if($item->image)

                                            <img src="{{ asset('uploads/vigilance/' . $item->image) }}" width="60">

                                        @endif

                                    </td>

                                    <td>

                                        @if($item->pdf)

                                            <a href="{{ asset('uploads/vigilance/' . $item->pdf) }}" target="_blank">

                                                View PDF

                                            </a>

                                        @endif

                                    </td>

                                    <td>

                                        <ul class="table-action">
                                            @if(auth()->guard('admin')->user()->can('sexual_harassment_of_women_at_workplace.edit'))
                                                <li>
                                                    <a href="javascript:void(0)" class="btn btn-edit openSexualEdit"
                                                        data-url="{{ url('admin/vigilance/harassment/edit/' . $item->id) }}">
                                                        Edit
                                                    </a>
                                                </li>
                                            @endif

                                            @if(auth()->guard('admin')->user()->can('sexual_harassment_of_women_at_workplace.delete'))
                                                <li>
                                                    <a href="{{ url('admin/vigilance/harassment/delete/' . $item->id) }}"
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
