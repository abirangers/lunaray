# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Lunaray Beauty Factory is a comprehensive Laravel 11.x platform for the cosmetics industry. The application features:
- Hybrid authentication (Google OAuth + email/password for staff)
- Role-based access control with granular permissions
- Content management system with articles and categories
- AI chatbot integration with guest access support
- Product management system with image handling
- Modern UI with TailwindCSS 4 and Alpine.js
- Spec-driven development using OpenSpec

## Development Commands

### Setup and Installation
```bash
# Initial setup (all steps automated)
composer setup

# Development server with concurrent processes (Laravel, Queue, Vite)
composer dev

# Alternative: Individual processes
php artisan serve                    # Start Laravel server
npm run dev                          # Start Vite dev server
php artisan queue:work              # Start queue worker
```

### Database Operations
```bash
php artisan migrate                 # Run migrations
php artisan db:seed                 # Seed database
php artisan migrate:fresh --seed    # Fresh migration with seeding
```

### Testing
```bash
composer test                       # Run PHPUnit tests with config clear
php artisan test                    # Direct PHPUnit test execution
php artisan test --filter=ProductTest  # Run specific test class
vendor/bin/phpunit                  # Direct PHPUnit execution
vendor/bin/phpunit --filter testMethodName  # Run specific test method
```

### Media Management
```bash
php artisan queue:work              # Process media conversions
php artisan queue:work --queue=media-conversions  # Process specific queue
```

### Building Assets
```bash
npm run build                       # Production build
npm run dev                         # Development with hot reload
```

### OpenSpec Workflow
```bash
openspec list                       # List active changes
openspec show <change-id>          # View change details
openspec validate --strict         # Validate specifications
openspec archive <change-id> --yes # Archive completed changes
```

## Architecture Overview

### Authentication System
The application uses a **hybrid authentication system**:

1. **Public Users** (`role:user`)
   - Google OAuth via Laravel Socialite
   - Stored tokens: `google_id`, `google_token`, `google_refresh_token` (encrypted)
   - No password required

2. **Staff Users** (`role:content_manager`, `role:admin`)
   - Email/password authentication
   - Standard Laravel authentication
   - Separate login route at `/staff/login`

3. **Guest Users**
   - Can access chatbot without authentication
   - Session tracked via localStorage with IP address
   - 7-day session expiry with automated cleanup

### Permission System
Uses Spatie Laravel Permission with granular permissions:

**Key Permissions:**
- `view admin dashboard` - Content managers and admins
- `edit articles` - Content managers and admins
- `manage products` - Content managers and admins
- `manage users` - Admins only
- `manage system settings` - Admins only

**Middleware Usage:**
```php
Route::middleware(['auth', 'permission:view admin dashboard'])
Route::middleware(['auth', 'permission:manage users'])
```

### Models and Media Management

**Media-Enabled Models** (via Spatie MediaLibrary):
- `User` - Avatar collection with thumb conversion
- `Article` - Featured image collection with thumb/medium/large conversions
- `Product` - Product images with automatic conversions
- `ProductCategory` - Category images

**Important Media Pattern:**
```php
// Upload media
$model->addMediaFromRequest('field_name')
    ->toMediaCollection('collection_name');

// Retrieve media URL
$model->getFirstMediaUrl('collection_name', 'conversion_name');
```

### Key Models and Relationships

1. **User** (HasMedia, HasRoles)
   - `articles()` - HasMany Article
   - `activities()` - HasMany UserActivity
   - Media: avatar collection

2. **Article** (HasMedia)
   - `author` - BelongsTo User
   - `categories` - BelongsToMany Category
   - `richTextContent` - MorphOne RichText
   - Media: featured collection

3. **Product** (HasMedia)
   - `category` - BelongsTo ProductCategory
   - `order` field for per-category ordering
   - Media: products collection

4. **ChatSession**
   - Supports both authenticated and guest users
   - `user_id` nullable for guest sessions
   - `ip_address` for guest tracking
   - `session_id` stored in localStorage

### Frontend Architecture

