<?php

namespace ArtARTs36\ULoginLaravel\Tests\Feature;

use ArtARTs36\ULoginLaravel\Http\Requests\AuthRequest;
use ArtARTs36\ULoginLaravel\Tests\TestCase;

final class AuthTest extends TestCase
{
    private const URL = '/user/token';

    /**
     * @covers \ArtARTs36\ULoginLaravel\Http\Controllers\UserController::auth
     */
    public function testByIncorrectToken(): void
    {
        $this
            ->post(static::URL, [
                AuthRequest::FIELD_TOKEN => 'random_token',
            ])
            ->assertStatus(422);
    }
}
