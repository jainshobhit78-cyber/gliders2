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

                    <input type="file" name="banner_video" class="form-control" accept=".mp4,.webm,.ogg,.mov,video/*"
                        id="videoInput">

                    {{-- SHOW ONLY IF EXISTS --}}
                    @if(!empty($offer) && $offer->banner_video)
                        <div class="mt-2">
                            <video id="previewVideo" width="200" controls>
                                <source src="{{ asset('uploads/video_banner/' . $offer->banner_video) }}" type="video/mp4">
                            </video>
                        </div>
                    @else
                        <video id="previewVideo" width="200" controls style="display:none;"></video>
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
                    <button type="submit" class="btn btn-primary">
                        {{ $offer ? 'Update' : 'Add' }}
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

