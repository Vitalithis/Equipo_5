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
        // Asegura que se carguen los permisos y roles del usuario logueado en cada request
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                Auth::user()->loadMissing('roles.permissions', 'permissions');
            }
        });
    }
}
