# OpenSpec Implementation Guide - Lunaray Beauty Factory

## 📋 Overview

Dokumen ini berisi **roadmap lengkap** untuk implementasi fitur admin dashboard dan dynamic content management di Lunaray Beauty Factory. Semua fitur saat ini masih **hardcoded** di `home.blade.php`, perlu dijadikan **dynamic** dan manageable via admin dashboard.

---

## 🎯 Proposal Roadmap

### Phase A - Core Dynamic Content (Priority: CRITICAL)
1. **implement-hero-slider-management** - Dynamic hero section
2. **implement-product-management** - Dynamic product categories & products

### Phase B - Content Management (Priority: HIGH)
3. **implement-content-blocks-management** - Dynamic content sections
4. **implement-settings-management** - Site configuration management

### Phase C - Enhancement (Priority: MEDIUM - Optional)
5. **add-testimonials-feature** - Customer testimonials system

---

## 📦 Detailed Proposals

---

## 1. implement-hero-slider-management

### Why
Current hero section menggunakan static image (`newbackground.webp`) yang hardcoded di code. Tidak ada cara untuk admin mengubah hero content, swap images, atau manage multiple slides untuk future slider feature.

### What Changes
- **Database**: Create `heroes` table untuk manage hero slides
- **Admin**: CRUD interface untuk hero management
- **Frontend**: Update `home.blade.php` untuk load hero dari database
- **Media**: Integration dengan Spatie MediaLibrary untuk image management

### Database Schema
```sql
CREATE TABLE heroes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(255) NULL,
    description TEXT NULL,
    button_text VARCHAR(100) NULL,
    button_link VARCHAR(255) NULL,
    order INT NOT NULL DEFAULT 0,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

**Media Collection**: `hero` (via Spatie MediaLibrary)

### Implementation Tasks
```markdown
## 1. Database Setup
- [ ] 1.1 Create heroes migration
- [ ] 1.2 Create Hero model with MediaLibrary integration
- [ ] 1.3 Create HeroSeeder dengan default hero (current newbackground.webp)
- [ ] 1.4 Run migrations

## 2. Admin Interface
- [ ] 2.1 Create HeroController (admin)
- [ ] 2.2 Create hero index view (list all heroes)
- [ ] 2.3 Create hero create/edit form
- [ ] 2.4 Add drag & drop image upload
- [ ] 2.5 Add order management (drag & drop reordering)
- [ ] 2.6 Add toggle active/inactive

## 3. Frontend Integration
- [ ] 3.1 Update HomeController to load active hero
- [ ] 3.2 Update home.blade.php to use dynamic hero
- [ ] 3.3 Keep fallback to default if no heroes exist
- [ ] 3.4 Optimize image loading (lazy load, srcset)

## 4. Routes & Permissions
- [ ] 4.1 Add admin routes for hero management
- [ ] 4.2 Add permission: 'manage heroes'
- [ ] 4.3 Assign permission to content_manager & admin roles
```

### Affected Files
- **New**: `database/migrations/YYYY_MM_DD_create_heroes_table.php`
- **New**: `app/Models/Hero.php`
- **New**: `app/Http/Controllers/Admin/HeroController.php`
- **New**: `resources/views/admin/heroes/index.blade.php`
- **New**: `resources/views/admin/heroes/create.blade.php`
- **New**: `resources/views/admin/heroes/edit.blade.php`
- **Modified**: `resources/views/home.blade.php` (lines 62-67)
- **Modified**: `routes/web.php`
- **Modified**: `database/seeders/PermissionSeeder.php`

### Affected Specs
- **content-management**: ADDED Requirements
- **web-platform**: MODIFIED Requirements (hero section)

### Dependencies
- None (can be implemented independently)

---

## 2. implement-product-management

### Why
Product categories (Skincare, Bodycare, Haircare, dll) dan product cards (Body Wash, Facial Mask, dll) saat ini hardcoded di `home.blade.php`. Tidak ada cara untuk admin menambah/edit categories dan products.

### What Changes
- **Database**: Create `product_categories` dan `products` tables
- **Admin**: CRUD interface untuk categories & products management
- **Frontend**: Update `home.blade.php` untuk load dynamic tabs & cards
- **Media**: Product images via Spatie MediaLibrary

### Database Schema
```sql
CREATE TABLE product_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT NULL,
    order INT NOT NULL DEFAULT 0,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_category_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NULL,
    features JSON NULL,
    order INT NOT NULL DEFAULT 0,
    is_featured BOOLEAN DEFAULT false,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (product_category_id) REFERENCES product_categories(id) ON DELETE CASCADE
);
```

**Media Collection**: `product_image` (via Spatie MediaLibrary)

### Implementation Tasks
```markdown
## 1. Database Setup
- [ ] 1.1 Create product_categories migration
- [ ] 1.2 Create products migration
- [ ] 1.3 Create ProductCategory model
- [ ] 1.4 Create Product model with MediaLibrary
- [ ] 1.5 Create ProductCategorySeeder (9 default categories)
- [ ] 1.6 Create ProductSeeder (3 default products)
- [ ] 1.7 Run migrations