**Stack:**
- TailwindCSS 4 with custom theme (OKLCH color space)
- Alpine.js for interactivity (v3.15.0)
- Sortable.js for drag-and-drop (product reordering)
- marked.js for markdown rendering (chatbot)
- Vite for asset bundling

**Custom Fonts:**
- MissRhinetta (cursive) - Landing page hero
- MilliardBold (sans-serif) - Landing page headers
- Adolphus (serif) - Landing page
- Inter (sans-serif) - Global
- Playfair Display (serif) - Global
- JetBrains Mono (monospace) - Code

**Template Strategy:**
- Uses Blade template inheritance (`@extends`, `@section`)
- NOT using Blade components for layouts
- Three main layouts: `app.blade.php`, `admin.blade.php`, `guest.blade.php`

### Testing Infrastructure

**Framework:** PHPUnit ^12.4 (migrated from Pest)

**Enhanced TestCase Features:**
- `RefreshDatabase` trait enabled
- Auto-seeds roles and permissions in `setUp()`
- SQLite in-memory database for fast tests
- Helper methods: `createAdmin()`, `createContentManager()`, `createUser()`

**Test Structure:**
```php
class ExampleTest extends TestCase
{
    public function testExample(): void
    {
        $admin = $this->createAdmin();
        // Test logic...
    }
}
```

### Product Management System

**Key Features:**
- Per-category ordering (order: 1, 2, 3, 4... per category)
- Drag-and-drop reordering via Sortable.js
- Quick move up/down buttons
- Auto-order assignment for new products
- Bulk actions (delete, toggle status)
- Image upload with automatic conversions

**Ordering Pattern:**
- Products ordered independently within each category
- New products auto-assigned to last position
- Reordering updates all products in category via transaction
- Manual order input removed from forms

### Chatbot Integration

**Architecture:**
- n8n webhook backend integration
- Database-backed chat history
- Session persistence (7 days)
- Rate limiting: 30 req/min (authenticated), 60 req/min (guests, IP-based)
- CSRF protection excluded for `/api/chatbot/*`

**Floating Chat Component:**
- Global availability across all pages (app, guest, admin layouts)
- Component: `resources/views/components/floating-chat.blade.php`
- Trigger: Luna avatar image (responsive: 20x20 → 24x24 → 36x36)
- Layout: Compact dropdown panel (max-w-xs, dynamic viewport height)
- Features: Lazy initialization, adaptive message area, fixed input field
- Online/offline status indicator on avatar (responsive: 2.5x2.5 → 3x3 → 4x4)
- Video introduction modal on first interaction
- No backend changes required (uses existing API endpoints)

**Video Introduction Feature:**
- First-time welcome video before chat interaction
- Smart detection via localStorage (`luna_intro_watched` flag)
- Autoplay with sound enabled by default
- Video formats: MP4 (H.264) + WebM (VP9) for browser compatibility
- Controls: Unmute/mute toggle, skip button (appears after 2s), close button
- Intelligent loading state: hides when video starts playing (not fixed delay)
- Graceful fallback for browsers blocking autoplay
- Responsive modal: 320px (mobile) to 2560px (desktop)
- Video location: `public/videos/luna-intro.mp4` and `luna-intro.webm`
- Smooth transitions and fade effects
- Multiple exit options: X button, skip button, backdrop click

**Guest Access:**
- Session ID stored in localStorage
- IP address tracking for rate limiting
- Automated cleanup via scheduled command
- No authentication required

## Important Development Patterns

### 1. Middleware Registration
All middleware aliases are registered in `bootstrap/app.php`:
```php
'role' => RoleMiddleware::class,
'permission' => PermissionMiddleware::class,
'chatbot.access' => ChatbotAccessMiddleware::class,
'chatbot.rate_limit' => ChatbotRateLimitMiddleware::class,
```

### 2. Trust Proxies for Ngrok
The application trusts all proxies (`'*'`) for ngrok development support. This is configured in `bootstrap/app.php`.

