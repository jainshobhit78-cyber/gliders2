<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">Key Offerings</h5>
        {{-- @if(auth()->guard('admin')->user()->can('vision.create')) --}}
        <a href="javascript:void(0)" class="btn btn-theme openKeyAdd" data-url="{{ url('admin/about/key_offerings/add') }}">
            <i data-feather="plus-square"></i>
            Add Key Offerings
        </a>
        {{-- @endif --}}
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
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($key_Offer as $key => $offer)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    {{-- IMAGE --}}
                                    <td>
                                        @if($offer->image)
                                            <img src="{{ asset('uploads/key_offerings/' . $offer->image) }}" width="60"
                                                height="60" style="object-fit:cover;">
                                        @else
                                            No Image
                                        @endif
                                    </td>

                                    {{-- TITLE --}}
                                    <td>{{ $offer->title }}</td>

                                    {{-- DESCRIPTION --}}
                                    <td>
                                        {!! \Str::limit(strip_tags($offer->description), 100) !!}
                                    </td>

                                    {{-- ACTION --}}
                                    <td>

                                        <ul class="table-action">

                                            {{-- @if(auth()->guard('admin')->user()->can('key_offering.edit')) --}}
                                                <li>
                                                    <a href="javascript:void(0)" class="btn btn-edit openKeyEdit"
                                                        data-url="{{ url('admin/about/key_offerings/edit/' . $offer->id) }}">
                                                        Edit
                                                    </a>
                                                </li>
                                            {{-- @endif --}}

                                            {{-- @if(auth()->guard('admin')->user()->can('key_offering.delete')) --}}
                                                <li>
                                                    <a href="{{ url('admin/about/key_offerings/delete/' . $offer->id) }}"
                                                        class="btn btn-delete" onclick="return confirm('Delete this record?')">
                                                        Delete
                                                    </a>
                                                </li>
                                            {{-- @endif --}}

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