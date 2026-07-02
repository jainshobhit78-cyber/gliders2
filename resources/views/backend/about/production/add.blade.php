<style>
    .milestone-section {
        margin-top: 30px;
    }

    .milestone-item {
        border: 1px solid #e5e7eb;
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 20px;
        /* background: #fff; */
        box-shadow: 0 4px 12px rgba(0, 0, 0, .06);
    }

    .milestone-label {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        display: block;
    }

    .filepond--root {
        margin-bottom: 0;
    }

    .image-preview-box {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .preview-item {
        position: relative;
        width: 100px;
        height: 100px;
    }

    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .remove-preview {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 22px;
        height: 22px;
        background: red;
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 12px;
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

    <h5>Add Production Unit</h5>

</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <form class="theme-form theme-form-2 mega-form" method="post"
                action="{{ url('admin/about/production-unit/add') }}" enctype="multipart/form-data">

                @csrf


                <div class="row">

                    <!-- Profile -->
                    <div class="mb-4 row align-items-center">

                        <label class="form-label-title col-sm-2">
                            Name Of Unit
                        </label>

                        <div class="col-sm-10">
                            <input type="text" name="profile" class="form-control" placeholder="Enter Name Of Unit"
                                required>
                        </div>

                    </div>


                    <!-- Heading -->
                    <div class="mb-4 row align-items-center">

                        <label class="form-label-title col-sm-2">
                            Heading
                        </label>

                        <div class="col-sm-10">
                            <input type="text" name="heading" class="form-control" placeholder="Enter Heading" required>
                        </div>

                    </div>


                    <!-- Sub Heading -->
                    <div class="mb-4 row align-items-center">

                        <label class="form-label-title col-sm-2">
                            Sub Heading
                        </label>

                        <div class="col-sm-10">
                            <input type="text" name="sub_heading" class="form-control" placeholder="Enter Sub Heading"
                                required>
                        </div>

                    </div>


                    <!-- BIO -->
                    <div class="mb-3 row align-items-center">

                        <label class="form-label-title col-sm-2">
                            Bio
                        </label>

                        <div class="col-sm-10">

                            <textarea name="bio" class="editor form-control" placeholder="Enter Bio"></textarea>

                        </div>

                    </div>



                    <div class="milestone-section mt-4">
                        <h4 class="about-label mb-3">Milestones</h4>

                        <div id="milestone-wrapper">

                            <div class="milestone-item">

                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="milestone-label">Milestone Date</label>
                                        <input type="date" name="milestones[0][milestone_date]" class="form-control">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="milestone-label">Milestone Name</label>
                                        <input type="text" name="milestones[0][milestone_name]" class="form-control"
                                            placeholder="Enter milestone name">
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="milestone-label">Description</label>
                                        <textarea name="milestones[0][bio]" class="form-control" rows="4"
                                            placeholder="Enter milestone description"></textarea>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="milestone-label">Images</label>

                                        <input type="file" name="milestones[0][images][]" multiple
                                            class="form-control milestone-images" onchange="previewImages(this)" accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">

                                        <div class="image-preview-box mt-3"></div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="milestone-label">Video</label>
                                        <input type="file" name="milestones[0][video]" class="form-control"
                                            accept="video/*">
                                    </div>

                                </div>

                            </div>

                        </div>

                        <button type="button" onclick="addMilestone()" class="btn btn-success w-100 mb-3">
                            + Add More Milestone
                        </button>
                    </div>

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


<script>
    let milestoneFiles = {};

    function previewImages(input) {
        const wrapper = input.closest('.milestone-item');
        const previewBox = wrapper.querySelector('.image-preview-box');
        const inputName = input.name;

        // create storage if not exists
        if (!milestoneFiles[inputName]) {
            milestoneFiles[inputName] = [];
        }

        // append new files
        Array.from(input.files).forEach(file => {
            milestoneFiles[inputName].push(file);
        });

        renderPreview(input, previewBox, inputName);
    }

    function renderPreview(input, previewBox, inputName) {
        previewBox.innerHTML = '';

        const dt = new DataTransfer();

        milestoneFiles[inputName].forEach((file, index) => {
            dt.items.add(file);

            const reader = new FileReader();

            reader.onload = function (e) {
                const div = document.createElement('div');
                div.className = 'preview-item';

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
</script>



<script>
    let count = 1;

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
                    class="form-control"
                    rows="4"></textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label class="milestone-label">Images</label>

                <input type="file"
                    name="milestones[${count}][images][]"
                    multiple
                    class="form-control"
                    onchange="previewImages(this)" accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">

                <div class="image-preview-box mt-3"></div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="milestone-label">Video</label>
                <input type="file"
                    name="milestones[${count}][video]"
                    class="form-control" accept="video/*">
            </div>


        </div>
    </div>`;

        document.getElementById('milestone-wrapper')
            .insertAdjacentHTML('beforeend', html);

        count++;
    }
</script>