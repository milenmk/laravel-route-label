<?php

namespace Milenmk\LaravelRouteLabel\Traits;

trait CompilesRoutes
{
    /**
     * Compile @routeLink('routeName') into an <a> tag.
     */
    protected function compileRouteLink($expression)
    {
        return "<?php echo '<a href=\"'.route({$expression}).'\">'.routeLabel({$expression}).'</a>'; ?>";
    }
}
