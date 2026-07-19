<div class="partner-cert-card">
    <div class="partner-cert-logo">
        @if($partner->image)
            <img src="{{ asset($partner->image) }}" alt="{{ $partner->name }}">
        @else
            <div class="fw-bold text-muted">No Logo</div>
        @endif
    </div>
    <h4>{{ $partner->name }}</h4>
</div>
