<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backSexual">
        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" fill="black" />
        </svg>
        <span>Back</span>
    </a>

    <h5>Add Sexual Harassment Info</h5>

</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <form method="post" action="{{ url('admin/vigilance/harassment/add') }}"
                enctype="multipart/form-data" class="theme-form">

                @csrf


                <div class="mb-4">

                    <label>Info Text</label>

                    <textarea name="info_text" class="editor form-control"></textarea>

                </div>


                <div class="mb-4">

                    <label>Image</label>

                    <input type="file" name="image" id="pictureInput" class="form-control" accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">

                    <img id="imagePreview" style="display:none;width:120px;margin-top:10px;border-radius:6px;">

                </div>


                <div class="mb-4">

                    <label>PDF</label>

                    <input type="file" name="pdf" accept="application/pdf" class="form-control">

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