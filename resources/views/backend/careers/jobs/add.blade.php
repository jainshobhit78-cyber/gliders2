<div class="title-header d-flex align-items-center gap-3">
    <a href="javascript:void(0)" class="back-btn backCareer">
        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" />
        </svg>
        <span>Back</span>
    </a>
    <h5>Add {{ ucfirst($type) }} Entry</h5>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ url('admin/careers/jobs/add') }}" enctype="multipart/form-data" class="theme-form">
                @csrf

                <input type="hidden" name="type" value="{{ $type }}">

                <div class="mb-4">
                    <label class="form-label-title">Job/Internship Title</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Graduate Engineer Trainee" required>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Job Info / Description</label>
                    <textarea name="job_info" class="editor form-control" placeholder="Enter key responsibilities, overview etc."></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Eligibility Criteria</label>
                    <textarea name="eligibility" class="editor form-control" placeholder="e.g. B.Tech in Mechanical Engineering with 60% minimum"></textarea>
                </div>

                <div class="mb-4 col-md-6 col-12">
                    <label class="form-label-title">Last Date to Apply</label>
                    <input type="date" name="last_date" class="form-control">
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Upload Job/Internship Details PDF</label>
                    <input type="file" name="pdf" class="form-control" accept="application/pdf">
                    <small class="text-muted">Upload advertisement or detailed notification PDF (Max 10MB)</small>
                </div>

                <div class="panel-footer">
                    <button class="btn btn-primary" id="submitBtn">
                        <span class="btnText">Save</span>
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
        $('#submitBtn').prop('disabled', true);
        $('.btnText').addClass('d-none');
        $('.btnLoader').removeClass('d-none');
    });
</script>
