<div class="title-header d-flex align-items-center gap-3">


    <h5>Update Our Units</h5>

</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-body">


            <form method="post" action="{{ url('admin/our_units/update') }}" class="theme-form"
                enctype="multipart/form-data">

                @csrf

                <div class="mb-4">
                    <label class="form-label-title">Heading</label>

                    <input type="text" name="heading" class="form-control"
                        value="{{ old('heading', $offer->heading ?? '') }}" placeholder="Enter heading">

                    @error('heading')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Sub Heading</label>

                    <input type="text" name="sub_heading" class="form-control"
                        value="{{ old('sub_heading', $offer->sub_heading ?? '') }}" placeholder="Enter Sub Heading">

                    @error('sub_heading')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Video</label>

                    <input type="file" name="video" class="form-control" accept="video/mp4" id="videoInput">

                    @if(!empty($offer) && $offer->video)
                    <div class="mt-2">
                        <video id="previewVideo" width="200" controls>
                            <source src="{{ asset('uploads/our_units/' . $offer->video) }}" type="video/mp4">
                        </video>
                    </div>
                    @else
                    <video id="previewVideo" width="200" controls style="display:none;"></video>
                    @endif

                    @error('video')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Description</label>

                    <textarea name="description" class="editor form-control">
                        {{ old('description', $offer->description ?? '') }}
                    </textarea>

                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
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