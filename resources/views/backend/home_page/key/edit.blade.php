<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backKey">

        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" fill="black" />
        </svg>

        <span>Back</span>

    </a>

    <h5>Edit Vision</h5>

</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <form method="post" action="{{ url('admin/about/key_offerings/update/' . $offer->id) }}" class="theme-form"
                enctype="multipart/form-data">

                @csrf

                {{-- TITLE --}}
                <div class="mb-4">
                    <label class="form-label-title">Title</label>

                    <input type="text" name="title" class="form-control" value="{{ old('title', $offer->title) }}">

                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- IMAGE --}}
                <div class="mb-4">
                    <label class="form-label-title">Image</label>

                    <input type="file" name="image" class="form-control" accept="image/*" id="imageInput">

                    {{-- PREVIEW IMAGE --}}
                    <div class="mt-2">
                        <img id="previewImage"
                            src="{{ $offer->image ? asset('uploads/key_offerings/' . $offer->image) : '' }}" width="100"
                            style="object-fit:cover; {{ $offer->image ? '' : 'display:none;' }}">
                    </div>

                    @error('image')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Show on Home</label>

                    <select name="is_home" class="form-control">
                        <option value="0" {{ $offer->is_home == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $offer->is_home == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Link to Product Category</label>
                    <select name="category_id" class="form-control">
                        <option value="">-- None (No Link) --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $offer->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- DESCRIPTION --}}
                <div class="mb-4">
                    <label class="form-label-title">Description</label>

                    <textarea name="description" class="editor form-control">
                        {{ old('description', $offer->description) }}
                    </textarea>

                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>



                {{-- BUTTON --}}
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary">
                        Update
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
</script>