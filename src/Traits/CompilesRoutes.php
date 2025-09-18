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
        // Parse the expression to extract route name and attributes as strings
        $args = $this->parseDirectiveArguments($expression);

        $routeNameExpr = $args[0] ?? $expression;
        $attributesExpr = $args[1] ?? '[]';

        return "<?php
            \$routeName = {$routeNameExpr};
            \$attributes = {$attributesExpr};
            \$attrString = '';
            foreach (\$attributes as \$key => \$value) {
                if (is_bool(\$value)) {
                    \$attrString .= \$value ? \" \$key\" : '';
                } else {
                    \$attrString .= \" \$key=\\\"\" . htmlspecialchars(\$value, ENT_QUOTES) . \"\\\"\";
                }
            }
            echo '<a href=\"' . route(\$routeName) . '\"' . \$attrString . '>' . routeLabel(\$routeName) . '</a>';
        ?>";
    }

    /**
     * Compile @routeLinkStart directive to open an <a> tag with attributes.
     */
    protected function compileRouteLinkStart($expression): string
    {
        // Parse the expression to extract route name and attributes as strings
        $args = $this->parseDirectiveArguments($expression);

        $routeNameExpr = $args[0] ?? $expression;
        $attributesExpr = $args[1] ?? '[]';

        return "<?php
            \$routeName = {$routeNameExpr};
            \$attributes = {$attributesExpr};
            \$attrString = '';
            foreach (\$attributes as \$key => \$value) {
                if (is_bool(\$value)) {
                    \$attrString .= \$value ? \" \$key\" : '';
                } else {
                    \$attrString .= \" \$key=\\\"\" . htmlspecialchars(\$value, ENT_QUOTES) . \"\\\"\";
                }
            }
            echo '<a href=\"' . route(\$routeName) . '\"' . \$attrString . '>';
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
        // Simple parsing: split by comma, keep as strings for runtime evaluation
        $parts = explode(',', $expression, 2);
        $args = [];

        foreach ($parts as $part) {
            $part = trim($part);
            if (empty($part)) {
                continue;
            }

            // Keep as string for runtime evaluation instead of compile-time eval
            $args[] = $part;
        }

        return $args;
    }
}
