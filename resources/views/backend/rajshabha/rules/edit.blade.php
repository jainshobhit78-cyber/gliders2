<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backRules">

        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" />
        </svg>

        <span>Back</span>

    </a>

    <h5>Edit Rule</h5>

</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <form method="post" action="{{ url('admin/rajshabha/rules/update/' . $item->id) }}"
                enctype="multipart/form-data" class="theme-form">

                @csrf

                <div class="mb-4">

                    <label class="form-label-title">
                        Heading
                    </label>

                    <input type="text" name="heading" value="{{$item->heading}}" class="form-control" required>

                </div>


                <div class="mb-4">

                    <label class="form-label-title">
                        PDF
                    </label>

                    <input type="file" name="pdf" class="form-control" accept="application/pdf">

                    @if($item->pdf)

                        <br>

                        <a href="{{asset('uploads/rajshabha/' . $item->pdf)}}" target="_blank">

                            View Current PDF

                        </a>

                    @endif

                </div>


                <div class="panel-footer">

                    <button class="btn btn-primary" id="submitBtn">

                        <span class="btnText">Update</span>

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

        $('#submitBtn').prop('disabled', true)

        $('.btnText').addClass('d-none')

        $('.btnLoader').removeClass('d-none')

    })

</script>