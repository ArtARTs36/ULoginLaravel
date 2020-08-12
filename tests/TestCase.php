<?php

namespace ArtARTs36\ULoginLaravel\Tests;

use ArtARTs36\ULoginLaravel\Contracts\User;
use ArtARTs36\ULoginLaravel\Providers\ULoginAuthProvider;

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

    protected function getPackageProviders($app)
    {
        return [
            ULoginAuthProvider::class,
        ];
    }

    protected function makeUser(int $id): User
    {
        return new class($id) implements User {
            private $id;

            public function __construct(int $id)
            {
                $this->id = $id;
            }

            public function getId(): int
            {
                return $this->id;
            }
        };
    }
}