## 2. Admin Interface - Categories
- [ ] 2.1 Create ProductCategoryController (admin)
- [ ] 2.2 Create category index view
- [ ] 2.3 Create category create/edit form
- [ ] 2.4 Add order management
- [ ] 2.5 Add toggle active/inactive

## 3. Admin Interface - Products
- [ ] 3.1 Create ProductController (admin)
- [ ] 3.2 Create product index view (filter by category)
- [ ] 3.3 Create product create/edit form
- [ ] 3.4 Add category selection dropdown
- [ ] 3.5 Add image upload
- [ ] 3.6 Add features editor (JSON field)
- [ ] 3.7 Add order management
- [ ] 3.8 Add toggle featured/active

## 4. Frontend Integration
- [ ] 4.1 Update HomeController to load categories & products
- [ ] 4.2 Update home.blade.php product tabs (dynamic categories)
- [ ] 4.3 Update home.blade.php product cards (dynamic products)
- [ ] 4.4 Add Alpine.js for tab switching functionality
- [ ] 4.5 Keep fallback to defaults if no data

## 5. Routes & Permissions
- [ ] 5.1 Add admin routes for category management
- [ ] 5.2 Add admin routes for product management
- [ ] 5.3 Add permission: 'manage products'
- [ ] 5.4 Assign permission to content_manager & admin roles
```

### Affected Files
- **New**: `database/migrations/YYYY_MM_DD_create_product_categories_table.php`
- **New**: `database/migrations/YYYY_MM_DD_create_products_table.php`
- **New**: `app/Models/ProductCategory.php`
- **New**: `app/Models/Product.php`
- **New**: `app/Http/Controllers/Admin/ProductCategoryController.php`
- **New**: `app/Http/Controllers/Admin/ProductController.php`
- **New**: `resources/views/admin/product-categories/` (folder + views)
- **New**: `resources/views/admin/products/` (folder + views)
- **Modified**: `resources/views/home.blade.php` (lines 88-129)
- **Modified**: `routes/web.php`
- **Modified**: `database/seeders/PermissionSeeder.php`

### Affected Specs
- **content-management**: ADDED Requirements
- **web-platform**: MODIFIED Requirements (products section)

### Dependencies
- None (can be implemented independently)

---

## 3. implement-content-blocks-management

### Why
Content sections seperti "In Lunaray, creation begins with purpose", "The Scientist's Choice", dan quote section saat ini hardcoded. Admin tidak bisa mengubah content tanpa edit code.

### What Changes
- **Database**: Create `content_blocks` table untuk flexible content management
- **Admin**: CRUD interface untuk content blocks dengan rich text editor
- **Frontend**: Update `home.blade.php` untuk load dynamic content blocks
- **Media**: Background images via Spatie MediaLibrary

### Database Schema
```sql
CREATE TABLE content_blocks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    key VARCHAR(100) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NULL,
    settings JSON NULL,
    order INT NOT NULL DEFAULT 0,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

**Key Examples:**
- `dual_card_left` - "In Lunaray, creation begins with purpose"
- `dual_card_right` - "The Scientist's Choice"
- `quote_section` - "From research to radiance..."
- `transition_section` - "Beauty Manufacturing Made Simple"

**Settings JSON Structure:**
```json
{
    "background_color": "#07143c",
    "text_color": "#ffffff",
    "overlay_opacity": 0.9,
    "button_text": "DISCOVER",
    "button_link": "#"
}
```

