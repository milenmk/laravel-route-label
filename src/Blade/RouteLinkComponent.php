<?php

declare(strict_types=1);

namespace Milenmk\LaravelRouteLabel\Blade;

use Illuminate\View\Component;

class RouteLinkComponent extends Component
{
    public string $route;
    public array $params;
    public string $class;
    public $attributes;

    public function __construct(string $route, array $params = [], string $class = '')
    {
        $this->route = $route;
        $this->params = $params;
        $this->class = $class ?: config('route-label.default_link_class');
        $this->attributes = $params['attributes'] ?? [];
    }

    public function render()
    {
        $label = routeLabel($this->route, $this->params);

        return view('route-label::components.route-link', [
            'label' => $label,
            'route' => $this->route,
            'params' => $this->params,
            'class' => $this->class,
            'attributes' => $this->attributes,
        ]);
    }
}
