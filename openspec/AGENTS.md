# OpenSpec Instructions

Instructions for AI coding assistants using OpenSpec for spec-driven development.

## TL;DR Quick Checklist

- Search existing work: `openspec spec list --long`, `openspec list` (use `rg` only for full-text search)
- Decide scope: new capability vs modify existing capability
- Pick a unique `change-id`: kebab-case, verb-led (`add-`, `update-`, `remove-`, `refactor-`)
- Scaffold: `proposal.md`, `tasks.md`, `design.md` (only if needed), and delta specs per affected capability
- Write deltas: use `## ADDED|MODIFIED|REMOVED|RENAMED Requirements`; include at least one `#### Scenario:` per requirement
- Validate: `openspec validate [change-id] --strict` and fix issues
- Request approval: Do not start implementation until proposal is approved

## Three-Stage Workflow

### Stage 1: Creating Changes
Create proposal when you need to:
- Add features or functionality
- Make breaking changes (API, schema)
- Change architecture or patterns  
- Optimize performance (changes behavior)
- Update security patterns

Triggers (examples):
- "Help me create a change proposal"
- "Help me plan a change"
- "Help me create a proposal"
- "I want to create a spec proposal"
- "I want to create a spec"

Loose matching guidance:
- Contains one of: `proposal`, `change`, `spec`
- With one of: `create`, `plan`, `make`, `start`, `help`

Skip proposal for:
- Bug fixes (restore intended behavior)
- Typos, formatting, comments
- Dependency updates (non-breaking)
- Configuration changes
- Tests for existing behavior

**Workflow**
1. Review `openspec/project.md`, `openspec list`, and `openspec list --specs` to understand current context.
2. Choose a unique verb-led `change-id` and scaffold `proposal.md`, `tasks.md`, optional `design.md`, and spec deltas under `openspec/changes/<id>/`.
3. Draft spec deltas using `## ADDED|MODIFIED|REMOVED Requirements` with at least one `#### Scenario:` per requirement.
4. Run `openspec validate <id> --strict` and resolve any issues before sharing the proposal.

### Stage 2: Implementing Changes
Track these steps as TODOs and complete them one by one.
1. **Read proposal.md** - Understand what's being built
2. **Read design.md** (if exists) - Review technical decisions
3. **Read tasks.md** - Get implementation checklist
4. **Implement tasks sequentially** - Complete in order
5. **Confirm completion** - Ensure every item in `tasks.md` is finished before updating statuses
6. **Update checklist** - After all work is done, set every task to `- [x]` so the list reflects reality
7. **Approval gate** - Do not start implementation until the proposal is reviewed and approved

### Stage 3: Archiving Changes
After deployment, create separate PR to:
- Move `changes/[name]/` â†’ `changes/archive/YYYY-MM-DD-[name]/`
- Update `specs/` if capabilities changed
- Use `openspec archive [change] --skip-specs --yes` for tooling-only changes
- Run `openspec validate --strict` to confirm the archived change passes checks

## Before Any Task

**Context Checklist:**
- [ ] Read relevant specs in `specs/[capability]/spec.md`
- [ ] Check pending changes in `changes/` for conflicts
- [ ] Read `openspec/project.md` for conventions
- [ ] Run `openspec list` to see active changes
- [ ] Run `openspec list --specs` to see existing capabilities

**Before Creating Specs:**
- Always check if capability already exists
- Prefer modifying existing specs over creating duplicates
- Use `openspec show [spec]` to review current state
- If request is ambiguous, ask 1â€“2 clarifying questions before scaffolding

### Search Guidance
- Enumerate specs: `openspec spec list --long` (or `--json` for scripts)
- Enumerate changes: `openspec list` (or `openspec change list --json` - deprecated but available)
- Show details:
  - Spec: `openspec show <spec-id> --type spec` (use `--json` for filters)
  - Change: `openspec show <change-id> --json --deltas-only`
- Full-text search (use ripgrep): `rg -n "Requirement:|Scenario:" openspec/specs`

## Quick Start

