<?php

namespace ArtARTs36\ULoginLaravel\Tests\Feature;

use ArtARTs36\ULoginLaravel\Tests\TestCase;

final class AuthTest extends TestCase
{
    private const URL = '/api/user/token?token=';

    /**
     * @covers \ArtARTs36\ULoginLaravel\Http\Controllers\UserController::auth
     */
    public function testByIncorrectToken(): void
    {
        $this
            ->postJson($this->url('random_token'))
            ->assertStatus(422);
    }

    /**
     * @param mixed $token
     * @return string
     */
    private function url($token): string
    {
        return static::URL . $token;
    }
}