**Media Collection**: `content_block_image` (via Spatie MediaLibrary)

### Implementation Tasks
```markdown
## 1. Database Setup
- [ ] 1.1 Create content_blocks migration
- [ ] 1.2 Create ContentBlock model with MediaLibrary
- [ ] 1.3 Create ContentBlockSeeder (4 default blocks)
- [ ] 1.4 Run migrations

## 2. Admin Interface
- [ ] 2.1 Create ContentBlockController (admin)
- [ ] 2.2 Create content block index view
- [ ] 2.3 Create content block edit form (no create, predefined keys)
- [ ] 2.4 Add rich text editor integration (Trix)
- [ ] 2.5 Add background image upload
- [ ] 2.6 Add settings editor (JSON with UI)
- [ ] 2.7 Add preview functionality

## 3. Frontend Integration
- [ ] 3.1 Update HomeController to load content blocks
- [ ] 3.2 Update home.blade.php transition section (line 78)
- [ ] 3.3 Update home.blade.php quote section (lines 131-152)
- [ ] 3.4 Update home.blade.php dual cards (lines 155-188)
- [ ] 3.5 Keep fallback to defaults if blocks don't exist

## 4. Routes & Permissions
- [ ] 4.1 Add admin routes for content block management
- [ ] 4.2 Add permission: 'manage content blocks'
- [ ] 4.3 Assign permission to content_manager & admin roles
```

### Affected Files
- **New**: `database/migrations/YYYY_MM_DD_create_content_blocks_table.php`
- **New**: `app/Models/ContentBlock.php`
- **New**: `app/Http/Controllers/Admin/ContentBlockController.php`
- **New**: `resources/views/admin/content-blocks/index.blade.php`
- **New**: `resources/views/admin/content-blocks/edit.blade.php`
- **Modified**: `resources/views/home.blade.php` (lines 78-80, 131-188)
- **Modified**: `routes/web.php`
- **Modified**: `database/seeders/PermissionSeeder.php`

### Affected Specs
- **content-management**: ADDED Requirements
- **web-platform**: MODIFIED Requirements (multiple sections)

### Dependencies
- **Recommended**: Implement after `implement-settings-management` (for media storage config)

---

## 4. implement-settings-management

### Why
Site configuration seperti logo, site name, contact info, social media links saat ini hardcoded atau di `.env`. Perlu centralized settings management yang user-friendly.

### What Changes
- **Database**: Create `settings` table dengan key-value structure
- **Admin**: Settings management interface dengan grouping
- **Frontend**: Load settings via helper/service
- **Global**: Available di semua views via view composer

### Database Schema
```sql
CREATE TABLE settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    key VARCHAR(100) UNIQUE NOT NULL,
    value TEXT NULL,
    group VARCHAR(50) NOT NULL DEFAULT 'general',
    type VARCHAR(50) NOT NULL DEFAULT 'text',
    label VARCHAR(255) NOT NULL,
    description TEXT NULL,
    options JSON NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

**Groups:**
- `general` - Site name, tagline, description
- `contact` - Phone, email, address
- `social` - Facebook, Instagram, Twitter, LinkedIn
- `seo` - Meta title, description, keywords
- `appearance` - Logo, favicon, colors

**Types:**
- `text` - Simple text input
- `textarea` - Multiline text
- `email` - Email input
- `url` - URL input
- `image` - File upload
- `color` - Color picker
- `boolean` - Checkbox
- `select` - Dropdown

### Implementation Tasks
```markdown
## 1. Database Setup
- [ ] 1.1 Create settings migration
- [ ] 1.2 Create Setting model
- [ ] 1.3 Create SettingsSeeder (default settings)
- [ ] 1.4 Run migrations

## 2. Helper & Service
- [ ] 2.1 Create SettingsService helper
- [ ] 2.2 Add settings() helper function
- [ ] 2.3 Create ViewComposer untuk inject settings ke views
- [ ] 2.4 Register ViewComposer di AppServiceProvider

## 3. Admin Interface
- [ ] 3.1 Create SettingsController (admin)
- [ ] 3.2 Create settings index with tabs (by group)
- [ ] 3.3 Create dynamic form based on setting type
- [ ] 3.4 Add image upload for logo/favicon
- [ ] 3.5 Add color picker for appearance settings
- [ ] 3.6 Add validation per setting type

