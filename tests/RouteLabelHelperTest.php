<?php

declare(strict_types=1);

namespace Milenmk\LaravelRouteLabel\Tests;

use Illuminate\Support\Facades\Route;
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
}
