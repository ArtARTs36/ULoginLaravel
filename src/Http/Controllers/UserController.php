<?php

namespace ArtARTs36\ULoginLaravel\Http\Controllers;

use ArtARTs36\ULoginApi\Exceptions\GivenIncorrectToken;
use ArtARTs36\ULoginLaravel\Http\Requests\AuthRequest;
use ArtARTs36\ULoginLaravel\Services\UserService;

class UserController extends Controller
{
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function auth(AuthRequest $request)
    {
        try {
            $user = $this->service->getUserByToken($request->get(AuthRequest::FIELD_TOKEN));

            \auth()->guard(\config('ulogin.auth.guard'))->setUser($user);
        } catch (GivenIncorrectToken $exception) {
            \abort(422, 'Given incorrect token');
        }

        return \response()->json([
            'result' => 'ok',
        ]);
    }
}
