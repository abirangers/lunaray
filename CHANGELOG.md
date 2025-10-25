# Changelog

All notable changes to Lunaray Beauty Factory project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- **Guest Chat Access** - Complete implementation allowing guest users to access chat without authentication
- **Guest Session Management** - localStorage-based session persistence with 7-day expiry
- **Guest Database Tracking** - IP address tracking and session expiry management for guest users
- **Guest Rate Limiting** - IP-based rate limiting (60 requests/minute) for guest users
- **Guest Navigation** - Chat link added to guest layout navigation
- **Guest Cleanup System** - Automated cleanup of expired guest sessions with daily scheduled command
- **Guest Security** - CSRF protection exclusion for chatbot API routes, IP tracking for abuse prevention
- **Spatie MediaLibrary v11 Integration** - Complete migration from Intervention Image to Spatie MediaLibrary
- **Advanced Media Management** - Automatic image conversions (thumb, medium, large) with queue processing
- **Responsive Images** - Automatic responsive image generation for optimal loading performance
- **Image Optimization** - Built-in optimization with multiple format support (JPEG, PNG, WebP, AVIF)
- **Media Collections** - Organized media storage with collections (featured, gallery, avatar)
- **Queue Processing** - Background image processing for better performance and user experience
- **Migration Command** - `php artisan media:migrate` for seamless migration of existing images
- **Custom Properties** - Rich metadata support for media files
- **Database Cleanup** - Removed old `featured_image` and `avatar` columns after successful migration
- Enhanced view count tracking with session-based duplicate prevention
- Cache-based batch updates for improved performance (no Redis dependency)
- Bot protection for accurate view count tracking via user agent filtering
- Session-based duplicate prevention to avoid counting page refreshes
- Laravel cache integration for optimized database performance
- Comprehensive view count testing and validation system
- Author selection feature for article creation and editing
- Flexible author name input with default value from current user
- Author name display across all article views
- Changelog and context tracking system
- Project documentation improvements
- Navigation Articles redirect functionality
- Separate admin articles management route
- Comprehensive user profile management system
- Profile editing functionality with validation and security measures
- Avatar upload and management system with drag & drop support
- Activity tracking and profile statistics for all user types
- Profile navigation integration in all layouts
- Role-based profile features and permissions
- **Complete Chatbot MVP implementation with production-ready features**
- **Database persistence for all chat messages (user and bot)**
- **Enhanced n8n webhook integration with comprehensive error handling**
- **Advanced session management system with automatic cleanup**
- **Rate limiting middleware (30 requests/minute per user)**
- **Bot detection and filtering system**
- **Advanced chat UI features: message copy, auto-resize textarea, status indicators**
- **Chat reset functionality with confirmation dialog**
- **Optimistic UI implementation for immediate message display**
- **Comprehensive error handling with user-friendly messages**
- **Database optimization with proper indexing and cleanup policies**
- **Security measures: authentication, validation, and data protection**
- **Performance monitoring and logging system**

### Guest Chat Access Implementation
- **Database Schema Updates** - Added guest support to chat tables with nullable user_id, is_guest flag, IP tracking, and session expiry
- **Model Enhancements** - Updated ChatSession and ChatMessage models with guest-specific methods (isExpired, isGuest)
- **Route Configuration** - Removed authentication middleware from chat routes while maintaining rate limiting
- **Controller Updates** - Enhanced ChatbotController to handle both authenticated and guest users with session management
- **Middleware Updates** - Updated chatbot middleware to allow guest access with IP-based rate limiting
- **Frontend Integration** - Implemented localStorage management for guest session persistence across page refreshes
- **Security Enhancements** - Added CSRF protection exclusion for chatbot API routes and IP tracking for abuse prevention
- **Cleanup System** - Created automated cleanup command for expired guest sessions with daily scheduling
- **Navigation Updates** - Added chat link to guest layout navigation for seamless access

### Changed
- View count behavior now prevents duplicate counts within same user session
- View count updates now use cache-based batch processing for better performance
- Bot traffic is now filtered out for more accurate view count statistics
- Article creation and editing now supports custom author names
- Author display now uses custom author_name field with fallback to user name
- Navigation "Articles" now always points to public articles page regardless of user role
- Admin articles management now accessible via separate "Manage Articles" link
- ArticleController index method now always returns public articles view
- User model now supports additional profile fields (avatar, bio, phone, location, website, social_links)
- Profile management system now provides role-based features and statistics
- **Chatbot system enhanced with production-ready MVP implementation**
- **Chat interface upgraded with modern UI/UX and advanced features**
- **Database schema optimized with proper indexing for chat performance**
- **API endpoints enhanced with comprehensive validation and error handling**
- **Session management improved with automatic cleanup and retention policies**

