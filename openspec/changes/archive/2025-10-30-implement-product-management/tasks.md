# Implementation Tasks

## 1. Database Setup
- [x] 1.1 Create product_categories migration (name, slug, description, order, is_active, timestamps)
- [x] 1.2 Create products migration (product_category_id, name, slug, description, features JSON, order, is_featured, is_active, timestamps)
- [x] 1.3 Add foreign key constraint: products.product_category_id → product_categories.id ON DELETE CASCADE
- [x] 1.4 Create ProductCategory model with HasMedia trait
- [x] 1.5 Create Product model with HasMedia trait and BelongsTo relationship
- [x] 1.6 Define media collections: 'product_image' for products, 'category_icon' for categories (optional)
- [x] 1.7 Create ProductCategorySeeder with 9 default categories (Skincare, Bodycare, Haircare, Babycare, Mommycare, Mancare, Therapeutic, Decorative, Perfume)
- [x] 1.8 Create ProductSeeder with 3 default products (Body Wash, Facial Mask, Facial Scrub)
- [x] 1.9 Run migrations: `php artisan migrate`
- [x] 1.10 Run seeders: `php artisan db:seed --class=ProductCategorySeeder` and `php artisan db:seed --class=ProductSeeder`
- [x] 1.11 Update DatabaseSeeder to call ProductCategorySeeder and ProductSeeder

## 2. Admin Interface - Product Categories
- [x] 2.1 Create ProductCategoryController (admin) with resource methods (index, create, store, edit, update, destroy)
- [x] 2.2 Add validation rules for category (name required|max:100, slug unique, description nullable, order integer, is_active boolean)
- [x] 2.3 Implement automatic slug generation from name using Str::slug()
- [x] 2.4 Create admin/product-categories/index.blade.php with modern data table
- [x] 2.5 Add search functionality for categories (by name, slug)
- [x] 2.6 Add sorting by order, name, created date
- [x] 2.7 Create admin/product-categories/create.blade.php with modern form layout
- [x] 2.8 Create admin/product-categories/edit.blade.php (reuse create form layout)
- [x] 2.9 Add order management field (manual input or drag & drop using Alpine.js)
- [x] 2.10 Add toggle active/inactive functionality with visual indicator
- [x] 2.11 Add category statistics (product count per category)
- [x] 2.12 Implement bulk actions (activate, deactivate, delete)
- [x] 2.13 Add delete confirmation modal with warning if category has products
- [x] 2.14 Add success/error toast notifications

## 3. Admin Interface - Products
- [x] 3.1 Create ProductController (admin) with resource methods (index, create, store, edit, update, destroy)
- [x] 3.2 Add validation rules for product (name required|max:255, category_id required|exists, slug unique, description nullable, features json, order integer, is_featured boolean, is_active boolean)
- [x] 3.3 Implement automatic slug generation from name
- [x] 3.4 Create admin/products/index.blade.php with modern data table
- [x] 3.5 Add filter by category dropdown (with "All Categories" option)
- [x] 3.6 Add search functionality (by name, slug, description)
- [x] 3.7 Add sorting by order, name, category, created date
- [x] 3.8 Display product thumbnails in table using MediaLibrary conversions
- [x] 3.9 Create admin/products/create.blade.php with modern form layout
- [x] 3.10 Add category selection dropdown (populated from active categories)
- [x] 3.11 Add image upload field with drag & drop support using Spatie MediaLibrary
- [x] 3.12 Add image preview after upload
- [x] 3.13 Add features editor (JSON field with dynamic key-value pairs or simple textarea)
- [x] 3.14 Add order management field (manual input)
- [x] 3.15 Add toggle featured checkbox (with clear label)
- [x] 3.16 Add toggle active/inactive checkbox
- [x] 3.17 Create admin/products/edit.blade.php (reuse create form with image replacement)
- [x] 3.18 Implement bulk actions (feature, unfeature, activate, deactivate, delete)
- [x] 3.19 Add delete confirmation modal
- [x] 3.20 Add success/error toast notifications
- [x] 3.21 Handle MediaLibrary image upload in store() method
- [x] 3.22 Handle MediaLibrary image replacement in update() method
- [x] 3.23 Configure MediaLibrary conversions (thumb: 300x200, medium: 800x600, large: 1200x800)

