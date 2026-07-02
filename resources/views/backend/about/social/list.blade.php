<div class="about-section">

    <div class="title-header d-flex align-items-center justify-content-between">

        <h5 class="mb-0 page-title">Social Responsibility</h5>
        @if(auth()->guard('admin')->user()->can('social_responsibility.create'))
            <a href="javascript:void(0)" class="btn btn-theme openSocialAdd"
                data-url="{{ url('admin/about/social-responsibility/add') }}">

                <i data-feather="plus-square"></i>
                Add Member

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
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($socials as $key => $social)

                                <tr>

                                    <td>{{ $key + 1 }}</td>

                                    <td>
                                        @if($social->photo)
                                            <img src="{{ asset('uploads/social/' . $social->photo) }}"
                                                style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                                        @endif
                                    </td>

                                    <td>{{ $social->name }}</td>

                                    <td>{{ $social->title }}</td>

                                    <td>{{ $social->phone }}</td>

                                    <td>

                                        <ul class="table-action">
                                            @if(auth()->guard('admin')->user()->can('social_responsibility.edit'))
                                                <li>
                                                    <a href="javascript:void(0)" class="btn btn-edit openSocialEdit"
                                                        data-url="{{ url('admin/about/social-responsibility/edit/' . $social->id) }}">
                                                        Edit
                                                    </a>
                                                </li>
                                            @endif

                                            @if(auth()->guard('admin')->user()->can('social_responsibility.delete'))
                                                <li>
                                                    <a href="{{ url('admin/about/social-responsibility/delete/' . $social->id) }}"
                                                        class="btn btn-delete" onclick="return confirm('Delete?')">
                                                        Delete
                                                    </a>
                                                </li>
                                            @endif

                                        </ul>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>