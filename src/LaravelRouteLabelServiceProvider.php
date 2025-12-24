<?php

declare(strict_types=1);

namespace Milenmk\LaravelRouteLabel;

use BackedEnum;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;
use LogicException;
use Milenmk\LaravelRouteLabel\Blade\RouteLinkComponent;
use Milenmk\LaravelRouteLabel\Traits\CompilesRoutes;
use UnitEnum;

class LaravelRouteLabelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'route-label');

        // Extend Route with macros for label()
        Route::macro('label', function ($label) {
            if (! isset($this->action['as'])) {
                throw new LogicException('Cannot set a route label without a route name. Use ->name() before ->label().');
            }

            if ($label instanceof BackedEnum) {
                $label = $label->value;
            }

            if (! is_string($label) && ! is_callable($label)) {
                throw new InvalidArgumentException('Label must be string, string-backed enum, or closure.');
            }

            $this->action['label'] = $label;

            return $this;
        });

        Route::macro('getLabel', function ($params = []) {
            $label = $this->action['label'] ?? null;

            if ($label === null) {
                return null;
            }

            if ($label instanceof BackedEnum) {
                $label = $label->value;
            } elseif ($label instanceof UnitEnum) {
                $label = $label->name;
            }

            if (is_callable($label)) {
                $label = $label($params);
            }

            if (is_string($label) && str_starts_with($label, 'trans:')) {
                $label = __(substr($label, 6), $params);
            }

            if ($label !== null && config('route-label.escape_html', true)) {
                $label = e($label);
            }

            return $label;
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

        // Register @routeLinkStart directive
        Blade::directive('routeLinkStart', function ($expression) {
            $compiler = new class
            {
                use CompilesRoutes;

                public function render($expression): string
                {
                    // Call protected trait method within class scope
                    return $this->compileRouteLinkStart($expression);
                }
            };

            return $compiler->render($expression);
        });

        // Register @routeLinkEnd directive
        Blade::directive('routeLinkEnd', function () {
            $compiler = new class
            {
                use CompilesRoutes;

                public function render(): string
                {
                    // Call protected trait method within class scope
                    return $this->compileRouteLinkEnd();
                }
            };

            return $compiler->render();
        });

        // Register Blade component
        Blade::component('route-link', RouteLinkComponent::class);

        // Ensure helper is loaded
        if (! function_exists('routeLabel')) {
            require_once __DIR__.'/Helpers/route_label.php';
        }

        if (! function_exists('route_enum_value')) {
            require_once __DIR__.'/Helpers/enum_value.php';
        }
    }

    public function register(): void
    {
        //
    }
}
