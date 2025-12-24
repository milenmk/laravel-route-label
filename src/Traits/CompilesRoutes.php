<?php

declare(strict_types=1);

namespace Milenmk\LaravelRouteLabel\Traits;

use BackedEnum;

trait CompilesRoutes
{
    /**
     * Compile @routeLink('routeName', ['class' => 'btn', 'wire:navigate' => true]) into an <a> tag with attributes.
     */
    protected function compileRouteLink($expression): string
    {
        $args = $this->parseDirectiveArguments($expression);

        $routeNameExpr = $args[0] ?? $expression;
        $attributesExpr = $args[1] ?? '[]';

        return "<?php
            \$routeName = $routeNameExpr;
            \$attributes = $attributesExpr;
            \$attrString = '';
            foreach (\$attributes as \$key => \$value) {
                if (is_bool(\$value)) {
                    \$attrString .= \$value ? \" \$key\" : '';
                } else {
                    \$attrString .= \" \$key=\\\"\" . htmlspecialchars(\$value, ENT_QUOTES) . \"\\\"\";
                }
            }
            echo '<a href=\"' . route(\$routeName, [], false) . '\"' . \$attrString . '>' . routeLabel(\$routeName) . '</a>';
        ?>";
    }

    /**
     * Compile @routeLinkStart directive to open an <a> tag with attributes.
     */
    protected function compileRouteLinkStart($expression): string
    {
        $args = $this->parseDirectiveArguments($expression);

        $routeNameExpr = $args[0] ?? $expression;
        $attributesExpr = $args[1] ?? '[]';

        return "<?php
            \$routeName = $routeNameExpr;
            \$attributes = $attributesExpr;
            \$attrString = '';
            foreach (\$attributes as \$key => \$value) {
                if (is_bool(\$value)) {
                    \$attrString .= \$value ? \" \$key\" : '';
                } else {
                    \$attrString .= \" \$key=\\\"\" . htmlspecialchars(\$value, ENT_QUOTES) . \"\\\"\";
                }
            }
            echo '<a href=\"' . route(\$routeName, [], false) . '\"' . \$attrString . '>';
        ?>";
    }

    /**
     * Compile @routeLinkEnd directive to close an <a> tag.
     */
    protected function compileRouteLinkEnd(): string
    {
        return "<?php echo '</a>'; ?>";
    }

    /**
     * Parse directive arguments from expression string.
     */
    protected function parseDirectiveArguments($expression): array
    {
        $parts = explode(',', $expression, 2);
        $args = [];

        foreach ($parts as $part) {
            $part = trim($part);
            if (! empty($part)) {
                $args[] = $part;
            }
        }

        return $args;
    }

    /**
     * Resolve route label dynamically (string, enum, closure, or translation key).
     */
    protected function resolveRouteLabel(string|BackedEnum|callable $label, array $params = []): string
    {
        if ($label instanceof BackedEnum) {
            $label = $label->value;
        }

        if (is_callable($label)) {
            $label = $label($params);
        }

        if (is_string($label) && str_starts_with($label, 'trans:')) {
            $label = __(substr($label, 6), $params);
        }

        if (config('route-label.escape_html', true)) {
            $label = e($label);
        }

        return $label;
    }
}
