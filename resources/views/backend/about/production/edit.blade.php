<style>
    .milestone-item {
        border: 1px solid #ddd;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 10px;
    }

    .image-preview-box {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .preview-item {
        position: relative;
        width: 90px;
        height: 90px;
    }

    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }

    .remove-preview {
        position: absolute;
        top: -8px;
        right: -8px;
        background: red;
        color: #fff;
        border: none;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        cursor: pointer;
    }
</style>

<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backProduction d-flex align-items-center">
        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" fill="black" />
        </svg>
        <span>Back</span>
    </a>

    <h5>Edit Production Unit</h5>

</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <form class="theme-form theme-form-2 mega-form" method="post"
                action="{{ url('admin/about/production-unit/update/' . $unit->id) }}" enctype="multipart/form-data">

                @csrf


                <div class="row">

                    {{-- Profile --}}
                    <div class="mb-4 row align-items-center">

                        <label class="form-label-title col-sm-2">
                            Name Of Unit
                        </label>

                        <div class="col-sm-10">
                            <input type="text" name="profile" class="form-control" value="{{ $unit->profile }}"
                                placeholder="Enter Name Of Unit">
                        </div>

                    </div>


                    {{-- Heading --}}
                    <div class="mb-4 row align-items-center">

                        <label class="form-label-title col-sm-2">
                            Heading
                        </label>

                        <div class="col-sm-10">
                            <input type="text" name="heading" class="form-control" value="{{ $unit->heading }}"
                                placeholder="Enter Heading">
                        </div>

                    </div>


                    {{-- Sub Heading --}}
                    <div class="mb-4 row align-items-center">

                        <label class="form-label-title col-sm-2">
                            Sub Heading
                        </label>

                        <div class="col-sm-10">
                            <input type="text" name="sub_heading" class="form-control" value="{{ $unit->sub_heading }}"
                                placeholder="Enter Sub Heading">
                        </div>

                    </div>


                    {{-- BIO --}}
                    <div class="mb-3 row align-items-center">

                        <label class="form-label-title col-sm-2">
                            Bio
                        </label>

                        <div class="col-sm-10">

                            <textarea name="bio" class="editor form-control"
                                placeholder="Enter Bio">{{ $unit->bio }}</textarea>

                        </div>

                    </div>


                    <div class="milestone-section mt-4">
                        <h4 class="about-label mb-3">Milestones</h4>
                        <div id="milestone-wrapper">

                            @foreach($unit->milestones as $index => $milestone)

                                <div class="milestone-item">

                                    <input type="hidden" name="milestones[{{ $index }}][id]" value="{{ $milestone->id }}">

                                    <div class="row">

                                        <div class="col-md-6 mb-3">
                                            <label>Date</label>
                                            <input type="date" name="milestones[{{ $index }}][milestone_date]"
                                                value="{{ $milestone->milestone_date }}" class="form-control">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Name</label>
                                            <input type="text" name="milestones[{{ $index }}][milestone_name]"
                                                value="{{ $milestone->milestone_name }}" class="form-control">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label>Description</label>
                                            <textarea name="milestones[{{ $index }}][bio]"
                                                class="form-control">{{ $milestone->bio }}</textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Images</label>

                                            <input type="file" multiple name="milestones[{{ $index }}][images][]"
                                                class="form-control" onchange="previewImages(this)"
                                                accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">

                                            <div class="image-preview-box">

                                                @foreach($milestone->images as $img)
                                                    <div class="preview-item existing-image">
                                                        <img src="{{ asset('uploads/production/images/' . $img->image) }}">
                                                        <button type="button" class="remove-preview"
                                                            onclick="removeOldImage(this, {{ $img->id }})">×</button>
                                                    </div>
                                                @endforeach

                                            </div>

                                            <input type="hidden" name="milestones[{{ $index }}][removed_images]"
                                                class="removed-images">

                                        </div>

                                        <div class="col-md-6">
                                            <label>Video</label>
                                            <input type="file" name="milestones[{{ $index }}][video]" accept="video/*"
                                                class="form-control">

                                            @if($milestone->video)
                                                <video width="150" controls class="mt-2">
                                                    <source src="{{ asset('uploads/production/videos/' . $milestone->video) }}">
                                                </video>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                            @endforeach

                        </div>

                        <button type="button" onclick="addMilestone()" class="btn btn-success w-100 mb-3">
                            + Add More Milestone
                        </button>
                    </div>


                    <div class="panel-footer">

                        <button class="btn btn-primary" id="submitBtn">

                            <span class="btnText">
                                Update
                            </span>

                            <span class="btnLoader d-none">
                                <i class="fa fa-spinner fa-spin"></i> Saving...
                            </span>

                        </button>

                    </div>
                </div>

                <input type="hidden" name="removed_images" id="removedImages">
            </form>

        </div>

    </div>

