# Migrate Entire Project from Blade Components to Template Inheritance

## Why
The current project implementation using Blade components (`<x-layouts.*>`) across all layouts (admin, app, guest, auth) is causing persistent errors with undefined variables despite proper data passing from controllers. The Blade component approach in Laravel 12 appears to have compatibility issues with data scoping, making it difficult to maintain and debug across the entire application. Switching to traditional template inheritance (`@extends` and `@section`) will provide a more stable and predictable approach for all layout systems in the project.

## What Changes
- Replace ALL Blade component layouts (`<x-layouts.*>`) with traditional template inheritance
- Convert ALL views from component syntax to `@extends('layouts.*')` and `@section` directives
- Update admin, app, guest, and auth layout systems to use template inheritance
- Convert all views using `<x-layouts.admin>`, `<x-layouts.app>`, `<x-layouts.guest>`, `<x-layouts.auth>` to template inheritance
- Ensure all controller data is properly accessible in all views
- Maintain existing functionality while improving stability across the entire application

## Impact
- Affected specs: content-management, user-management, web-platform
- Affected code: All layout components in `resources/views/components/layouts/`, all views using layout components, entire layout structure
- Breaking change: Yes - changes from Blade components to template inheritance across entire project
- Dependencies: None - this is a comprehensive refactoring change
