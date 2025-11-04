# Product Management System - Quick Reference

## 🚀 Quick Start

### Access Admin Dashboard
1. **Login as Content Manager or Admin**:
   - Content Manager: `content@lunaray.com` / `content123456`
   - Admin: `admin@lunaray.com` / `admin123456`

2. **Navigate to Product Management**:
   - Product Categories: `/admin/product-categories`
   - Products: `/admin/products`

### View Landing Page
- Homepage: `/` - Dynamic product tabs and cards

---

## 📦 What's Included

### Database
- **Tables**: `product_categories`, `products`
- **Seeders**: 9 categories, 3 sample products
- **Migrations**: Foreign keys, indexes, timestamps

### Admin Features
- **Product Categories**: CRUD, bulk actions (activate, deactivate, delete)
- **Products**: CRUD, image upload, bulk actions (feature, unfeature, activate, deactivate, delete)
- **Search & Filter**: By name, slug, category
- **Sorting**: By order, name, date
- **Pagination**: 20 items per page

### Frontend Features
- **Dynamic Tabs**: Category-based filtering (Alpine.js)
- **Product Cards**: Images from MediaLibrary
- **Caching**: 1-hour cache for performance
- **Fallback**: Hardcoded content if DB empty

---

## 🛠️ Common Commands

### Clear Caches
```bash
php artisan cache:clear
php artisan route:clear
php artisan permission:cache-reset
```

### Re-seed Data
```bash
php artisan db:seed --class=ProductCategorySeeder
php artisan db:seed --class=ProductSeeder
```

### Fresh Start
```bash
php artisan migrate:fresh --seed
```

---

## 📁 Key Files

### Backend
- **Models**: `app/Models/{Product,ProductCategory}.php`
- **Controllers**: `app/Http/Controllers/Admin/{Product,ProductCategory}Controller.php`
- **HomeController**: `app/Http/Controllers/HomeController.php`
- **Seeders**: `database/seeders/{ProductCategory,Product}Seeder.php`
- **Routes**: `routes/web.php` (lines 94-105)

### Frontend
- **Landing Page**: `resources/views/home.blade.php`
- **Admin Layout**: `resources/views/layouts/admin.blade.php`
- **Category Views**: `resources/views/admin/product-categories/*.blade.php`
- **Product Views**: `resources/views/admin/products/*.blade.php`

---

## 🔒 Permissions

**Permission**: `manage products`  
**Roles**: Content Manager, Admin  
**Applied to**: All product routes (`/admin/product-categories/*`, `/admin/products/*`)

---

## 📊 Database Schema

### product_categories
- `id`, `name`, `slug` (unique), `description`
- `order` (default: 0), `is_active` (default: true)
- `created_at`, `updated_at`
- Media: `category_icon` (optional)

### products
- `id`, `product_category_id` (FK), `name`, `slug` (unique)
- `description`, `features` (JSON), `order` (default: 0)
- `is_featured` (default: false), `is_active` (default: true)
- `created_at`, `updated_at`
- Media: `product_image` (required) with conversions:
  - `thumb`: 300x200
  - `medium`: 800x600
  - `large`: 1200x900

---

## 💡 Tips

### For Content Managers
1. Create categories before products
2. Use "Generate" button for slugs
3. Use high-quality images (min 800x600, max 5MB)
4. Separate features with commas
5. Use order increments of 10 (10, 20, 30...)

### For Developers
1. Always clear cache after updates
2. Use `with('category')` for eager loading
3. Check `storage/logs/laravel.log` for errors
4. Use MediaLibrary conversions (don't resize manually)

---

## 🐛 Known Issues

### Deprecation Warning (FIXED ✅)
Changed `Media $media = null` to `?Media $media = null` in Product model.

---

## 📚 Full Documentation

For comprehensive documentation, see OpenSpec:
- **Proposal**: `openspec/changes/implement-product-management/proposal.md`
- **Tasks**: `openspec/changes/implement-product-management/tasks.md`
- **Design**: `openspec/changes/implement-product-management/design.md`

---

**OpenSpec ID**: `implement-product-management`  
**Status**: ✅ Implemented (103/103 tasks)  
**Last Updated**: October 30, 2025

