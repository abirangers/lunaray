# Changelog

All notable changes to Lunaray Beauty Factory project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- **Keyboard Navigation System** - Desktop-only keyboard shortcuts for presentation mode on landing page
- **Sequential Section Navigation** - Ctrl+↓ for next section, Ctrl+↑ for previous section with smooth scroll animation
- **Direct Section Jumping** - Number keys 1-9 for instant navigation to specific sections (hero, tagline, products, etc.)
- **Quick Navigation Keys** - Home key jumps to hero section, End key jumps to contact section
- **Section ID System** - All landing page sections now have unique IDs for programmatic navigation
- **Presentation Optimization** - Silent navigation with no visual indicators for clean presentation experience
- **Alpine.js Navigation Component** - Lightweight keyboard handler with desktop detection (≥1024px width)
- **Smart Index Tracking** - Current section index automatically updates during sequential navigation
- **Edge Case Handling** - Prevents navigation beyond first/last sections with boundary checking
- **Home Page Responsive Optimization** - Complete mobile-first responsive design for tagline and products sections
- **Tagline Section Responsive** - Progressive typography (2xl → 6xl) and spacing optimization for all screen sizes
- **Products Section Header Responsive** - Adaptive alignment (center → right) and typography scaling for optimal mobile UX
- **Category Tabs Responsive** - Touch-friendly button sizes with progressive font scaling and flex-wrap layout
- **Product Cards Responsive** - Adaptive image heights (h-48 → h-72) and typography scaling for all viewports
- **Quote Section Responsive** - Multi-breakpoint typography scaling with adaptive quote formatting
- **Discover Button Responsive** - Desktop absolute positioning with mobile/tablet centered layout and touch optimization
- **Static Fallback Products Responsive** - Complete responsive treatment for fallback product display
- **Video Introduction Modal** - Luna AI introduction video plays before first chat interaction
- **Smart First-Time Experience** - Video modal shown only on first Luna avatar click, tracked via localStorage
- **Video Autoplay with Sound** - Introduction video plays automatically with audio enabled by default
- **Intelligent Loading State** - Loading indicator hides when video starts playing, not on fixed delay
- **Skip Button with Delay** - Skip intro button appears after 2 seconds to ensure key message delivery
- **Video Control Interface** - Unmute/mute toggle button with icon states and responsive design
- **Close Modal Options** - Multiple exit paths: close button (X), skip button, or click backdrop
- **Dual Video Format Support** - MP4 (H.264) for universal compatibility + WebM (VP9) for modern browsers
- **Graceful Autoplay Fallback** - Handles browser autoplay restrictions with fallback to user-initiated unmute
- **Video State Management** - Independent tracking for loading, muted, skip availability, and modal visibility
- **Smooth Transitions** - Fade in/out animations for modal, loading overlay, and skip button appearance
- **Responsive Video Modal** - Optimized for mobile (max-w-xs) through desktop (max-w-2xl) with touch-friendly controls
- **Video Event Handling** - Listeners for 'playing', 'ended', and 'loadedmetadata' events for accurate state management
- **localStorage Video Tracking** - `luna_intro_watched` flag prevents repetitive video playback for returning users
- **Video Directory Structure** - Created `/public/videos/` with comprehensive README for video specifications
- **Video Optimization Guide** - Documentation for compression, conversion, and browser compatibility requirements
- **Comprehensive Style Guide** - Complete "Beauty High Tech" design system documentation with 13 detailed sections
- **Design System Documentation** - Color palette, typography, spacing, components, shadows, animations, and layout patterns
- **Component Reference Library** - 10+ complete component examples with HTML/Tailwind code for hero, sections, cards, and forms
- **Typography System** - Detailed font usage guide for MissRhinetta, MilliardBold, Adolphus with size scales and weight patterns
- **Color System Documentation** - Complete color hierarchy with hex codes, Tailwind classes, and usage contexts
- **Spacing Guidelines** - Comprehensive padding, margin, gap, and max-width patterns with common combinations
- **Layout Patterns** - Full-width sections, grid layouts, flexbox patterns, and responsive strategies
- **Visual Effects Guide** - Glass morphism, backdrop blur, overlays, shadows, and z-index hierarchy
- **Tailwind Usage Patterns** - Most frequent utility combinations, responsive breakpoints, and best practices
- **Decorative Elements** - Futuristic graphics, hexagonal patterns, molecular diagrams documentation
- **Floating Chat Component** - Global chat component accessible from all pages with Luna avatar trigger
- **Lazy Chat Initialization** - Chat session only initialized on first open for improved performance
- **Adaptive Chat Layout** - Responsive chat panel with flexible message area and fixed input (max-w-xs, 500px height)
- **Global Chat Availability** - Floating chat integrated into all layouts (app, guest, admin)
- **Visual Status Indicator** - Online/offline status badge on Luna avatar trigger
- **Product Slider Integration** - Splide.js slider untuk produk di halaman home dengan per-category filtering
- **Dynamic Product Showcase** - Interactive product slider dengan autoplay, arrows, dan pagination
- **Responsive Product Display** - Breakpoints untuk desktop (4), tablet (2), mobile (1) produk per slide
- **Category-Aware Slider** - One slider per kategori dengan destroy & reinit saat switch kategori
- **Splide.js Integration** - Library slider modern dengan lazy loading dan touch swipe support
- **Custom Splide Styling** - Cyan theme Lunaray dengan hover effects dan responsive arrows
- **Product Order System 2.0** - Drag & drop product reordering with Sortable.js integration
- **Visual Product Reordering** - Intuitive drag & drop modal interface for per-category product ordering
- **Quick Move Buttons** - Up/down arrow buttons for single-position product moves in admin table
- **Sortable.js Integration** - Installed via npm and integrated with Alpine.js for smooth drag & drop
- **Auto-Order Assignment** - New products automatically assigned to last position in their category
- **Per-Category Ordering** - Independent ordering system for each product category (1, 2, 3, 4...)
- **Reorder Modal Interface** - Category selector dropdown with draggable product list and visual feedback
- **Real-time Order Updates** - AJAX-powered auto-save functionality without page reload
- **Product Order Routes** - New routes: `/admin/products/reorder`, `/admin/products/{product}/move-up`, `/admin/products/{product}/move-down`
- **Product Reorder Controller Methods** - `reorder()`, `moveUp()`, and `moveDown()` methods with DB transactions
- **Order Field Removal** - Removed manual order input from product create/edit forms for better UX
- **Order Information Display** - Informative blue boxes in forms explaining auto-ordering system

