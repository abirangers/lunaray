# Design Document: Product Management System

## Context

The current landing page hardcodes 9 product categories and 3 product showcase items directly in the Blade template. This creates several challenges:
- **Maintainability**: Content changes require code deployment
- **User Experience**: Non-technical staff cannot update product showcases
- **Scalability**: Cannot easily add/remove categories or products
- **Flexibility**: No way to feature products or manage display order

This design document outlines the technical approach for implementing a fully dynamic product management system that integrates seamlessly with the existing Lunaray Beauty Factory platform.

### Stakeholders
- **Content Managers**: Need to manage product categories and products via admin dashboard
- **Admins**: Full control over product system configuration
- **Public Users**: View product showcases on landing page
- **Developers**: Maintain and extend the system

### Constraints
- Must use existing Spatie MediaLibrary v11 for image management
- Must integrate with existing permission system (Spatie Laravel Permission)
- Must maintain responsive design and current visual aesthetic
- Must support Alpine.js for interactive tab functionality
- Must not break existing landing page functionality (fallback required)

## Goals / Non-Goals

### Goals
- ✅ Enable admin/content managers to manage product categories and products via admin dashboard
- ✅ Dynamic product showcase on landing page with tab-based category filtering
- ✅ Image management with automatic conversions (thumb, medium, large)
- ✅ Product ordering and featured functionality
- ✅ Permission-based access control
- ✅ Responsive design maintained across all devices
- ✅ Smooth tab switching with Alpine.js
- ✅ Backward compatibility with fallback to defaults

### Non-Goals
- ❌ E-commerce functionality (shopping cart, checkout, payments)
- ❌ Product inventory management
- ❌ Product variants/options system
- ❌ Product reviews/ratings (may be added later)
- ❌ Advanced product filtering (by price, attributes, etc.)
- ❌ Product search on landing page (only category tabs)
- ❌ Product detail pages (landing page showcase only)

## Decisions

### Decision 1: Two-Table Architecture (product_categories + products)

**Rationale:**
- Clear separation of concerns between categories and products
- Simple one-to-many relationship (category has many products)
- Easier to manage and query than single denormalized table
- Aligns with existing Laravel conventions

**Database Schema:**

```sql
-- product_categories table
CREATE TABLE product_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT NULL,
    order INT NOT NULL DEFAULT 0,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_order (order),
    INDEX idx_is_active (is_active)
);

-- products table
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
    FOREIGN KEY (product_category_id) REFERENCES product_categories(id) ON DELETE CASCADE,
    INDEX idx_category_id (product_category_id),
    INDEX idx_order (order),
    INDEX idx_is_featured (is_featured),
    INDEX idx_is_active (is_active)
);
```

**Alternatives Considered:**
- **Single products table with category column**: Less flexible, harder to manage category metadata
- **Many-to-many relationship**: Overengineered for current use case (products belong to single category)

### Decision 2: Spatie MediaLibrary for Image Management

**Rationale:**
- Already installed and used for articles and user avatars
- Provides automatic image conversions (thumb, medium, large)
- Queue processing support for large images
- Consistent with existing codebase patterns

**Media Collections:**
- `product_image` - Product showcase images
- `category_icon` (optional) - Category icons for future use

**Conversions:**
```php
// Product images
- thumb: 300x200px (table thumbnails)
- medium: 800x600px (landing page cards)
- large: 1200x800px (future detail pages)
```

**Alternatives Considered:**
- **Intervention Image direct**: More manual work, less integrated
- **Simple file upload**: No automatic conversions or optimizations

### Decision 3: Alpine.js for Tab Switching

**Rationale:**
- Already used throughout the application
- Lightweight and perfect for simple interactivity
- No need for Vue/React for simple tab functionality
- Aligns with project's minimal JavaScript approach

**Implementation:**
```javascript
x-data="{ activeTab: '{{ $categories->first()?->slug ?? 'skincare' }}' }"

// Tab button
x-on:click="activeTab = '{{ $category->slug }}'"
:class="{ 'text-cyan-400': activeTab === '{{ $category->slug }}' }"

// Product card
x-show="activeTab === '{{ $product->category->slug }}'"
```

