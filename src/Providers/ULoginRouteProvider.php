<?php

namespace ArtARTs36\ULoginLaravel\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

class ULoginRouteProvider extends RouteServiceProvider
{
    protected $namespace = 'ArtARTs36\ULoginLaravel\Http\Controllers';

    public function map()
    {
        $this->mapApiRoutes();
    }

    protected function mapApiRoutes()
    {
        Route::namespace($this->namespace)
            ->group(__DIR__.'/../../routes/web.php');
    }
}
