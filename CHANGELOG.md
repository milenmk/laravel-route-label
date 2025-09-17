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
