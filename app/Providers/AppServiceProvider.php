<?php

namespace App\Providers;

use App\Support\SystemStatus;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // WEB-001 failsafe: never expose debug output (stack traces) on a real domain,
        // regardless of the .env APP_DEBUG value. Debug stays on only for local hosts.
        if (!$this->app->runningInConsole()) {
            $host = request()->getHost();
            if (!in_array($host, ['127.0.0.1', 'localhost', '::1'], true)) {
                config(['app.debug' => false]);
            }
        }

        // Automatically bypass Spatie permission checks for super administrators
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return method_exists($user, 'hasRole') && $user->hasRole('admin') ? true : null;
        });

        // Automatically clear all caches on code redeployment
        $deployFile = base_path('.deploy_timestamp');
        $routesFile = base_path('routes/web.php');
        $currentMtime = file_exists($routesFile) ? filemtime($routesFile) : time();
        $lastMtime = file_exists($deployFile) ? (int)file_get_contents($deployFile) : 0;
        if ($currentMtime > $lastMtime) {
            try {
                \Illuminate\Support\Facades\Artisan::call('view:clear');
                \Illuminate\Support\Facades\Artisan::call('route:clear');
                \Illuminate\Support\Facades\Artisan::call('cache:clear');
                if (function_exists('opcache_reset')) {
                    @opcache_reset();
                }
                @file_put_contents($deployFile, $currentMtime);
            } catch (\Exception $e) {
                // Fail silently
            }
        }

        view()->composer('*', function ($view) {
            if (!session()->has('captcha_num1') || !session()->has('captcha_num2')) {
                session([
                    'captcha_num1' => rand(1, 10),
                    'captcha_num2' => rand(1, 10)
                ]);
            }
        });

        view()->composer([
            'backend.auth.forgot-password',
            'backend.auth.login',
            'backend.auth.reset-password',
            'backend.auth.verify-otp',
            'backend.layout.sidebar',
        ], function ($view) {
            $view->with('systemStatus', app(SystemStatus::class)->snapshot(request()));
        });
    }
}