</div>



<script>
    let milestoneFiles = {};
    let count = {{ $unit->milestones->count() }};

    function previewImages(input) {
        const wrapper = input.closest('.milestone-item');
        const previewBox = wrapper.querySelector('.image-preview-box');
        const inputName = input.name;

        if (!milestoneFiles[inputName]) {
            milestoneFiles[inputName] = [];
        }

        Array.from(input.files).forEach(file => {
            milestoneFiles[inputName].push(file);
        });

        renderPreview(input, previewBox, inputName);
    }

    function renderPreview(input, previewBox, inputName) {
        const existingImages = previewBox.querySelectorAll('.existing-image');

        previewBox.querySelectorAll('.new-image').forEach(el => el.remove());

        const dt = new DataTransfer();

        milestoneFiles[inputName].forEach((file, index) => {
            dt.items.add(file);

            const reader = new FileReader();

            reader.onload = function (e) {
                const div = document.createElement('div');
                div.className = 'preview-item new-image';

                div.innerHTML = `
                <img src="${e.target.result}">
                <button type="button"
                    class="remove-preview"
                    onclick="removeSelectedImage('${inputName}', ${index}, this)">
                    ×
                </button>
            `;

                previewBox.appendChild(div);
            };

            reader.readAsDataURL(file);
        });

        input.files = dt.files;
    }

    function removeSelectedImage(inputName, index, btn) {
        const wrapper = btn.closest('.milestone-item');
        const input = wrapper.querySelector('input[type="file"][multiple]');
        const previewBox = wrapper.querySelector('.image-preview-box');

        milestoneFiles[inputName].splice(index, 1);

        renderPreview(input, previewBox, inputName);
    }

    function removeOldImage(btn, imageId) {
        const wrapper = btn.closest('.milestone-item');
        const hiddenInput = wrapper.querySelector('.removed-images');

        let oldIds = hiddenInput.value ? hiddenInput.value.split(',') : [];

        oldIds.push(imageId);

        hiddenInput.value = oldIds.join(',');

        btn.parentElement.remove();
    }

    function addMilestone() {
        let html = `
        <div class="milestone-item">
            <div class="row">
                <div class="col-md-6 mb-3">
                     <label class="milestone-label">Milestone Date</label>
                    <input type="date"
                        name="milestones[${count}][milestone_date]"
                        class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="milestone-label">Milestone Name</label>
                    <input type="text"
                        name="milestones[${count}][milestone_name]"
                        class="form-control">
                </div>

                <div class="col-md-12 mb-3">
                    <label class="milestone-label">Description</label>
                    <textarea
                        name="milestones[${count}][bio]"
                        class="form-control"></textarea>
                </div>

                <div class="col-md-6">
                     <label class="milestone-label">Images</label>
                    <input type="file"
                        multiple
                        name="milestones[${count}][images][]"
                        class="form-control"
                        onchange="previewImages(this)">
                    <div class="image-preview-box"></div>
                    <input type="hidden"
                        name="milestones[${count}][removed_images]"
                        class="removed-images" accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">
                </div>

                <div class="col-md-6">
                     <label class="milestone-label">Video</label>
                    <input type="file"
                        name="milestones[${count}][video]"
                        class="form-control" accept="video/*">
                </div>

                <div class="col-md-12">
                <button type="button"
                    onclick="this.closest('.milestone-item').remove()"
                    class="btn btn-danger">
                    Remove
                </button>
            </div>
            </div>
        </div>
    `;

        document.getElementById('milestone-wrapper')
            .insertAdjacentHTML('beforeend', html);

        count++;
    }
</script>


<script>

    $(document).on('submit', '.theme-form', function () {

        $('#submitBtn').prop('disabled', true)

        $('.btnText').addClass('d-none')
        $('.btnLoader').removeClass('d-none')

    })

</script>