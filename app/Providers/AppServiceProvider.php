<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        // Configurar la ruta de vistas para apuntar a public/resources/views
        $viewPath = public_path('resources/views');
        
        // Reemplazar la ruta de vistas por defecto
        config(['view.paths' => [$viewPath]]);
    }
}
