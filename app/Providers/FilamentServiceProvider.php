<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Filament::serving(function () {
            // Accès restreint aux admins
            if (auth()->check() && auth()->user()->role !== 'admin') {
                abort(403);
            }
        });
    }

    public function register(): void
    {
        //
    }
}
