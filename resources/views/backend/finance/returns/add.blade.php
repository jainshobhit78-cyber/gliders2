<div class="title-header d-flex align-items-center gap-3">
    <a href="javascript:void(0)" class="back-btn backReturn">
        <svg width="24" height="24" viewBox="0 0 24 24"><path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" /></svg>
        <span>Back</span>
    </a>
    <h5>Add Annual Return</h5>
</div>

<div class="container-fluid">
    <div class="card"><div class="card-body">
        <form method="post" action="{{ url('admin/finance/returns/add') }}" enctype="multipart/form-data" class="theme-form">
            @csrf
            <div class="mb-4">
                <label class="form-label-title">Financial Year</label>
                <input type="text" name="fiscal_year" class="form-control" placeholder="24-25" pattern="(?:20)?[0-9]{2}-[0-9]{2}" required>
            </div>
            <div class="mb-4">
                <label class="form-label-title">PDF</label>
                <input type="file" name="pdf" class="form-control" accept="application/pdf">
            </div>
            <div class="panel-footer"><button class="btn btn-primary">Add</button></div>
        </form>
    </div></div>
</div>
