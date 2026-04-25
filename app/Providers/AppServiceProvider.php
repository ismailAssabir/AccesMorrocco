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
        // 1. SUPER ADMIN: Toujours autorisé (super_admin)
        // Commenté pour que les permissions soient strictement gérées par la base de données.
        /*
        Gate::before(function ($user, $ability) {
            return $user->type === 'admin' ? true : null;
        });
        */

        // 2. DYNAMIC PERMISSIONS: 
        // We use Spatie's HasRoles trait in the User model.
        // Laravel's Gate will automatically check for permissions defined via Spatie.

    }
}
