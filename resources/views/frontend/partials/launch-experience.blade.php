@php
    $launchTarget = $trackingSetting->launch_animation_target_at
        ? $trackingSetting->launch_animation_target_at->copy()->setTimezone('Asia/Kolkata')->toIso8601String()
        : '2026-08-15T00:00:00+05:30';
    $launchTitle = $trackingSetting->launch_animation_title ?: 'Happy Independence Day';
    $launchMessage = $trackingSetting->launch_animation_message ?: 'Honouring the spirit of freedom, courage and self-reliance.';
    $launchButton = $trackingSetting->launch_animation_button_text ?: 'Enter the Website';
    $launchDuration = $trackingSetting->launch_animation_auto_reveal_seconds ?: 8;
    $launchVersion = optional($trackingSetting->updated_at)->timestamp ?: 1;
@endphp

<section class="launch-experience" id="launchExperience"
    data-target="{{ $launchTarget }}"
    data-auto-reveal="{{ $launchDuration }}"
    data-version="{{ $launchVersion }}"
    data-preview="{{ $launchPreview ? 'true' : 'false' }}"
    aria-label="Gliders India Independence Day welcome" aria-modal="true" role="dialog">
    <div class="launch-experience__sky" aria-hidden="true">
        <span class="launch-glow launch-glow--saffron"></span>
        <span class="launch-glow launch-glow--green"></span>
        <span class="launch-grid"></span>
        @for($i = 1; $i <= 10; $i++)
            <span class="launch-spark" style="--spark: {{ $i }}"></span>
        @endfor
    </div>

    <div class="launch-experience__shell">
        <header class="launch-brand">
            <img src="{{ asset('frontend/images/logo/gliders.png') }}" alt="Gliders India Limited">
            <span>India's defence manufacturing heritage</span>
        </header>

        <div class="launch-experience__layout">
            <div class="launch-copy">
                <div class="launch-kicker"><span></span> 15 August · India</div>
                <h1>{{ $launchTitle }}</h1>
                <p>{{ $launchMessage }}</p>

                <div class="launch-countdown" id="launchCountdown" aria-label="Countdown to Independence Day">
                    <div class="launch-countdown__item"><strong data-launch-days>00</strong><span>Days</span></div>
                    <div class="launch-countdown__separator">:</div>
                    <div class="launch-countdown__item"><strong data-launch-hours>00</strong><span>Hours</span></div>
                    <div class="launch-countdown__separator">:</div>
                    <div class="launch-countdown__item"><strong data-launch-minutes>00</strong><span>Minutes</span></div>
                    <div class="launch-countdown__separator">:</div>
                    <div class="launch-countdown__item"><strong data-launch-seconds>00</strong><span>Seconds</span></div>
                </div>

                <div class="launch-actions">
                    <button type="button" class="launch-enter-button" id="launchEnterButton">
                        <span>{{ $launchButton }}</span>
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h13M13 6l6 6-6 6"/></svg>
                    </button>
                    <span class="launch-auto-note" id="launchAutoNote">Website opens automatically in <b>{{ $launchDuration }}</b>s</span>
                </div>
            </div>

            <div class="launch-flag-stage" aria-hidden="true">
                <div class="launch-chakra-orbit">
                    <svg viewBox="0 0 100 100">
                        <circle cx="50" cy="50" r="42"/>
                        @for($i = 0; $i < 24; $i++)
                            <line x1="50" y1="50" x2="50" y2="8" transform="rotate({{ $i * 15 }} 50 50)"/>
                        @endfor
                    </svg>
                </div>
                <div class="launch-flag-pole"></div>
                <div class="launch-flag">
                    <span class="launch-flag__band launch-flag__band--saffron"></span>
                    <span class="launch-flag__band launch-flag__band--white">
                        <svg viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="38"/>
                            @for($i = 0; $i < 24; $i++)
                                <line x1="50" y1="50" x2="50" y2="12" transform="rotate({{ $i * 15 }} 50 50)"/>
                            @endfor
                        </svg>
                    </span>
                    <span class="launch-flag__band launch-flag__band--green"></span>
                    <span class="launch-flag__shine"></span>
                </div>
                <div class="launch-parachute launch-parachute--one">
                    <svg viewBox="0 0 80 90"><path d="M8 35C10 10 69 10 72 35M8 35h64M8 35l32 40 32-40M25 35l15 40 15-40M35 77h10v7H35z"/></svg>
                </div>
                <div class="launch-parachute launch-parachute--two">
                    <svg viewBox="0 0 80 90"><path d="M8 35C10 10 69 10 72 35M8 35h64M8 35l32 40 32-40M25 35l15 40 15-40M35 77h10v7H35z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="launch-reveal" aria-hidden="true">
        <span class="launch-reveal__saffron"></span>
        <span class="launch-reveal__white"></span>
        <span class="launch-reveal__green"></span>
    </div>
</section>

<script src="{{ asset('frontend/js/launch-experience.js') }}?v=1" defer></script>
