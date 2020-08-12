<?php

namespace ArtARTs36\ULoginLaravel\Providers;

use ArtARTs36\ULoginApi\Api;
use ArtARTs36\ULoginApi\Contracts\Client;
use Illuminate\Support\ServiceProvider;

class ULoginAuthProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app->singleton(Client::class, function () {
            return new \ArtARTs36\ULoginApi\Client(request()->getHost());
        });

        $this->app->singleton(Api::class, function () {
            return new Api($this->app->get(Client::class));
        });
    }
}
