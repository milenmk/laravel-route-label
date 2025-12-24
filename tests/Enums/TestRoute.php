<?php

declare(strict_types=1);

namespace Milenmk\LaravelRouteLabel\Tests\Enums;

enum TestRoute: string
{
    case UsersIndex = 'users.index';
    case Home = 'home';
}
