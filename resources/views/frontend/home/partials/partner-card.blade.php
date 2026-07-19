<div class="force-card-inner {{ Str::slug($partner->name) }}">
    <!-- Top section: full logo only (no background image) -->
    <div class="force-card-top">
        <div class="force-card-glass"></div>
        <div class="force-logo-wrap">
            @if($partner->image)
                <img src="{{ asset($partner->image) }}" alt="{{ $partner->name }}">
            @else
                <div class="text-white fw-bold">No Logo</div>
            @endif
        </div>
    </div>

    <!-- Gold separator and hex badge -->
    <div class="force-card-separator">
        <div class="separator-line"></div>
        <div class="force-badge-hex">
            <svg viewBox="0 0 100 115" width="46" height="53">
                <!-- Outer gold hexagon -->
                <polygon points="50,3 97,28 97,82 50,107 3,82 3,28" fill="#1b1c1e" stroke="#d4af37" stroke-width="4"/>
                <!-- Inner icon depending on organization -->
                @if(str_contains(strtolower($partner->name), 'army'))
                    <!-- Crossed Swords -->
                    <path d="M30,75 L70,35 M33,78 L73,38 M30,35 L70,75 M33,32 L73,72" stroke="#d4af37" stroke-width="4" stroke-linecap="round"/>
                    <circle cx="30" cy="75" r="4" fill="#d4af37"/>
                    <circle cx="70" cy="75" r="4" fill="#d4af37"/>
                @elseif(str_contains(strtolower($partner->name), 'air force'))
                    <!-- Fighter Jet -->
                    <path d="M50,20 L60,45 L80,50 L55,60 L50,85 L45,60 L20,50 L40,45 Z" fill="#d4af37"/>
                @elseif(str_contains(strtolower($partner->name), 'drdo'))
                    <!-- Radar antenna / wave -->
                    <circle cx="50" cy="75" r="5" fill="#d4af37"/>
                    <path d="M50,75 L50,55 M30,45 C40,35 60,35 70,45 M40,55 C45,50 55,50 60,55" stroke="#d4af37" stroke-width="3" stroke-linecap="round" fill="none"/>
                @else
                    <!-- Default Star -->
                    <polygon points="50,25 58,45 80,45 62,58 68,80 50,68 32,80 38,58 20,45 42,45" fill="#d4af37"/>
                @endif
            </svg>
        </div>
        <div class="separator-line"></div>
    </div>

    <!-- Bottom section: organization name only (no subheading) -->
    <div class="force-card-bottom">
        <h4>{{ $partner->name }}</h4>
        <div class="gold-bottom-bar"></div>
    </div>
</div>