## 4. Frontend Integration - Home Page
- [x] 4.1 Update HomeController to load active product categories with order
- [x] 4.2 Load products grouped by category (or load all active products)
- [x] 4.3 Pass categories and products to home view
- [x] 4.4 Update home.blade.php product tabs section (lines 93-105)
- [x] 4.5 Replace hardcoded tabs with dynamic loop over $categories
- [x] 4.6 Add Alpine.js data for active category tab (x-data="{ activeTab: '{{ $categories->first()?->slug ?? 'skincare' }}' }")
- [x] 4.7 Add x-on:click to tabs to update activeTab
- [x] 4.8 Add active/inactive styling based on activeTab === category.slug
- [x] 4.9 Update home.blade.php product cards section (lines 108-129)
- [x] 4.10 Replace hardcoded cards with dynamic loop over $products filtered by activeTab
- [x] 4.11 Use x-show="activeTab === '{{ $product->category->slug }}'" for filtering
- [x] 4.12 Display product image using getFirstMediaUrl('product_image', 'medium')
- [x] 4.13 Display product name from database
- [x] 4.14 Add fallback to defaults if no categories/products exist (@if($categories->isEmpty()))
- [x] 4.15 Optimize Alpine.js tab switching for smooth transitions
- [x] 4.16 Add loading states for images (lazy loading)
- [x] 4.17 Test responsive behavior (mobile, tablet, desktop)
- [x] 4.18 Add featured products section (optional - if needed)

## 5. Routes & Permissions
- [x] 5.1 Add admin routes for product category management (resource routes)
- [x] 5.2 Add admin routes for product management (resource routes)
- [x] 5.3 Group routes with 'permission:manage products' middleware
- [x] 5.4 Update PermissionSeeder to add 'manage products' permission
- [x] 5.5 Assign 'manage products' permission to content_manager role
- [x] 5.6 Assign 'manage products' permission to admin role
- [x] 5.7 Run seeder: `php artisan db:seed --class=PermissionSeeder` or migrate:fresh

## 6. Admin Navigation & UI
- [x] 6.1 Update admin.blade.php layout to add "Products" menu section
- [x] 6.2 Add submenu: "Product Categories" (with icon)
- [x] 6.3 Add submenu: "Products List" (with icon)
- [x] 6.4 Add active state highlighting for products menu
- [x] 6.5 Ensure menu is accessible only to users with 'manage products' permission

## 7. Testing & Validation
- [x] 7.1 Test product category CRUD operations (create, edit, delete)
- [x] 7.2 Test product CRUD operations (create with image, edit, delete)
- [x] 7.3 Test category deletion prevention when products exist
- [x] 7.4 Test image upload and MediaLibrary conversions
- [x] 7.5 Test image replacement on product edit
- [x] 7.6 Test frontend tab switching with Alpine.js
- [x] 7.7 Test product filtering by category on frontend
- [x] 7.8 Test fallback behavior when no data exists
- [x] 7.9 Test responsive design on mobile, tablet, desktop
- [x] 7.10 Test permission enforcement (only content_manager/admin can access)
- [x] 7.11 Test bulk actions functionality
- [x] 7.12 Test search and filter functionality
- [x] 7.13 Test ordering and featured functionality
- [x] 7.14 Validate all form inputs and error handling
- [x] 7.15 Test performance with multiple products and categories

## 8. Documentation & Cleanup
- [x] 8.1 Update CHANGELOG.md with new feature
- [x] 8.2 Update CONTEXT.md to reflect completion
- [x] 8.3 Add comments to complex code sections
- [x] 8.4 Create admin user guide for product management (optional)
- [x] 8.5 Take screenshots of admin interface for documentation
- [x] 8.6 Update README.md with product management feature

## 9. OpenSpec Finalization
- [x] 9.1 Validate proposal: `openspec validate implement-product-management --strict`
- [x] 9.2 Fix any validation errors
- [x] 9.3 Mark all tasks as complete
- [x] 9.4 Prepare for archiving after deployment