**Alternatives Considered:**
- **Full page reload with query params**: Poor UX, slower
- **Vue.js/React**: Overengineered for simple tab switching

### Decision 4: JSON Field for Product Features

**Rationale:**
- Flexible structure for different product types
- No need for separate features table
- Easy to render in admin form and frontend
- MySQL/PostgreSQL both support JSON field type

**Example Structure:**
```json
{
    "key_ingredients": ["Vitamin C", "Hyaluronic Acid"],
    "skin_type": "All skin types",
    "size": "100ml",
    "benefits": ["Hydrating", "Anti-aging", "Brightening"]
}
```

**Alternatives Considered:**
- **Separate features table**: Overengineered, complex queries
- **Text field with manual parsing**: Less structured, harder to validate

### Decision 5: Permission-Based Access Control

**Rationale:**
- Consistent with existing permission system
- Single permission `manage products` for both categories and products
- Content managers and admins can manage products
- Public users can only view on landing page

**Permission Assignment:**
- `content_manager` role → `manage products` permission
- `admin` role → `manage products` permission

**Alternatives Considered:**
- **Separate permissions for categories/products**: Unnecessary complexity
- **Role-based only**: Less flexible than permission-based

### Decision 6: Fallback to Hardcoded Defaults

**Rationale:**
- Ensures landing page never breaks if database is empty
- Smooth migration path from hardcoded to dynamic
- Maintains current functionality during development

**Implementation:**
```blade
@if($categories->isEmpty())
    {{-- Fallback to hardcoded tabs --}}
    <button>Skincare</button>
    <button>Bodycare</button>
    {{-- etc... --}}
@else
    {{-- Dynamic tabs --}}
    @foreach($categories as $category)
        <button>{{ $category->name }}</button>
    @endforeach
@endif
```

**Alternatives Considered:**
- **No fallback**: Risky, could break landing page
- **Redirect to admin**: Poor UX for public users

## Risks / Trade-offs

### Risk 1: Alpine.js Performance with Many Products
**Impact**: Medium  
**Likelihood**: Low  
**Mitigation**: 
- Limit products per category to reasonable number (e.g., 10-20)
- Use lazy loading for product images
- Consider pagination if product count grows significantly

### Risk 2: Image Upload Size and Processing Time
**Impact**: Medium  
**Likelihood**: Medium  
**Mitigation**:
- Implement file size validation (max 5MB)
- Use queue processing for large images
- Add loading indicators during upload
- Provide image optimization guidelines to content managers

### Risk 3: Category Deletion with Existing Products
**Impact**: High  
**Likelihood**: Low  
**Mitigation**:
- Prevent deletion if products exist (with clear error message)
- Offer "reassign products" functionality before deletion
- Use ON DELETE CASCADE for orphaned products (or prevent deletion)

### Risk 4: Slug Conflicts
**Impact**: Low  
**Likelihood**: Low  
**Mitigation**:
- Automatic slug generation from name
- Unique constraint on slug column
- Validation error with helpful message
- Auto-append number if slug exists (e.g., skincare-2)

### Trade-off 1: JSON Features vs Structured Table
**Choice**: JSON field  
**Benefit**: Flexibility, simpler structure  
**Cost**: Harder to query/filter by specific features  
**Justification**: Current use case only needs display, not filtering

### Trade-off 2: Single Permission vs Granular Permissions
**Choice**: Single `manage products` permission  
**Benefit**: Simpler permission management  
**Cost**: Cannot separate category vs product permissions  
**Justification**: Content managers typically need both anyway

## Migration Plan

### Phase 1: Database Setup (Day 1)
1. Create migrations for product_categories and products tables
2. Create models with relationships and MediaLibrary traits
3. Create seeders with 9 default categories and 3 default products
4. Run migrations and seeders
5. Test database structure and relationships

