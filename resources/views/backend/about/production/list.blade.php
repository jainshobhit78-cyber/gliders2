<style>
    .production-card {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: 0.3s;
    }


    .production-card .leader-img {
        height: 240px;
        overflow: hidden;
    }

    .production-card .leader-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .production-card .leader-body {
        padding: 18px;
    }

    .production-card .leader-name {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .production-card .leader-sub {
        color: #666;
        margin-bottom: 8px;
    }

    .production-card .leader-role {
        color: #2b5cff;
        font-weight: 500;
        margin-bottom: 5px;
    }
</style>

<div class="about-section">

    <div class="title-header title-header-1 d-flex align-items-center justify-content-between">

        <div class="d-flex align-items-center gap-3">
            <h5 class="mb-0 page-title">Production Unit</h5>
        </div>
        @if(auth()->guard('admin')->user()->can('production_unit.create'))
            <form class="d-inline-flex">
                <a href="javascript:void(0)" class="btn btn-theme openProductionAdd"
                    data-url="{{ url('admin/about/production-unit/add') }}">

                    <i data-feather="plus-square"></i>
                    Add Production Unit
                </a>
            </form>
        @endif

    </div>

    @include('_message')

    <div class="row g-4 mt-2">

        @forelse($units as $unit)

            <div class="col-xl-3 col-lg-4 col-md-6">

                <div class="leader-card production-card">

                    <div class="leader-img">

                        @php
                            $firstImage = $unit->milestones->first()?->images->first();
                        @endphp

                        @if($firstImage)
                            <img src="{{ asset('uploads/production/images/' . $firstImage->image) }}" alt="Production Image">
                        @else
                            <img src="{{ asset('backend/images/no-image.png') }}" alt="No Image">
                        @endif

                    </div>

                    <div class="leader-body">

                        <p class="leader-role">
                            {{ $unit->profile }}
                        </p>

                        <p class="leader-sub">
                            {{ $unit->sub_heading }}
                        </p>

                        <h5 class="leader-name">
                            {{ $unit->heading }}
                        </h5>

                        <div class="small text-muted mb-2">
                            Total Milestones:
                            <strong>{{ $unit->milestones->count() }}</strong>
                        </div>

                        <div class="leader-actions">
                            <a href="javascript:void(0)" class="btn btn-info btn-view viewMilestones"
                                data-id="{{ $unit->id }}">
                                View
                            </a>
                            @if(auth()->guard('admin')->user()->can('production_unit.edit'))
                                <a href="javascript:void(0)" class="btn btn-edit openProductionEdit"
                                    data-url="{{ url('admin/about/production-unit/edit/' . $unit->id) }}">
                                    Edit
                                </a>
                            @endif
                            @if(auth()->guard('admin')->user()->can('production_unit.delete'))
                                <x-delete-form :action="url('admin/about/production-unit/delete/' . $unit->id)" class="btn btn-delete" confirm="Are you sure?" />
                            @endif
                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">
                <div class="alert alert-info">
                    No Production Units Found
                </div>
            </div>

        @endforelse

    </div>

</div>

<div class="modal fade" id="milestoneModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Milestone Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="milestoneModalBody">
                Loading...
            </div>

        </div>
    </div>
</div>

<script>
    $(document).on('click', '.viewMilestones', function () {

        let unitId = $(this).data('id');

        $.ajax({
            url: "{{ url('admin/about/production-unit/view') }}/" + unitId,
            type: "GET",
            success: function (response) {
                $('#milestoneModalBody').html(response);
                $('#milestoneModal').modal('show');
            }
        });

    });
</script>