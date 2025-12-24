<?php

declare(strict_types=1);

namespace Milenmk\LaravelRouteLabel\Tests;

use Exception;
use Illuminate\Support\Facades\Route;
use Milenmk\LaravelRouteLabel\LaravelRouteLabelServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->app['router']->get('/users', fn () => 'users')
            ->name('users.index')
            ->label('Users');

        $this->app['router']->get('/users/{user}', fn () => 'user')
            ->name('users.show')
            ->label(fn ($params) => "User {$params['user']}");

        $this->app['router']->get('/home', fn () => 'home')
            ->name('home')
            ->label('Homepage');
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelRouteLabelServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [];
    }

    protected function defineRoutes($router): void
    {
        // Define minimal routes needed for testing
        Route::get('/users', fn () => 'users')
            ->name('users.index')
            ->label('Users'); // must be string, enum, or closure

        Route::get('/users/{user}', fn () => 'user')
            ->name('users.show')
            ->label(fn ($params) => "User {$params['user']}");
    }
}
