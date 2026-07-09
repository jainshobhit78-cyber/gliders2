<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backEoi">

        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" />
        </svg>

        <span>Back</span>

    </a>

    <h5>Edit EOI</h5>

</div>



<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <form method="post" action="{{ url('admin/finance/eoi/update/' . $item->id) }}" enctype="multipart/form-data"
                class="theme-form">

                @csrf



                <div class="mb-4">

                    <label class="form-label-title">

                        Title

                    </label>

                    <input type="text" name="title" value="{{$item->title}}" class="form-control">

                </div>



                <div class="mb-4">

                    <label class="form-label-title">

                        Description

                    </label>

                    <textarea name="description" class="editor form-control">

{{ $item->description }}

</textarea>

                </div>



                <div class="mb-4">

                    <label class="form-label-title">

                        PDF

                    </label>

                    @if($item->pdf)

                        <p>

                            <a href="{{asset('uploads/finance/' . $item->pdf)}}" target="_blank">

                                View Existing PDF

                            </a>

                        </p>

                    @endif


                    <input type="file" name="pdf" class="form-control" accept="application/pdf">

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
