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
        // 🚨 REGISTRO DEL MIDDLEWARE EN EL APP SERVICE PROVIDER
        // Obtenemos la instancia del Router
        $router = $this->app->make('router');

        // Creamos el alias 'role' apuntando a nuestra clase
        $router->aliasMiddleware('role', \App\Http\Middleware\CheckUserRole::class);
    }
}
