<div class="title-header d-flex align-items-center gap-3">


    <h5>Update State Counter</h5>

</div>


<div class="container-fluid">

    <div class="card">

        <div class="card-body">


            <form method="post" action="{{ url('admin/state_counter/update') }}" class="theme-form"
                enctype="multipart/form-data">

                @csrf

                <div class="mb-4">
                    <label class="form-label-title">Years of Legacy</label>

                    <input type="text" name="years_of_legacy" class="form-control"
                        value="{{ old('years_of_legacy', $offer->years_of_legacy ?? '') }}" placeholder="Enter Years of Legacy">

                    @error('years_of_legacy')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Parachutes Manufactured</label>

                    <input type="text" name="parachutes_manufactured" class="form-control"
                        value="{{ old('parachutes_manufactured', $offer->parachutes_manufactured ?? '') }}"
                        placeholder="Enter Parachutes Manufactured">

                    @error('parachutes_manufactured')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Indigenous Manufacturing</label>

                    <input type="text" name="indigenous_manufacturing" class="form-control"
                        value="{{ old('indigenous_manufacturing', $offer->indigenous_manufacturing ?? '') }}"
                        placeholder="Enter Indigenous Manufacturing">

                    @error('indigenous_manufacturing')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label-title">Annual Production Value</label>

                    <input type="text" name="annual_production_value" class="form-control"
                        value="{{ old('annual_production_value', $offer->annual_production_value ?? '') }}"
                        placeholder="Enter Annual Production Value">

                    @error('annual_production_value')
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