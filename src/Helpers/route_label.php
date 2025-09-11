<?php

declare(strict_types=1);

if (! function_exists('routeLabel')) {
    function routeLabel(string|BackedEnum $name): ?string
    {
        $name = route_enum_value($name);

        $route = app('router')->getRoutes()->getByName($name);

        if (! $route) {
            return null;
        }

        return $route->getLabel() ?? $name;
    }
}
