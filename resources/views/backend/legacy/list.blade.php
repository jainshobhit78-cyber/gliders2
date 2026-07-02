@extends('backend.layout.app')

@section('content')
<div class="about-section">
    <div class="title-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0 page-title">{{ $title }} Management</h5>
        <a href="{{ $type === 'opf' ? route('admin.opf_legacy.add') : route('admin.legacy.add') }}" class="btn btn-theme">
            Add Leader
        </a>
    </div>

    <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-header p-0">
                <ul class="nav nav-tabs" id="legacyTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="leaders-tab" data-bs-toggle="tab" data-bs-target="#leaders-content" type="button" role="tab">Leaders</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings-content" type="button" role="tab">Page Settings</button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                @include('_message')

                <div class="tab-content" id="legacyTabsContent">
                    <!-- Leaders List Tab -->
                    <div class="tab-pane fade show active" id="leaders-content" role="tabpanel">
                        <p class="text-muted mb-3">
                            Drag rows using <b>⠿</b> to reorder. The order here reflects the display order on the public page.
                        </p>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;"></th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Tenure</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="leadersTbody">
                                    @foreach($leaders as $leader)
                                        <tr draggable="true" data-id="{{ $leader->id }}">
                                            <td class="drag-col" style="cursor: grab; font-size: 18px; color: #aab3c5; text-align: center; user-select: none;">⠿</td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center rounded-circle text-white font-weight-bold" style="width: 42px; height: 42px; background: {{ $leader->color ?: '#0b2a5b' }}; font-size: 14px;">
                                                    @if($leader->image)
                                                        <img src="{{ asset('uploads/category/' . $leader->image) }}" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                                                    @else
                                                        {{ $leader->initials ?: '?' }}
                                                    @endif
                                                </div>
                                            </td>
                                            <td><b>{{ $leader->name }}</b></td>
                                            <td>{{ $leader->role }}</td>
                                            <td>{{ $leader->tenure_text }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ $type === 'opf' ? route('admin.opf_legacy.edit', $leader->id) : route('admin.legacy.edit', $leader->id) }}" class="btn btn-sm btn-edit" style="background: #e8f0fb; color: #2A538E;">Edit</a>
                                                    <a href="{{ $type === 'opf' ? route('admin.opf_legacy.delete', $leader->id) : route('admin.legacy.delete', $leader->id) }}" class="btn btn-sm btn-delete" style="background: #fde8e8; color: #c0392b;" onclick="return confirm('Are you sure you want to delete this leader?')">Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Page Settings Tab -->
                    <div class="tab-pane fade" id="settings-content" role="tabpanel">
                        <form method="POST" action="{{ route('admin.legacy.settings') }}">
                            @csrf
                            <h6 class="mb-3 text-primary" style="font-weight: 700; border-bottom: 2px solid #eef2f8; padding-bottom: 8px;">Hero Section</h6>
                            
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Heading (main)</label>
                                <div class="col-sm-10">
                                    <input type="text" name="hero_title" class="form-control" value="{{ old('hero_title', $setting->hero_title ?? '') }}" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Heading (accent)</label>
                                <div class="col-sm-10">
                                    <input type="text" name="hero_accent" class="form-control" value="{{ old('hero_accent', $setting->hero_accent ?? '') }}" required>
                                    <small class="text-muted">Will show up highlighted (e.g. Leadership <span class="text-warning">Legacy</span>)</small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Subtitle</label>
                                <div class="col-sm-10">
                                    <input type="text" name="hero_subtitle" class="form-control" value="{{ old('hero_subtitle', $setting->hero_subtitle ?? '') }}" required>
                                </div>
                            </div>

                            <h6 class="mb-3 mt-4 text-primary" style="font-weight: 700; border-bottom: 2px solid #eef2f8; padding-bottom: 8px;">Timeline Section</h6>
                            
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Timeline Heading</label>
                                <div class="col-sm-10">
                                    <input type="text" name="timeline_title" class="form-control" value="{{ old('timeline_title', $setting->timeline_title ?? '') }}" required>
                                </div>
                            </div>

                            <h6 class="mb-3 mt-4 text-primary" style="font-weight: 700; border-bottom: 2px solid #eef2f8; padding-bottom: 8px;">Footer CTA Section</h6>
                            
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Line 1</label>
                                <div class="col-sm-10">
                                    <input type="text" name="footer_line1" class="form-control" value="{{ old('footer_line1', $setting->footer_line1 ?? '') }}" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Line 2 (highlighted)</label>
                                <div class="col-sm-10">
                                    <input type="text" name="footer_line2" class="form-control" value="{{ old('footer_line2', $setting->footer_line2 ?? '') }}" required>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-theme">Save Settings</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    let dragRow = null;

    document.querySelectorAll('#leadersTbody tr').forEach(function(row) {
        row.addEventListener('dragstart', function() {
            dragRow = row;
            row.style.opacity = '0.4';
        });
        row.addEventListener('dragend', function() {
            row.style.opacity = '1';
        });
        row.addEventListener('dragover', function(e) {
            e.preventDefault();
        });
        row.addEventListener('drop', function(e) {
            e.preventDefault();
            if (!dragRow || dragRow === row) return;

            let parent = row.parentNode;
            let rows = Array.from(parent.children);
            let fromIndex = rows.indexOf(dragRow);
            let toIndex = rows.indexOf(row);

            if (fromIndex < toIndex) {
                parent.insertBefore(dragRow, row.nextSibling);
            } else {
                parent.insertBefore(dragRow, row);
            }

            // Save new order
            let newOrder = Array.from(parent.children).map(r => r.dataset.id);
            saveNewOrder(newOrder);
        });
    });

    function saveNewOrder(order) {
        fetch("{{ route('admin.legacy.reorder') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ order: order })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                toastr.success('Display order updated successfully.');
            } else {
                toastr.error('Failed to update display order.');
            }
        })
        .catch(error => {
            console.error('Error updating order:', error);
            toastr.error('Error saving new order.');
        });
    }
</script>
@endsection
