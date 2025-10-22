## Why

Lunaray Beauty Factory needs a comprehensive authentication system to support different user types: public users (who will use Google OAuth for easy access) and staff members (content managers and admins who need secure email/password authentication). The current Laravel setup only has basic authentication without role-based access control or hybrid authentication methods.

## What Changes

- **BREAKING**: Implement hybrid authentication system with two login methods
- **BREAKING**: Add role-based access control with three user roles (user, content_manager, admin)
- **BREAKING**: New authentication routes and controllers for both Google OAuth and email/password
- **BREAKING**: New middleware system for role-based route protection
- New Google OAuth integration using Laravel Socialite
- New user role management system using spatie/laravel-permission
- New login/logout UI components for both authentication methods
- New user registration flow for Google OAuth users
- New staff account creation system for admins

## Impact

- **Affected specs**: user-management (major updates), web-platform (new auth UI)
- **Affected code**: 
  - User model (role management)
  - Authentication controllers and routes
  - Middleware for role-based access
  - Frontend login/logout components
- **Affected systems**:
  - Google OAuth integration
  - Laravel's built-in authentication system
  - Role and permission management
  - Route protection system
- **New dependencies**: laravel/socialite for Google OAuth
- **Database changes**: Role and permission tables (already migrated from Fase 1)
