<?php

declare(strict_types=1);

namespace Milenmk\LaravelRouteLabel\Tests;

use Illuminate\Support\Facades\Route;
use Milenmk\LaravelRouteLabel\Tests\Enums\TestLabel;
use Milenmk\LaravelRouteLabel\Tests\Enums\TestRoute;
use PHPUnit\Framework\Attributes\Test;

class RouteLabelHelperTest extends TestCase
{
    #[Test]
    public function helper_returns_label()
    {
        Route::get('/users', fn () => 'users')->name('users.index')->label('Users');

        $this->assertEquals('Users', routeLabel('users.index'));
    }

    #[Test]
    public function helper_returns_null_for_unknown_route()
    {
        $this->assertNull(routeLabel('unknown.route'));
    }

    #[Test]
    public function helper_accepts_enum_route_name()
    {
        Route::get('/users', fn () => 'users')->name('users.index')->label('Users');

        $this->assertEquals('Users', routeLabel(TestRoute::UsersIndex));
    }

    #[Test]
    public function helper_returns_label_for_enum_label()
    {
        Route::get('/home', fn () => 'home')->name('home')->label(TestLabel::Homepage);

        $this->assertEquals('Homepage', routeLabel('home'));
    }
}
