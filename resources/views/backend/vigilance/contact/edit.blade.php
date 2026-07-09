<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backContact">

        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" />
        </svg>

        <span>Back</span>

    </a>

    <h5>Edit Contact</h5>

</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <form method="post" action="{{ url('admin/vigilance/contact/update/' . $contact->id) }}"
                enctype="multipart/form-data" class="theme-form">

                @csrf


                <div class="mb-4">
                    <label class="form-label-title">Title</label>

                    <input type="text" name="title" value="{{ $contact->title }}" class="form-control" required>
                </div>


                <div class="mb-4">
                    <label class="form-label-title">Sub Title</label>

                    <input type="text" name="sub_title" value="{{ $contact->sub_title }}" class="form-control" required>
                </div>


                <div class="mb-4">
                    <label class="form-label-title">Name</label>

                    <input type="text" name="name" value="{{ $contact->name }}" class="form-control" required>
                </div>


                <div class="mb-3">
                    <label class="form-label-title">Emails</label>

                    <div id="emailWrapper">

                        @foreach($contact->emails as $email)

                            <input type="email" name="emails[]" value="{{ $email }}" class="form-control mb-2" required>

                        @endforeach

                    </div>

                </div>


                <button type="button" class="btn btn-theme mb-4" id="addEmail">

                    Add More Email

                </button>


                <div class="mb-4">

                    <label class="form-label-title">Upload New Photo</label>

                    <input type="file" name="photo" id="pictureInput" class="form-control"
                        accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">

                    @if($contact->photo)

                        <div class="mb-3">

                            <img src="{{ asset('uploads/vigilance/' . $contact->photo) }}" id="imagePreview"
                                style="margin-top:10px;height:120px;border:1px solid #ddd;padding:4px;">

                        </div>

                    @endif


                </div>



                <div class="mb-4">

                    <label class="form-label-title">Address</label>

                    <textarea name="address" class="editor form-control">

{{ $contact->address }}

</textarea>

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

    $("#addEmail").click(function () {

        $("#emailWrapper").append(
            '<input type="email" name="emails[]" class="form-control mb-2" placeholder="Email">'
        )

    })


    $(document).on('submit', '.theme-form', function () {

        $('#submitBtn').prop('disabled', true)

        $('.btnText').addClass('d-none')
        $('.btnLoader').removeClass('d-none')

    })

</script>
