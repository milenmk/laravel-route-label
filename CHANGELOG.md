## v1.3.0

#### Published at: 2025-12-24

- [FEATURE] Added `<x-route-link />` Blade component for a more declarative approach to generating route links
    - Supports `route` name, optional `:params` array, and `:attributes` array for full customization
    - Boolean attributes (e.g., `wire:navigate`) are handled automatically
    - Works with dynamic route labels, closures, translations, and Enums
- [FEATURE] Extended route labels to support **closure-based dynamic labels** directly in route definitions
    - Example: `->label(fn($params) => "Edit {$params['user']->name}")`
    - Useful for runtime-generated link text (e.g., usernames)
- [FEATURE] Added support for **translation keys** in route labels using `trans:` prefix
    - Example: `->label('trans:routes.home')`
    - Automatically resolves translations from `resources/lang/<locale>/routes.php`
- [IMPROVEMENT] Enhanced `@routeLink` and block directives to handle **dynamic runtime expressions** in attributes
    - Previously only static strings were fully supported
    - Now PHP variables and expressions are safely evaluated
- [IMPROVEMENT] Unified helper function `routeLabel()` and blade directives with full support for:
    - Enums (string-backed)
    - Closures
    - Translation keys
    - Runtime attributes
- [IMPROVEMENT] Updated README with full usage examples for:
    - Blade component
    - Dynamic closure labels
    - Translation-based labels
    - Complex content with block directives
- [MAINTENANCE] Preserved backward compatibility for all previous Blade directives (`@routeLink`, `@routeLinkStart`, `@routeLinkEnd`)

## v1.2.1

#### Published at: 2025-09-18

- [FIX] Critical bug fix for `@routeLink` and `@routeLinkStart` directives - resolved "Undefined variable" error when using PHP variables in attribute arrays (e.g., `['class' => $class]`)
- [IMPROVEMENT] Changed argument parsing from compile-time eval to runtime evaluation to properly support template variables

## v1.2.0

#### Published at: 2025-09-17

- [FEATURE] Added block blade directives `@routeLinkStart` and `@routeLinkEnd` for complex link content
- [ENHANCEMENT] Support for links with images, multiple elements, and complex HTML structures
- [IMPROVEMENT] Full attribute support in block directives (CSS classes, Livewire, Alpine.js, data attributes)

## v1.1.1

#### Published at: 2025-09-17

- [FIX] Critical bug fix for extended `@routeLink` directive - resolved "Undefined constant" error when using route names in attribute parameter
- [FIX] Fixed route name quoting in generated PHP code to prevent PHP from treating route names as constants

## v1.1.0

#### Published at: 2025-09-17

- [ENHANCEMENT] Extended `@routeLink` blade directive to accept additional HTML attributes as a second parameter
- [FEATURE] Support for CSS classes, Livewire directives, Alpine.js directives, and custom data attributes
- [IMPROVEMENT] Boolean attributes are properly handled (added as attribute names when true)

## v1.0.2

#### Published at: 2025-09-17

- [FIX] Fixed macro registration to use the Route class instead of the Router facade, resolving the "Method 'label' not found" error when chaining ->label() on route definitions


## v1.0.1

#### Published at: 2025-09-11

- [FIX] Error `Call to protected method class@anonymous::compileRouteLink() ` when using the blade directive

## v1.0.0

#### Published at: 2025-09-11

- Initial release
