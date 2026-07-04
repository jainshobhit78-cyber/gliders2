<?php

namespace App\Providers;

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

        view()->composer('*', function ($view) {
            if (!session()->has('captcha_num1') || !session()->has('captcha_num2')) {
                session([
                    'captcha_num1' => rand(1, 10),
                    'captcha_num2' => rand(1, 10)
                ]);
            }
        });
    }
}
