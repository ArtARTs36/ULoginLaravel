<?php

namespace ArtARTs36\ULoginLaravel\Tests\Unit;

use ArtARTs36\ULoginApi\Entities\User as ExternalProfile;
use ArtARTs36\ULoginApi\Support\Network;
use ArtARTs36\ULoginLaravel\Models\Profile;
use ArtARTs36\ULoginLaravel\Tests\TestCase;

/**
 * Class ProfileTest
 * @package ArtARTs36\ULoginLaravel\Tests\Unit
 */
class ProfileTest extends TestCase
{
    /**
     * @covers \ArtARTs36\ULoginLaravel\Models\Profile::createOfExternal
     */
    public function testCreateOfExternal(): void
    {
        $identity = '123456789';

        $external = new ExternalProfile(Network::VK, [
            'first_name' => 'Artem',
            'last_name' => 'Ukrainskiy',
            'identity' => $identity,
        ]);

        $profile = Profile::createOfExternal($external, $user = $this->makeUser(1));

        //

        self::assertEquals(Network::VK, $profile->network);
        self::assertEquals($user->getId(), $profile->user_id);
        self::assertEquals($identity, $profile->identity);
    }
}
