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
        // Super Admin access
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return $user->type === 'admin' ? true : null;
        });

        // Basic permissions mapping based on user type
        \Illuminate\Support\Facades\Gate::define('objectif.view', function ($user) {
            return in_array($user->type, ['admin', 'manager', 'employee', 'employe']);
        });

        \Illuminate\Support\Facades\Gate::define('objectif.create', function ($user) {
            return in_array($user->type, ['admin', 'manager']);
        });

        \Illuminate\Support\Facades\Gate::define('objectif.edit', function ($user) {
            return in_array($user->type, ['admin', 'manager']);
        });

        \Illuminate\Support\Facades\Gate::define('objectif.delete', function ($user) {
            return $user->type === 'admin';
        });

        // Document permissions
        \Illuminate\Support\Facades\Gate::define('document.view', function ($user) {
            return in_array($user->type, ['admin', 'manager', 'employee', 'employe']);
        });
        
        \Illuminate\Support\Facades\Gate::define('document.create', function ($user) {
            return true; // Everyone can request documents
        });

        // Meeting permissions
        \Illuminate\Support\Facades\Gate::define('reunion.view', function ($user) {
            return true;
        });
    }
}
