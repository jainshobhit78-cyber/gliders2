<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">
            Contact Details
        </h5>
        @if(auth()->guard('admin')->user()->can('vigilance_contact_details.create'))
            <a href="javascript:void(0)" class="btn btn-theme openContactAdd"
                data-url="{{ url('admin/vigilance/contact/add') }}">

                Add Contact

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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Photo</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($contacts as $key => $contact)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>{{ $contact->title }}</td>

                                    <td>{{ $contact->name }}</td>

                                    <td>

                                        @if($contact->emails)

                                            @foreach($contact->emails as $email)

                                                {{ $email }} <br>

                                            @endforeach

                                        @endif

                                    </td>

                                    <td>

                                        @if($contact->photo)

                                            <img src="{{ asset('uploads/vigilance/' . $contact->photo) }}" width="50">

                                        @endif

                                    </td>

                                    <td>

                                        <ul class="table-action">
                                            @if(auth()->guard('admin')->user()->can('vigilance_contact_details.edit'))
                                                <li>

                                                    <a href="javascript:void(0)" class="btn btn-edit openContactEdit"
                                                        data-url="{{ url('admin/vigilance/contact/edit/' . $contact->id) }}">

                                                        Edit

                                                    </a>

                                                </li>
                                            @endif

                                            @if(auth()->guard('admin')->user()->can('vigilance_contact_details.delete'))
                                                <li>

                                                    <a href="{{ url('admin/vigilance/contact/delete/' . $contact->id) }}"
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
                                    <td colspan="6">No Data Found</td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>