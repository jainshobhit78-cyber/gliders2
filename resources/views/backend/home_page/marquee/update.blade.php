<div class="title-header d-flex align-items-center gap-3">


    <h5>Update Marquee Text</h5>

</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-body">


            <form method="post" action="{{ url('admin/marquee/update') }}" class="theme-form"
                enctype="multipart/form-data">

                @csrf

                <div class="mb-4">
                    <label class="form-label-title">text 1</label>

                    <input type="text" name="text1" class="form-control"
                        value="{{ old('text1', $offer->text1 ?? '') }}" placeholder="Enter text 1">

                    @error('text1')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label-title">text 2</label>

                    <input type="text" name="text2" class="form-control"
                        value="{{ old('text2', $offer->text2 ?? '') }}" placeholder="Enter text 2">

                    @error('text2')
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