# Implementation Tasks

## 1. Database Setup
- [ ] 1.1 Create heroes migration (name, slug, order, is_active, timestamps)
- [ ] 1.2 Create Hero model with HasMedia trait
- [ ] 1.3 Define media collection: 'hero_image' with automatic conversions
- [ ] 1.4 Configure MediaLibrary conversions (thumb: 300x200, medium: 800x600, large: 1920x1080)
- [ ] 1.5 Create HeroSeeder with default hero (newbackground2.webp from public)
- [ ] 1.6 Update DatabaseSeeder to call HeroSeeder
- [ ] 1.7 Run migrations: `php artisan migrate`
- [ ] 1.8 Run seeder: `php artisan db:seed --class=HeroSeeder`

## 2. Admin Interface - Heroes
- [ ] 2.1 Create HeroController (admin) with resource methods (index, create, store, edit, update, destroy)
- [ ] 2.2 Add validation rules (name required|max:255, slug unique, order integer, is_active boolean)
- [ ] 2.3 Implement automatic slug generation from name using Str::slug()
- [ ] 2.4 Create admin/heroes/index.blade.php with modern data table
- [ ] 2.5 Add thumbnail preview using MediaLibrary
- [ ] 2.6 Add sorting by order, name, created date
- [ ] 2.7 Create admin/heroes/create.blade.php with modern form layout
- [ ] 2.8 Create admin/heroes/edit.blade.php (reuse create form)
- [ ] 2.9 Add image upload field with drag & drop support
- [ ] 2.10 Add image preview after upload
- [ ] 2.11 Add order management field (manual input)
- [ ] 2.12 Add toggle active/inactive checkbox
- [ ] 2.13 Implement bulk actions (activate, deactivate, delete)
- [ ] 2.14 Add delete confirmation modal
- [ ] 2.15 Add success/error toast notifications
- [ ] 2.16 Handle MediaLibrary image upload in store() method
- [ ] 2.17 Handle MediaLibrary image replacement in update() method

## 3. Frontend Integration
- [ ] 3.1 Update HomeController to load active heroes ordered by order field
- [ ] 3.2 Pass heroes to home view
- [ ] 3.3 Update home.blade.php hero section (line 115)
- [ ] 3.4 Replace static image with Splide slider structure
- [ ] 3.5 Add Splide slider initialization in resources/js/app.js
- [ ] 3.6 Configure Splide with autoplay (6s), loop, arrows, pagination
- [ ] 3.7 Use large conversion for hero images
- [ ] 3.8 Add lazy loading for images
- [ ] 3.9 Add fallback to default image if no heroes exist
- [ ] 3.10 Apply custom Splide styling (cyan theme)
- [ ] 3.11 Ensure hero slider doesn't conflict with product slider
- [ ] 3.12 Test responsive behavior (mobile, tablet, desktop)

## 4. Routes & Permissions
- [ ] 4.1 Add admin routes for hero management (resource routes)
- [ ] 4.2 Group routes with 'permission:manage heroes' middleware
- [ ] 4.3 Update PermissionSeeder to add 'manage heroes' permission
- [ ] 4.4 Assign 'manage heroes' permission to content_manager role
- [ ] 4.5 Assign 'manage heroes' permission to admin role
- [ ] 4.6 Run seeder: `php artisan db:seed --class=PermissionSeeder`

## 5. Admin Navigation
- [ ] 5.1 Update admin.blade.php layout to add "Heroes" menu item
- [ ] 5.2 Add link to heroes index in sidebar
- [ ] 5.3 Add active state highlighting for heroes menu
- [ ] 5.4 Ensure menu is accessible only with 'manage heroes' permission

## 6. Testing & Validation
- [ ] 6.1 Test hero CRUD operations (create with image, edit, delete)
- [ ] 6.2 Test image upload and MediaLibrary conversions
- [ ] 6.3 Test image replacement on hero edit
- [ ] 6.4 Test frontend slider with multiple heroes
- [ ] 6.5 Test autoplay and navigation (arrows, pagination)
- [ ] 6.6 Test toggle active/inactive functionality
- [ ] 6.7 Test fallback when no active heroes exist
- [ ] 6.8 Test responsive design on mobile, tablet, desktop
- [ ] 6.9 Test permission enforcement
- [ ] 6.10 Test bulk actions
- [ ] 6.11 Test performance with multiple hero images
- [ ] 6.12 Verify no conflicts between hero and product sliders

## 7. Documentation & Cleanup
- [ ] 7.1 Update CHANGELOG.md
- [ ] 7.2 Update CONTEXT.md
- [ ] 7.3 Add code comments for complex sections
- [ ] 7.4 Update README.md if needed

## 8. OpenSpec Finalization
- [ ] 8.1 Validate proposal: `openspec validate implement-hero-slider-management --strict`
- [ ] 8.2 Fix any validation errors
- [ ] 8.3 Mark all tasks as complete when done
- [ ] 8.4 Prepare for archiving