### CLI Commands

```bash
# Essential commands
openspec list                  # List active changes
openspec list --specs          # List specifications
openspec show [item]           # Display change or spec
openspec diff [change]         # Show spec differences
openspec validate [item]       # Validate changes or specs
openspec archive [change] [--yes|-y]      # Archive after deployment (add --yes for non-interactive runs)

# Project management
openspec init [path]           # Initialize OpenSpec
openspec update [path]         # Update instruction files

# Interactive mode
openspec show                  # Prompts for selection
openspec validate              # Bulk validation mode

# Debugging
openspec show [change] --json --deltas-only
openspec validate [change] --strict
```

### Command Flags

- `--json` - Machine-readable output
- `--type change|spec` - Disambiguate items
- `--strict` - Comprehensive validation
- `--no-interactive` - Disable prompts
- `--skip-specs` - Archive without spec updates
- `--yes`/`-y` - Skip confirmation prompts (non-interactive archive)

## Directory Structure

```
openspec/
â”œâ”€â”€ project.md              # Project conventions
â”œâ”€â”€ specs/                  # Current truth - what IS built
â”‚   â””â”€â”€ [capability]/       # Single focused capability
â”‚       â”œâ”€â”€ spec.md         # Requirements and scenarios
â”‚       â””â”€â”€ design.md       # Technical patterns
â”œâ”€â”€ changes/                # Proposals - what SHOULD change
â”‚   â”œâ”€â”€ [change-name]/
â”‚   â”‚   â”œâ”€â”€ proposal.md     # Why, what, impact
â”‚   â”‚   â”œâ”€â”€ tasks.md        # Implementation checklist
â”‚   â”‚   â”œâ”€â”€ design.md       # Technical decisions (optional; see criteria)
â”‚   â”‚   â””â”€â”€ specs/          # Delta changes
â”‚   â”‚       â””â”€â”€ [capability]/
â”‚   â”‚           â””â”€â”€ spec.md # ADDED/MODIFIED/REMOVED
â”‚   â””â”€â”€ archive/            # Completed changes
```

## Creating Change Proposals

### Decision Tree

```
New request?
â”œâ”€ Bug fix restoring spec behavior? â†’ Fix directly
â”œâ”€ Typo/format/comment? â†’ Fix directly  
â”œâ”€ New feature/capability? â†’ Create proposal
â”œâ”€ Breaking change? â†’ Create proposal
â”œâ”€ Architecture change? â†’ Create proposal
â””â”€ Unclear? â†’ Create proposal (safer)
```

### Proposal Structure

1. **Create directory:** `changes/[change-id]/` (kebab-case, verb-led, unique)

2. **Write proposal.md:**
```markdown
## Why
[1-2 sentences on problem/opportunity]

## What Changes
- [Bullet list of changes]
- [Mark breaking changes with **BREAKING**]

## Impact
- Affected specs: [list capabilities]
- Affected code: [key files/systems]
```

3. **Create spec deltas:** `specs/[capability]/spec.md`
```markdown
## ADDED Requirements
### Requirement: New Feature
The system SHALL provide...

#### Scenario: Success case
- **WHEN** user performs action
- **THEN** expected result

## MODIFIED Requirements
### Requirement: Existing Feature
[Complete modified requirement]

## REMOVED Requirements
### Requirement: Old Feature
**Reason**: [Why removing]
**Migration**: [How to handle]
```
If multiple capabilities are affected, create multiple delta files under `changes/[change-id]/specs/<capability>/spec.md`â€”one per capability.

4. **Create tasks.md:**
```markdown
## 1. Implementation
- [ ] 1.1 Create database schema
- [ ] 1.2 Implement API endpoint
- [ ] 1.3 Add frontend component
- [ ] 1.4 Write tests
```

5. **Create design.md when needed:**
Create `design.md` if any of the following apply; otherwise omit it:
- Cross-cutting change (multiple services/modules) or a new architectural pattern
- New external dependency or significant data model changes
- Security, performance, or migration complexity
- Ambiguity that benefits from technical decisions before coding

