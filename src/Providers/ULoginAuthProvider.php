<?php

namespace ArtARTs36\ULoginLaravel\Providers;

use ArtARTs36\ULoginApi\Api;
use ArtARTs36\ULoginApi\Contracts\Client;
use Illuminate\Support\ServiceProvider;

/**
 * Class ULoginAuthProvider
 * @package ArtARTs36\ULoginLaravel\Providers
 */
class ULoginAuthProvider extends ServiceProvider
{
    protected const ROOT_PATH = __DIR__.'/../../';

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                static::ROOT_PATH . '/config/ulogin.php' => config_path('ulogin.php'),
            ], 'ulogin');

            $this->loadMigrationsFrom(static::ROOT_PATH . '/database/migrations');
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/ulogin.php',
            'ulogin'
        );

        $this->app->singleton(Client::class, function () {
            return new \ArtARTs36\ULoginApi\Client(request()->getHost());
        });

        $this->app->singleton(Api::class, function () {
            return new Api($this->app->get(Client::class));
        });

        $this->registerRoutes();
    }

    protected function registerRoutes(): void
    {
        $this->app->register(ULoginRouteProvider::class);
    }
}
