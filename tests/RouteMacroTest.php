<?php

declare(strict_types=1);

namespace Milenmk\LaravelRouteLabel\Tests;

use Illuminate\Support\Facades\Route;
use InvalidArgumentException;
use Milenmk\LaravelRouteLabel\Tests\Enums\TestLabel;
use PHPUnit\Framework\Attributes\Test;

class RouteMacroTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->defineRoutes(Route::getFacadeRoot());
    }

    #[Test]
    public function label_macro()
    {
        $route = Route::getRoutes()->getByName('users.index');
        $this->assertEquals('Users', $route->getLabel());
    }

    #[Test]
    public function closure_label()
    {
        $route = Route::getRoutes()->getByName('users.show');
        $this->assertEquals('User 42', $route->getLabel(['user' => 42]));
    }

    #[Test]
    public function enum_label()
    {
        Route::get('/posts', fn () => 'posts')->name('posts.index')->label(TestLabel::Users);

        $route = Route::getRoutes()->getByName('posts.index');
        $this->assertEquals('Users', $route->getLabel());
    }

    #[Test]
    public function closure_label_with_missing_params()
    {
        $route = Route::getRoutes()->getByName('users.show');
        $this->assertEquals('User ', $route->getLabel([]));
    }

    #[Test]
    public function label_macro_throws_exception_for_invalid_label_type()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Label must be string, string-backed enum, or closure.');

        Route::get('/invalid', fn () => 'invalid')->name('invalid')->label(123);
    }

    #[Test]
    public function closure_label_with_multiple_params()
    {
        $route = Route::getRoutes()->getByName('users.posts.show');
        $this->assertEquals('Post 5 by User 1', $route->getLabel(['user' => 1, 'post' => 5]));
    }
}
