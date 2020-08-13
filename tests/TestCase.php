<?php

namespace ArtARTs36\ULoginLaravel\Tests;

use ArtARTs36\ULoginLaravel\Contracts\User;
use ArtARTs36\ULoginLaravel\Providers\ULoginAuthProvider;
use ArtARTs36\ULoginLaravel\Support\UserOnULogin;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'testing']);

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->loadLaravelMigrations(['--database' => 'testing']);

        //$this->withFactories(__DIR__.'/../database/factories/');
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            ULoginAuthProvider::class,
        ];
    }

    /**
     * @param int $id
     * @return User
     */
    protected function makeUser(int $id): User
    {
        return new class(['id' => $id]) extends \Illuminate\Foundation\Auth\User implements User {
            use UserOnULogin;

            protected $fillable = [
                'id',
            ];

            public function getId(): int
            {
                return $this->id;
            }
        };
    }

    /**
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return auth()->guard(\config('ulogin.auth.guard'));
    }
}
