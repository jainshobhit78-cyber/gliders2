@extends('backend.layout.app')

@section('content')
    <div class="container-fluid">
        <div class="title-header mb-4">
            <h5 class="page-title">System Tools</h5>
            <p class="text-muted mb-0">Maintenance actions. Each runs as a CSRF-protected POST and is restricted to super-admins.</p>
        </div>

        @include('_message')

        <div class="row g-3">

            @php
                $tools = [
                    ['url' => url('admin/reconcile-migrations'), 'title' => 'Reconcile Migrations', 'desc' => 'Safely syncs the migration history: runs any pending migrations, and records already-applied ones so future migrations work. Never drops data.', 'btn' => 'Reconcile', 'class' => 'btn-primary', 'confirm' => 'Run migration reconciliation now?'],
                    ['url' => url('admin/sync-df-profile'), 'title' => 'Sync Director (Finance) Profile', 'desc' => 'Applies the official Director (Finance) profile &amp; milestones brief (figures, dates and awards). Safe to re-run.', 'btn' => 'Sync', 'class' => 'btn-primary', 'confirm' => 'Apply the Director (Finance) profile and milestones?'],
                    ['url' => url('admin/run-migrations'), 'title' => 'Run Migrations', 'desc' => 'Runs the predefined set of migrations (social fields, launch experience, etc.).', 'btn' => 'Run', 'class' => 'btn-primary', 'confirm' => 'Run migrations now?'],
                    ['url' => url('admin/clear-cache'), 'title' => 'Clear Cache', 'desc' => 'Clears config, route, view, application cache and OPcache.', 'btn' => 'Clear', 'class' => 'btn-secondary', 'confirm' => 'Clear all caches?'],
                    ['url' => url('admin/fix-permissions'), 'title' => 'Fix Permissions', 'desc' => 'Re-seeds the roles &amp; permissions table.', 'btn' => 'Fix', 'class' => 'btn-warning', 'confirm' => 'Re-seed roles and permissions?'],
                    ['url' => url('admin/update_units'), 'title' => 'Normalize Units (DB)', 'desc' => 'Rewrites unit spellings (Kg→kg, etc.) directly in the database. Irreversible.', 'btn' => 'Run', 'class' => 'btn-warning', 'confirm' => 'This permanently rewrites text in the database. Continue?'],
                    ['url' => url('admin/seed-all-products'), 'title' => 'Seed All Products', 'desc' => 'Seeds/updates the product catalogue. May overwrite existing products.', 'btn' => 'Seed', 'class' => 'btn-danger', 'confirm' => 'This may overwrite products. Continue?'],
                    ['url' => url('admin/seed-brake-parachutes'), 'title' => 'Seed Brake Parachutes', 'desc' => 'Seeds the brake-parachute product data.', 'btn' => 'Seed', 'class' => 'btn-danger', 'confirm' => 'Seed brake-parachute data?'],
                ];
            @endphp

            @foreach($tools as $tool)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <h6 class="mb-2">{{ $tool['title'] }}</h6>
                            <p class="text-muted small flex-grow-1">{!! $tool['desc'] !!}</p>
                            <form action="{{ $tool['url'] }}" method="POST" onsubmit="return confirm('{{ $tool['confirm'] }}');">
                                @csrf
                                <button type="submit" class="btn {{ $tool['class'] }} btn-sm">{{ $tool['btn'] }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
