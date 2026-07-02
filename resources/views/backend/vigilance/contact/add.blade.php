<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backContact">
        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" fill="black" />
        </svg>
        <span>Back</span>
    </a>

    <h5>Add Contact</h5>

</div>

<div class="container-fluid">

    <div class="card">

        <div class="card-body">
            <form method="post" action="{{ url('admin/vigilance/contact/add') }}" enctype="multipart/form-data"
                class="theme-form">

                @csrf


                <div class="mb-4">
                    <label class="form-label-title">Title</label>
                    <input type="text" name="title" placeholder="Title" class="form-control mb-3" required>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Sub Title</label>
                    <input type="text" name="sub_title" placeholder="Sub Title" class="form-control mb-3" required>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Name</label>
                    <input type="text" name="name" placeholder="Name" class="form-control mb-3" required>
                </div>

                <div class="mb-2">
                    <label class="form-label-title">Email</label>
                    <div id="emailWrapper">
                        <input type="email" name="emails[]" class="form-control mb-2" placeholder="Email" required>
                    </div>
                </div>

                <button type="button" class="btn btn-theme mb-4" id="addEmail">
                    Add More Email
                </button>


                <div class="mb-4">
                    <label class="form-label-title">Photo</label>
                    <input type="file" name="photo" id="pictureInput" class="form-control mb-3"
                        accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">
                    <img id="imagePreview" style="display:none;width:120px;border-radius:6px;margin-top:10px;">
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Address</label>
                    <textarea name="address" class="editor form-control mb-3" placeholder="Address"></textarea>
                </div>


                <div class="panel-footer">
                    <button class="btn btn-primary" id="submitBtn">

                        <span class="btnText">Add</span>

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
    $("#addEmail").click(function () {

        $("#emailWrapper").append(
            '<input type="email" name="emails[]" class="form-control mb-2" placeholder="Email">'
        );

    });
</script>

<script>
    $(document).on('submit', '.theme-form', function () {

        $('#submitBtn').prop('disabled', true)

        $('.btnText').addClass('d-none')
        $('.btnLoader').removeClass('d-none')

    })
</script>