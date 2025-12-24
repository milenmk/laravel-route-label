<?php

declare(strict_types=1);

namespace Milenmk\LaravelRouteLabel\Tests;

use Exception;
use Milenmk\LaravelRouteLabel\LaravelRouteLabelServiceProvider;
use Milenmk\LaravelRouteLabel\Tests\Enums\TestLabel;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->defineRoutes($this->app['router']);
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
        $router->get('/users', fn () => 'users')
            ->name('users.index')
            ->label('Users');

        $router->get('/users/{user}', fn () => 'user')
            ->name('users.show')
            ->label(fn ($params) => 'User '.($params['user'] ?? ''));

        $router->get('/users/{user}/posts/{post}', fn () => 'post')
            ->name('users.posts.show')
            ->label(fn ($params) => "Post {$params['post']} by User {$params['user']}");

        $router->get('/home', fn () => 'home')
            ->name('home')
            ->label(TestLabel::Homepage);

        $router->get('/posts', fn () => 'posts')
            ->name('posts.index')
            ->label(TestLabel::Users);
    }
}
