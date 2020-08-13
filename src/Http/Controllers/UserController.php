<?php

namespace ArtARTs36\ULoginLaravel\Http\Controllers;

use ArtARTs36\ULoginApi\Exceptions\GivenIncorrectToken;
use ArtARTs36\ULoginLaravel\Contracts\User;
use ArtARTs36\ULoginLaravel\Http\Requests\AuthRequest;
use ArtARTs36\ULoginLaravel\Models\Profile;
use ArtARTs36\ULoginLaravel\Services\UserService;
use Illuminate\Http\Response;

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
            \abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'Given incorrect token');

            return null;
        }
    }

    /**
     * @param AuthRequest $request
     * @return Profile|null
     */
    public function attachProfile(AuthRequest $request): ?Profile
    {
        if (auth()->guard(\config('ulogin.auth.guard'))->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        try {
            $external = $this->service->getExternalUser($request->get(AuthRequest::FIELD_TOKEN));
            $profile = $this->service->findProfileByIdentity($external->identity());

            if ($profile) {
                throw new \LogicException('Profile already attach');
            }

            return Profile::createOfExternal($external, auth()->user());
        } catch (GivenIncorrectToken $exception) {
            \abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'Given incorrect token');

            return null;
        } catch (\Exception $exception) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY);

            return null;
        }
    }
}
