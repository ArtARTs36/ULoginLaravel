<?php

namespace ArtARTs36\ULoginLaravel\Http\Controllers;

use ArtARTs36\ULoginApi\Api;
use ArtARTs36\ULoginLaravel\Http\Requests\AuthRequest;

class UserController extends Controller
{
    private $uLoginApi;

    public function __construct(Api $uLoginApi)
    {
        $this->uLoginApi = $uLoginApi;
    }

    public function auth(AuthRequest $request)
    {

    }
}
