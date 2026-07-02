<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backSocial">
        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" fill="black" />
        </svg>
        <span>Back</span>
    </a>

    <h5>Edit Social Responsibility Member</h5>

</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <form method="post" action="{{ url('admin/about/social-responsibility/update/' . $social->id) }}"
                enctype="multipart/form-data" class="theme-form">

                @csrf

                <div class="mb-4">
                    <label class="form-label-title">Heading</label>
                    <input type="text" name="heading" class="form-control" value="{{ $social->heading }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Sub Heading</label>
                    <input type="text" name="sub_heading" class="form-control" value="{{ $social->sub_heading }}"
                        required>
                </div>

                <div class="mb-4">
                    <label class="form-label-title col-sm-2">Description</label>
                    <textarea name="description" id="bioEditor" class="editor form-control"
                        placeholder="Enter Description">{{ $social->description }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Name</label>
                    <input type="text" name="name" value="{{ $social->name }}" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Designation</label>
                    <input type="text" name="title" value="{{ $social->title }}" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Role</label>
                    <input type="text" name="sub_title" value="{{ $social->sub_title }}" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Phone</label>
                    <input type="text" name="phone" value="{{ $social->phone }}" class="form-control" required>
                </div>


                <div class="mb-4">

                    <label class="form-label-title">Photo</label>

                    <input type="file" name="photo" id="pictureInput" class="form-control"
                        accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">

                    @if($social->photo)
                        <img src="{{ asset('uploads/social/' . $social->photo) }}" id="imagePreview"
                            style="margin-top:10px;height:120px;border:1px solid #ddd;padding:4px;">
                    @endif


                </div>


                <div class="panel-footer">

                    <button class="btn btn-primary" id="submitBtn">

                        <span class="btnText">
                            Update
                        </span>

                        <span class="btnLoader d-none">
                            <i class="fa fa-spinner fa-spin"></i> Saving...
                        </span>

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

    $(document).on('submit', '.theme-form', function () {

        $('#submitBtn').prop('disabled', true)

        $('.btnText').addClass('d-none')
        $('.btnLoader').removeClass('d-none')

    })

</script>