Minimal `design.md` skeleton:
```markdown
## Context
[Background, constraints, stakeholders]

## Goals / Non-Goals
- Goals: [...]
- Non-Goals: [...]

## Decisions
- Decision: [What and why]
- Alternatives considered: [Options + rationale]

## Risks / Trade-offs
- [Risk] â†’ Mitigation

## Migration Plan
[Steps, rollback]

## Open Questions
- [...]
```

## Spec File Format

### Critical: Scenario Formatting

**CORRECT** (use #### headers):
```markdown
#### Scenario: User login success
- **WHEN** valid credentials provided
- **THEN** return JWT token
```

**WRONG** (don't use bullets or bold):
```markdown
- **Scenario: User login**  âŒ
**Scenario**: User login     âŒ
### Scenario: User login      âŒ
```

Every requirement MUST have at least one scenario.

### Requirement Wording
- Use SHALL/MUST for normative requirements (avoid should/may unless intentionally non-normative)

### Delta Operations

- `## ADDED Requirements` - New capabilities
- `## MODIFIED Requirements` - Changed behavior
- `## REMOVED Requirements` - Deprecated features
- `## RENAMED Requirements` - Name changes

Headers matched with `trim(header)` - whitespace ignored.

#### When to use ADDED vs MODIFIED
- ADDED: Introduces a new capability or sub-capability that can stand alone as a requirement. Prefer ADDED when the change is orthogonal (e.g., adding "Slash Command Configuration") rather than altering the semantics of an existing requirement.
- MODIFIED: Changes the behavior, scope, or acceptance criteria of an existing requirement. Always paste the full, updated requirement content (header + all scenarios). The archiver will replace the entire requirement with what you provide here; partial deltas will drop previous details.
- RENAMED: Use when only the name changes. If you also change behavior, use RENAMED (name) plus MODIFIED (content) referencing the new name.

Common pitfall: Using MODIFIED to add a new concern without including the previous text. This causes loss of detail at archive time. If you arenâ€™t explicitly changing the existing requirement, add a new requirement under ADDED instead.

Authoring a MODIFIED requirement correctly:
1) Locate the existing requirement in `openspec/specs/<capability>/spec.md`.
2) Copy the entire requirement block (from `### Requirement: ...` through its scenarios).
3) Paste it under `## MODIFIED Requirements` and edit to reflect the new behavior.
4) Ensure the header text matches exactly (whitespace-insensitive) and keep at least one `#### Scenario:`.

Example for RENAMED:
```markdown
## RENAMED Requirements
- FROM: `### Requirement: Login`
- TO: `### Requirement: User Authentication`
```

## Troubleshooting

### Common Errors

**"Change must have at least one delta"**
- Check `changes/[name]/specs/` exists with .md files
- Verify files have operation prefixes (## ADDED Requirements)

**"Requirement must have at least one scenario"**
- Check scenarios use `#### Scenario:` format (4 hashtags)
- Don't use bullet points or bold for scenario headers

**Silent scenario parsing failures**
- Exact format required: `#### Scenario: Name`
- Debug with: `openspec show [change] --json --deltas-only`

### Validation Tips

```bash
# Always use strict mode for comprehensive checks
openspec validate [change] --strict

# Debug delta parsing
openspec show [change] --json | jq '.deltas'

# Check specific requirement
openspec show [spec] --json -r 1
```

## Happy Path Script

```bash
# 1) Explore current state
openspec spec list --long
openspec list
# Optional full-text search:
# rg -n "Requirement:|Scenario:" openspec/specs
# rg -n "^#|Requirement:" openspec/changes

# 2) Choose change id and scaffold
CHANGE=add-two-factor-auth
mkdir -p openspec/changes/$CHANGE/{specs/auth}
printf "## Why\n...\n\n## What Changes\n- ...\n\n## Impact\n- ...\n" > openspec/changes/$CHANGE/proposal.md
printf "## 1. Implementation\n- [ ] 1.1 ...\n" > openspec/changes/$CHANGE/tasks.md

# 3) Add deltas (example)
cat > openspec/changes/$CHANGE/specs/auth/spec.md << 'EOF'
## ADDED Requirements
### Requirement: Two-Factor Authentication
Users MUST provide a second factor during login.

#### Scenario: OTP required
- **WHEN** valid credentials are provided
- **THEN** an OTP challenge is required
EOF

# 4) Validate
openspec validate $CHANGE --strict
```

