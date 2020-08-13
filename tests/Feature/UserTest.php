<?php

namespace ArtARTs36\ULoginLaravel\Tests\Feature;

use ArtARTs36\ULoginApi\Api;
use ArtARTs36\ULoginApi\Entities\User;
use ArtARTs36\ULoginApi\Support\Network;
use ArtARTs36\ULoginLaravel\Http\Requests\AuthRequest;
use ArtARTs36\ULoginLaravel\Services\UserService;
use ArtARTs36\ULoginLaravel\Tests\TestCase;
use Illuminate\Http\Response;

final class UserTest extends TestCase
{
    public function testBadAttachProfile(): void
    {
        // without token

        $this
            ->postJson('/user/attach_profile')
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        // with not auth user

        $this
            ->postJson('/user/attach_profile', [
                AuthRequest::FIELD_TOKEN => '555555',
            ])
            ->assertStatus(Response::HTTP_FORBIDDEN);

        //

        $this
            ->actingAs($user = $this->makeUser(1))
            ->guard()
            ->setUser($user);

        // with incorrect token

        $this
            ->postJson('/user/attach_profile', [
                AuthRequest::FIELD_TOKEN => '555555',
            ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testGoodAttachProfile(): void
    {
        $this
            ->actingAs($user = $this->makeUser(1))
            ->guard()
            ->setUser($user);

        $this->instance(UserService::class, new class(app(Api::class)) extends UserService {
            public function getExternalUser(string $token)
            {
                return new User(Network::VK, [
                    'first_name' => 'Artem',
                    'last_name' => 'Ukrainskiy',
                    'identity' => '123456789',
                ]);
            }
        });

        //

        $this
            ->postJson('/user/attach_profile', [
                AuthRequest::FIELD_TOKEN => md5('555'),
            ])
            ->assertCreated();
    }
}
