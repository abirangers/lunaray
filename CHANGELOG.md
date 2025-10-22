# Changelog

All notable changes to Lunaray Beauty Factory project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Changelog and context tracking system
- Project documentation improvements

## [2025-10-22] - Content Management System Implementation

### Added
- Complete article management system with CRUD operations
- Category management system with color coding
- Rich text editor integration using tonysm/rich-text-laravel
- SEO features with ralphjsmit/laravel-seo package
- Content manager dashboard with analytics and statistics
- Article search and filtering functionality
- Featured articles system
- Article view counting and analytics
- Content management permissions and authorization
- Responsive article listing and detail pages
- Image upload and management for articles
- Article status management (draft/published)
- Category-based article organization

### Changed
- Updated database schema with articles, categories, and pivot tables
- Enhanced user model with article relationships
- Improved admin navigation with content management links
- Updated permission system for content management access

### Fixed
- Data scoping issues with Blade components
- Template inheritance migration for stable data access
- Permission-based route protection for admin dashboard

### Security
- Implemented proper authorization for content management
- Added input validation and sanitization for articles
- Enhanced file upload security for images
- Permission-based access control for content operations

## [2025-10-22] - Template Inheritance Migration

### Added
- Complete migration from Blade components to template inheritance
- New layout system using @extends and @section directives
- Stable data passing from controllers to views
- Consistent layout patterns across all areas

### Changed
- Migrated all layouts from <x-layouts.*> to @extends('layouts.*')
- Updated all views to use template inheritance syntax
- Converted admin, app, guest, and auth layout systems
- Replaced component slots with @section directives

### Removed
- All Blade component layout files
- Component-based layout architecture
- Data scoping issues with undefined variables

### Fixed
- Undefined variable errors in admin dashboard
- Data accessibility issues across all views
- Layout consistency problems
- Template inheritance stability

## [2025-10-22] - OpenSpec Archive Management

### Added
- Automated change archiving system
- Spec validation and compliance checking
- Change completion tracking

### Changed
- Archived completed changes to archive directory
- Updated task status tracking
- Improved change management workflow

### Fixed
- Change archiving permission issues
- Spec validation conflicts
- Task completion status tracking

## [2025-10-22] - Chatbot Integration Implementation

### Added
- Complete chatbot integration system with n8n webhook
- Modern chat interface with real-time messaging using Alpine.js
- Chat history management and session persistence
- Administrative chat logging and monitoring dashboard
- Secure webhook communication with error handling and retry logic
- Responsive chat UI that matches site design
- Performance optimization for concurrent users
- Rate limiting (10 requests per minute per user)
- Typing indicators and smooth animations
- Quick questions functionality
- Offline handling with user-friendly messages

### Changed
- Updated user permissions to include 'use_chatbot'
- Enhanced middleware system with ChatbotAccessMiddleware
- Improved error handling with graceful fallbacks

### Fixed
- Webhook timeout and retry mechanisms
- Session management for chat persistence
- Mobile responsiveness for chat interface

### Security
- Implemented secure webhook communication with HTTPS
- Added user data protection and sanitization
- Enhanced rate limiting for chat requests
- Permission-based access control for chatbot features

## [2025-10-22] - Permission System Implementation

### Added
- Granular permission system using Spatie Laravel Permission
- Permission-based middleware for route protection
- Blade directive updates with `@can` permissions
- Stateless OAuth implementation for improved reliability
- Comprehensive permission testing and validation

### Changed
- Updated route middleware from `role:` to `permission:`
- Modified authentication flow to use stateless OAuth
- Enhanced error handling for OAuth failures

### Fixed
- InvalidStateException errors in Google OAuth
- Permission inheritance issues
- Route protection inconsistencies

### Security
- Implemented granular permission control
- Enhanced OAuth security with stateless flow
- Improved session management

## [2025-10-22] - Authentication System Implementation

### Added
- Hybrid authentication system (Google OAuth + Email/Password)
- Google OAuth integration using Laravel Socialite
- Staff authentication system with email/password
- Role-based access control (user, content_manager, admin)
- Authentication UI components
- Session management and security features
- User activity logging system

### Changed
- Updated user model structure
- Modified login flow for dual authentication
- Enhanced security measures for staff accounts

### Fixed
- Authentication flow issues
- User registration process
- Session handling problems

## [2025-10-21] - Laravel Migration

### Added
- Complete migration to Laravel 11.x framework
- TailwindCSS 4 integration
- Alpine.js for interactive components
- Laravel Blade Components architecture
- Modern UI/UX design system
- Responsive navigation system
- Article management system
- Content management capabilities
- Chatbot integration framework
- Web platform foundation

### Changed
- Migrated from previous framework to Laravel
- Updated project structure and architecture
- Implemented modern development practices

### Removed
- Legacy framework dependencies
- Outdated UI components
- Deprecated authentication methods

## [2025-10-20] - Project Initialization

### Added
- Project setup and configuration
- OpenSpec specification-driven development
- Initial project structure
- Development environment setup

---

## Legend

- **Added** for new features
- **Changed** for changes in existing functionality
- **Deprecated** for soon-to-be removed features
- **Removed** for now removed features
- **Fixed** for any bug fixes
- **Security** for security improvements

## References

- [OpenSpec Documentation](./openspec/AGENTS.md)
- [Project Context](./CONTEXT.md)
- [Archive Changes](./openspec/changes/archive/)
