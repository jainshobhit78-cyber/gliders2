<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backOfficer">

        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" />
        </svg>

        <span>Back</span>

    </a>

    <h5>Edit RTI Officer</h5>

</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <form method="post" action="{{ url('admin/rti/officers/update/' . $item->id) }}"
                enctype="multipart/form-data" class="theme-form">

                @csrf

                <div class="mb-4">
                    <label class="form-label-title">Title</label>
                    <input type="text" name="title" value="{{ $item->title }}" class="form-control mb-3" required>
                </div>


                <div class="mb-4">
                    <label class="form-label-title">Name</label>
                    <input type="text" name="name" value="{{ $item->name }}" class="form-control mb-3" required>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Post</label>
                    <input type="text" name="post" value="{{ $item->post }}" class="form-control mb-3" required>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Email</label>
                    <input type="email" name="email" value="{{ $item->email }}" class="form-control mb-3" required>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Phone</label>
                    <input type="text" name="phone" value="{{ $item->phone }}" class="form-control mb-3" required>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Role</label>
                    <br>
                    <label>
                        <input type="radio" name="role" value="OPF" {{ $item->role == 'OPF' ? 'checked' : '' }}> OPF
                    </label>

                    <label class="ms-3">
                        <input type="radio" name="role" value="GLIDERS" {{ $item->role == 'GLIDERS' ? 'checked' : '' }}>
                        GLIDERS

                    </label>
                </div>



                <div class="mb-4">
                    <label class="form-label-title">Image</label>
                    <input type="file" name="image" id="pictureInput" class="form-control mt-3"
                        accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">
                    @if($item->image)
                        <img src="{{ asset('uploads/rti/' . $item->image) }}" id="imagePreview"
                            style="margin-top:10px;height:120px;border:1px solid #ddd;padding:4px;">
                    @endif
                </div>


                <div class="panel-footer">

                    <button class="btn btn-primary mt-3" id="submitBtn">

                        <span class="btnText">Update</span>

                        <span class="btnLoader d-none">

                            <i class="fa fa-spinner fa-spin"></i> Saving...

                        </span>

                    </button>
                </div>
            </form>

        </div>

    </div>

</div>