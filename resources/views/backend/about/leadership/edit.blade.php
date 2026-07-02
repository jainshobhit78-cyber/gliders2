<style>
    #milestone-wrapper {
        margin-top: 15px;
    }

    .milestone-item {
        border: 1px solid #dcdcdc;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        /* background: #f9f9fb; */
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .milestone-item input,
    .milestone-item textarea {
        margin-bottom: 12px;
    }

    .milestone-item textarea {
        min-height: 100px;
        resize: vertical;
    }

    .milestone-actions {
        text-align: right;
        margin-top: 10px;
    }

    .add-milestone-btn {
        margin-top: 10px;
        width: 100%;
        font-weight: 600;
    }

    .leader-img img {
        width: 100%;
        height: 260px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #ddd;
    }
</style>

<div class="title-header d-flex align-items-center gap-3">

    <a href="javascript:void(0)" class="back-btn backLeadership d-flex align-items-center">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M22.0003 13.0006L22.0004 11.0007H5.82845L9.77817 7.05093L8.36396 5.63672L2 12.0007L8.36396 18.3647L9.77817 16.9504L5.8284 13.0007L22.0003 13.0006Z"
                fill="black" />
        </svg>
        <span>Back</span>
    </a>

    <h5>Edit Leadership</h5>

</div>

<div class="container-fluid">

    <div class="card">

        <div class="card-body">

            <form class="theme-form theme-form-2 mega-form" method="post"
                action="{{ url('admin/about/leadership/update/' . $leader->id) }}" enctype="multipart/form-data">

                @csrf

                <div class="row">

                    <div class="mb-4 row align-items-center">

                        <label class="form-label-title col-sm-2">Role</label>

                        <div class="col-sm-10">
                            <input type="text" name="role" class="form-control" value="{{ $leader->role }}"
                                placeholder="Enter Role">
                        </div>

                    </div>

                    <div class="mb-4 row align-items-center">

                        <label class="form-label-title col-sm-2">Role Secondary</label>

                        <div class="col-sm-10">
                            <input type="text" name="sub_title" value="{{ $leader->sub_title  }}" class="form-control"
                                placeholder="Enter Role Secondary" required>
                        </div>

                    </div>

                    <div class="mb-4 row align-items-center">

                        <label class="form-label-title col-sm-2">Leader Name</label>

                        <div class="col-sm-10">
                            <input type="text" name="leader_name" value="{{ $leader->leader_name }}"
                                class="form-control" placeholder="Enter Leader Name" required>
                        </div>

                    </div>

                    <div class="mb-4 row align-items-center">

                        <label class="form-label-title col-sm-2">Profile Picture</label>

                        <div class="col-sm-10">
                            <input type="file" name="picture" class="form-control" accept="image/*">
                            @if($leader->picture)
                                <img src="{{ asset('uploads/leadership/' . $leader->picture) }}" style="height: 100px; margin-top: 10px; border-radius: 8px; border: 1px solid #ddd; padding: 4px;">
                            @endif
                        </div>

                    </div>

                    <div class="mb-3 row align-items-center">

                        <label class="form-label-title col-sm-2">Bio</label>

                        <div class="col-sm-10">

                            <textarea name="bio" id="bioEditor" class="editor form-control" placeholder="Enter Bio">
                                {{ $leader->bio }}
                            </textarea>

                        </div>

                    </div>

                    <h4 class="about-label">Milestones</h4>

                    <div id="milestone-wrapper">
                        @foreach($leader->milestones as $index => $milestone)

                            <div class="milestone-item border p-3 mb-3">
                                <div class="mb-3 d-flex align-items-center">
                                    <label for="" class="col-sm-2">Start Date</label>
                                    <input type="date" name="milestones[{{ $index }}][start_date]"
                                        value="{{ $milestone->start_date }}" class="form-control  mb-2"
                                        placeholder="Start Date">
                                </div>

                                <div class="mb-3 d-flex align-items-center">
                                    <label for="" class="col-sm-2">End Date</label>
                                    <input type="date" name="milestones[{{ $index }}][end_date]"
                                        value="{{ $milestone->end_date }}" class="form-control  mb-2"
                                        placeholder="End Date">
                                </div>

                                <div class="mb-3 d-flex align-items-center">
                                    <label for="" class="col-sm-2">Heading</label>
                                    <input type="text" name="milestones[{{ $index }}][heading]"
                                        value="{{ $milestone->heading }}" class="form-control mb-2" placeholder="Heading">
                                </div>

                                <div class="mb-3 row align-items-center">

                                    <label class="form-label-title col-sm-2">Description</label>

                                    <div class="col-sm-10">

                                        <textarea name="milestones[{{ $index }}][description]" id="bioEditor"
                                            class="editor form-control" placeholder="Enter Description">
                                                                        {{ $milestone->description }}</textarea>

                                    </div>

                                </div>

                                <div class="mb-3 d-flex align-items-center">
                                    <label for="" class="col-sm-2">Image</label>
                                    <input type="file" name="milestones[{{ $index }}][image]" id="pictureInput"
                                        class="form-control"
                                        accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">

                                    @if($milestone->image)
                                        <img src="{{ asset('uploads/milestones/' . $milestone->image) }}"
                                            style="height:100px;margin-top:10px;" id="imagePreview">
                                    @endif

                                    <!-- <img id="imagePreview"
                                                                style="display:none;margin-top:10px;height:120px;border:1px solid #ddd;padding:4px;"> -->
                                </div>

                                <div class="milestone-actions">
                                    <button type="button" onclick="this.closest('.milestone-item').remove()"
                                        class="btn btn-danger">Remove</button>
                                </div>
                                <input type="hidden" name="milestones[{{ $index }}][id]" value="{{ $milestone->id }}">
                                <input type="hidden" name="milestones[{{ $index }}][old_image]"
                                    value="{{ $milestone->image }}">
                            </div>

                        @endforeach


                    </div>
                    <div class="px-2 w-100">
                        <button type="button" class="btn btn-success w-100 mb-3" onclick="addMilestone()">
                            + Add Milestone
                        </button>
                    </div>

                    <div class="panel-footer">

                        <button class="btn btn-primary" id="submitBtn">
                            <span class="btnText">Update</span>
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

<script>
    document.querySelector('input[name="position"]').addEventListener('input', function () {
        if (this.value < 1) {
            this.value = 1;
        }
    });
</script>

<script>
    let count = {{ $leader->milestones->count() }};

    function addMilestone() {

        let html = `

        <div class="milestone-item border p-3 mb-3">
        <div class="mb-3 d-flex align-items-center">
            <label for="" class="col-sm-2">Start Date</label>
            <input type="date" name="milestones[${count}][start_date]" class="form-control">
        </div>

        <div class="mb-3 d-flex align-items-center">
            <label for="" class="col-sm-2">End Date</label>
            <input type="date" name="milestones[${count}][end_date]" class="form-control">
        </div>

        <div class="mb-3 d-flex align-items-center">
            <label for="" class="col-sm-2">Heading</label>
            <input type="text" name="milestones[${count}][heading]" class="form-control" placeholder="Heading">
        </div>

        <div class="mb-3 row align-items-center">

            <label class="form-label-title col-sm-2">Description</label>

            <div class="col-sm-10">

                <textarea name="milestones[${count}][description]" id="bioEditor"
                    class="editor form-control" placeholder="Enter Description"></textarea>

            </div>

        </div>

        <div class="mb-3 d-flex align-items-center">
            <label for="" class="col-sm-2">Image</label>
            <input type="file" name="milestones[${count}][image]" id="pictureInput" class="form-control"
            accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml">

            <img id="imagePreview"
                style="display:none;margin-top:10px;height:120px;border:1px solid #ddd;padding:4px;">
        </div>

        <div class="milestone-actions">
            <button type="button" onclick="this.closest('.milestone-item').remove()" class="btn btn-danger">
                Remove
            </button>
        </div>
    </div>

    `;

        document.getElementById('milestone-wrapper').insertAdjacentHTML('beforeend', html);

        count++;
    }
</script>