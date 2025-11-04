# Design: Hero Slider Management

## Context

The Lunaray Beauty Factory landing page hero section currently uses a hardcoded static image. To enable dynamic content management and provide an engaging slider experience, we need a database-driven hero management system integrated with Splide.js for smooth slider functionality.

## Goals / Non-Goals

### Goals
- Admin-manageable hero slides with image upload
- Smooth slider experience using Splide.js
- Responsive design with performance optimization
- Permission-based access control
- Image management via Spatie MediaLibrary
- Slide ordering and active/inactive status

### Non-Goals
- Text overlay or CTAs on hero slides (images only for now)
- Complex animations beyond Splide.js transitions
- Admin preview functionality
- Analytics tracking for hero slides

## Decisions

### Decision 1: Database Structure
- **Chosen**: Simple `heroes` table with minimal fields (name, order, is_active, timestamps)
- **Alternatives**: Complex fields with text, buttons, CTAs
- **Rationale**: Start simple, images only. Can extend later with text overlay if needed.

### Decision 2: Media Library Integration
- **Chosen**: Spatie MediaLibrary for hero images
- **Alternatives**: Direct file storage, Laravel Storage
- **Rationale**: Already installed, provides conversions, consistent with products/articles

### Decision 3: Slider Library
- **Chosen**: Splide.js (already installed)
- **Alternatives**: Swiper.js, Glide.js
- **Rationale**: Already integrated in project, good performance, lightweight

### Decision 4: Slider Configuration
- **Chosen**: Auto-play (5-7s), loop, arrows, pagination
- **Alternatives**: Manual only, fade transitions
- **Rationale**: Engages users, common pattern, matches existing product slider config

### Decision 5: Image Conversions
- **Chosen**: thumb (300x200), medium (800x600), large (1920x1080)
- **Alternatives**: Single size, more conversions
- **Rationale**: Large for hero full-width, medium for previews, thumb for admin list

## Risks / Trade-offs

### Risk 1: Multiple Large Images Impacting Page Load
- **Mitigation**: Use WebP format, lazy loading, CDN if needed
- **Trade-off**: Slightly longer initial load for better experience

### Risk 2: Splide.js Conflicting with Product Slider
- **Mitigation**: Isolated instances, separate initialization
- **Trade-off**: Two slider instances on page (acceptable)

### Risk 3: Admin User Complexity
- **Mitigation**: Simple UI, drag & drop ordering, clear active/inactive toggle
- **Trade-off**: More admin education needed

## Migration Plan

- No existing hero data to migrate
- Fresh implementation with default hero seeder
- Gradual rollout: start with 1-2 hero slides
- Backward compatible: fallback to static image if no data

## Open Questions

- Should hero slides have expiration dates for campaigns? → Future enhancement
- Analytics tracking for slide impressions? → Future enhancement
- Text overlay support for CTAs? → Future enhancement

