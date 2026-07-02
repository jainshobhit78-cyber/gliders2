<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backKey">

        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" fill="black" />
        </svg>

        <span>Back</span>

    </a>

    <h5>Add Key Offerings</h5>

</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <form method="post" action="{{ url('admin/about/key_offerings/add') }}" class="theme-form"
                enctype="multipart/form-data">

                @csrf

                {{-- TITLE --}}
                <div class="mb-4">
                    <label class="form-label-title">Title</label>

                    <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                        placeholder="Enter Title">

                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- IMAGE --}}
                <div class="mb-4">
                    <label class="form-label-title">Image</label>

                    <input type="file" name="image" class="form-control" accept="image/*">
                    <br>
                    <img id="previewImage" src="" width="80" class="mb-2 d-none">
                    @error('image')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="form-label-title">Show on Home</label>

                    <select name="is_home" class="form-control">
                        <option value="0" {{ old('is_home') == '0' ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('is_home') == '1' ? 'selected' : '' }}>Yes</option>
                    </select>

                    @error('is_home')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>


                {{-- DESCRIPTION --}}
                <div class="mb-4">
                    <label class="form-label-title">Description</label>

                    <textarea name="description" class="editor form-control"
                        placeholder="Enter Description">{{ old('description') }}</textarea>

                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- IS HOME --}}

                {{-- BUTTON --}}
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary" id="submitBtn">

                        <span class="btnText">Add</span>

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

<script>
    document.querySelector('input[name="image"]').addEventListener('change', function (e) {
        let file = e.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                let img = document.getElementById('previewImage');
                img.src = e.target.result;
                img.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        }
    });
</script>