### 3. View Count Tracking
Uses cache-based batch updates with bot protection:
- Session-based duplicate prevention
- User agent filtering for bots
- Cache accumulation before database write
- No Redis dependency (uses Laravel cache)

### 4. Bulk Actions Pattern
Admin tables support bulk operations:
```php
Route::post('/resource/bulk-action', [Controller::class, 'bulkAction']);
```
Actions: delete, publish, unpublish, feature, unfeature

### 5. Media Conversions
Automatic image conversions defined in model:
```php
public function registerMediaConversions(?Media $media = null): void
{
    $this->addMediaConversion('thumb')->width(300)->height(200);
    $this->addMediaConversion('medium')->width(800)->height(600);
    $this->addMediaConversion('large')->width(1200)->height(800);
}
```

### 6. Route Organization
Routes organized by permission level:
- Public routes (no auth)
- User routes (`auth` middleware)
- Content manager routes (`auth` + `permission:edit articles`)
- Admin routes (`auth` + `permission:manage users`)
- **Note**: `/chat` route redirects to home (use floating chat component instead)

## Code Style Guidelines

### PHP/Laravel Conventions
- Follow PSR-12 coding standards
- Use type hints and return types
- Leverage Laravel helpers and facades
- Use Eloquent relationships over manual joins
- Implement model events for side effects
- Use Form Requests for complex validation

### Database Conventions
- Migration files: `YYYY_MM_DD_HHMMSS_action_table_name.php`
- Use `updateOrCreate()` in seeders for idempotency
- Add indexes for foreign keys and frequently queried columns
- Use transactions for multi-step operations

### Frontend Conventions
- TailwindCSS utility-first approach
- Alpine.js for component state (`x-data`, `x-model`)
- Fetch API for AJAX requests (not jQuery)
- Toast notifications for user feedback
- Loading states for async operations

### Testing Conventions
- Test file naming: `{Feature}Test.php` or `{Model}Test.php`
- Use factory methods when possible
- Clean up test data with `RefreshDatabase`
- Test both happy and error paths
- Test permission-based access control

## Common Pitfalls

### 1. Template Inheritance vs Components
❌ Don't use Blade components for layouts:
```php
<x-app-layout> // Don't do this
```

✅ Use template inheritance:
```php
@extends('layouts.app')
@section('content')
```

### 2. Media Handling
❌ Don't use old image columns:
```php
$article->featured_image // Removed in migration
```

✅ Use MediaLibrary:
```php
$article->getFirstMediaUrl('featured', 'large')
```

### 3. Authentication Guards
❌ Don't mix authentication types:
```php
// Public users don't have passwords
User::where('email', $email)->first()->password
```

✅ Check authentication type:
```php
if ($user->google_id) {
    // OAuth user
} else {
    // Email/password user
}
```

### 4. Permission Checks
❌ Don't use role checks directly in controllers:
```php
if (auth()->user()->hasRole('admin'))
```

✅ Use middleware and policies:
```php
Route::middleware(['permission:manage users'])
```

### 5. Queue Processing for Media
❌ Don't expect immediate media conversions:
```php
$article->addMedia($file)->toMediaCollection('featured');
$url = $article->getFirstMediaUrl('featured', 'large'); // May not exist yet
```

✅ Process queue or use queue:work:
```bash
php artisan queue:work
```

### 6. Floating Chat Component
❌ Don't create separate chat pages:
```php
Route::get('/new-chat', ...); // Don't do this
```

✅ Use the global floating component:
```php
// Already available in all layouts
@include('components.floating-chat')
```

❌ Don't duplicate chat UI:
```blade
<!-- Don't add chat forms manually -->
<div class="fixed ...">
    <form>...</form>
</div>
```

✅ Rely on the component (already included):
```blade
<!-- Component handles everything automatically -->
<!-- No manual integration needed -->
```

### 7. Video Introduction
❌ Don't manually check video watched status:
```javascript
// Don't check localStorage directly in other components
if (localStorage.getItem('luna_intro_watched')) { ... }
```

✅ Let the component handle it:
```blade
<!-- Component manages video state automatically -->
<!-- No external intervention needed -->
```

