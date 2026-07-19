<div class="title-header d-flex align-items-center gap-3">
    <a href="javascript:void(0)" class="back-btn backSocialList">
        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" fill="black" />
        </svg>
        <span>Back</span>
    </a>
    <h5> {{ !empty($edit) ? 'Update Social Post' : 'Add New Social Post' }} </h5>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">

            <form action="{{ url('admin/home/social_posts/save') }}" method="POST" enctype="multipart/form-data" class="theme-form">
                @csrf
                <input type="hidden" name="id" value="{{ $edit->id ?? '' }}">

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Platform</label>
                        <select name="platform" class="form-control" required>
                            @foreach(['facebook' => 'Facebook', 'linkedin' => 'LinkedIn', 'instagram' => 'Instagram'] as $val => $lbl)
                                <option value="{{ $val }}" {{ (isset($edit) && $edit->platform === $val) ? 'selected' : '' }}>{{ $lbl }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Post Date</label>
                        <input type="date" name="post_date" class="form-control" value="{{ isset($edit) && $edit->post_date ? \Carbon\Carbon::parse($edit->post_date)->format('Y-m-d') : '' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="Published" {{ (isset($edit) && $edit->status === 'Published') ? 'selected' : '' }}>Published</option>
                            <option value="Draft" {{ (isset($edit) && $edit->status === 'Draft') ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Post Content</label>
                    <textarea name="content" class="form-control" rows="3" placeholder="What did you post?" required>{{ $edit->content ?? '' }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label>Likes</label>
                        <input type="number" name="likes" class="form-control" min="0" value="{{ $edit->likes ?? 0 }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Comments</label>
                        <input type="number" name="comments" class="form-control" min="0" value="{{ $edit->comments ?? 0 }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Shares</label>
                        <input type="number" name="shares" class="form-control" min="0" value="{{ $edit->shares ?? 0 }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ $edit->sort_order ?? 0 }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Post Link (opens when clicked)</label>
                    <input type="text" name="link" class="form-control" placeholder="https://facebook.com/your-post" value="{{ $edit->link ?? '' }}">
                </div>

                <div class="mb-3">
                    <label>Post Image (optional)</label>
                    <input type="file" name="image" id="imageInput" class="form-control">
                </div>

                <div class="mb-3">
                    <img id="previewImage" src="{{ !empty($edit) && $edit->image ? asset('uploads/social/' . $edit->image) : '' }}"
                        width="120" style="border-radius:10px; {{ empty($edit) || empty($edit->image) ? 'display:none;' : '' }}">
                </div>

                <button type="submit" id="submitBtn" class="btn btn-primary">
                    <span class="btnText">{{ !empty($edit) ? 'Update' : 'Add' }}</span>
                    <span class="btnLoader d-none">Loading...</span>
                </button>
            </form>
        </div>
    </div>
</div>

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

    $(document).on('submit', '.theme-form', function () {
        $('#submitBtn').prop('disabled', true);
        $('.btnText').addClass('d-none');
        $('.btnLoader').removeClass('d-none');
    });
</script>