## Multi-Capability Example

```
openspec/changes/add-2fa-notify/
â”œâ”€â”€ proposal.md
â”œâ”€â”€ tasks.md
â””â”€â”€ specs/
    â”œâ”€â”€ auth/
    â”‚   â””â”€â”€ spec.md   # ADDED: Two-Factor Authentication
    â””â”€â”€ notifications/
        â””â”€â”€ spec.md   # ADDED: OTP email notification
```

auth/spec.md
```markdown
## ADDED Requirements
### Requirement: Two-Factor Authentication
...
```

notifications/spec.md
```markdown
## ADDED Requirements
### Requirement: OTP Email Notification
...
```

## Best Practices

### Simplicity First
- Default to <100 lines of new code
- Single-file implementations until proven insufficient
- Avoid frameworks without clear justification
- Choose boring, proven patterns

### Complexity Triggers
Only add complexity with:
- Performance data showing current solution too slow
- Concrete scale requirements (>1000 users, >100MB data)
- Multiple proven use cases requiring abstraction

### Clear References
- Use `file.ts:42` format for code locations
- Reference specs as `specs/auth/spec.md`
- Link related changes and PRs

### Capability Naming
- Use verb-noun: `user-auth`, `payment-capture`
- Single purpose per capability
- 10-minute understandability rule
- Split if description needs "AND"

### Change ID Naming
- Use kebab-case, short and descriptive: `add-two-factor-auth`
- Prefer verb-led prefixes: `add-`, `update-`, `remove-`, `refactor-`
- Ensure uniqueness; if taken, append `-2`, `-3`, etc.

## Tool Selection Guide

| Task | Tool | Why |
|------|------|-----|
| Find files by pattern | Glob | Fast pattern matching |
| Search code content | Grep | Optimized regex search |
| Read specific files | Read | Direct file access |
| Explore unknown scope | Task | Multi-step investigation |

## Error Recovery

### Change Conflicts
1. Run `openspec list` to see active changes
2. Check for overlapping specs
3. Coordinate with change owners
4. Consider combining proposals

### Validation Failures
1. Run with `--strict` flag
2. Check JSON output for details
3. Verify spec file format
4. Ensure scenarios properly formatted

### Missing Context
1. Read project.md first
2. Check related specs
3. Review recent archives
4. Ask for clarification

## Quick Reference

### Stage Indicators
- `changes/` - Proposed, not yet built
- `specs/` - Built and deployed
- `archive/` - Completed changes

### File Purposes
- `proposal.md` - Why and what
- `tasks.md` - Implementation steps
- `design.md` - Technical decisions
- `spec.md` - Requirements and behavior

### CLI Essentials
```bash
openspec list              # What's in progress?
openspec show [item]       # View details
openspec diff [change]     # What's changing?
openspec validate --strict # Is it correct?
openspec archive [change] [--yes|-y]  # Mark complete (add --yes for automation)
```

Remember: Specs are truth. Changes are proposals. Keep them in sync.

## Repository Guidance (from CLAUDE.md)

This guidance now applies to all AI coding assistants working with this repository.

## Project Overview

Lunaray Beauty Factory is a comprehensive Laravel 11.x platform for the cosmetics industry. The application features:
- Unified email/password authentication for all users
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
The application uses **email/password authentication** for all users:

1. **All Users** (public, staff, admins)
   - Email/password authentication
   - Standard Laravel authentication
   - Single unified login at `/login`
   - Password hashing with bcrypt

2. **Guest Users**
   - Can access chatbot without authentication
   - Session tracked via localStorage with IP address
   - 7-day session expiry with automated cleanup