**To reset video for testing:**
```javascript
// In browser console
localStorage.removeItem('luna_intro_watched');
location.reload();
```

**Video specifications:**
- Format: MP4 (H.264) + WebM (VP9)
- Location: `public/videos/luna-intro.mp4` and `luna-intro.webm`
- Max size: < 5MB recommended
- Duration: 5-10 seconds optimal
- Aspect ratio: 16:9 or 1:1

## Brand Identity

**Colors (OKLCH):**
- Primary: Deep Blue `oklch(0.45 0.15 240)`
- Secondary: Light Blue `oklch(0.75 0.12 200)`
- Accent: Bright Blue `oklch(0.85 0.08 200)`
- Neutral: White/Light Gray `oklch(0.95 0.02 0)`

**Custom Utility Classes:**
```css
.font-rhinetta  /* MissRhinetta cursive */
.font-milliard  /* MilliardBold sans-serif */
.font-adolphus  /* Adolphus serif */
```

## OpenSpec Workflow

This project follows spec-driven development:

1. **Create Change Proposal** - Plan features in `openspec/changes/`
2. **Implement Changes** - Build according to specs
3. **Archive Completed** - Move to `openspec/changes/archive/`

**Active Specifications:**
- `user-management` (11 requirements)
- `content-management` (13 requirements)
- `chatbot-integration` (7 requirements)
- `web-platform` (13 requirements)
- `guest-chat-access` (8 requirements)

## Current Development Status

**Recently Completed:**
- Video Introduction Modal for Luna AI chatbot (first-time experience)
- Floating Chat Component responsive optimization (mobile-first design)
- Intelligent video loading state management (playback-based, not time-based)
- Dual video format support (MP4 + WebM) with browser fallbacks
- Floating Chat Component with global availability and Luna avatar trigger
- Product Order System 2.0 with drag-and-drop reordering (Sortable.js)
- Product Management System with complete CRUD
- PHPUnit migration from Pest
- Landing page hero redesign with custom fonts
- Guest chat access implementation

**Next Priorities:**
1. Product Management Tests (unit and feature tests)
2. Hero Slider Management (dynamic slider with database backend)
3. Content Blocks Management (dynamic content sections)
4. Settings Management (site-wide configuration)
5. Testimonials Feature (customer testimonials showcase)

## Useful File Locations

**Configuration:**
- `bootstrap/app.php` - Application bootstrap, middleware registration, proxy settings
- `config/services.php` - Third-party services (Google OAuth, n8n webhook)
- `routes/web.php` - All web routes with permission-based grouping

**Core Models:**
- `app/Models/User.php` - User with roles, permissions, media
- `app/Models/Article.php` - Article with rich text, categories, media
- `app/Models/Product.php` - Product with ordering, media
- `app/Models/ChatSession.php` - Chat with guest support

**Testing:**
- `tests/TestCase.php` - Enhanced base test case
- `phpunit.xml` - PHPUnit configuration
- `tests/Feature/` - Feature tests
- `tests/Unit/` - Unit tests

**Documentation:**
- `CONTEXT.md` - Current development focus and recent achievements
- `CHANGELOG.md` - Detailed change history
- `README.md` - Project overview and setup guide
- `docs/STYLE_GUIDE.md` - Complete "Beauty High Tech" design system documentation
- `docs/openspec-implementation-guide.md` - Admin dashboard proposals
- `public/videos/README.md` - Video introduction specifications and guidelines
- `.cursor/rules/core.mdc` - Cursor IDE rules

**Frontend Components:**
- `resources/views/components/floating-chat.blade.php` - Global chat with video intro
- `resources/views/layouts/app.blade.php` - Main application layout
- `resources/views/layouts/admin.blade.php` - Admin dashboard layout
- `resources/views/layouts/guest.blade.php` - Guest/landing page layout

---

*For detailed project context and current priorities, see CONTEXT.md*
*For change history and version tracking, see CHANGELOG.md*
*For setup instructions and features, see README.md*
*For design system guidelines and component reference, see docs/STYLE_GUIDE.md*
