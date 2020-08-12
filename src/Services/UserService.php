<?php

namespace ArtARTs36\ULoginLaravel\Services;

use ArtARTs36\ULoginApi\Api;
use ArtARTs36\ULoginLaravel\Contracts\User;
use ArtARTs36\ULoginLaravel\Models\Profile;
use ArtARTs36\ULoginApi\Entities\User as ExternalProfile;

class UserService
{
    /** @var Api */
    private $uLoginApi;

    /**
     * UserService constructor.
     * @param Api $uLoginApi
     */
    public function __construct(Api $uLoginApi)
    {
        $this->uLoginApi = $uLoginApi;
    }

    /**
     * @param string $token
     * @return User|Profile|null
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getUserByToken(string $token)
    {
        $external = $this->uLoginApi->user($token);

        return $this->findProfileByIdentity($external->identity()) ?? $this->createUser($external);
    }

    /**
     * @param string $identity
     * @return Profile|null
     */
    public function findProfileByIdentity(string $identity): ?Profile
    {
        return Profile::query()
            ->where(Profile::FIELD_IDENTITY, $identity)
            ->first();
    }

    /**
     * @param ExternalProfile $external
     * @return User
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function createUser(ExternalProfile $external): User
    {
        /** @var User $user */
        $user = (app()->make(User::class))::createOfExternal($external);

        Profile::createOfExternal($external, $user);

        return $user;
    }
}
