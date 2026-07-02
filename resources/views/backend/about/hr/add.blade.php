<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backHr">
        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" fill="black" />
        </svg>
        <span>Back</span>
    </a>

    <h5>Add Human Resource</h5>

</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">

            <form method="post" action="{{ url('admin/about/human-resources/add') }}" class="theme-form">
                @csrf

                <div class="mb-4">
                    <label class="form-label-title">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter Title">
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Description</label>
                    <textarea name="description" class="editor form-control" placeholder="Enter Description"></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">HR Vision</label>
                    <textarea name="vision" class="editor form-control" placeholder="Enter HR Vision"></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">HR Mission</label>
                    <textarea name="mission" class="editor form-control" placeholder="Enter HR Mission"></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Objectives</label>
                    <textarea name="objectives" class="editor form-control" placeholder="Enter Objectives"></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Strategy</label>
                    <textarea name="strategy" class="editor form-control" placeholder="Enter Strategy"></textarea>
                </div>

                <div class="panel-footer">

                    <button class="btn btn-primary" id="submitBtn">

                        <span class="btnText">
                            Add
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