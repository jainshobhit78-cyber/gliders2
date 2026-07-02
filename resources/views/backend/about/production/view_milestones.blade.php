<div class="container-fluid">

    <h4 class="mb-3">{{ $unit->heading }}</h4>

    @foreach($unit->milestones as $milestone)

        <div class="card mb-4">
            <div class="card-body">

                <h5>{{ $milestone->milestone_name }}</h5>

                <p>
                    <strong>Date:</strong>
                    {{ $milestone->milestone_date }}
                </p>

                <p>
                    <strong>Description:</strong>
                    {{ $milestone->bio }}
                </p>

                <div class="d-flex flex-wrap gap-2">

                    @foreach($milestone->images as $img)

                        <img src="{{ asset('uploads/production/images/' . $img->image) }}"
                            style="width:120px;height:120px;object-fit:cover;border-radius:8px;">

                    @endforeach

                </div>

                @if($milestone->video)
                    <div class="mt-3">
                        <video width="250" controls>
                            <source src="{{ asset('uploads/production/videos/' . $milestone->video) }}">
                        </video>
                    </div>
                @endif

            </div>
        </div>

    @endforeach

</div>