<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backDirectory">
        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" fill="black" />
        </svg>
        <span>Back</span>
    </a>

    <h5>Edit Directory</h5>

</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <form method="post" action="{{ url('admin/about/directory/update/' . $directory->id) }}" class="theme-form"
                enctype="multipart/form-data">

                @csrf
                <!-- Roles -->
                <div class="mb-4">
                    <label class="form-label-title col-sm-2">
                        Units
                    </label>
                    <div class="col-sm-10">
                        <label class="me-4">
                            <input type="radio" name="role" value="Headquarters" {{ $directory->role == 'Headquarters' ? 'checked' : '' }}>
                            Headquarters
                        </label>
                        <label>
                            <input type="radio" name="role" value="OPF" {{ $directory->role == 'OPF' ? 'checked' : '' }}>
                            OPF
                        </label>
                    </div>

                </div>

                <div class="mb-4">
                    <label class="form-label-title">Serial Number</label>
                    <input type="text" name="sr_no" class="form-control" required value="{{ $directory->sr_no }}">
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Organization</label>
                    <input type="text" name="org" class="form-control" required value="{{ $directory->org }}">
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Name (S/Shri)</label>
                    <input type="text" name="name" class="form-control" value="{{ $directory->name }}">
                </div>


                <div class="mb-4">
                    <label class="form-label-title">Designation</label>
                    <input type="text" name="designation" class="form-control" value="{{ $directory->designation }}">
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Sub Designation</label>
                    <input type="text" name="sub_designation" class="form-control"
                        value="{{ $directory->sub_designation }}">
                </div>



                <!-- Mobile -->
                <div class="mb-4">
                    <label class="form-label-title">Mobile</label>

                    <div id="mobileWrapper">
                        @foreach($directory->mobile_no ?? [] as $mobile)
                            <div class="input-group mb-2">
                                <input type="text" name="mobiles[]" value="{{ $mobile }}" class="form-control mobile-input">
                                <button type="button" class="btn btn-danger removeMobile">Remove</button>
                            </div>
                        @endforeach

                        @if(empty($directory->mobile_no))
                            <div class="input-group mb-2">
                                <input type="text" name="mobiles[]" class="form-control mobile-input">
                            </div>
                        @endif
                    </div>
                </div>

                <button type="button" class="btn btn-theme mb-4" id="addMobile">
                    Add More Mobile
                </button>

                <div class="mb-4">
                    <label class="form-label-title">Telephone Number</label>
                    <input type="text" name="telephone_number" value="{{ $directory->telephone_number }}"
                        class="form-control">
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Fax</label>
                    <input type="text" name="fax" value="{{ $directory->fax }}" class="form-control">
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="form-label-title">E-Mail</label>

                    <div id="emailWrapper">
                        @foreach($directory->email ?? [] as $email)
                            <div class="input-group mb-2">
                                <input type="email" name="emails[]" value="{{ $email }}" class="form-control email-input">
                                <button type="button" class="btn btn-danger removeEmail">Remove</button>
                            </div>
                        @endforeach

                        @if(empty($directory->email))
                            <div class="input-group mb-2">
                                <input type="email" name="emails[]" class="form-control email-input">
                            </div>
                        @endif
                    </div>
                </div>

                <button type="button" class="btn btn-theme mb-4" id="addEmail">
                    Add More Email
                </button>



                <!-- Deals In -->
                <div class="mb-4">

                    <label class="form-label-title col-sm-2">
                        Deals In
                    </label>

                    <div class="col-sm-10">

                        <input type="text" name="deals_in" value="{{ $directory->deals_in }}" class="form-control">

                    </div>

                </div>

                <div class="mb-4">
                    <label class="form-label-title">Profile Photo</label>

                    <input type="file" name="profile_photo" id="profilePhotoInput" class="form-control"
                        accept="image/*">

                    <div class="mt-2">
                        <img id="previewImage"
                            src="{{ $directory->profile_photo ? asset('uploads/directory/' . $directory->profile_photo) : '' }}"
                            style="max-height:120px; {{ $directory->profile_photo ? '' : 'display:none;' }}">
                    </div>


                </div>

                <!-- Submit Button -->
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

    $("#addEmail").click(function () {

        let lastInput = $(".email-input").last();

        if (lastInput.length === 0 || lastInput.val().trim() !== "") {

            $("#emailWrapper").append(`
            <div class="input-group mb-2">
                <input type="email" name="emails[]" class="form-control email-input" placeholder="Email">
                <button type="button" class="btn btn-danger removeEmail">Remove</button>
            </div>
        `);

        } else {
            toastr.warning('Please fill the previous email first!');
        }
    });

    $(document).on("click", ".removeEmail", function () {

        if ($(".email-input").length === 1) {
            toastr.warning('At least one email is required!');
            return;
        }

        $(this).closest(".input-group").remove();
    });
    $(document).on("input", ".mobile-input", function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $("#addMobile").click(function () {

        let lastInput = $(".mobile-input").last();

        // If no input exists OR last is filled → allow add
        if (lastInput.length === 0 || lastInput.val().trim() !== "") {

            $("#mobileWrapper").append(`
            <div class="input-group mb-2">
                <input type="text" name="mobiles[]" class="form-control mobile-input" placeholder="Mobile">
                <button type="button" class="btn btn-danger removeMobile">Remove</button>
            </div>
        `);

        } else {
            toastr.warning('Please fill the previous mobile first!');
        }
    });

    $(document).on("click", ".removeMobile", function () {

        if ($(".mobile-input").length === 1) {
            toastr.warning('At least one mobile is required!');
            return;
        }

        $(this).closest(".input-group").remove();
    });


    $("#profilePhotoInput").on("change", function (e) {
        let reader = new FileReader();

        reader.onload = function (e) {
            $("#previewImage").attr("src", e.target.result).show();
        };

        reader.readAsDataURL(this.files[0]);
    });

    $("#removePhoto").click(function () {
        $("#profilePhotoInput").val('');
        $("#previewImage").hide().attr("src", '');
    });
</script>