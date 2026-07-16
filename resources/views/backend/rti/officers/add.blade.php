<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backOfficer">

        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" />
        </svg>

        <span>Back</span>

    </a>

    <h5>Add RTI Officer</h5>

</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <form method="post" action="{{ url('admin/rti/officers/add') }}" enctype="multipart/form-data"
                class="theme-form">

                @csrf


                <div class="mb-4">

                    <label class="form-label-title">Title</label>

                    <input type="text" name="title" class="form-control" required>

                </div>


                <div class="mb-4">

                    <label class="form-label-title">Name</label>

                    <input type="text" name="name" class="form-control" required>

                </div>


                <div class="mb-4">

                    <label class="form-label-title">Post</label>

                    <input type="text" name="post" class="form-control" required>

                </div>


                <div class="mb-4">

                    <label class="form-label-title">Email</label>

                    <input type="email" name="email" class="form-control" required>

                </div>


                <div class="mb-4">

                    <label class="form-label-title">Phone</label>

                    <input type="text" name="phone" class="form-control" required>

                </div>


                <div class="mb-4">

                    <label class="form-label-title">Organisation</label>

                    <br>

                    <label class="form-label-title">

                        <input type="radio" name="role" value="OPF" checked> OPF

                    </label>

                    <label class="ms-3 form-label-title">

                        <input type="radio" name="role" value="GLIDERS"> GLIDERS

                    </label>

                </div>


                <div class="mb-4">

                    <label class="form-label-title">Image</label>

                    <input type="file" name="image" id="pictureInput" class="form-control" accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">

                    <img id="imagePreview" style="display:none;width:120px;margin-top:10px;border-radius:6px;">

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

    $(document).on('submit', '.theme-form', function () {

        $('#submitBtn').prop('disabled', true)

        $('.btnText').addClass('d-none')
        $('.btnLoader').removeClass('d-none')

    })

</script>
