<?php

declare(strict_types=1);

namespace Milenmk\LaravelRouteLabel\Traits;

trait CompilesRoutes
{
    /**
     * Compile @routeLink('routeName') into an <a> tag.
     */
    protected function compileRouteLink($expression): string
    {
        return "<?php echo '<a href=\"'.route($expression).'\">'.routeLabel($expression).'</a>'; ?>";
    }
}
