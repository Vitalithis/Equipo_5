<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Cargar roles y permisos del usuario logueado en todas las vistas
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                Auth::user()->loadMissing('roles.permissions', 'permissions');
            }
        });
    }
}
