# Migration Tasks: Complete Project Layout Migration

## 1. Layout Components Migration
- [x] 1.1 Create `resources/views/layouts/admin.blade.php` using template inheritance
- [x] 1.2 Create `resources/views/layouts/app.blade.php` using template inheritance  
- [x] 1.3 Create `resources/views/layouts/guest.blade.php` using template inheritance
- [x] 1.4 Create `resources/views/layouts/auth.blade.php` using template inheritance
- [x] 1.5 Implement `@yield` directives for content sections (title, content, scripts) in all layouts
- [x] 1.6 Test all layouts rendering without data dependencies

## 2. Admin Views Migration
- [x] 2.1 Convert `resources/views/admin/dashboard.blade.php` from component to template inheritance
- [x] 2.2 Convert all admin article views (`index`, `create`, `edit`, `show`) to template inheritance
- [x] 2.3 Convert all admin category views to template inheritance
- [x] 2.4 Replace `<x-layouts.admin>` with `@extends('layouts.admin')` in all admin views
- [x] 2.5 Replace slot syntax with `@section` directives in all admin views
- [x] 2.6 Test admin dashboard with all controller data (`$stats`, `$recent_articles`, etc.)

## 3. App Views Migration
- [x] 3.1 Convert `resources/views/home.blade.php` from component to template inheritance
- [x] 3.2 Convert `resources/views/user/dashboard.blade.php` from component to template inheritance
- [x] 3.3 Convert `resources/views/user/chat.blade.php` from component to template inheritance
- [x] 3.4 Replace `<x-layouts.app>` with `@extends('layouts.app')` in all app views
- [x] 3.5 Replace slot syntax with `@section` directives in all app views

## 4. Guest Views Migration
- [x] 4.1 Convert any guest views using `<x-layouts.guest>` to template inheritance
- [x] 4.2 Replace `<x-layouts.guest>` with `@extends('layouts.guest')` in all guest views
- [x] 4.3 Replace slot syntax with `@section` directives in all guest views

## 5. Auth Views Migration
- [x] 5.1 Convert `resources/views/auth/google-login.blade.php` from component to template inheritance
- [x] 5.2 Convert all authentication views to template inheritance
- [x] 5.3 Replace `<x-layouts.auth>` with `@extends('layouts.auth')` in all auth views
- [x] 5.4 Replace slot syntax with `@section` directives in all auth views

## 6. Cleanup and Validation
- [x] 6.1 Remove all old component layout files from `resources/views/components/layouts/`
- [x] 6.2 Test all routes and functionality across the entire application
- [x] 6.3 Verify data passing from controllers to views in all layouts
- [x] 6.4 Clear view cache and test production-like environment
- [x] 6.5 Update documentation if needed

## 7. Testing and Verification
- [x] 7.1 Test admin dashboard with sample data
- [x] 7.2 Test article CRUD operations
- [x] 7.3 Test category CRUD operations
- [x] 7.4 Test user dashboard and chat functionality
- [x] 7.5 Test authentication flows (login, logout, Google OAuth)
- [x] 7.6 Test home page and guest functionality
- [x] 7.7 Verify responsive design and navigation across all layouts
- [x] 7.8 Test authentication and authorization across all areas
