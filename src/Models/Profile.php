<?php

namespace ArtARTs36\ULoginLaravel\Models;

use ArtARTs36\ULoginLaravel\Contracts\User;
use ArtARTs36\ULoginApi\Entities\User as ExternalProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $network
 * @property int $user_id
 * @property User $user
 * @property string $identity
 */
class Profile extends Model
{
    public const FIELD_NETWORK = 'network';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_IDENTITY = 'identity';

    protected $table = 'user_social_profiles';

    protected $fillable = [
        self::FIELD_NETWORK,
        self::FIELD_USER_ID,
        self::FIELD_IDENTITY,
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(config('ulogin.models.user'));
    }

    /**
     * @param ExternalProfile $external
     * @param User $user
     * @return static
     */
    public static function createOfExternal(ExternalProfile $external, User $user): self
    {
        return static::query()->create([
            static::FIELD_NETWORK => $external->network(),
            static::FIELD_USER_ID => $user->getId(),
            static::FIELD_IDENTITY => $external->identity(),
        ]);
    }
}