## 4. Frontend Integration
- [ ] 4.1 Update layouts to use dynamic logo
- [ ] 4.2 Update footer with contact info
- [ ] 4.3 Add social media icons (if available)
- [ ] 4.4 Update meta tags with SEO settings

## 5. Routes & Permissions
- [ ] 5.1 Add admin routes for settings
- [ ] 5.2 Add permission: 'manage system settings' (already exists)
- [ ] 5.3 Update menu navigation
```

### Affected Files
- **New**: `database/migrations/YYYY_MM_DD_create_settings_table.php`
- **New**: `app/Models/Setting.php`
- **New**: `app/Services/SettingsService.php`
- **New**: `app/View/Composers/SettingsComposer.php`
- **New**: `app/Helpers/settings.php`
- **New**: `app/Http/Controllers/Admin/SettingsController.php` (if not exists)
- **New**: `resources/views/admin/settings/index.blade.php`
- **Modified**: `app/Providers/AppServiceProvider.php`
- **Modified**: `resources/views/layouts/guest.blade.php`
- **Modified**: `resources/views/layouts/admin.blade.php`
- **Modified**: `routes/web.php`
- **Modified**: `composer.json` (autoload helpers)

### Affected Specs
- **content-management**: ADDED Requirements
- **web-platform**: MODIFIED Requirements (global settings)

### Dependencies
- None (but recommended to implement early as other features may depend on it)

---

## 5. add-testimonials-feature

### Why
Testimonials adalah social proof yang penting untuk trust building. Saat ini tidak ada section untuk customer testimonials di website.

### What Changes
- **Database**: Create `testimonials` table
- **Admin**: CRUD interface untuk testimonials management
- **Frontend**: Add new testimonials section di `home.blade.php`
- **Media**: Customer avatars via Spatie MediaLibrary

### Database Schema
```sql
CREATE TABLE testimonials (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(255) NOT NULL,
    client_position VARCHAR(255) NULL,
    client_company VARCHAR(255) NULL,
    content TEXT NOT NULL,
    rating INT NULL DEFAULT 5,
    is_featured BOOLEAN DEFAULT false,
    is_active BOOLEAN DEFAULT true,
    order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

**Media Collection**: `testimonial_avatar` (via Spatie MediaLibrary)

### Implementation Tasks
```markdown
## 1. Database Setup
- [ ] 1.1 Create testimonials migration
- [ ] 1.2 Create Testimonial model with MediaLibrary
- [ ] 1.3 Create TestimonialSeeder (3 sample testimonials)
- [ ] 1.4 Run migrations

## 2. Admin Interface
- [ ] 2.1 Create TestimonialController (admin)
- [ ] 2.2 Create testimonial index view
- [ ] 2.3 Create testimonial create/edit form
- [ ] 2.4 Add avatar upload
- [ ] 2.5 Add rating selector (1-5 stars)
- [ ] 2.6 Add order management
- [ ] 2.7 Add toggle featured/active

## 3. Frontend Integration
- [ ] 3.1 Update HomeController to load testimonials
- [ ] 3.2 Design testimonials section (after products section)
- [ ] 3.3 Add testimonials carousel/slider (Swiper.js)
- [ ] 3.4 Add star rating display
- [ ] 3.5 Make responsive (mobile/tablet/desktop)

## 4. Routes & Permissions
- [ ] 4.1 Add admin routes for testimonial management
- [ ] 4.2 Add permission: 'manage testimonials'
- [ ] 4.3 Assign permission to content_manager & admin roles
```

### Affected Files
- **New**: `database/migrations/YYYY_MM_DD_create_testimonials_table.php`
- **New**: `app/Models/Testimonial.php`
- **New**: `app/Http/Controllers/Admin/TestimonialController.php`
- **New**: `resources/views/admin/testimonials/` (folder + views)
- **New**: `resources/views/components/testimonials-section.blade.php`
- **Modified**: `resources/views/home.blade.php` (add new section after line 153)
- **Modified**: `routes/web.php`
- **Modified**: `database/seeders/PermissionSeeder.php`
- **Modified**: `package.json` (add Swiper.js if using carousel)

### Affected Specs
- **content-management**: ADDED Requirements
- **web-platform**: ADDED Requirements (new testimonials section)

### Dependencies
- None (optional feature, can be implemented anytime)

---

## 📊 Implementation Priority Matrix

| Proposal | Priority | Impact | Effort | Dependencies |
|----------|----------|--------|--------|--------------|
| Hero Slider | 🔥 Critical | High | Medium | None |
| Product Management | 🔥 Critical | Very High | High | None |
| Content Blocks | ⚡ High | Medium | Medium | Settings (recommended) |
| Settings Management | ⚡ High | High | Medium | None |
| Testimonials | 📊 Medium | Low | Low | None |

---

## 🚀 Recommended Implementation Order

### Week 1: Core Dynamic Content
```
Day 1-2: implement-hero-slider-management
Day 3-5: implement-product-management
```
**Deliverable**: Home page hero & products fully dynamic

### Week 2: Content Management
```
Day 1-2: implement-settings-management
Day 3-4: implement-content-blocks-management
```
**Deliverable**: All home page content manageable via admin

### Week 3: Enhancement (Optional)
```
Day 1-2: add-testimonials-feature
Day 3: Testing & bug fixes
```
**Deliverable**: Complete admin dashboard with all features

---

## 📝 Admin Dashboard Menu Structure (After All Proposals)

```
Admin Dashboard
├── 📊 Dashboard (overview/statistics)
├── 📰 Content Management
│   ├── 🎬 Hero Slides
│   ├── 📦 Products
│   │   ├── Categories
│   │   └── Products List
│   ├── 📄 Articles (already exists)
│   ├── 🏷️ Categories (already exists)
│   └── 📝 Content Blocks
├── 👥 User Management (already exists)
├── ⭐ Testimonials
├── 💬 Chatbot (already exists)
└── ⚙️ Settings
    ├── General Settings
    ├── Contact Information
    ├── Social Media
    ├── SEO Settings
    └── Appearance
```

---

## 🔧 Technical Notes

### Media Management
All image uploads menggunakan **Spatie MediaLibrary v11** yang sudah installed:
- Automatic conversions (thumb, medium, large)
- Responsive images
- Queue processing
- Custom properties support

### Permissions
Menggunakan **Spatie Laravel Permission** yang sudah implemented:
- Permission-based access control
- Role assignments (user, content_manager, admin)
- Middleware protection

### Rich Text Editor
Menggunakan **Trix Editor** (tonysm/rich-text-laravel) yang sudah installed:
- Already integrated untuk articles
- Support untuk content blocks & testimonials

### SEO
Menggunakan **ralphjsmit/laravel-seo** yang sudah installed:
- Meta tags generation
- Structured data
- Social sharing

---

## ✅ Checklist Before Each Proposal

- [ ] Review current home.blade.php implementation
- [ ] Check existing database schema
- [ ] Review Spatie packages (MediaLibrary, Permission)
- [ ] Plan migration rollback strategy
- [ ] Consider backward compatibility
- [ ] Plan seeder data (default values)
- [ ] Design admin interface mockup
- [ ] Update permissions seeder
- [ ] Test responsive design
- [ ] Validate OpenSpec spec format

---

## 📚 References

- **Current Implementation**: `resources/views/home.blade.php`
- **Database Migrations**: `database/migrations/`
- **Existing Models**: `app/Models/`
- **Admin Controllers**: `app/Http/Controllers/Admin/`
- **Admin Views**: `resources/views/admin/`
- **Routes**: `routes/web.php`
- **Permissions**: `database/seeders/PermissionSeeder.php`

---

## 🎯 Success Criteria

After completing all proposals:
- ✅ Home page 100% dynamic (no hardcoded content)
- ✅ Admin dapat manage semua content via dashboard
- ✅ Non-technical users dapat update website
- ✅ Responsive & mobile-friendly
- ✅ SEO optimized
- ✅ Performance maintained
- ✅ All features tested & documented
- ✅ OpenSpec specs updated & archived

---

**Last Updated**: October 30, 2025  
**Project**: Lunaray Beauty Factory  
**Tech Stack**: Laravel 11.x, TailwindCSS 4, Alpine.js, Spatie Packages  
**OpenSpec Version**: Latest  

---

*Dokumen ini adalah living document dan akan diupdate seiring progress implementasi.*

