<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backCodes">
        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" fill="black" />
        </svg>
        <span>Back</span>
    </a>

    <h5>Edit Codes of Conduct</h5>

</div>


<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ url('admin/about/codes/update/' . $code->id) }}"
                enctype="multipart/form-data" class="theme-form">
                @csrf
                <!-- Title -->
                <div class="mb-4 row align-items-center">
                    <label class="form-label-title col-sm-2">
                        Title
                    </label>
                    <div class="col-sm-10">
                        <input type="text" name="title" value="{{ $code->title }}" class="form-control">
                    </div>
                </div>
                <!-- Description -->
                <div class="mb-4 row align-items-center">
                    <label class="form-label-title col-sm-2">
                        Description
                    </label>
                    <div class="col-sm-10">
                        <textarea name="description" class="editor form-control">
                        {!! $code->description !!}
                        </textarea>
                    </div>
                </div>
                <!-- Current PDF -->
                @if($code->pdf)
                    <div class="mb-4 row align-items-center">
                        <label class="form-label-title col-sm-2">
                            Current PDF
                        </label>
                        <div class="col-sm-10 d-flex align-items-center gap-3">

                            <a href="{{ asset('uploads/codes/' . $code->pdf) }}" target="_blank"
                                class="btn btn-sm btn-info">
                                View PDF
                            </a>
                            <div class="form-check">
                                <input type="checkbox" name="remove_pdf" value="1" class="form-check-input" id="removePdf">
                                <label for="removePdf" class="form-check-label text-danger">
                                    Remove PDF
                                </label>
                            </div>

                        </div>
                    </div>
                @endif
                <!-- Upload New PDF -->
                <div class="mb-4 row align-items-center">
                    <label class="form-label-title col-sm-2">
                        Upload New PDF
                    </label>
                    <div class="col-sm-10">
                        <input type="file" name="pdf" accept="application/pdf" class="form-control">
                    </div>

                </div>



                <!-- Submit -->
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