<?php

declare(strict_types=1);

namespace Milenmk\LaravelRouteLabel;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;
use LogicException;
use Milenmk\LaravelRouteLabel\Traits\CompilesRoutes;

class LaravelRouteLabelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Extend Route with macros for label()
        Route::macro('label', function ($label) {
            if (! isset($this->action['as'])) {
                throw new LogicException('Cannot set a route label without a route name. Use ->name() before ->label().');
            }

            $label = route_enum_value($label);

            if (! is_string($label)) {
                throw new InvalidArgumentException('Enum must be string backed.');
            }

            $this->action['label'] = $label;

            return $this;
        });

        Route::macro('getLabel', function () {
            return $this->action['label'] ?? null;
        });

        // Register @routeLink directive
        Blade::directive('routeLink', function ($expression) {
            $compiler = new class
            {
                use CompilesRoutes;

                public function render($expression): string
                {
                    // Call protected trait method within class scope
                    return $this->compileRouteLink($expression);
                }
            };

            return $compiler->render($expression);
        });

        // Register routeLabel() helper (optional, but can ensure it's loaded)
        if (! function_exists('routeLabel')) {
            require_once __DIR__.'/Helpers/route_label.php';
        }
    }

    public function register(): void
    {
        //
    }
}
