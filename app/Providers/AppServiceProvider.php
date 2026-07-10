<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
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
        // Share superadmin verification status globally to all views
        View::composer('*', function ($view) {
            $superadminVerified = isSuperadminVerified(session());
            $view->with('superadminVerified', $superadminVerified);
        });
    }
}
