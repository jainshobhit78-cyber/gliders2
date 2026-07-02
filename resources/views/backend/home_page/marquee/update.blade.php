<div class="title-header d-flex align-items-center justify-content-between mb-4">
    <h5>📢 Ticker News Notification Centre</h5>
</div>

<div class="container-fluid">
    <div class="row g-4">
        {{-- LEFT COLUMN: Ticker Settings & Add Form --}}
        <div class="col-xl-4 col-lg-5">
            {{-- SPEED SETTINGS CARD --}}
            <div class="card mb-4" style="box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-radius: 12px;">
                <div class="card-header pb-0 bg-transparent border-0">
                    <h5 class="fw-bold text-dark">Ticker Scroll Speed</h5>
                    <p class="text-muted small">Configure how fast the ticker text moves across the homepage screen (lower number = faster scroll).</p>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('admin/home/marquee/speed/update') }}" class="theme-form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Scroll Duration (in seconds)</label>
                            <div class="input-group">
                                <input type="number" min="5" max="100" name="ticker_speed" class="form-control" value="{{ $settings->ticker_speed ?? 20 }}" required>
                                <span class="input-group-text">seconds</span>
                            </div>
                            <small class="text-muted">Suggested: 10s (Fast), 20s (Medium), 35s (Slow).</small>
                        </div>
                        <button type="submit" class="btn btn-theme" style="background: #e06a00; color: #fff; border: none; padding: 6px 20px; border-radius: 6px;">Update Speed</button>
                    </form>
                </div>
            </div>

            {{-- ADD NOTIFICATION CARD --}}
            <div class="card" style="box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-radius: 12px;">
                <div class="card-header pb-0 bg-transparent border-0">
                    <h5 id="formTitle" class="fw-bold text-dark">Add Ticker Notification</h5>
                </div>
                <div class="card-body">
                    <form id="tickerForm" method="post" action="{{ url('admin/home/marquee/add') }}" class="theme-form">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Notification Text</label>
                            <textarea name="text" id="tickerText" rows="3" class="form-control" placeholder="Enter notification message..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Redirect Link (Optional)</label>
                            <input type="url" name="link" id="tickerLink" class="form-control" placeholder="https://example.com/page">
                            <small class="text-muted">Users will be redirected here when they click this notification.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Display Order / Position</label>
                            <input type="number" name="position" id="tickerPosition" class="form-control" value="0" required>
                        </div>

                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="tickerActive" value="1" checked>
                            <label class="form-check-label" for="tickerActive">Active Status</label>
                        </div>

                        <button type="submit" id="submitBtn" class="btn btn-primary w-100" style="background: #0f2b5c; border: none; padding: 8px; border-radius: 6px;">Save Notification</button>
                        <button type="button" id="cancelEditBtn" class="btn btn-secondary w-100 mt-2 d-none" onclick="resetForm()">Cancel Edit</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: Notifications List Table --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card" style="box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-radius: 12px;">
                <div class="card-header pb-0 bg-transparent border-0">
                    <h5 class="fw-bold text-dark">Active Ticker Messages</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th width="80">Order</th>
                                    <th>Message Text</th>
                                    <th>Link</th>
                                    <th width="100">Status</th>
                                    <th width="140">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tickerItems as $item)
                                    <tr>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $item->position }}</span>
                                        </td>
                                        <td class="text-wrap" style="max-width: 250px;">
                                            {{ $item->text }}
                                        </td>
                                        <td>
                                            @if($item->link)
                                                <a href="{{ $item->link }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 150px;">{{ $item->link }}</a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-danger' }}">
                                                {{ $item->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-edit-item" 
                                                    data-id="{{ $item->id }}"
                                                    data-text="{{ $item->text }}"
                                                    data-link="{{ $item->link }}"
                                                    data-position="{{ $item->position }}"
                                                    data-active="{{ $item->is_active }}"
                                                    onclick="editTicker(this)"
                                                    style="background: #e2dd6151; border: 1px solid #c2b53b; color: #7f6e10; padding: 2px 8px; border-radius: 4px;">
                                                Edit
                                            </button>
                                            <a href="{{ url('admin/home/marquee/delete/' . $item->id) }}" 
                                               onclick="return confirm('Are you sure you want to delete this notification?')" 
                                               class="btn btn-sm btn-delete"
                                               style="background: #ff000018; border: 1px solid #ff000040; color: #ff0000; padding: 2px 8px; border-radius: 4px;">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No ticker notifications configured.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function editTicker(btn) {
        const id = btn.dataset.id;
        const text = btn.dataset.text;
        const link = btn.dataset.link;
        const position = btn.dataset.position;
        const active = btn.dataset.active == "1";

        // Update form action and title
        document.getElementById('tickerForm').action = "{{ url('admin/home/marquee/update-item') }}/" + id;
        document.getElementById('formTitle').innerText = "Edit Ticker Notification";
        document.getElementById('tickerText').value = text;
        document.getElementById('tickerLink').value = link || "";
        document.getElementById('tickerPosition').value = position;
        document.getElementById('tickerActive').checked = active;
        
        // Show cancel button
        document.getElementById('cancelEditBtn').classList.remove('d-none');
        document.getElementById('submitBtn').innerText = "Update Notification";
    }

    function resetForm() {
        document.getElementById('tickerForm').action = "{{ url('admin/home/marquee/add') }}";
        document.getElementById('formTitle').innerText = "Add Ticker Notification";
        document.getElementById('tickerText').value = "";
        document.getElementById('tickerLink').value = "";
        document.getElementById('tickerPosition').value = "0";
        document.getElementById('tickerActive').checked = true;
        
        // Hide cancel button
        document.getElementById('cancelEditBtn').classList.add('d-none');
        document.getElementById('submitBtn').innerText = "Save Notification";
    }
</script>