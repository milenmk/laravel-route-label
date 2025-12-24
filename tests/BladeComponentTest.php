<?php

declare(strict_types=1);

namespace Milenmk\LaravelRouteLabel\Tests;

use Illuminate\Support\Facades\Blade;
use PHPUnit\Framework\Attributes\Test;

class BladeComponentTest extends TestCase
{
    #[Test]
    public function component_renders_label()
    {
        $html = Blade::render('<x-route-link route="users.index" class="btn" />');

        $this->assertStringContainsString('<a', $html);
        $this->assertStringContainsString('class="btn"', $html);
    }
}