### Changed
- **Floating Chat Responsive Design** - Enhanced mobile responsiveness with tighter spacing and better breakpoints
- **Chat Avatar Sizing** - Progressive scaling: 20x20 (base) → 24x24 (sm) → 36x36 (md) for optimal mobile experience
- **Chat Status Indicator** - Refined sizing: 2.5x2.5 (base) → 3x3 (sm) → 4x4 (md) with better positioning
- **Chat Panel Height** - Improved max-height calculation using dvh (dynamic viewport height) for mobile browsers
- **Chat Message Area Padding** - Reduced from p-3 to p-2 (sm:p-3) for more content space on small screens
- **Chat Input Controls** - Optimized button sizes with min-w/h-[44px] for touch-friendly mobile interface
- **Chat Welcome Message** - Responsive icon and text sizing for better mobile readability
- **Video Modal Default Audio** - Changed from muted to unmuted by default for immediate sound playback
- **Loading Indicator Behavior** - Now tied to actual video playback start instead of fixed 2-second delay
- **Video Loading State** - Separated loading state from skip button availability for independent control
- **Loading Overlay Timing** - Fades out when video starts playing (0.5-1s) instead of after 2 seconds
- **Chat Route Behavior** - `/chat` route now redirects to home page (floating chat replaces standalone page)
- **Chat UI Location** - Migrated from standalone page to floating component with Luna avatar trigger
- **Chat Panel Sizing** - Optimized from max-w-md (448px) to max-w-xs (320px) for better screen real estate
- **Chat Messages Layout** - Changed from fixed height (h-96) to flexible layout (flex-1) for adaptive sizing
- **Product Display** - Replaced static grid dengan Splide.js slider untuk better UX dan responsive design
- **Product Limit** - Removed 4 products limit, menampilkan semua produk per kategori di slider
- **HomeController** - Updated untuk load semua active products tanpa limit per category
- **Product Order Management** - Replaced manual number input with visual drag & drop interface
- **Product Create/Edit Forms** - Removed order field input, replaced with informational display
- **Product Order Logic** - Changed from global ordering to per-category ordering system
- **Product Store Method** - Auto-assigns new products to last position (max order + 1) in category
- **Product Update Method** - Preserves existing order during product updates (no reset)

### Removed
- **Standalone Chat Page** - Removed duplicate Luna avatar from home.blade.php (now handled by global component)
- **Direct Chat Navigation** - Chat link navigation updated to use floating component instead of dedicated page

### Fixed
- **Video Loading UX Issue** - Fixed loading screen remaining visible while video plays in background
- **Video State Management** - Separated loading indicator from skip button delay for accurate loading representation
- **Video Playback Detection** - Added 'playing' event listener to detect actual video start, not just metadata load
- **Autoplay Fallback** - Improved error handling for browser autoplay restrictions with graceful loading state cleanup
- **Chat Input Visibility** - Fixed chat input being hidden when panel height reduced by using flexible layout
- **Chat Panel Responsiveness** - Fixed message area taking fixed height causing input overflow
- **Product Drag & Drop** - Fixed issue where product names didn't sync with order numbers after reordering
- **Product Order Sync** - Fixed Alpine.js reactivity by destroying and re-initializing Sortable after array updates
- **Sortable.js Class Names** - Fixed InvalidCharacterError by using single class names instead of multiple classes with spaces
- **Alpine.js Form Submission** - Fixed expression error in bulk actions form by using `@submit.prevent` with conditional submit
- **Sortable Visual Feedback** - Added proper CSS classes for drag states (ghost, chosen, drag) with dark mode support

