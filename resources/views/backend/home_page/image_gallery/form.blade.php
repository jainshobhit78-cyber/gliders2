<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backImageList">

        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" fill="black" />
        </svg>

        <span>Back</span>

    </a>

    <h5> {{ !empty($edit) ? 'Update Image' : 'Add New Image' }} </h5>

</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <form action="{{ url('admin/home/image_gallery/save') }}" method="POST" enctype="multipart/form-data"
                class="theme-form">
                @csrf

                <input type="hidden" name="id" value="{{ $edit->id ?? '' }}">

                <div class="mb-3">
                    <label>Upload Image</label>
                    <input type="file" name="image" id="imageInput" class="form-control">
                </div>

                {{-- Preview --}}
                <div class="mb-3">
                    <img id="previewImage" style="transition:0.3s; cursor:pointer;"
                        onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"
                        src="{{ !empty($edit) && $edit->image ? asset($edit->image) : '' }}" width="120"
                        style="border-radius:10px; {{ empty($edit) ? 'display:none;' : '' }}">
                </div>

                <button type="submit" id="submitBtn" class="btn btn-primary">
                    <span class="btnText">
                        {{ !empty($edit) ? 'Update' : 'Add' }}
                    </span>
                    <span class="btnLoader d-none">Loading...</span>
                </button>

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
<script>
    // Image Preview
    document.getElementById('imageInput').addEventListener('change', function (e) {

        let file = e.target.files[0];

        if (file) {
            let reader = new FileReader();

            reader.onload = function (e) {
                let preview = document.getElementById('previewImage');
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            reader.readAsDataURL(file);
        }
    });

    // Button Loader
    $(document).on('submit', '.theme-form', function () {

        $('#submitBtn').prop('disabled', true);

        $('.btnText').addClass('d-none');
        $('.btnLoader').removeClass('d-none');

    });
</script>