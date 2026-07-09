<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backBulletin">

        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" />
        </svg>

        <span>Back</span>

    </a>

    <h5>Edit Bulletin</h5>

</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <form method="post" action="{{ url('admin/vigilance/bulletin/update/' . $item->id) }}"
                enctype="multipart/form-data" class="theme-form">

                @csrf


                <div class="mb-4">

                    <label>Info Text</label>

                    <textarea name="info_text" class="editor form-control">

{{ $item->info_text }}

</textarea>

                </div>

                <div class="mb-4">

                    <label>Upload New PDF</label>

                    <input type="file" name="pdf" accept="application/pdf" class="form-control">

                </div>

                @if($item->pdf)

                    <div class="mb-3">

                        <a href="{{ asset('uploads/vigilance/' . $item->pdf) }}" target="_blank">

                            View Current PDF

                        </a>

                    </div>

                @endif

                <div class="panel-footer">

                    <button class="btn btn-primary" id="submitBtn">

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


<script>

    $(document).on('submit', '.theme-form', function () {

        $('#submitBtn').prop('disabled', true)

        $('.btnText').addClass('d-none')
        $('.btnLoader').removeClass('d-none')

    })

</script>
