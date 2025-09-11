<?php

if (! function_exists('route_enum_value')) {
    /**
     * Return the value of a BackedEnum, or string as-is.
     */
    function route_enum_value(mixed $value): ?string
    {
        if ($value instanceof BackedEnum) {
            return $value->value;
        }

        if (is_string($value)) {
            return $value;
        }

        return null;
    }
}
