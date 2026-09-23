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
        // Automatically bypass Spatie permission checks for super administrators
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return method_exists($user, 'hasRole') && $user->hasRole('admin') ? true : null;
        });

        // Automatically clear caches after any user-facing deployment file changes.
        // This covers CSS and Blade-only releases as well as route changes.
        $deployFile = base_path('.deploy_timestamp');
        $deploymentFiles = [
            base_path('routes/web.php'),
            app_path('Http/Controllers/Backend/AdminAuthController.php'),
            resource_path('views/frontend/layouts/app.blade.php'),
            resource_path('views/frontend/home/index.blade.php'),
            resource_path('views/frontend/products/index.blade.php'),
            resource_path('views/frontend/products/category-products.blade.php'),
            resource_path('views/frontend/products/product-detail.blade.php'),
            public_path('frontend/css/style.css'),
        ];
        $deploymentMtimes = array_map(
            static fn (string $path): int => file_exists($path) ? (int) filemtime($path) : 0,
            $deploymentFiles
        );
        $currentMtime = max($deploymentMtimes ?: [time()]);
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
