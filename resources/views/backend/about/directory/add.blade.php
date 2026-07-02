<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backDirectory">

        <svg width="24" height="24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" />
        </svg>

        <span>Back</span>

    </a>

    <h5>Add Directory</h5>

</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <form method="post" action="{{ url('admin/about/directory/add') }}" class="theme-form"
                enctype="multipart/form-data">

                @csrf
                <div class="mb-4">
                    <label class="form-label-title">Units</label>
                    <div>
                        <label>
                            <input type="radio" name="role" value="Headquarters" checked> Headquarters
                        </label>

                        <label class="ms-3">
                            <input type="radio" name="role" value="OPF"> OPF
                        </label>
                    </div>

                </div>

                <div class="mb-4">
                    <label class="form-label-title">Serial Number</label>
                    <input type="text" name="sr_no" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Organization</label>
                    <input type="text" name="org" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Name (S/Shri)</label>
                    <input type="text" name="name" class="form-control">
                </div>


                <div class="mb-4">
                    <label class="form-label-title">Designation</label>
                    <input type="text" name="designation" class="form-control">
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Sub Designation</label>
                    <input type="text" name="sub_designation" class="form-control">
                </div>

                <div class="mb-2">
                    <label class="form-label-title">Mobile</label>

                    <div id="mobileWrapper">
                        <div class="input-group mb-2">
                            <input type="text" name="mobiles[]" class="form-control mobile-input" placeholder="Mobile"
                                pattern="[0-9]{10}" maxlength="10" required>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-theme mb-4" id="addMobile">
                    Add More Mobile
                </button>

                <div class="mb-4">
                    <label class="form-label-title">Telephone Number</label>
                    <input type="text" name="telephone_number" class="form-control">
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Fax</label>
                    <input type="text" name="fax" class="form-control">
                </div>

                <div class="mb-2">
                    <label class="form-label-title">Email</label>

                    <div id="emailWrapper">
                        <div class="input-group mb-2">
                            <input type="email" name="emails[]" class="form-control email-input" placeholder="Email"
                                required>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-theme mb-4" id="addEmail">
                    Add More Email
                </button>

                <div class="mb-4">
                    <label class="form-label-title">Deals In</label>
                    <input type="text" name="deals_in" class="form-control">
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Profile Photo</label>

                    <input type="file" name="profile_photo" id="profilePhotoInput" class="form-control" accept="image/*"
                        required>

                    <div class="mt-2">
                        <img id="previewImage" src="" style="max-height:120px; display:none;">
                    </div>

                    <button type="button" class="btn btn-danger mt-2 d-none" id="removePhoto">
                        Remove
                    </button>
                </div>

                <div class="panel-footer">

                    <button class="btn btn-primary" id="submitBtn">

                        <span class="btnText">
                            Add
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

    $("#addEmail").click(function () {

        let lastEmail = $(".email-input").last().val();

        // ❌ Prevent adding if last field is empty
        if (lastEmail.trim() === "") {
            toastr.warning('Please fill the previous email first!');
            return;
        }

        $("#emailWrapper").append(`
        <div class="input-group mb-2">
            <input type="email" name="emails[]" class="form-control email-input" placeholder="Email">
            <button type="button" class="btn btn-danger removeEmail">Remove</button>
        </div>
    `);
    });


    $(document).on("click", ".removeEmail", function () {
        $(this).closest(".input-group").remove();
    });
    $(document).on("input", ".mobile-input", function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $("#addMobile").click(function () {

        let lastMobile = $(".mobile-input").last().val();

        if (lastMobile.trim() === "") {
            toastr.warning('Please fill the previous mobile first!');
            return;
        }

        $("#mobileWrapper").append(`
        <div class="input-group mb-2">
            <input type="text" name="mobiles[]" class="form-control mobile-input" placeholder="Mobile">
            <button type="button" class="btn btn-danger removeMobile">Remove</button>
        </div>
    `);
    });

    $(document).on("click", ".removeMobile", function () {
        $(this).closest(".input-group").remove();
    });

    $("#profilePhotoInput").on("change", function (e) {
        let reader = new FileReader();

        reader.onload = function (e) {
            $("#previewImage").attr("src", e.target.result).show();
            $("#removePhoto").removeClass("d-none");
        };

        reader.readAsDataURL(this.files[0]);
    });

    $("#removePhoto").click(function () {
        $("#profilePhotoInput").val('');
        $("#previewImage").hide().attr("src", '');
    });
</script>