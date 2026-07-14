<div class="about-section">

    <div class="title-header title-header-1 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <h5 class="mb-0 page-title">All Leadership</h5>

        </div>
        @if(auth()->guard('admin')->user()->can('leadership.create'))
            <form class="d-inline-flex">
                <a href="javascript:void(0)" class="btn btn-theme openLeadershipAdd"
                    data-url="{{ url('admin/about/leadership/add') }}">
                    <i data-feather="plus-square"></i>
                    Add New Leadership
                </a>
            </form>
        @endif
    </div>

    <div class="row g-4">

        @foreach($leaders as $leader)

            <div class="col-xl-3 col-lg-4 col-md-6">

                <div class="leader-card">

                    <!-- <div class="leader-img">
                                    <img src="{{ asset('uploads/milestones/' . $leader->picture) }}" alt="">
                                </div> -->

                    <div class="leader-img">
                        @if($leader->picture)
                            <img src="{{ asset('uploads/leadership/' . $leader->picture) }}" alt="" style="object-fit: cover;">
                        @else
                            <img src="{{ asset('frontend/images/avatar/user-account.jpg') }}" alt="" style="object-fit: cover;">
                        @endif
                    </div>

                    <div class="leader-body">


                        <p class="leader-role">
                            {{ $leader->role }}
                        </p>
                        <p class="leader-sub">
                            {{ $leader->sub_title }}
                        </p>
                        <h5 class="leader-name">
                            {{ $leader->leader_name }}
                        </h5>

                        <div class="leader-actions">
                            @if(auth()->guard('admin')->user()->can('leadership.edit'))
                                <a href="javascript:void(0)" class="btn btn-edit openLeadershipEdit"
                                    data-url="{{ url('admin/about/leadership/edit/' . $leader->id) }}">
                                    Edit
                                </a>
                            @endif
                            @if(auth()->guard('admin')->user()->can('leadership.delete'))

                                <form action="{{ url('admin/about/leadership/delete/' . $leader->id) }}"
                                    method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">Delete</button>
                                </form>
                            @endif
                        </div>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>
