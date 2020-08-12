<?php

namespace ArtARTs36\ULoginLaravel\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use ArtARTs36\ULoginApi\Entities\User as ExternalUser;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Interface User
 * @package ArtARTs36\ULoginLaravel\Contracts
 */
interface User extends Authenticatable
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return HasMany
     */
    public function socialProfiles(): HasMany;

    /**
     * @return Builder
     */
    public static function query();

    /**
     * @param ExternalUser $user
     * @return User
     */
    public static function createOfExternal(ExternalUser $user): User;
}
