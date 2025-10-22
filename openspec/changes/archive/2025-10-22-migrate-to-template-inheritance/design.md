# Design: Complete Project Migration from Blade Components to Template Inheritance

## Context
The current project uses Laravel Blade components (`<x-layouts.*>`) across all layout systems (admin, app, guest, auth) which is causing data scoping issues in Laravel 12. Controller data is not properly accessible within the component slots, leading to "Undefined variable" errors despite correct data passing. This affects the entire application, not just the admin area.

## Goals / Non-Goals
- **Goals:**
  - Replace ALL Blade component layouts with traditional template inheritance
  - Ensure all controller data is accessible in ALL views across the entire application
  - Maintain existing functionality and styling across all layouts
  - Improve debugging and maintainability for the entire project
  - Provide consistent layout patterns across admin, app, guest, and auth areas
- **Non-Goals:**
  - Changing the overall interface design of any area
  - Modifying controller logic or business logic
  - Altering database structure or models
  - Changing the visual appearance or user experience

## Decisions
- **Template Inheritance Pattern**: Use `@extends('layouts.*')` and `@section` directives instead of Blade components across ALL layouts
- **Layout Structure**: Maintain the same HTML structure and CSS classes for all layouts
- **Data Access**: Controller data will be directly accessible in views without component scoping issues across the entire application
- **Navigation**: Keep existing navigation structure and routes for all areas
- **Styling**: Preserve all TailwindCSS classes and responsive design across all layouts
- **Consistency**: Apply the same migration pattern to all layout types (admin, app, guest, auth)

## Risks / Trade-offs
- **Risk**: Potential loss of component reusability across the entire application
  - **Mitigation**: Layouts are specific to their areas and not heavily reused; template inheritance is more predictable
- **Risk**: More verbose syntax compared to components across all views
  - **Mitigation**: Template inheritance is more predictable and easier to debug; consistency across the entire application
- **Risk**: Breaking existing functionality during migration across the entire application
  - **Mitigation**: Careful step-by-step migration with testing at each stage; migrate one layout type at a time
- **Risk**: Large scope of changes affecting the entire application
  - **Mitigation**: Systematic approach with comprehensive testing; maintain existing functionality throughout

## Migration Plan
1. Create new layout files for all layout types using template inheritance
2. Convert views by layout type (admin, app, guest, auth) systematically
3. Test data accessibility and functionality for each layout type
4. Migrate all views within each layout type
5. Remove all old component files
6. Validate all functionality across the entire application

## Open Questions
- Should we maintain any component-based patterns for reusable UI elements within layouts?
- Do we need to update any documentation about the layout system across the entire application?
- Are there any performance implications of switching from components to template inheritance across the entire application?
