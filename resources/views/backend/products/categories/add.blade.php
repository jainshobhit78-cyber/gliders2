@extends('backend.layout.app')

@section('content')

    <div class="container-fluid">

        <div class="title-header d-flex align-items-center gap-3">

            <a href="{{ url('admin/category/list') }}" class="back-btn">

                <svg width="24" height="24" viewBox="0 0 24 24">
                    <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" />
                </svg>

                <span>Back</span>

            </a>

            <h5>Add New Category</h5>

        </div>

        <form method="POST" action="{{ url('admin/category/add') }}" enctype="multipart/form-data" class="theme-form">

            @csrf

            <div class="mb-3">

                <label class="form-label-title">Category Name</label>

                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>

            </div>

            <div class="mb-3">

                <label class="form-label-title">Category Title (Detailed Heading)</label>

                <input type="text" name="category_title" value="{{ old('category_title') }}" class="form-control">

            </div>

            <div class="mb-3">

                <label class="form-label-title">Category Subtitle (Detailed Text)</label>

                <textarea name="category_subtitle" class="form-control" rows="3">{{ old('category_subtitle') }}</textarea>

            </div>

            <div class="mb-3">

                <label class="form-label-title">Background Wallpaper</label>

                <input type="file" name="wallpaper_image" id="wallpaperInput" class="form-control" accept="image/jpeg,image/png,image/jpg,image/webp">

                <div class="mt-2">

                    <img id="wallpaperPreview" src="" style="max-width:200px; display:none; border-radius:6px;">

                </div>

            </div>

            <div class="mb-3">

                <label class="form-label-title">Display Order</label>

                <input type="number" name="display_order" value="{{ old('display_order') }}" class="form-control" step="1">

            </div>

            <div class="mb-3">

                <label class="form-label-title">Image</label>

                <input type="file" name="image" id="imageInput" class="form-control" accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">

                <div class="mt-2">

                    <img id="imagePreview" src="" style="max-width:120px; display:none; border-radius:6px;">

                </div>

            </div>

            <div class="mb-3">

                <label class="form-label-title">Status</label>

                <select name="status" class="form-control">

                    <option value="active" @if(old('status', 'active') == 'active') selected @endif>Active</option>
                    <option value="inactive" @if(old('status') == 'inactive') selected @endif>Inactive</option>

                </select>

            </div>

            <div class="panel-footer">

                <button class="btn btn-primary" id="submitBtn">

                    <span class="btnText">

                        Add Category

                    </span>

                    <span class="btnLoader d-none">

                        <i class="fa fa-spinner fa-spin"></i>
                        Saving...

                    </span>

                </button>

            </div>

        </form>

    </div>

@endsection

@section('script')
    <script>

        $(document).ready(function () {

            $('.theme-form').on('submit', function () {

                if (typeof tinymce !== "undefined") {
                    tinymce.triggerSave();
                }

                $('#submitBtn').prop('disabled', true);

                $('.btnText').addClass('d-none');
                $('.btnLoader').removeClass('d-none');

            });


            </div>

            <div class="panel-footer">

                <button class="btn btn-primary" id="submitBtn">

                    <span class="btnText">

                        Add Category

                    </span>

                    <span class="btnLoader d-none">

                        <i class="fa fa-spinner fa-spin"></i>
                        Saving...

                    </span>

                </button>

            </div>

        </form>

    </div>

@endsection

@section('script')
    <script>

        $(document).ready(function () {

            $('.theme-form').on('submit', function () {

                if (typeof tinymce !== "undefined") {
                    tinymce.triggerSave();
                }

                $('#submitBtn').prop('disabled', true);

                $('.btnText').addClass('d-none');
                $('.btnLoader').removeClass('d-none');

            });

        });

    </script>

    <script>

        $(document).ready(function () {

            $('#imageInput').change(function () {

                let reader = new FileReader();

                reader.onload = function (e) {

                    $('#imagePreview')
                        .attr('src', e.target.result)
                        .show();

                }

                reader.readAsDataURL(this.files[0]);

            });

            $('#wallpaperInput').change(function () {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#wallpaperPreview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(this.files[0]);
            });

        });

    </script>
@endsection
