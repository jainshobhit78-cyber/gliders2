<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backReport">

        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" />
        </svg>

        <span>Back</span>

    </a>

    <h5>Edit Annual Report</h5>

</div>



<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <form method="post" action="{{ url('admin/finance/reports/update/' . $item->id) }}"
                enctype="multipart/form-data" class="theme-form">

                @csrf



                <div class="mb-4">

                    <label class="form-label-title">
                        Heading
                    </label>

                    <input type="text" name="heading" value="{{ $item->heading }}" class="form-control">

                </div>



                <div class="mb-4">

                    <label class="form-label-title">
                        Description
                    </label>

                    <textarea name="description" class="editor form-control">

{{ $item->description }}

</textarea>

                </div>



                @if($item->files)

                    <div class="mb-4">

                        <label class="form-label-title">

                            Existing PDFs

                        </label>


                        @foreach($item->files as $file)

                            <div class="mb-2">

                                <a href="{{ asset('uploads/finance/' . $file->pdf) }}" target="_blank">

                                    View PDF

                                </a>


                                <a href="{{ url('admin/finance/reports/file/delete/' . $file->id) }}"
                                    class="btn btn-sm btn-danger ms-2">

                                    Delete

                                </a>

                            </div>

                        @endforeach

                    </div>

                @endif



                <div class="mb-4">

                    <label class="form-label-title">

                        Add More PDF

                    </label>


                    <div id="pdfWrapper">

                        <input type="file" name="pdfs[]" class="form-control" accept="application/pdf">

                    </div>


                    <button type="button" id="addPdf" class="btn btn-sm btn-primary mt-2">

                        Add More PDF

                    </button>

                </div>



                <div class="panel-footer">

                    <button class="btn btn-primary" id="submitBtn">

                        <span class="btnText">

                            Update

                        </span>

                        <span class="btnLoader d-none">

                            <i class="fa fa-spinner fa-spin"></i>
                            Saving...

                        </span>

                    </button>

                </div>


            </form>

        </div>

    </div>

</div>



<script>

    $(document).on('submit', '.theme-form', function () {

        if (typeof tinymce !== "undefined") {
            tinymce.triggerSave();
        }

        $('#submitBtn').prop('disabled', true)

        $('.btnText').addClass('d-none')
        $('.btnLoader').removeClass('d-none')

    })



    $("#addPdf").click(function () {

        $("#pdfWrapper").append(
            '<input type="file" name="pdfs[]" class="form-control accept="application/pdf" mt-2">'
        )

    })

</script>
