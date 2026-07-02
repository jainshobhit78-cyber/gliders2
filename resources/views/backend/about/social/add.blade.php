<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backSocial">
        <svg width="24" height="24" viewBox="0 0 24 24">
            <path d="M22 13V11H5.82L9.77 7.05L8.36 5.64L2 12L8.36 18.36L9.77 16.95L5.82 13H22Z" fill="black" />
        </svg>
        <span>Back</span>
    </a>

    <h5>Add Social Responsibility Member</h5>

</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <form method="post" action="{{ url('admin/about/social-responsibility/add') }}"
                enctype="multipart/form-data" class="theme-form">

                @csrf
                <div class="mb-4">
                    <label class="form-label-title">Heading</label>
                    <input type="text" name="heading" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Sub Heading</label>
                    <input type="text" name="sub_heading" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label-title col-sm-2">Description</label>
                    <textarea name="description" id="bioEditor" class="editor form-control"
                        placeholder="Enter Description"></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Designation </label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Role</label>
                    <input type="text" name="sub_title" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Phone</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>


                <div class="mb-4">

                    <label class="form-label-title">Photo</label>

                    <input type="file" name="photo" id="pictureInput" class="form-control"
                        accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">

                    <img id="imagePreview"
                        style="display:none;margin-top:10px;height:120px;border:1px solid #ddd;padding:4px;">

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
{{--
<script>
    function initLeadershipScripts() {

        if (typeof tinymce !== "undefined") {

            if (tinymce.editors && tinymce.editors.length > 0) {
                tinymce.remove();
            }

            if (document.querySelector('.editor')) {

                tinymce.init({
                    selector: '.editor',
                    height: 350,
                    menubar: false,
                    plugins: [
                        'advlist autolink lists link image charmap preview anchor',
                        'searchreplace visualblocks code fullscreen',
                        'insertdatetime media table code wordcount'
                    ],
                    toolbar:
                        'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image | forecolor backcolor | code fullscreen preview',

                    content_style: `
                            body {
                                background: transparent !important;
                            }
                            p {
                                background: transparent !important;
                            }
                        `
                });

            }
        }

    }
    initLeadershipScripts();
</script> --}}