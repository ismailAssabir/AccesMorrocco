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
            return $user->hasRole('super_admin') ? true : null;
        });
        */

        // 2. DYNAMIC PERMISSIONS: Fallback vers Spatie pour toutes les autres permissions
        // Note: On laisse Laravel gérer ça via le trait HasRoles du modèle User.
        // Si aucune Gate n'est définie ici, Laravel vérifiera automatiquement
        // si le rôle de l'utilisateur possède la permission en base de données.
    }
}
