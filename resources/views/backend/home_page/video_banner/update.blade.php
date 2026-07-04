<div class="title-header d-flex align-items-center gap-3">
    <h5>Update Video Banner</h5>
</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-body">


            <form method="post" action="{{ url('admin/video_banner/update') }}" class="theme-form"
                enctype="multipart/form-data">

                @csrf

                {{-- TITLE --}}
                {{-- <div class="mb-4">
                    <label class="form-label-title">Title</label>

                    <input type="text" name="title" class="form-control" value="{{ old('title', $offer->title ?? '') }}"
                        placeholder="Enter Title">

                    @error('title')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div> --}}

                {{-- VIDEO --}}
                <div class="mb-4">
                    <label class="form-label-title">Banner Video</label>

                    <input type="file" name="banner_video_file" class="form-control" accept=".mp4,.webm,.ogg,.mov,video/*"
                        id="videoInput">
                    <input type="hidden" name="uploaded_banner_video" id="uploadedBannerVideo">

                    <!-- Progress Bar for chunked uploads -->
                    <div class="progress mt-3 d-none" style="height: 22px; border-radius: 8px;" id="uploadProgressContainer">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 0%; font-weight: bold; line-height: 22px; color: #fff;" id="chunkProgressBar">0%</div>
                    </div>
                    <small class="text-primary mt-1 d-none" id="chunkProgressText" style="font-weight: 600; display: block;"></small>

                    {{-- SHOW ONLY IF EXISTS --}}
                    @if(!empty($offer) && $offer->banner_video)
                        <div class="mt-2" id="previewContainer">
                            <video id="previewVideo" width="200" controls>
                                <source src="{{ asset('uploads/video_banner/' . $offer->banner_video) }}" type="video/mp4">
                            </video>
                        </div>
                    @else
                        <div class="mt-2" id="previewContainer" style="display:none;">
                            <video id="previewVideo" width="200" controls></video>
                        </div>
                    @endif

                    @error('banner_video')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- <div class="mb-4">
                    <label class="form-label-title">Middle Video</label>

                    <input type="file" name="mid_video" class="form-control" accept=".mp4,.webm,.ogg,.mov,video/*"
                        id="videoInput">

                    @if(!empty($offer) && $offer->mid_video)
                        <div class="mt-2">
                            <video id="previewVideo" width="200" controls>
                                <source src="{{ asset('uploads/video_banner/' . $offer->mid_video) }}" type="video/mp4">
                            </video>
                        </div>
                    @else
                        <video id="previewVideo" width="200" controls style="display:none;"></video>
                    @endif

                    @error('mid_video')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div> -->

                {{-- BUTTON --}}
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <span class="btnText">{{ $offer ? 'Update' : 'Add' }}</span>
                        <span class="btnLoader d-none"><i class="fa fa-spinner fa-spin"></i> Saving... Please wait</span>
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>


<script>
    $(document).ready(function() {
        const fileInput = document.getElementById('videoInput');
        const progressBar = document.getElementById('chunkProgressBar');
        const progressContainer = document.getElementById('uploadProgressContainer');
        const progressText = document.getElementById('chunkProgressText');
        const hiddenInput = document.getElementById('uploadedBannerVideo');
        const submitBtn = document.getElementById('submitBtn');

        fileInput.addEventListener('change', function() {
            const file = fileInput.files[0];
            if (!file) return;

            // Start chunked upload
            uploadFileInChunks(file);
        });

        function uploadFileInChunks(file) {
            const chunkSize = 5 * 1024 * 1024; // 5MB chunks
            const totalChunks = Math.ceil(file.size / chunkSize);
            
            // Alphanumeric upload ID and clean file extension (avoids WAF blocks on parameters ending with .mp4)
            const upload_id = Date.now() + Math.random().toString(36).substring(2, 10);
            const file_ext = file.name.split('.').pop().replace(/[^a-zA-Z0-9]/g, '');
            
            progressBar.style.width = '0%';
            progressBar.innerText = '0%';
            progressContainer.classList.remove('d-none');
            progressText.classList.remove('d-none');
            progressText.innerText = 'Initializing upload... Please wait.';
            progressText.style.color = '#0b2a5b';
            submitBtn.disabled = true;

            let chunkIndex = 0;

            function uploadNextChunk() {
                const start = chunkIndex * chunkSize;
                const end = Math.min(start + chunkSize, file.size);
                const blob = file.slice(start, end);

                const formData = new FormData();
                formData.append('file', blob);
                formData.append('chunkIndex', chunkIndex);
                formData.append('totalChunks', totalChunks);
                formData.append('upload_id', upload_id);
                formData.append('file_ext', file_ext);
                formData.append('_token', '{{ csrf_token() }}');

                fetch('{{ route("admin.video_banner.upload_chunk") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        alert('Upload failed: ' + data.error);
                        progressContainer.classList.add('d-none');
                        progressText.classList.add('d-none');
                        submitBtn.disabled = false;
                        return;
                    }

                    chunkIndex++;
                    const percentComplete = Math.round((chunkIndex / totalChunks) * 100);
                    progressBar.style.width = percentComplete + '%';
                    progressBar.innerText = percentComplete + '%';
                    progressText.innerText = `Uploading video: ${percentComplete}% completed (${chunkIndex} of ${totalChunks} parts uploaded).`;

                    if (chunkIndex < totalChunks) {
                        uploadNextChunk();
                    } else {
                        // Done!
                        hiddenInput.value = data.finalName;
                        progressText.innerText = 'Video upload complete! You can now click Update to save the banner.';
                        progressText.style.color = '#198754';
                        submitBtn.disabled = false;

                        // Preview local video
                        const previewVideo = document.getElementById('previewVideo');
                        const previewContainer = document.getElementById('previewContainer');
                        if (previewVideo) {
                            previewVideo.src = URL.createObjectURL(file);
                            previewContainer.style.display = 'block';
                        }
                    }
                })
                .catch(err => {
                    alert('Upload error: ' + err.message);
                    progressContainer.classList.add('d-none');
                    progressText.classList.add('d-none');
                    submitBtn.disabled = false;
                });
            }

            uploadNextChunk();
        }
    });

    $(document).on('submit', '.theme-form', function () {
        // Disable file inputs to prevent the browser from uploading the large file again over standard POST
        $('input[type="file"]').prop('disabled', true);

        $('#submitBtn').prop('disabled', true);
        $('.btnText').addClass('d-none');
        $('.btnLoader').removeClass('d-none');
    });
</script>
