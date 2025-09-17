<?php

declare(strict_types=1);

namespace Milenmk\LaravelRouteLabel\Traits;

trait CompilesRoutes
{
    /**
     * Compile @routeLink('routeName', ['class' => 'btn', 'wire:navigate' => true]) into an <a> tag with attributes.
     */
    protected function compileRouteLink($expression): string
    {
        // Parse the expression to extract route name and attributes
        $args = $this->parseDirectiveArguments($expression);

        $routeName = $args[0] ?? $expression;
        $attributes = $args[1] ?? [];

        // Build the attributes string
        $attrString = '';
        foreach ($attributes as $key => $value) {
            if (is_bool($value)) {
                $attrString .= $value ? " $key" : '';
            } else {
                $attrString .= " $key=\"$value\"";
            }
        }

        return "<?php echo '<a href=\"'.route({$routeName}).'\"{$attrString}>'.routeLabel({$routeName}).'</a>'; ?>";
    }

    /**
     * Parse directive arguments from expression string.
     */
    protected function parseDirectiveArguments($expression): array
    {
        // Simple parsing: split by comma and evaluate each part
        $parts = explode(',', $expression, 2);
        $args = [];

        foreach ($parts as $part) {
            $part = trim($part);
            if (empty($part)) {
                continue;
            }

            // Use eval to parse PHP expressions (be careful with security)
            $args[] = eval("return $part;");
        }

        return $args;
    }
}
