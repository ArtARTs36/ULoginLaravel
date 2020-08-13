<?php

namespace ArtARTs36\ULoginLaravel\Http\Controllers;

use ArtARTs36\ULoginApi\Exceptions\GivenIncorrectToken;
use ArtARTs36\ULoginLaravel\Contracts\User;
use ArtARTs36\ULoginLaravel\Http\Requests\AuthRequest;
use ArtARTs36\ULoginLaravel\Services\UserService;

class UserController extends Controller
{
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @param AuthRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function redirectAfterSuccessAuth(AuthRequest $request)
    {
        $this->auth($request);

        return redirect()->back();
    }

    /**
     * @param AuthRequest $request
     * @return User|null
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function auth(AuthRequest $request): ?User
    {
        try {
            $user = $this->service->getUserByToken($request->get(AuthRequest::FIELD_TOKEN));

            $this->service->authInGuard($user);

            return $user;
        } catch (GivenIncorrectToken $exception) {
            \abort(422, 'Given incorrect token');

            return null;
        }
    }
}
