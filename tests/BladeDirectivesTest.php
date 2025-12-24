<?php

declare(strict_types=1);

namespace Milenmk\LaravelRouteLabel\Tests;

use Illuminate\Support\Facades\Blade;
use PHPUnit\Framework\Attributes\Test;

class BladeDirectivesTest extends TestCase
{
    #[Test]
    public function route_link_directive_renders_correctly()
    {
        $blade = Blade::render("@routeLink('users.index')", [
            'users' => [],
        ]);

        $this->assertStringContainsString('<a href="/users">', $blade);
        $this->assertStringContainsString('Users', $blade);
        $this->assertStringContainsString('</a>', $blade);
    }

    #[Test]
    public function route_link_with_attributes()
    {
        $blade = Blade::render("@routeLink('users.index', ['class' => 'btn'])");

        $this->assertStringContainsString('class="btn"', $blade);
        $this->assertStringContainsString('<a href="/users"', $blade);
        $this->assertStringContainsString('Users', $blade);
        $this->assertStringContainsString('</a>', $blade);
    }

    #[Test]
    public function route_link_start_and_end()
    {
        $blade = Blade::render("@routeLinkStart('users.index', ['class' => 'btn']) Content @routeLinkEnd");

        $this->assertStringContainsString('<a href="/users" class="btn"> Content </a>', $blade);
    }
}
