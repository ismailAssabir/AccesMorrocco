<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        // 1. SUPER ADMIN: Grant all permissions to users with type 'admin'
        Gate::before(function ($user, $ability) {
            return $user->type === 'admin' ? true : null;
        });

        // 2. DYNAMIC PERMISSIONS: 
        // We use Spatie's HasRoles trait in the User model.
        // Laravel's Gate will automatically check for permissions defined via Spatie.
    }
}
