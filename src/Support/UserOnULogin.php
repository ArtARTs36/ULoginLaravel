<?php

namespace ArtARTs36\ULoginLaravel\Support;

use ArtARTs36\ULoginApi\Entities\User as ExternalUser;
use ArtARTs36\ULoginLaravel\Contracts\User;
use ArtARTs36\ULoginLaravel\Models\Profile;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait UserOnULogin
{
    /**
     * @return HasMany
     */
    public function socialProfiles(): HasMany
    {
        return $this->hasMany(Profile::class, Profile::FIELD_USER_ID);
    }

    /**
     * @param ExternalUser $user
     * @return User
     */
    public static function createOfExternal(ExternalUser $user): User
    {
        return static::query()->create([
            'name' => $user->firstName() . ' ' . $user->lastName(),
            'password' => bcrypt(str_random(10)),
        ]);
    }
}
