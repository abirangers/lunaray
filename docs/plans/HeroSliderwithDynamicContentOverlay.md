Implementation Plan: Hero Slider with Dynamic Content Overlay

  Overview

  Enhance the existing hero slider to support dynamic overlay content that syncs with each slide. Each hero slide will have
  unique content (title, subtitle, CTA button with subtext, and tagline) managed through the admin panel and stored in the
  database.

  Design Reference

  Based on the provided image showing:
  - Large multi-line title: "Where Science Meet Beauty We Create Magic"
  - Description paragraph below title
  - Decorative cyan separator line
  - Left-aligned CTA button ("EXPLORE") with subtext ("our vision and value")
  - Right-aligned tagline text ("Driven by Research. Perfected by Expertise.")

  Technical Architecture

  Database Layer

  Table: heroes (existing table, needs migration to add columns)

  New Columns to Add:
  - title VARCHAR(255) NULLABLE - Main heading
  - subtitle TEXT NULLABLE - Description paragraph
  - cta_text VARCHAR(100) NULLABLE - Button text (e.g., "EXPLORE")
  - cta_link VARCHAR(255) NULLABLE - Button URL
  - cta_subtext VARCHAR(100) NULLABLE - Text below button (e.g., "our vision and value")
  - tagline VARCHAR(255) NULLABLE - Tagline beside button (e.g., "Driven by Research...")

  Frontend Layer

  Technologies:
  - Splide.js (existing slider library)
  - Alpine.js (for reactive content switching)
  - TailwindCSS 4 (for styling)

  Content Syncing Strategy:
  Each hero slide will maintain data attributes linking to corresponding content blocks. JavaScript will listen to Splide's slide
   change events and show/hide content accordingly with smooth transitions.

  ---
  Implementation Steps

  Step 1: Database Migration

  File: database/migrations/YYYY_MM_DD_HHMMSS_add_content_fields_to_heroes_table.php

  Tasks:
  1. Create new migration file with timestamp
  2. Add columns: title, subtitle, cta_text, cta_link, cta_subtext, tagline
  3. All fields should be NULLABLE to support backward compatibility
  4. Add appropriate indexes if needed for performance

  Verification:
  - Run php artisan migrate successfully
  - Verify columns exist in database using php artisan tinker or database client

  Code Structure:
  public function up()
  {
      Schema::table('heroes', function (Blueprint $table) {
          $table->string('title')->nullable()->after('order');
          $table->text('subtitle')->nullable()->after('title');
          $table->string('cta_text', 100)->nullable()->after('subtitle');
          $table->string('cta_link')->nullable()->after('cta_text');
          $table->string('cta_subtext', 100)->nullable()->after('cta_link');
          $table->string('tagline')->nullable()->after('cta_subtext');
      });
  }

  public function down()
  {
      Schema::table('heroes', function (Blueprint $table) {
          $table->dropColumn(['title', 'subtitle', 'cta_text', 'cta_link', 'cta_subtext', 'tagline']);
      });
  }

  ---
  Step 2: Update Hero Model

  File: app/Models/Hero.php

  Tasks:
  1. Add new fields to $fillable array
  2. Add validation rules if using model-level validation
  3. Add accessor methods if needed for formatting (e.g., truncating long text)
  4. Ensure existing media handling remains unchanged

  Verification:
  - Hero model can mass-assign new fields
  - Existing media collection ('hero_image') still works
  - Model relationships remain intact

  Code Changes:
  protected $fillable = [
      'name',
      'order',
      'is_active',
      'title',           // NEW
      'subtitle',        // NEW
      'cta_text',        // NEW
      'cta_link',        // NEW
      'cta_subtext',     // NEW
      'tagline',         // NEW
  ];

  // Optional: Add accessor for title with fallback
  public function getTitleAttribute($value)
  {
      return $value ?? $this->name;
  }

  ---
  Step 3: Update Admin Hero Controller

  File: app/Http/Controllers/Admin/HeroController.php

  Tasks:
  1. Update store() method to handle new fields
  2. Update update() method to handle new fields
  3. Add validation rules for new fields in FormRequest or controller
  4. Ensure image upload logic remains unchanged

  Validation Rules:
  'title' => 'nullable|string|max:255',
  'subtitle' => 'nullable|string|max:1000',
  'cta_text' => 'nullable|string|max:100',
  'cta_link' => 'nullable|url|max:255',
  'cta_subtext' => 'nullable|string|max:100',
  'tagline' => 'nullable|string|max:255',

  Verification:
  - Admin can create new heroes with content fields
  - Admin can update existing heroes with content fields
  - Validation works correctly (optional fields don't block submission)
  - Image upload still functions properly

  ---
  Step 4: Update Admin Hero Form View

  File: resources/views/admin/heroes/create.blade.php and edit.blade.php

  Tasks:
  1. Add form fields for: title, subtitle, cta_text, cta_link, cta_subtext, tagline
  2. Use appropriate input types (text, textarea, url)
  3. Show existing values when editing
  4. Add helper text/placeholders for clarity
  5. Maintain existing form structure and styling

  Form Structure:
  {{-- Hero Image Upload (existing) --}}
  {{-- Keep existing image upload section --}}

  {{-- Content Overlay Section --}}
  <div class="space-y-6">
      <h3 class="text-lg font-semibold">Hero Content Overlay</h3>

      {{-- Title --}}
      <div>
          <label>Title</label>
          <input type="text" name="title" value="{{ old('title', $hero->title ?? '') }}"
                 placeholder="Where Science Meet Beauty We Create Magic">
      </div>

      {{-- Subtitle --}}
      <div>
          <label>Subtitle</label>
          <textarea name="subtitle" rows="3"
                    placeholder="Dari laboratorium hingga cahaya...">{{ old('subtitle', $hero->subtitle ?? '') }}</textarea>
      </div>

      {{-- CTA Button --}}
      <div class="grid grid-cols-2 gap-4">
          <div>
              <label>Button Text</label>
              <input type="text" name="cta_text" value="{{ old('cta_text', $hero->cta_text ?? '') }}"
                     placeholder="EXPLORE">
          </div>
          <div>
              <label>Button Link</label>
              <input type="url" name="cta_link" value="{{ old('cta_link', $hero->cta_link ?? '') }}"
                     placeholder="https://...">
          </div>
      </div>

      {{-- CTA Subtext --}}
      <div>
          <label>Button Subtext</label>
          <input type="text" name="cta_subtext" value="{{ old('cta_subtext', $hero->cta_subtext ?? '') }}"
                 placeholder="our vision and value">
      </div>

      {{-- Tagline --}}
      <div>
          <label>Tagline</label>
          <input type="text" name="tagline" value="{{ old('tagline', $hero->tagline ?? '') }}"
                 placeholder="Driven by Research. Perfected by Expertise.">
      </div>
  </div>

  Verification:
  - Form fields display correctly in create/edit views
  - Old input values persist on validation errors
  - Placeholders provide helpful examples
  - Form submission includes all new fields

  ---
  Step 5: Update Home View - Hero Section Structure

  File: resources/views/home.blade.php

  Tasks:
  1. Restructure hero section to support overlay content
  2. Add data attributes to slides for content association
  3. Create separate content overlay container
  4. Add gradient overlay for better text readability
  5. Implement responsive layout (mobile-first)

  HTML Structure:
  <div id="section-hero" class="relative w-full overflow-hidden">
      {{-- Background Slider --}}
      <div class="hero-slider-container relative">
          {{-- Gradient Overlay for Text Readability --}}
          <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent z-10
  pointer-events-none"></div>

          {{-- Splide Slider (Images Only) --}}
          <div class="splide hero-slider">
              <div class="splide__track">
                  <ul class="splide__list">
                      @foreach($heroes as $index => $hero)
                          <li class="splide__slide" data-slide-index="{{ $index }}">
                              @if($hero->hasMedia('hero_image'))
                                  <img src="{{ $hero->getFirstMediaUrl('hero_image', 'large') }}"
                                       alt="{{ $hero->name }}"
                                       class="w-full h-[50vh] sm:h-[60vh] md:h-[70vh] lg:h-[80vh] xl:h-screen object-cover
  object-center">
                              @endif
                          </li>
                      @endforeach
                  </ul>
              </div>
          </div>

          {{-- Content Overlay Container (Positioned Absolutely) --}}
          <div class="absolute inset-0 z-20 pointer-events-none">
              <div class="container mx-auto h-full flex items-center px-4 sm:px-6 md:px-8 lg:px-12">
                  <div class="max-w-4xl pointer-events-auto">
                      @foreach($heroes as $index => $hero)
                          <div class="hero-content"
                               data-content-index="{{ $index }}"
                               x-show="activeSlide === {{ $index }}"
                               x-transition:enter="transition ease-out duration-500"
                               x-transition:enter-start="opacity-0 translate-y-4"
                               x-transition:enter-end="opacity-100 translate-y-0"
                               x-transition:leave="transition ease-in duration-300"
                               x-transition:leave-start="opacity-100"
                               x-transition:leave-end="opacity-0"
                               style="{{ $index === 0 ? '' : 'display: none;' }}">

                              {{-- Title --}}
                              @if($hero->title)
                                  <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold text-white mb-4
  sm:mb-6 leading-tight">
                                      {!! nl2br(e($hero->title)) !!}
                                  </h1>
                              @endif

                              {{-- Subtitle --}}
                              @if($hero->subtitle)
                                  <p class="text-sm sm:text-base md:text-lg lg:text-xl text-white/90 mb-6 sm:mb-8 leading-relaxed
   max-w-2xl">
                                      {{ $hero->subtitle }}
                                  </p>
                              @endif

                              {{-- Decorative Cyan Line --}}
                              <div class="w-full max-w-3xl h-0.5 bg-cyan-400 mb-6 sm:mb-8"></div>

                              {{-- CTA and Tagline Section --}}
                              <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 sm:gap-12">
                                  {{-- CTA Button with Subtext --}}
                                  @if($hero->cta_text && $hero->cta_link)
                                      <div class="flex flex-col items-start">
                                          <a href="{{ $hero->cta_link }}"
                                             class="bg-cyan-400 hover:bg-cyan-500 text-white font-bold text-lg sm:text-xl px-8
  sm:px-12 py-3 sm:py-4 rounded-full transition duration-300 shadow-lg hover:shadow-xl touch-manipulation">
                                              {{ $hero->cta_text }}
                                          </a>
                                          @if($hero->cta_subtext)
                                              <span class="text-white/80 text-xs sm:text-sm mt-2 ml-2">
                                                  {{ $hero->cta_subtext }}
                                              </span>
                                          @endif
                                      </div>
                                  @endif

                                  {{-- Tagline --}}
                                  @if($hero->tagline)
                                      <p class="text-cyan-400 font-semibold text-base sm:text-lg md:text-xl">
                                          {{ $hero->tagline }}
                                      </p>
                                  @endif
                              </div>
                          </div>
                      @endforeach
                  </div>
              </div>
          </div>
      </div>
  </div>

  Key Design Decisions:
  - Gradient Overlay: Left-to-right gradient from dark to transparent ensures text readability
  - Absolute Positioning: Content overlay is positioned absolutely to sit on top of slider
  - Pointer Events: Container has pointer-events-none, content has pointer-events-auto for clickable buttons
  - Alpine.js Transitions: Smooth fade-in/fade-out when switching content
  - Responsive Sizing: Progressive text sizing from mobile to desktop

  Verification:
  - Content displays on top of hero images
  - Text is readable against all background images
  - Layout doesn't break on mobile devices
  - CTA buttons are clickable

  ---
  Step 6: JavaScript - Splide Integration

  File: resources/views/layouts/guest.blade.php or inline in home.blade.php

  Tasks:
  1. Initialize Splide slider with appropriate settings
  2. Add Alpine.js component for content state management
  3. Listen to Splide's move event to sync content
  4. Implement smooth transitions between content

  JavaScript Implementation:
  <script>
  document.addEventListener('DOMContentLoaded', function() {
      // Alpine.js component for hero content management
      Alpine.data('heroSlider', () => ({
          activeSlide: 0,

          init() {
              // Initialize Splide
              const heroSlider = new Splide('.hero-slider', {
                  type: 'loop',
                  autoplay: true,
                  interval: 5000,
                  speed: 1000,
                  pauseOnHover: true,
                  pauseOnFocus: true,
                  arrows: true,
                  pagination: true,
                  rewind: true,
                  lazyLoad: 'nearby',
              });

              // Sync content when slide changes
              heroSlider.on('move', (newIndex) => {
                  this.activeSlide = newIndex;
              });

              heroSlider.mount();
          }
      }));
  });
  </script>

  Alpine.js Component in HTML:
  <div x-data="heroSlider()" x-init="init()">
      {{-- Hero slider markup --}}
  </div>

  Verification:
  - Slider initializes without errors
  - Content changes when slider moves
  - Transitions are smooth
  - Autoplay works correctly

  ---
  Step 7: Styling - Responsive Design

  File: Inline styles in home.blade.php or dedicated CSS file

  Tasks:
  1. Ensure mobile-first responsive design
  2. Test touch targets (minimum 44x44px for buttons)
  3. Verify text contrast ratios for accessibility
  4. Test on various screen sizes (320px to 2560px)

  Responsive Breakpoints:
  - Mobile (< 640px): Stacked layout, smaller text, button below title
  - Tablet (640px - 1024px): Increased text size, side-by-side button/tagline
  - Desktop (> 1024px): Full-size text, optimal spacing

  CSS Classes (TailwindCSS):
  /* Title - Progressive sizing */
  .hero-title {
      @apply text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl;
  }

  /* Subtitle */
  .hero-subtitle {
      @apply text-sm sm:text-base md:text-lg lg:text-xl;
  }

  /* CTA Button - Touch-friendly */
  .hero-cta {
      @apply min-w-[44px] min-h-[44px] touch-manipulation;
  }

  /* Gradient Overlay */
  .hero-gradient {
      @apply bg-gradient-to-r from-black/70 via-black/40 to-transparent;
  }

  Verification:
  - All text is readable on smallest mobile screens
  - Buttons are easily tappable on touch devices
  - Layout doesn't overflow horizontally
  - Content doesn't overlap navigation

  ---
  Step 8: Handle Edge Cases

  Tasks:
  1. No content scenario: Show default fallback if hero has no content
  2. No CTA scenario: Hide button section gracefully
  3. Single hero: Disable autoplay and arrows
  4. Empty heroes: Show static fallback image (existing behavior)

  Fallback Logic:
  {{-- If hero has no title, use name as fallback --}}
  <h1>{{ $hero->title ?? $hero->name }}</h1>

  {{-- Only show CTA section if either button or tagline exists --}}
  @if($hero->cta_text || $hero->tagline)
      <div class="cta-section">...</div>
  @endif

  {{-- Disable slider features if only one hero --}}
  @if($heroes->count() === 1)
      <script>
          heroSlider.options = {
              arrows: false,
              autoplay: false
          };
      </script>
  @endif

  Verification:
  - Heroes without content still display images
  - Single hero doesn't auto-slide
  - Missing fields don't break layout

  ---
  Step 9: Testing & Quality Assurance

  Manual Testing Checklist:
  - Admin can create new hero with all content fields
  - Admin can edit existing hero and update content
  - Admin can leave content fields empty (optional fields)
  - Hero slider displays correctly on homepage
  - Content syncs when slider transitions
  - Transitions are smooth without flicker
  - CTA buttons link to correct URLs
  - Layout is responsive on mobile (320px width)
  - Layout is responsive on tablet (768px width)
  - Layout is responsive on desktop (1920px width)
  - Text is readable on light backgrounds
  - Text is readable on dark backgrounds
  - Gradient overlay doesn't obscure important image elements
  - Touch targets are minimum 44x44px
  - No console errors in browser
  - No horizontal scroll on any device

  Browser Testing:
  - Chrome (latest)
  - Firefox (latest)
  - Safari (latest)
  - Mobile Safari (iOS)
  - Chrome Mobile (Android)

  Performance Testing:
  - Images load efficiently (lazy loading)
  - No layout shift (CLS) during content transitions
  - Smooth 60fps animations
  - No memory leaks with autoplay

  ---
  Step 10: Documentation & Seeder Update

  Tasks:
  1. Update CLAUDE.md with new hero content feature
  2. Create/update hero seeder with example content
  3. Add comments in code for future maintainers

  Seeder Example:
  // database/seeders/HeroSeeder.php
  Hero::create([
      'name' => 'Main Hero - Science Meets Beauty',
      'order' => 1,
      'is_active' => true,
      'title' => "Where Science\nMeet Beauty\nWe Create Magic",
      'subtitle' => 'Dari laboratorium hingga cahaya yang menyentuh kulit, setiap formula di Lunaray adalah harmoni dari
  perjalanan sains, keahlian, pengalaman dan ketulusan.',
      'cta_text' => 'EXPLORE',
      'cta_link' => '/about',
      'cta_subtext' => 'our vision and value',
      'tagline' => 'Driven by Research. Perfected by Expertise.',
  ])->addMediaFromUrl('https://example.com/hero1.jpg')
    ->toMediaCollection('hero_image');

  Documentation Update (CLAUDE.md):
  ### Hero Slider with Dynamic Content

  **Features:**
  - Dynamic content overlay on slider images
  - Per-slide content: title, subtitle, CTA button, tagline
  - Database-backed content management
  - Admin panel integration
  - Responsive mobile-first design

  **Content Fields:**
  - `title` - Main heading (supports line breaks with \n)
  - `subtitle` - Description paragraph
  - `cta_text` - Button text
  - `cta_link` - Button URL
  - `cta_subtext` - Text below button
  - `tagline` - Tagline beside button

  **Admin Management:**
  - Navigate to Admin > Heroes
  - Create/edit hero with image and content
  - All content fields are optional
  - Preview shows how content will appear

  Verification:
  - Seeder creates heroes with realistic content
  - Documentation is clear and comprehensive
  - Code comments explain complex logic

  ---
  Success Criteria

  ✅ Functional Requirements:
  1. Admin can manage hero content through admin panel
  2. Each hero slide displays unique overlay content
  3. Content syncs smoothly with slider transitions
  4. CTA buttons link to specified URLs
  5. Layout is fully responsive (mobile-first)

  ✅ Technical Requirements:
  1. Database migration runs without errors
  2. No breaking changes to existing functionality
  3. No console errors or warnings
  4. Code follows Laravel and project conventions
  5. Performance remains optimal (no lag)

  ✅ Design Requirements:
  1. Matches provided design reference
  2. Text is readable on all backgrounds
  3. Gradient overlay enhances readability
  4. Animations are smooth and professional
  5. Touch targets meet accessibility standards (44x44px)

  ---
  Rollback Plan

  If issues arise during implementation:

  1. Database: Run php artisan migrate:rollback to remove new columns
  2. Frontend: Revert home.blade.php to previous commit
  3. Admin: Revert hero controller and form views
  4. Cache: Run php artisan cache:clear and php artisan view:clear

  ---
  Timeline Estimate

  - Step 1-3 (Database & Model): 15-20 minutes
  - Step 4 (Admin Forms): 20-30 minutes
  - Step 5-6 (Frontend & JS): 30-45 minutes
  - Step 7 (Styling): 20-30 minutes
  - Step 8-10 (Edge Cases, Testing, Docs): 30-40 minutes

  Total Estimated Time: 2-3 hours for complete implementation and testing

  ---
  Notes for Implementation

  - Existing Functionality: Do NOT modify existing hero image upload or media handling
  - Backward Compatibility: All new fields are nullable to support existing heroes
  - Design System: Follow "Beauty High Tech" design guidelines (cyan accent, OKLCH colors)
  - Brand Fonts: Use existing custom fonts (MissRhinetta for script, Adolphus for serif)
  - Mobile-First: Always start with mobile layout, then enhance for larger screens
  - Alpine.js: Leverage existing Alpine.js setup, no need to add new libraries
  - Splide.js: Use existing Splide.js instance, extend with content sync logic

  ---
  This plan is now ready for execution. Each step is detailed with exact file paths, code examples, verification steps, and
  expected outcomes. Proceed with implementation step-by-step, marking each task complete in the TodoWrite tool as you go.