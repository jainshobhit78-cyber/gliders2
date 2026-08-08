@php
    $launchTarget = $trackingSetting->launch_animation_target_at
        ? $trackingSetting->launch_animation_target_at->copy()->setTimezone('Asia/Kolkata')->toIso8601String()
        : '2026-08-15T00:00:00+05:30';
    $launchDateLabel = $trackingSetting->launch_animation_target_at
        ? $trackingSetting->launch_animation_target_at->copy()->setTimezone('Asia/Kolkata')->format('d F Y')
        : '15 August 2026';
    $launchTitle = $trackingSetting->launch_animation_title ?: 'Happy Independence Day';
    $launchMessage = $trackingSetting->launch_animation_message ?: 'Honouring the spirit of freedom, courage and self-reliance.';
    $launchButton = $trackingSetting->launch_animation_button_text ?: 'Enter the Website';
    $launchDuration = max(14, (int) ($trackingSetting->launch_animation_auto_reveal_seconds ?: 16));
    $launchVersion = optional($trackingSetting->updated_at)->timestamp ?: 1;
@endphp

<section class="launch-experience" id="launchExperience"
    data-target="{{ $launchTarget }}"
    data-duration="{{ $launchDuration }}"
    data-version="{{ $launchVersion }}"
    data-preview="{{ $launchPreview ? 'true' : 'false' }}"
    aria-label="Gliders India website launch ceremony" aria-modal="true" role="dialog">

    <canvas class="launch-fireworks-canvas" id="launchFireworksCanvas" aria-hidden="true"></canvas>

    <div class="launch-ambient" aria-hidden="true">
        <span class="launch-ambient__aurora launch-ambient__aurora--saffron"></span>
        <span class="launch-ambient__aurora launch-ambient__aurora--green"></span>
        <span class="launch-ambient__halo"></span>
        <span class="launch-ambient__grid"></span>
        <span class="launch-ambient__grain"></span>
        <span class="launch-ambient__beam launch-ambient__beam--one"></span>
        <span class="launch-ambient__beam launch-ambient__beam--two"></span>
        @for($star = 1; $star <= 30; $star++)
            <i class="launch-star" style="--x: {{ ($star * 37) % 97 }}%; --y: {{ ($star * 61) % 89 }}%; --size: {{ 1 + ($star % 3) }}px; --alpha: {{ (18 + ($star % 5) * 10) / 100 }}; --twinkle: {{ 2.5 + ($star % 7) * .4 }}s"></i>
        @endfor
    </div>

    <header class="launch-header">
        <div class="launch-header__identity">
            <div class="launch-header__logo-wrap">
                <img src="{{ asset('frontend/images/logo/gliders.png') }}" alt="Gliders India Limited">
            </div>
            <div class="launch-header__copy">
                <strong>Gliders India Limited</strong>
                <span>A Government of India Enterprise</span>
            </div>
        </div>

        <button type="button" class="launch-skip" id="launchEnterButton" aria-label="{{ $launchButton }}">
            <span>{{ $launchButton }}</span>
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h13M13 6l6 6-6 6"/></svg>
        </button>
    </header>

    <div class="launch-stage">
        <section class="launch-scene launch-scene--intro" aria-labelledby="launchExperienceTitle">
            <div class="launch-chakra launch-chakra--hero" aria-hidden="true">
                <svg viewBox="0 0 120 120">
                    <circle cx="60" cy="60" r="48"/>
                    <circle cx="60" cy="60" r="7"/>
                    @for($spoke = 0; $spoke < 24; $spoke++)
                        <line x1="60" y1="60" x2="60" y2="12" transform="rotate({{ $spoke * 15 }} 60 60)"/>
                    @endfor
                </svg>
            </div>

            <div class="launch-intro__date"><span></span>{{ $launchDateLabel }}<span></span></div>
            <p class="launch-overline">Celebrating freedom. Building self-reliance.</p>
            <h1 id="launchExperienceTitle">{{ $launchTitle }}</h1>
            <p class="launch-intro__message">{{ $launchMessage }}</p>
            <div class="launch-tricolour-stroke" aria-hidden="true"><i></i><i></i><i></i></div>
            <p class="launch-intro__whisper">A new digital chapter is ready to take flight</p>
        </section>

        <section class="launch-scene launch-scene--ribbon" aria-label="Ceremonial ribbon cutting">
            <p class="launch-overline">With pride, we unveil</p>
            <h2>A New Era of<br><em>Innovation</em></h2>

            <div class="launch-ribbon-stage" aria-hidden="true">
                <div class="launch-ribbon__half launch-ribbon__half--left">
                    <span></span><span></span><span></span>
                </div>
                <div class="launch-ribbon__seal">
                    <svg class="launch-ribbon__chakra" viewBox="0 0 100 100">
                        <circle cx="50" cy="50" r="39"/>
                        @for($spoke = 0; $spoke < 24; $spoke++)
                            <line x1="50" y1="50" x2="50" y2="11" transform="rotate({{ $spoke * 15 }} 50 50)"/>
                        @endfor
                    </svg>
                </div>
                <svg class="launch-scissors" viewBox="0 0 100 100">
                    <circle cx="23" cy="76" r="14"/><circle cx="77" cy="76" r="14"/>
                    <path d="M33 65L76 17M67 65L24 17M49 47l2 2"/>
                </svg>
                <div class="launch-ribbon__half launch-ribbon__half--right">
                    <span></span><span></span><span></span>
                </div>
            </div>
            <p class="launch-ribbon__caption">Gliders India Limited</p>
        </section>

        <section class="launch-scene launch-scene--countdown" aria-label="Website launch countdown">
            <p class="launch-overline">The future takes flight in</p>
            <div class="launch-countdown-orbit" aria-hidden="true">
                <svg viewBox="0 0 220 220">
                    <circle class="launch-countdown-orbit__track" cx="110" cy="110" r="96"/>
                    <circle class="launch-countdown-orbit__progress" cx="110" cy="110" r="96"/>
                </svg>
                <span class="launch-countdown-orbit__spark"></span>
            </div>
            <strong class="launch-countdown-number" id="launchCountdownNumber">5</strong>
            <p class="launch-countdown-word" id="launchCountdownWord">Five seconds to a new chapter</p>
        </section>

        <section class="launch-scene launch-scene--finale" aria-labelledby="launchFinaleTitle">
            <div class="launch-finale__rings" aria-hidden="true"><i></i><i></i><i></i></div>
            <div class="launch-finale__logo">
                <img src="{{ asset('frontend/images/logo/gliders.png') }}" alt="">
            </div>
            <p class="launch-overline">Proudly presenting</p>
            <h2 id="launchFinaleTitle">Our New Digital Home</h2>
            <p>Modern. Accessible. Mission ready.</p>
            <div class="launch-finale__badge">
                <span class="launch-finale__badge-dot"></span>
                Welcome to the new Gliders India website
            </div>
        </section>
    </div>

    <div class="launch-phase-indicator" aria-hidden="true">
        <span class="is-active" data-phase-dot="intro"></span>
        <span data-phase-dot="ribbon"></span>
        <span data-phase-dot="countdown"></span>
        <span data-phase-dot="finale"></span>
    </div>

    <div class="launch-confetti-field" id="launchConfettiField" aria-hidden="true">
        @for($piece = 1; $piece <= 54; $piece++)
            <i style="--x: {{ ($piece * 41) % 101 }}%; --drift: {{ (($piece % 9) - 4) * 26 }}px; --width: {{ 5 + ($piece % 4) * 2 }}px; --height: {{ 10 + ($piece % 5) * 2 }}px; --duration: {{ 2.2 + ($piece % 6) * .22 }}s; --delay: {{ ($piece % 15) * .06 }}s; --spin: {{ $piece * 37 }}deg"></i>
        @endfor
    </div>

    <div class="launch-transition" aria-hidden="true">
        <div class="launch-transition__panel launch-transition__panel--saffron"></div>
        <div class="launch-transition__panel launch-transition__panel--white">
            <div class="launch-transition__mark">
                <svg viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="38"/>
                    @for($spoke = 0; $spoke < 24; $spoke++)
                        <line x1="50" y1="50" x2="50" y2="12" transform="rotate({{ $spoke * 15 }} 50 50)"/>
                    @endfor
                </svg>
            </div>
        </div>
        <div class="launch-transition__panel launch-transition__panel--green"></div>
    </div>

    <p class="visually-hidden" id="launchLiveStatus" aria-live="assertive">Launch ceremony started</p>
</section>

<script src="{{ asset('frontend/js/launch-experience.js') }}?v=3" defer></script>
