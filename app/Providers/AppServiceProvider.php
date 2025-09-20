<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Passport::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //$this->registerPolicies();

        //Passport::routes();
        $this->registerPolicies();

    // Asegúrate de que esta línea esté presente y descomentada:
    Passport::hashClientSecrets();
    Passport::tokensExpireIn(now()->addDays(15)); // Opcional: configuración de expiración
    Passport::refreshTokensExpireIn(now()->addDays(30));
    Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