### Phase 2: Admin Interface (Days 2-4)
1. Build product category CRUD (Day 2)
   - Controller, routes, views
   - Form validation
   - Order management
   - Active/inactive toggle
2. Build product CRUD (Days 3-4)
   - Controller, routes, views
   - Image upload with MediaLibrary
   - Category selection
   - Features editor
   - Order and featured management

### Phase 3: Frontend Integration (Day 5)
1. Update HomeController to load categories and products
2. Update home.blade.php with dynamic tabs
3. Implement Alpine.js tab switching
4. Add fallback logic for empty data
5. Test responsive design

### Phase 4: Testing & Polish (Days 6-7)
1. Comprehensive testing (CRUD, permissions, frontend)
2. Performance testing with multiple products
3. Mobile/tablet/desktop responsive testing
4. Edge case testing (empty data, invalid inputs)
5. Documentation and cleanup

### Rollback Strategy
- Keep hardcoded HTML in comments for quick rollback
- Database migrations are reversible (down methods)
- Feature flag option: Use config to toggle between dynamic/static

### Data Migration
- No existing data to migrate (greenfield)
- Default seeders provide starting point
- Content managers can gradually add products

## Open Questions

### Q1: Should product categories have icons/images?
**Status**: Optional - Not in MVP  
**Decision**: Add media collection but don't require it  
**Reasoning**: Can be added later without breaking changes

### Q2: Should products have multiple images (gallery)?
**Status**: Not in MVP  
**Decision**: Single featured image only  
**Reasoning**: Landing page only shows one image per product

### Q3: Should we implement drag-and-drop reordering?
**Status**: Nice-to-have  
**Decision**: Manual order field for MVP, drag-and-drop later  
**Reasoning**: Saves development time, order field is sufficient

### Q4: Should featured products have separate section?
**Status**: Not in MVP  
**Decision**: Add is_featured flag but don't use on frontend yet  
**Reasoning**: Flexible for future enhancement

### Q5: How to handle product features input in admin?
**Status**: Decided  
**Decision**: Simple textarea with JSON formatting help  
**Reasoning**: Balances flexibility and ease of use

## Performance Considerations

### Database Queries
```php
// Eager load relationships to avoid N+1
$categories = ProductCategory::active()
    ->ordered()
    ->with(['products' => function($query) {
        $query->active()->ordered();
    }])
    ->get();
```

### Caching Strategy
```php
// Cache categories and products for 1 hour
$categories = Cache::remember('landing.products', 3600, function() {
    return ProductCategory::active()->ordered()->with('products')->get();
});

// Clear cache on product/category update
Cache::forget('landing.products');
```

### Image Optimization
- Use MediaLibrary responsive images: `getResponsiveImages('product_image')`
- Lazy loading: `<img loading="lazy" ...>`
- WebP format support for modern browsers
- Proper image dimensions (800x600 for medium)

## Technical Dependencies

### Existing Packages
- ✅ Spatie MediaLibrary v11 (installed)
- ✅ Spatie Laravel Permission (installed)
- ✅ Alpine.js (installed)
- ✅ TailwindCSS 4 (installed)

### New Dependencies
- ❌ None required

## Success Metrics

### Functional Metrics
- ✅ Admin can create/edit/delete categories in < 30 seconds
- ✅ Admin can create/edit product with image in < 2 minutes
- ✅ Tab switching on landing page is smooth (< 100ms)
- ✅ Image upload completes in < 5 seconds
- ✅ Landing page loads in < 3 seconds (unchanged)

### Technical Metrics
- ✅ Database queries optimized (N+1 prevention)
- ✅ Image conversions queue processed successfully
- ✅ No JavaScript errors in console
- ✅ Responsive design works on all breakpoints
- ✅ Permission enforcement 100% effective

### User Experience Metrics
- ✅ Content managers can manage products without developer help
- ✅ No breaking changes to landing page appearance
- ✅ Admin interface follows existing design patterns
- ✅ Clear error messages for validation failures
- ✅ Intuitive workflow for product management

