# Proposal: Implement Hero Slider Management

## Why

The current hero section on the landing page (`home.blade.php` line 115) uses a hardcoded single static image (`newbackground2.webp`). This static approach prevents:
- Admin/content managers from managing multiple hero slides
- Non-technical users from updating hero content without code deployment
- Dynamic hero slider functionality to showcase multiple messages
- Flexibility to change hero content based on campaigns or seasonal promotions

The solution is to create a **Hero Slider Management System** with database-backed hero slides that can be managed through the admin dashboard, integrated with Splide.js for modern slider functionality.

## What Changes

- **Database**: Create `heroes` table to store hero slides with image management
- **Model**: Create `Hero` Eloquent model with Spatie MediaLibrary integration for images
- **Admin Interface**: Build complete CRUD interface for managing hero slides
- **Frontend**: Update `home.blade.php` to load dynamic hero slider from database
- **Media Management**: Integrate Spatie MediaLibrary for hero images with automatic conversions
- **Slider Integration**: Implement Splide.js for smooth slider functionality with autoplay
- **Permissions**: Add 'manage heroes' permission for content managers and admins
- **Seeding**: Create seeder with default hero slide for smooth migration

### Breaking Changes

None - This is a new feature addition with backward compatibility (fallback to static image if no heroes exist)

## Impact

### Affected Specs
- **content-management**: ADDED Requirements (Hero Management System)
- **web-platform**: MODIFIED Requirements (Modern Landing Page - Enhanced Home Page Experience)

### Affected Code
- **New Files**:
  - `database/migrations/YYYY_MM_DD_create_heroes_table.php`
  - `app/Models/Hero.php`
  - `app/Http/Controllers/Admin/HeroController.php`
  - `database/seeders/HeroSeeder.php`
  - `resources/views/admin/heroes/index.blade.php`
  - `resources/views/admin/heroes/create.blade.php`
  - `resources/views/admin/heroes/edit.blade.php`

- **Modified Files**:
  - `resources/views/home.blade.php` (line 115: hero section)
  - `app/Http/Controllers/HomeController.php` (add hero data loading)
  - `resources/js/app.js` (add hero slider Splide initialization)
  - `routes/web.php` (add admin routes for hero management)
  - `database/seeders/PermissionSeeder.php` (add 'manage heroes' permission)
  - `database/seeders/DatabaseSeeder.php` (call hero seeder)

### Dependencies
- **Spatie MediaLibrary v11** (already installed)
- **Spatie Laravel Permission** (already installed)
- **Splide.js** (already installed and integrated)
- **Alpine.js** (already installed)

### Integration Points
- Integrates with existing admin dashboard layout
- Uses existing permission system (Spatie Laravel Permission)
- Leverages existing media management (Spatie MediaLibrary)
- Follows existing patterns from product management
- Uses existing Splide.js configuration from product slider

## Success Criteria

- ✅ Admin can create, edit, and delete hero slides
- ✅ Hero slides display as slider on landing page with Splide.js
- ✅ Image upload works with Spatie MediaLibrary (thumb, medium, large conversions)
- ✅ Admin can manage slide order (drag & drop or manual)
- ✅ Admin can toggle active/inactive status for slides
- ✅ Only active slides display on frontend
- ✅ Auto-play slider functionality works smoothly
- ✅ Responsive design maintained across all devices
- ✅ Performance optimized with lazy loading
- ✅ Permission-based access control enforced
- ✅ Fallback to static image if no heroes exist
- ✅ Splide.js styling matches Lunaray cyan theme

## Timeline Estimate

**3-4 days** (streamlined implementation)

- **Day 1**: Database setup (migrations, model, seeder) + Admin controller & routes
- **Day 2**: Admin interface (CRUD views with image upload)
- **Day 3**: Frontend integration (home.blade.php with Splide.js)
- **Day 4**: Testing, polish, and documentation