- **Product Management System** - Complete CRUD system for product categories and products with admin interface
- **Product Categories CRUD** - Create, read, update, delete product categories with slug generation, ordering, and bulk actions
- **Products CRUD** - Complete product management with image upload (Spatie MediaLibrary), features (JSON), featured flag, and bulk operations
- **Dynamic Product Showcase** - Frontend integration with Alpine.js tab switching and cached data loading
- **Product Permissions** - 'manage products' permission assigned to content_manager and admin roles
- **Product Admin Navigation** - Added "Products" section in admin sidebar with submenu for categories and products
- **PHPUnit Testing Framework** - Migrated from Pest to PHPUnit for better IDE support and standard Laravel testing
- **Enhanced TestCase** - Added RefreshDatabase trait, role/permission seeding, and helper methods (createAdmin, createContentManager, createUser)
- **Test Infrastructure** - Complete PHPUnit setup with SQLite in-memory database for fast testing
- **Hero Section as Image** - Converted hero section from text content to full background image for future slider implementation
- **Landing Page Custom Fonts** - Integrated MissRhinetta, MilliardBold, and Adolphus custom fonts with responsive sizing
- **OpenSpec Implementation Guide** - Comprehensive documentation for all planned admin dashboard proposals and features (`docs/openspec-implementation-guide.md`)
- **Documentation System** - Created `docs/` folder with README and detailed implementation roadmap (5 major proposals planned)
- **Ngrok Support** - Added ngrok configuration to .gitignore and trust proxies middleware for development tunneling
- **Product Showcase Updates** - Added Facial Mask and Facial Scrub products to showcase section
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

### Product Management Implementation
- **Database Schema** - Created product_categories and products tables with proper indexes and foreign keys
- **ProductCategory Model** - Eloquent model with HasMedia trait, auto-slug generation, and scoped queries
- **Product Model** - Eloquent model with HasMedia, image conversions (thumb/medium/large), JSON features, and relationships
- **Product Seeders** - 9 default categories (Skincare, Bodycare, Haircare, etc.) and 3 sample products
- **ProductCategoryController** - Full CRUD with search, sorting, pagination, and bulk actions (activate, deactivate, delete)
- **ProductController** - Full CRUD with image upload, category filter, search, bulk actions, and MediaLibrary integration
- **Admin Views** - Modern card-based layouts for categories, table layout for products with thumbnails
- **Frontend Integration** - Dynamic product tabs with Alpine.js, cached data loading via HomeController
- **Route Protection** - All product routes protected with 'permission:manage products' middleware
- **Image Handling** - Automatic conversions (300x200 thumb, 800x600 medium, 1200x800 large) with responsive display

### Testing Framework Migration
- **Pest Removal** - Removed pestphp/pest and pestphp/pest-plugin-laravel dependencies
- **PHPUnit Installation** - Added phpunit/phpunit ^12.4 with all Sebastian Bergmann packages
- **Test Conversion** - Converted all Pest-style tests to PHPUnit class-based tests
- **TestCase Enhancement** - Added RefreshDatabase, auto-seeding, and user creation helpers
- **Configuration** - Updated phpunit.xml with SQLite in-memory database for fast testing
- **Verification** - All tests passing (2 passed, 2 assertions) with proper setup/teardown

### Landing Page Redesign Implementation
- **Hero Section Conversion** - Replaced text-based hero with dynamic image implementation ready for future slider feature
- **Image Tag Implementation** - Using HTML `<img>` tag instead of CSS background for better SEO and programmatic control
- **Responsive Hero Strategy** - Tailwind breakpoints: mobile/tablet (h-auto, no crop) vs desktop (h-screen, object-cover)
- **Fixed Ask Me Avatar** - Positioned avatar with fixed positioning (bottom-right, z-50) for persistent visibility
- **Custom Font Integration** - Added @font-face declarations for MissRhinetta (cursive), MilliardBold (sans-serif), Adolphus (serif)
- **Font Utility Classes** - Created responsive font classes (.font-rhinetta, .font-milliard, .font-adolphus) with mobile breakpoints
- **Animation Support** - Added clickEffect keyframe animation for Ask Me avatar
- **Product Updates** - Updated product showcase from Hair Conditioner/Shampoo to Facial Mask/Scrub

### Documentation System Implementation
- **Implementation Guide** - Created comprehensive 627-line guide covering 5 major proposals with database schemas, tasks, and priorities
- **Proposal Planning** - Documented Hero Slider, Product Management, Content Blocks, Settings, and Testimonials proposals
- **Priority Matrix** - Effort estimation and dependency mapping for all planned features
- **Technical Notes** - Integration guides for Spatie packages (MediaLibrary, Permission) and existing systems
- **Success Criteria** - Clear deliverables and testing checklist for each implementation phase

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
- **Hero Section Implementation** - Hero now uses `<img>` tag instead of CSS background for better SEO and easier management
- **Ask Me Avatar** - Changed from absolute to fixed positioning for persistent visibility during scroll
- **Hero Responsive Behavior** - Desktop uses full-screen height with object-cover, mobile/tablet shows full image without cropping
- **Product Categories Font Size** - Increased font size to 21px for better readability
- **Removed GA4 Configuration** - Cleaned up unused Google Analytics 4 config from services.php
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