### Fixed
- Fixed Article model SEO data generation error with toPlainText() method
- Fixed null content handling in article views
- Fixed cache-based view count increment logic for better reliability
- Fixed session handling for view count duplicate prevention
- Fixed bot detection method accessibility for testing purposes
- Fixed navigation redirect issue where admin users were redirected to admin articles page
- **Fixed chatbot session persistence across page refreshes**
- **Fixed chat message alignment (user right, bot left)**
- **Fixed keyboard shortcuts (Enter vs Shift+Enter) behavior**
- **Fixed chat reset functionality with proper session management**
- **Fixed message copy feature with visual feedback**
- **Fixed rate limiting and error handling in chatbot API**

### Technical Improvements
- Improved view count accuracy by implementing session-based tracking
- Enhanced system performance through cache-based batch updates
- Added comprehensive bot protection for accurate analytics
- Optimized database writes by reducing direct updates
- Implemented graceful fallback mechanisms for cache failures
- Improved navigation consistency across different user roles
- Enhanced admin interface with clearer separation between public and admin views
- Implemented comprehensive user profile management with avatar upload functionality
- Added activity tracking system for user actions and profile statistics
- Enhanced user experience with role-based profile features and navigation integration

## [2025-10-23] - Bulk Actions & Bug Fixes

### Added
- Complete bulk actions functionality for article management
- Toggle all checkbox with indeterminate state support
- Modern bulk actions UI with selected counter
- Toast notification system for user feedback
- Enhanced error handling and validation
- Comprehensive logging for debugging
- Fetch API integration for form submissions
- Success/error message display system
- Loading states with spinner animations

### Changed
- Updated Alpine.js component architecture for better state management
- Enhanced controller validation and error handling
- Improved form submission using modern fetch API
- Updated UI feedback system with better user experience
- Enhanced debugging capabilities with comprehensive logging

### Fixed
- Alpine.js scope errors for bulk actions variables
- Form data format issues causing validation errors
- Checkbox synchronization between select all and individual checkboxes
- Bulk actions form submission and data handling
- Error message display and user feedback
- JavaScript reference errors in Alpine.js components
- Controller validation and data processing
- UI state management and user interactions

### Technical Improvements
- Proper FormData API usage for form submissions
- Enhanced error handling with try-catch blocks
- Improved logging system for debugging
- Better validation rules and error messages
- Modern JavaScript async/await patterns
- Enhanced user experience with loading states

## [2025-10-23] - Admin Interface Redesign

### Added
- Modern minimalist admin interface with dark/light mode support
- Advanced data tables with search, filter, and bulk operations
- Enhanced form experience with floating labels and drag & drop
- Interactive dashboard with modern statistics cards
- Dark mode toggle with Alpine.js integration
- Custom TailwindCSS design system with OKLCH color palette
- Component classes for consistent modern styling
- Auto-save functionality for forms
- Image preview and drag & drop upload
- Export functionality for data tables
- Enhanced user management with role statistics
- Category management with color coding and live preview
- Article management with rich text editor and preview
- Modern card layouts with hover effects and animations

### Changed
- Redesigned admin layout with modern sidebar navigation
- Updated all admin pages to use modern component classes
- Enhanced dashboard with interactive statistics
- Improved form layouts with better UX patterns
- Updated table designs with advanced filtering
- Modernized authentication pages with minimalist design
- Enhanced user experience across all admin interfaces

### Fixed
- TailwindCSS build errors with component class definitions
- Duplicate header elements in admin pages
- Drag & drop functionality for image uploads
- Alpine.js component initialization issues
- Form validation and error handling

## [2025-10-23] - Public Pages Redesign

### Added
- Modern minimalist public pages design
- Responsive authentication pages (Google OAuth + Staff login)
- Enhanced home page with hero, features, stats, and CTA sections
- Redesigned chat interface with modern messaging UI
- Public article pages with clean card layouts
- Mobile optimization for all public pages
- SEO optimization with Laravel SEO package
- Meta tags, structured data, and social sharing
- Default image placeholders for articles
- Breadcrumb navigation for articles and categories
- Modern navigation with minimalist design

### Changed
- Updated guest layout with clean, minimalist design
- Enhanced authentication flow with modern UI
- Improved home page with complete landing page structure
- Redesigned chat interface with better UX
- Updated article pages with modern card design
- Enhanced mobile responsiveness across all pages
- Improved SEO with dynamic meta tags and structured data

### Fixed
- Authentication page styling issues
- Mobile responsiveness problems
- SEO meta tag implementation
- Image placeholder handling
- Navigation consistency across pages

### Security
- Enhanced SEO security with proper meta tag sanitization
- Improved authentication page security
- Better input validation for public forms

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
