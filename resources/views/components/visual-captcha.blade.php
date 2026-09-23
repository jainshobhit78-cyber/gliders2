@props(['context' => 'public', 'dark' => false])

<div class="visual-captcha" data-captcha-context="{{ $context }}" style="margin-bottom: 16px;">
    <label for="captcha-{{ $context }}" style="display:block;margin-bottom:8px;font-weight:700;color:{{ $dark ? '#dce9ff' : '#0b2a5b' }};">
        Security CAPTCHA (5 characters)
    </label>
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        <img
            src="{{ route('security.captcha', ['context' => $context, 'v' => now()->timestamp]) }}"
            alt="Five-character security CAPTCHA"
            width="220"
            height="70"
            data-captcha-image
            style="width:220px;max-width:100%;height:70px;object-fit:cover;border-radius:9px;border:1px solid {{ $dark ? 'rgba(255,255,255,.32)' : '#b9c9df' }};box-shadow:0 8px 20px rgba(5,22,50,.16);"
        >
        <button
            type="button"
            data-captcha-refresh
            aria-label="Refresh CAPTCHA"
            style="min-width:46px;height:46px;border-radius:9px;border:1px solid {{ $dark ? 'rgba(255,255,255,.32)' : '#b9c9df' }};background:{{ $dark ? 'rgba(255,255,255,.08)' : '#fff' }};color:{{ $dark ? '#fff' : '#0b2a5b' }};font-size:22px;cursor:pointer;"
        >&#8635;</button>
    </div>
    <input
        id="captcha-{{ $context }}"
        name="captcha"
        type="text"
        inputmode="text"
        autocomplete="off"
        autocapitalize="characters"
        minlength="5"
        maxlength="5"
        required
        placeholder="Enter the 5 characters"
        style="width:100%;margin-top:10px;padding:11px 13px;border-radius:8px;border:1px solid {{ $dark ? 'rgba(255,255,255,.28)' : '#c9d5e6' }};background:{{ $dark ? 'rgba(255,255,255,.08)' : '#fff' }};color:{{ $dark ? '#fff' : '#172033' }};text-transform:uppercase;letter-spacing:.18em;font-weight:700;"
    >
    @error('captcha')
        <div class="error" style="margin-top:7px;color:#dc3545;font-size:13px;">{{ $message }}</div>
    @enderror
</div>

@once
    <script>
        document.addEventListener('click', function (event) {
            const button = event.target.closest('[data-captcha-refresh]');
            if (!button) return;
            const wrapper = button.closest('[data-captcha-context]');
            const image = wrapper && wrapper.querySelector('[data-captcha-image]');
            if (!image) return;
            const url = new URL(image.src, window.location.origin);
            url.searchParams.set('v', Date.now().toString());
            image.src = url.toString();
            const input = wrapper.querySelector('input[name="captcha"]');
            if (input) {
                input.value = '';
                input.focus();
            }
        });
    </script>
@endonce
