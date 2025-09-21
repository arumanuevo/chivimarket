<?php
/*namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPolicies();
        //Passport::hashClientSecrets();
       // Passport::tokensExpireIn(now()->addDays(15));
    }
}*/

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
         *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Registrar rutas y configuración de Passport
       // if (! $this->app->routesAreCached()) {
           // Passport::routes();
        //}

        // Configurar el tiempo de expiración de los tokens
        //Passport::tokensExpireIn(now()->addDays(15));
        //Passport::refreshTokensExpireIn(now()->addDays(30));
    }
}