**Role-based Access:**
- `role:user` - Public users with basic access
- `role:content_manager` - Content editing and management
- `role:admin` - Full system administration

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
- Trigger: Luna avatar image (responsive: 20x20 â†’ 24x24 â†’ 36x36)
- Layout: Compact dropdown panel (max-w-xs, dynamic viewport height)
- Features: Lazy initialization, adaptive message area, fixed input field
- Online/offline status indicator on avatar (responsive: 2.5x2.5 â†’ 3x3 â†’ 4x4)
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

### Responsive Design Conventions
- **Mobile-First Approach** - Start with mobile base styles, scale up with breakpoints
- **Progressive Enhancement** - Base functionality on mobile, enhanced features on desktop
- **Breakpoint Strategy** - sm (640px), md (768px), lg (1024px), xl (1280px), 2xl (1536px)
- **Typography Scaling** - Progressive text sizing: `text-sm â†’ sm:text-base â†’ md:text-lg â†’ lg:text-xl`
- **Spacing Scale** - Consistent spacing progression: `p-4 â†’ sm:p-6 â†’ md:p-8 â†’ lg:p-12`
- **Touch Targets** - Minimum 44x44px for interactive elements on mobile (`min-w-[44px] min-h-[44px]`)
- **Touch Manipulation** - Add `touch-manipulation` class for better mobile tap response
- **Adaptive Layouts** - Use flexbox/grid with responsive breakpoints for layout shifts
- **Image Responsiveness** - Progressive height scaling: `h-48 â†’ sm:h-56 â†’ md:h-64 â†’ lg:h-72`
- **Viewport Units** - Use `dvh` (dynamic viewport height) for mobile browser compatibility
- **Conditional Display** - Use `hidden lg:block` or `lg:hidden` for responsive visibility
- **Breakpoint-Specific Alignment** - Example: `text-center sm:text-right` for mobile-centered, desktop-right

### Testing Conventions
- Test file naming: `{Feature}Test.php` or `{Model}Test.php`
- Use factory methods when possible
- Clean up test data with `RefreshDatabase`
- Test both happy and error paths
- Test permission-based access control

## Common Pitfalls

### 1. Template Inheritance vs Components
âŒ Don't use Blade components for layouts:
```php
<x-app-layout> // Don't do this
```

âœ… Use template inheritance:
```php
@extends('layouts.app')
@section('content')
```

### 2. Media Handling
âŒ Don't use old image columns:
```php
$article->featured_image // Removed in migration
```

âœ… Use MediaLibrary:
```php
$article->getFirstMediaUrl('featured', 'large')
```

### 3. Permission Checks
âŒ Don't use role checks directly in controllers:
```php
if (auth()->user()->hasRole('admin'))
```

âœ… Use middleware and policies:
```php
Route::middleware(['permission:manage users'])
```

### 4. Queue Processing for Media
âŒ Don't expect immediate media conversions:
```php
$article->addMedia($file)->toMediaCollection('featured');
$url = $article->getFirstMediaUrl('featured', 'large'); // May not exist yet
```

âœ… Process queue or use queue:work:
```bash
php artisan queue:work
```

### 5. Floating Chat Component
âŒ Don't create separate chat pages:
```php
Route::get('/new-chat', ...); // Don't do this
```

âœ… Use the global floating component:
```php
// Already available in all layouts
@include('components.floating-chat')
```

âŒ Don't duplicate chat UI:
```blade
<!-- Don't add chat forms manually -->
<div class="fixed ...">
    <form>...</form>
</div>
```

âœ… Rely on the component (already included):
```blade
<!-- Component handles everything automatically -->
<!-- No manual integration needed -->
```

### 6. Video Introduction
âŒ Don't manually check video watched status:
```javascript
// Don't check localStorage directly in other components
if (localStorage.getItem('luna_intro_watched')) { ... }
```

âœ… Let the component handle it:
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
- Home Page Responsive Optimization (Tagline & Products sections, mobile-first design)
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
- `config/services.php` - Third-party services (n8n webhook)
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
