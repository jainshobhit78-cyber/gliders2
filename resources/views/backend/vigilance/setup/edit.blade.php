<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backSetup">
        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" fill="black" />
        </svg>
        <span>Back</span>
    </a>

    <h5>Edit Vigilance Setup</h5>

</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <form method="post" action="{{ url('admin/vigilance/setup/update/' . $setup->id) }}"
                enctype="multipart/form-data" class="theme-form">

                @csrf

                <div class="mb-4">

                    <label class="form-label-title">Description</label>

                    <textarea name="description" class="editor form-control">

                    {!! $setup->description !!}

                    </textarea>

                </div>





                <div class="mb-4">

                    <label class="form-label-title">Upload New Image</label>

                    <input type="file" name="image" id="pictureInput" class="form-control"
                        accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">

                    @if($setup->image)
                        <div class="mb-4">
                            <img src="{{ asset('uploads/vigilance/' . $setup->image) }}" id="imagePreview"
                                style="margin-top:10px;height:120px;border:1px solid #ddd;padding:4px;">
                        </div>

                    @endif

                </div>

                <div class="mb-4">

                    <label class="form-label-title">Upload New PDF</label>

                    <input type="file" name="pdf" accept="application/pdf" class="form-control">

                </div>
                @if($setup->pdf)
                    <div class="mb-4">
                        <a href="{{ asset('uploads/vigilance/' . $setup->pdf) }}" target="_blank">
                            View Current PDF
                        </a>
                    </div>
                @endif


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