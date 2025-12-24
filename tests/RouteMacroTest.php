<?php

declare(strict_types=1);

namespace Milenmk\LaravelRouteLabel\Tests;

use Illuminate\Support\Facades\Route;
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
}
