@extends('backend.layout.app')

@section('content')
<div class="about-section">
    <div class="title-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0 page-title">Add {{ $title }} Leader</h5>
        <a href="{{ $type === 'opf' ? route('admin.opf_legacy.index') : route('admin.legacy.index') }}" class="btn btn-secondary btn-sm">
            Back to List
        </a>
    </div>

    <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ $type === 'opf' ? route('admin.opf_legacy.store') : route('admin.legacy.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="{{ $type }}">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-4" id="leaderFormTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic-info" type="button" role="tab">Basic Info</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="achievements-tab" data-bs-toggle="tab" data-bs-target="#achievements-info" type="button" role="tab">Achievements & Focus</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="stats-tab" data-bs-toggle="tab" data-bs-target="#stats-info" type="button" role="tab">Stats & Timeline</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="leaderFormTabsContent">
                        <!-- Tab 1: Basic Info -->
                        <div class="tab-pane fade show active" id="basic-info" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="e.g. Shri A. K. Srivastava" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Role <span class="text-danger">*</span></label>
                                    <input type="text" name="role" class="form-control" value="Chairman & Managing Director" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tenure Start Year</label>
                                    <input type="text" name="tenure_start" class="form-control" placeholder="e.g. 1992">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tenure End Year</label>
                                    <input type="text" name="tenure_end" class="form-control" placeholder="e.g. 1997 (leave empty for Present)">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tenure Label/Text</label>
                                    <input type="text" name="tenure_text" class="form-control" placeholder="e.g. Tenure: 1992 – 1997">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Initials (for avatar fallback)</label>
                                    <input type="text" name="initials" class="form-control" placeholder="e.g. AS" maxlength="5">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Theme Color</label>
                                    <input type="color" name="color" class="form-control form-control-color w-100" value="#0b2a5b">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Leader Photo</label>
                                    <input type="file" name="image" class="form-control">
                                    <small class="text-muted">Will show inside the avatar circle. Falls back to Initials if empty.</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Short Description</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Short biography or summary of accomplishments..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Quote</label>
                                <textarea name="quote" class="form-control" rows="2" placeholder="e.g. Scaling capacity responsibly is the surest way to meet the nation's growing demand."></textarea>
                            </div>
                        </div>

                        <!-- Tab 2: Achievements & Focus -->
                        <div class="tab-pane fade" id="achievements-info" role="tabpanel">
                            <div class="mb-4">
                                <label class="form-label">Key Achievements (One per line)</label>
                                <textarea name="achievements" class="form-control" rows="6" placeholder="Initiated early digital process automation&#10;Secured key international quality certifications&#10;Diversified the client and order book base"></textarea>
                                <small class="text-muted">Write each achievement on a new line. They will be rendered with checkmark icons on the page.</small>
                            </div>

                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label mb-0">Focus Areas & Initiatives</label>
                                    <button type="button" class="btn btn-sm btn-info text-white" onclick="addFocusRow()">+ Add Focus Area</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Icon</th>
                                                <th>Label / Focus Text</th>
                                                <th style="width: 50px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="focusContainer">
                                            <!-- Dynamically added -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 3: Stats & Timeline -->
                        <div class="tab-pane fade" id="stats-info" role="tabpanel">
                            <div class="mb-4">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label mb-0">Key Statistics</label>
                                    <button type="button" class="btn btn-sm btn-info text-white" onclick="addStatRow()">+ Add Stat</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Icon</th>
                                                <th>Number / Value</th>
                                                <th>Label</th>
                                                <th style="width: 50px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="statsContainer">
                                            <!-- Dynamically added -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label mb-0">Timeline Milestones</label>
                                    <button type="button" class="btn btn-sm btn-info text-white" onclick="addTimelineRow()">+ Add Milestone</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Year</th>
                                                <th>Title / Event Name</th>
                                                <th>Icon</th>
                                                <th style="width: 50px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="timelineContainer">
                                            <!-- Dynamically added -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 border-top pt-3">
                        <button type="submit" class="btn btn-theme">Save Leader</button>
                        <a href="{{ route('admin.legacy.index') }}" class="btn btn-light ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Option lists for icon dropdowns -->
@php
    $icons = [
        'gear' => 'Gear (Setting/Machine)',
        'globe' => 'Globe (Export/International)',
        'monitor' => 'Monitor (Digital/Screen)',
        'medal' => 'Medal (Quality/Certification)',
        'people' => 'People (Welfare/Team)',
        'bulb' => 'Bulb (R&D/Idea)',
        'rupee' => 'Rupee (Finance/Orders)',
        'chart' => 'Chart (Growth/Stats)',
        'wrench' => 'Wrench (Modernization/Tool)',
        'flag' => 'Flag (Join Officer)',
        'arrowUp' => 'Arrow Up (Promotion)',
        'star' => 'Star (CMD Charge)'
    ];
@endphp
@endsection

@section('script')
<script>
    const availableIcons = @json($icons);

    function getIconSelect(name, selectedValue = 'gear') {
        let select = `<select name="${name}" class="form-select">`;
        for (let [value, label] of Object.entries(availableIcons)) {
            let selected = value === selectedValue ? 'selected' : '';
            select += `<option value="${value}" ${selected}>${label}</option>`;
        }
        select += `</select>`;
        return select;
    }

    // Dynamic Focus Rows
    let focusCount = 0;
    function addFocusRow(icon = 'gear', label = '') {
        const tr = document.createElement('tr');
        tr.id = `focus_row_${focusCount}`;
        tr.innerHTML = `
            <td>${getIconSelect(`focus_areas[${focusCount}][icon]`, icon)}</td>
            <td><input type="text" name="focus_areas[${focusCount}][label]" class="form-control" value="${label}" required placeholder="e.g. Plant Modernization"></td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger text-white" onclick="document.getElementById('focus_row_${focusCount}').remove()">✖</button>
            </td>
        `;
        document.getElementById('focusContainer').appendChild(tr);
        focusCount++;
    }

    // Dynamic Stat Rows
    let statCount = 0;
    function addStatRow(icon = 'rupee', number = '', label = '') {
        const tr = document.createElement('tr');
        tr.id = `stat_row_${statCount}`;
        tr.innerHTML = `
            <td>${getIconSelect(`stats[${statCount}][icon]`, icon)}</td>
            <td><input type="text" name="stats[${statCount}][number]" class="form-control" value="${number}" required placeholder="e.g. ₹120 Cr+"></td>
            <td><input type="text" name="stats[${statCount}][label]" class="form-control" value="${label}" required placeholder="e.g. Orders Secured"></td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger text-white" onclick="document.getElementById('stat_row_${statCount}').remove()">✖</button>
            </td>
        `;
        document.getElementById('statsContainer').appendChild(tr);
        statCount++;
    }

    // Dynamic Timeline Rows
    let timelineCount = 0;
    function addTimelineRow(year = '', title = '', icon = 'flag') {
        const tr = document.createElement('tr');
        tr.id = `timeline_row_${timelineCount}`;
        tr.innerHTML = `
            <td><input type="text" name="timeline[${timelineCount}][year]" class="form-control" value="${year}" required placeholder="e.g. 1975"></td>
            <td><input type="text" name="timeline[${timelineCount}][title]" class="form-control" value="${title}" required placeholder="e.g. Joined IOFS as Probationary Officer"></td>
            <td>${getIconSelect(`timeline[${timelineCount}][icon]`, icon)}</td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger text-white" onclick="document.getElementById('timeline_row_${timelineCount}').remove()">✖</button>
            </td>
        `;
        document.getElementById('timelineContainer').appendChild(tr);
        timelineCount++;
    }

    // Seed defaults to help the admin user get started easily
    window.addEventListener('DOMContentLoaded', () => {
        addFocusRow('wrench', 'Capacity Expansion');
        addFocusRow('gear', 'Plant Modernization');
        addFocusRow('chart', 'Output Growth');

        addStatRow('rupee', '₹120 Cr+', 'Orders Secured');
        addStatRow('chart', '3+', 'Major Initiatives');

        addTimelineRow('1975', 'Joined IOFS as Probationary Officer', 'flag');
        addTimelineRow('2002', 'Appointed Chairman & Managing Director', 'star');
    });
</script>
@endsection
