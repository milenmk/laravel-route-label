<?php

declare(strict_types=1);

return [
    // Default CSS class for links generated via the Blade component.
    'default_link_class' => 'text-blue-500 hover:underline',

    // Whether to escape HTML in route labels.
    'escape_html' => true,

    /*
     * Fallback behavior when a route label is missing.
     * Options: 'route_name' | 'null'
     */
    'missing_label_behavior' => 'route_name',
];
