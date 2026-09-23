<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\PasswordReset;
use App\Support\VisualCaptcha;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class AdminAuthController extends Controller
{

    public function login()
    {
        return view('backend.auth.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|string|size:' . VisualCaptcha::LENGTH,
        ]);

        $captchaKey = VisualCaptcha::limiterKey('admin', $request);
        if (RateLimiter::tooManyAttempts($captchaKey, 3)) {
            $seconds = RateLimiter::availableIn($captchaKey);

            return back()->withErrors([
                'captcha' => 'Too many incorrect CAPTCHA entries. Please wait ' . $seconds . ' seconds before trying again.',
            ])->onlyInput('email');
        }

        if (! VisualCaptcha::verify($request, 'admin', $request->input('captcha'))) {
            RateLimiter::hit($captchaKey, 300);
            $attemptsRemaining = max(0, 3 - RateLimiter::attempts($captchaKey));
            $message = $attemptsRemaining > 0
                ? 'Incorrect CAPTCHA. ' . $attemptsRemaining . ' attempt(s) remaining before a 5-minute lock.'
                : 'Too many incorrect CAPTCHA entries. CAPTCHA entry is locked for 5 minutes.';

            return back()->withErrors(['captcha' => $message])->onlyInput('email');
        }
        RateLimiter::clear($captchaKey);

        $passwordKey = 'admin-password-failures:' . Str::lower($request->email) . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($passwordKey, 3)) {
            $seconds = RateLimiter::availableIn($passwordKey);

            return back()->withErrors([
                'email' => 'Too many incorrect login attempts. Please wait ' . $seconds . ' seconds before trying again.',
            ])->onlyInput('email');
        }

        $admin = Admin::where('email', $request->email)->first();
        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            RateLimiter::hit($passwordKey, 60);
            $attemptsRemaining = max(0, 3 - RateLimiter::attempts($passwordKey));
            $message = $attemptsRemaining > 0
                ? 'Invalid email or password. ' . $attemptsRemaining . ' attempt(s) remaining before a 1-minute lock.'
                : 'Too many incorrect login attempts. Login is locked for 1 minute.';

            return back()->withErrors(['email' => $message])->onlyInput('email');
        }
        RateLimiter::clear($passwordKey);

        $otp = (string) random_int(100000, 999999);
        $settings = GeneralSetting::first();
        $recipientEmail = $settings?->otp_recipient_email ?: $admin->email;

        $request->session()->put([
            'admin_login_mfa.admin_id' => $admin->id,
            'admin_login_mfa.otp_hash' => Hash::make($otp),
            'admin_login_mfa.expires_at' => now()->addMinutes(10)->timestamp,
            'admin_login_mfa.remember' => $request->boolean('remember'),
            'admin_login_mfa.recipient_hint' => $this->maskEmail($recipientEmail),
        ]);

        try {
            Mail::send('backend.auth.login-otp-mail', [
                'otp' => $otp,
                'admin' => $admin,
            ], function ($message) use ($recipientEmail) {
                $message->to($recipientEmail);
                $message->subject('Gliders India Admin Login Verification Code');
            });
        } catch (\Throwable $exception) {
            Log::error('Admin login OTP could not be sent.', [
                'admin_id' => $admin->id,
                'exception' => $exception->getMessage(),
            ]);
            $request->session()->forget('admin_login_mfa');

            return back()->withErrors([
                'email' => 'Your credentials were correct, but the verification email could not be sent. Please contact the system administrator.',
            ])->onlyInput('email');
        }

        return redirect()->route('admin.login.otp')->with('success', 'A 6-digit verification code has been sent to the configured security email.');
    }

    public function loginOtpForm(Request $request)
    {
        if (! $request->session()->has('admin_login_mfa.admin_id')) {
            return redirect('admin/login')->withErrors(['email' => 'Please enter your login credentials first.']);
        }

        return view('backend.auth.login-otp', [
            'recipientHint' => $request->session()->get('admin_login_mfa.recipient_hint'),
        ]);
    }

    public function loginOtpPost(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $adminId = $request->session()->get('admin_login_mfa.admin_id');
        $otpHash = $request->session()->get('admin_login_mfa.otp_hash');
        $expiresAt = (int) $request->session()->get('admin_login_mfa.expires_at', 0);
        $otpKey = 'admin-login-otp-failures:' . $request->ip() . '|' . $adminId;

        if (RateLimiter::tooManyAttempts($otpKey, 5)) {
            return back()->withErrors([
                'otp' => 'Too many incorrect verification codes. Please try again in ' . RateLimiter::availableIn($otpKey) . ' seconds.',
            ]);
        }

        if (! $adminId || ! $otpHash || $expiresAt < now()->timestamp) {
            $request->session()->forget('admin_login_mfa');

            return redirect('admin/login')->withErrors(['email' => 'The verification session expired. Please log in again.']);
        }

        if (! Hash::check((string) $request->otp, (string) $otpHash)) {
            RateLimiter::hit($otpKey, 300);

            return back()->withErrors(['otp' => 'Incorrect verification code. Please check the email and try again.']);
        }

        $admin = Admin::find($adminId);
        if (! $admin) {
            $request->session()->forget('admin_login_mfa');

            return redirect('admin/login')->withErrors(['email' => 'The administrator account is no longer available.']);
        }

        $remember = (bool) $request->session()->get('admin_login_mfa.remember', false);
        RateLimiter::clear($otpKey);
        $request->session()->forget('admin_login_mfa');
        Auth::guard('admin')->login($admin, $remember);
        $request->session()->regenerate();

        return redirect('admin/dashboard');
    }

    public function forgotPassword()
    {
        return view('backend.auth.forgot-password');
    }

    public function forgotPasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return back()->with('success', 'If this email is registered, a reset OTP has been sent.');
        }

        // Generate a 6-digit numeric OTP
        $otp = rand(100000, 999999);

        PasswordReset::where('email', $request->email)->delete();

        PasswordReset::create([
            'email' => $request->email,
            'token' => Hash::make($otp),
            'created_at' => now()
        ]);

        // Get OTP recipient email from settings
        $settings = \App\Models\GeneralSetting::first();
        $recipientEmail = ($settings && $settings->otp_recipient_email) ? $settings->otp_recipient_email : $request->email;

        // ✅ Send OTP Mail
        Mail::send('backend.auth.otp-mail', [
            'otp' => $otp,
            'admin' => $admin
        ], function ($message) use ($recipientEmail) {
            $message->to($recipientEmail);
            $message->subject('Your Password Reset OTP');
        });

        // Store reset email in session for verify-otp page
        session(['reset_email' => $request->email]);

        return redirect('admin/verify-otp')->with('success', 'Password reset OTP has been sent to the configured security email.');
    }

    public function verifyOtpForm()
    {
        return view('backend.auth.verify-otp');
    }

    public function verifyOtpPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
            'password' => [
                'required', 'confirmed', 'min:10',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/',
            ]
        ]);

        $record = PasswordReset::where('email', $request->email)
            ->where('created_at', '>=', now()->subMinutes(60))
            ->first();

        if (!$record || !Hash::check($request->otp, $record->token)) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP code.'])->withInput();
        }

        // ✅ Update password
        Admin::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        // ✅ Delete OTP after use
        PasswordReset::where('email', $request->email)->delete();
        session()->forget('reset_email');

        return redirect('admin/login')->with('success', 'Password reset successfully! You can now log in.');
    }

    public function showResetForm($token)
    {
        $record = PasswordReset::where('created_at', '>=', now()->subMinutes(60))->get()
            ->first(fn ($reset) => Hash::check($token, $reset->token));

        if (!$record) {
            abort(404);
        }

        return view('backend.auth.reset-password', compact('token'));
    }


    public function resetPasswordPost(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => [
                'required', 'confirmed', 'min:10',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/',
            ]
        ]);

        $record = PasswordReset::where('created_at', '>=', now()->subMinutes(60))->get()
            ->first(fn ($reset) => Hash::check($request->token, $reset->token));

        if (!$record) {
            return back()->withErrors(['token' => 'Invalid or expired token']);
        }

        // ✅ Update password
        Admin::where('email', $record->email)->update([
            'password' => Hash::make($request->password)
        ]);

        // ✅ Delete token after use
        PasswordReset::where('email', $record->email)->delete();

        return redirect('admin/login')->with('success', 'Password reset successfully!');
    }

    public function profile_page()
    {
        $admin = Auth::guard('admin')->user();
        return view('backend.profile.update_profile', compact('admin'));
    }



    public function update_profile(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'new_password' => [
                'nullable', 'confirmed', 'min:10',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/',
            ],
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->hasFile('profile_photo')) {
            if ($admin->profile_photo && file_exists(public_path('uploads/profile/' . $admin->profile_photo))) {
                @unlink(public_path('uploads/profile/' . $admin->profile_photo));
            }
            $file = $request->file('profile_photo');
            $name = 'admin_' . $admin->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile'), $name);
            $admin->profile_photo = $name;
        }

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->with('error', 'Current password is incorrect');
            }
            $admin->password = Hash::make($request->new_password);
        }
        $admin->save();
        return back()->with('success', 'Profile Updated Successfully');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();       
        $request->session()->regenerateToken();

        return redirect('admin/login');
    }

    private function maskEmail(string $email): string
    {
        [$name, $domain] = array_pad(explode('@', $email, 2), 2, '');
        $visible = mb_substr($name, 0, min(2, mb_strlen($name)));

        return $visible . str_repeat('*', max(3, mb_strlen($name) - mb_strlen($visible))) . '@' . $domain;
    }

}
