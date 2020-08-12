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
