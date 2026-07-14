<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">
            Vigilance Setup
        </h5>
        @if(auth()->guard('admin')->user()->can('vigilance_setup.create'))
            <a href="javascript:void(0)" class="btn btn-theme openSetupAdd"
                data-url="{{ url('admin/vigilance/setup/add') }}">

                Add Vigilance Setup

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
                                <th>Description</th>
                                <th>Image</th>
                                <th>PDF</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($setups as $key => $setup)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>{{ \Str::limit(strip_tags($setup->description), 120) }}</td>

                                    <td>

                                        @if($setup->image)

                                            <img src="{{ asset('uploads/vigilance/' . $setup->image) }}" width="60">

                                        @endif

                                    </td>

                                    <td>

                                        @if($setup->pdf)

                                            <a href="{{ asset('uploads/vigilance/' . $setup->pdf) }}" target="_blank">

                                                View PDF

                                            </a>

                                        @endif

                                    </td>

                                    <td>

                                        <ul class="table-action">
                                            @if(auth()->guard('admin')->user()->can('vigilance_setup.edit'))
                                                <li>

                                                    <a href="javascript:void(0)" class="btn btn-edit openSetupEdit"
                                                        data-url="{{ url('admin/vigilance/setup/edit/' . $setup->id) }}">

                                                        Edit

                                                    </a>

                                                </li>
                                            @endif

                                            @if(auth()->guard('admin')->user()->can('vigilance_setup.delete'))
                                                <li>

                                                    <x-delete-form :action="url('admin/vigilance/setup/delete/' . $setup->id)" class="btn btn-delete" confirm="Delete this record?" />

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
