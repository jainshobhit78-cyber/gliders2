<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Str;
use Hash;
use Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
class AdminAuthController extends Controller
{

    public function login()
    {
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        session(['admin_captcha' => $num1 + $num2]);
        $captcha_question = "What is $num1 + $num2?";

        return view('backend.auth.login', compact('captcha_question'));
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|integer'
        ]);

        $key = 'login-attempts:' . Str::lower($request->email) . '|' . $request->ip();

        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => 'Too many login attempts. Please try again in ' . $seconds . ' seconds.'
            ])->withInput();
        }

        if ($request->captcha != session('admin_captcha')) {
            // Regenerate captcha on failure
            $num1 = rand(1, 10);
            $num2 = rand(1, 10);
            session(['admin_captcha' => $num1 + $num2]);
            return back()->withErrors([
                'captcha' => 'Invalid CAPTCHA answer.'
            ])->withInput();
        }

        if (
            Auth::guard('admin')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ])
        ) {
            \Illuminate\Support\Facades\RateLimiter::clear($key);
            return redirect('admin/dashboard');
        }

        \Illuminate\Support\Facades\RateLimiter::hit($key, 60);

        // Regenerate captcha on failure
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        session(['admin_captcha' => $num1 + $num2]);

        return back()->withErrors([
            'email' => 'Invalid email or password'
        ])->withInput();
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
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

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

}
