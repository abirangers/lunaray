# Lunaray Beauty Factory - Style Guide
## "Beauty High Tech" Design System

> **Version:** 1.0.0
> **Last Updated:** 2025-11-03
> **Design Philosophy:** Science meets beauty with futuristic, high-tech aesthetic

---

## Table of Contents
1. [Overview](#overview)
2. [Color Palette](#color-palette)
3. [Typography System](#typography-system)
4. [Spacing System](#spacing-system)
5. [Component Styles](#component-styles)
6. [Shadows & Elevation](#shadows--elevation)
7. [Animations & Transitions](#animations--transitions)
8. [Border Radius](#border-radius)
9. [Opacity & Transparency](#opacity--transparency)
10. [Layout Patterns](#layout-patterns)
11. [Decorative Elements](#decorative-elements)
12. [Common Tailwind CSS Usage](#common-tailwind-css-usage)
13. [Component Reference Code](#component-reference-code)

---

## Overview

### Design Identity
**"Beauty High Tech"** - A futuristic, science-inspired design system that bridges the gap between cosmetic beauty and scientific innovation. The design language emphasizes:

- **Futuristic aesthetic** with tech/sci-fi elements
- **Scientific credibility** through molecular diagrams, hexagonal patterns, and lab imagery
- **Premium feel** with gradient overlays and sophisticated color schemes
- **Clean, modern layouts** with generous white space
- **Bilingual support** (English navigation, Indonesian content)

### Visual Themes
1. **Hero Sections:** Dark navy with cyan accents, featuring futuristic line graphics
2. **Product Sections:** Light blue gradients with hexagonal background patterns
3. **Scientific Sections:** Blue tones with molecular overlays and lab coat imagery
4. **Innovation Sections:** Translucent overlays with tech/AI graphic elements
5. **CTA Sections:** Deep space-like backgrounds with glowing product showcases

---

## Color Palette

### Primary Colors

#### Deep Navy (Primary Dark)
```css
/* Background - Hero, Headers */
#000d1a     /* RGB: 0, 13, 26 */
#001829     /* Slightly lighter variant */
#00152a     /* Dark navy base */
```

**Usage:**
- Hero section backgrounds
- Navigation bar overlay
- Dark section dividers
- Text on light backgrounds

#### Cyan/Turquoise (Primary Accent)
```css
/* Interactive Elements, Highlights */
text-cyan-400      /* Tailwind: #22d3ee */
text-cyan-300      /* Tailwind: #67e8f9 */
border-cyan-400    /* Borders, icons */
```

**Usage:**
- Active navigation links
- Hover states
- Call-to-action buttons
- Decorative line graphics
- Keyword highlights in text
- Social media icon borders

#### Blue (Secondary)
```css
/* Headings, Body Text on Light BG */
text-blue-900      /* Tailwind: #1e3a8a - Dark blue for headings */
text-blue-600      /* Tailwind: #2563eb - Medium blue for links */
text-blue-950      /* Tailwind: #172554 - Deepest blue */
text-blue-400      /* Tailwind: #60a5fa - Light blue for accents */
bg-blue-300        /* Tailwind: #93c5fd - Light background */
bg-blue-400        /* Tailwind: #60a5fa - Section backgrounds */
```

**Usage:**
- Primary headings on light backgrounds
- Body text on light sections
- Section backgrounds (light blue)

### Neutral Colors

#### White & Light Grays
```css
/* Backgrounds, Cards */
bg-white           /* Pure white */
bg-neutral-200     /* Light gray placeholder backgrounds */
text-white         /* White text on dark backgrounds */
text-neutral-400   /* Light gray for placeholders */
text-neutral-600   /* Medium gray for secondary text */
bg-neutral-900     /* Dark gray for dropdowns */
border-neutral-700 /* Dark gray borders */
```

#### Black & Dark Grays
```css
/* Text, Overlays */
bg-black           /* Pure black for tab containers */
text-black         /* Black text on light backgrounds */
bg-black/20        /* 20% black overlay */
bg-neutral-800     /* Dark gray hover states */
```

### Gradient Colors

#### Golden/Yellow (Premium Accent)
```css
/* CTA Buttons, Pricing */
bg-[#FDB913]       /* Golden yellow - primary CTA */
bg-[#e5a710]       /* Darker golden - hover state */
```

**Usage:**
- "Order Now" buttons
- "Explore" CTA buttons
- Premium pricing accents

#### Blue Gradients (Atmospheric)
```css
/* Used in background images */
- Light blue to white gradients (product sections)
- Navy to dark blue gradients (hero sections)
- Translucent blue overlays (scientific sections)
```

### Color Usage Patterns

#### Text Color Hierarchy
```css
/* On Dark Backgrounds */
.text-white              /* Primary text */
.text-cyan-400           /* Highlighted/active text */
.text-cyan-300           /* Hover states */
.text-neutral-400        /* Secondary/muted text */

/* On Light Backgrounds */
.text-blue-900           /* Primary headings */
.text-blue-950           /* Deep headings (Beautyversity) */
.text-black              /* Body text */
.text-neutral-600        /* Secondary text */
.text-blue-600           /* Links */
```

#### Background Color Hierarchy
```css
/* Dark Sections */
bg-[#000d1a]            /* Hero, dark sections */
bg-neutral-900          /* Dropdowns, modals */
bg-black                /* Tab containers */

/* Light Sections */
bg-blue-300             /* Beautyversity section */
bg-blue-400             /* Pricing section */
bg-white                /* Cards, pricing boxes */

/* Transparent Overlays */
bg-black/20             /* Dark overlay on images */
bg-white/90             /* Light overlay on buttons */
bg-transparent          /* Transparent circular cards */
```

---

## Typography System

### Font Families

#### 1. **MissRhinetta** (Cursive/Script)
```css
.font-rhinetta {
    font-family: 'MissRhinetta', cursive;
}
```

**Characteristics:**
- Elegant, handwritten script style
- Italic baseline
- Used for emotional, artistic headings

**Usage:**
- Hero taglines ("Beauty Manufacturing Made Simple")
- Quote sections ("From research to radiance...")
- CTA headings ("Ready to Build the Future...")
- Contact section headers
- Emphasis on "beauty" and emotional content

**Font Sizes:**
```css
text-2xl md:text-4xl lg:text-5xl    /* Quote sections */
text-4xl md:text-5xl lg:text-6xl xl:text-7xl  /* Hero CTAs */
```

#### 2. **MilliardBold** (Sans-Serif Bold)
```css
.font-milliard {
    font-family: 'MilliardBold', sans-serif;
}
```

**Characteristics:**
- Strong, bold sans-serif
- High weight for impact
- Modern, geometric letterforms

**Usage:**
- Not directly visible in current code but part of design system
- Intended for strong headers and navigation

#### 3. **Adolphus** (Serif)
```css
.font-adolphus {
    font-family: 'Adolphus', serif;
}
```

**Characteristics:**
- Classic serif typeface
- Elegant, traditional feel
- Balance between modern and timeless

**Usage:**
- Tagline section ("Beauty Manufacturing Made Simple")
- Secondary headings

**Font Size:**
```css
text-3xl md:text-5xl lg:text-6xl    /* Tagline */
```

#### 4. **System Defaults** (Sans-Serif)

Used when no custom font specified:

```css
/* Likely Inter or similar (from global config) */
- Navigation links
- Body text
- Category tabs
- Product names
- Most UI elements
```

### Font Size Scale

#### Headings

**Hero Headings (Display):**
```css
/* Largest - Hero primary */
text-4xl md:text-5xl lg:text-6xl xl:text-7xl
/* Example: 2.25rem → 3rem → 3.75rem → 4.5rem */
/* Usage: "Ready to Build the Future..." */

/* Large - Section headings */
text-4xl md:text-5xl lg:text-6xl
/* Example: 2.25rem → 3rem → 3.75rem */
/* Usage: "Lunaray Beauty Innovation", "Contact Us" */

/* Medium - Section headers */
text-3xl md:text-5xl lg:text-6xl
/* Example: 1.875rem → 3rem → 3.75rem */
/* Usage: "Beauty Manufacturing Made Simple" */

/* Standard - Card headings */
text-xl md:text-2xl lg:text-3xl
/* Example: 1.25rem → 1.5rem → 1.875rem */
/* Usage: "AI-Powered, Nature-Inspired" */
```

**Subheadings:**
```css
/* Large subheading */
text-2xl md:text-3xl
/* Usage: Pricing card titles */

/* Medium subheading */
text-xl md:text-2xl
/* Usage: Article cards, service cards */

/* Small subheading */
text-xl
/* Usage: Product names, category labels */
```

#### Body Text

```css
/* Large body */
text-base md:text-lg lg:text-xl
/* Example: 1rem → 1.125rem → 1.25rem */
/* Usage: CTA descriptions, important paragraphs */

/* Standard body */
text-base md:text-lg
/* Example: 1rem → 1.125rem */
/* Usage: Main content, article excerpts */

/* Small body */
text-sm md:text-base
/* Example: 0.875rem → 1rem */
/* Usage: Article body, card descriptions */

/* Navigation links */
text-sm
/* Example: 0.875rem */
/* Usage: Top navigation menu */
```

#### Special Text

```css
/* Quote text */
text-2xl md:text-4xl lg:text-5xl
/* Usage: Featured quotes with font-rhinetta */

/* Tab labels */
text-[21px]
/* Usage: Category tabs (custom pixel value) */

/* Price display */
text-4xl md:text-5xl
/* Usage: Pricing cards */

/* Button text size */
text-xl
/* Usage: "DISCOVER" button label */

/* Small button sublabel */
text-xs
/* Usage: "our product range" under button */
```

### Font Weights

```css
/* Extra Bold */
font-bold              /* 700 - Primary headings, CTAs */

/* Semibold */
font-semibold          /* 600 - Category tabs, subheadings, links */

/* Normal */
font-normal            /* 400 - Body text, descriptions */

/* Script (from font) */
font-script            /* Rhinetta italic weight */
```

**Usage Patterns:**
```css
/* Hero headings */
.font-bold text-white

/* Section headings */
.font-bold text-blue-900

/* Category tabs */
.font-semibold text-[21px]

/* Body text */
.font-normal text-base md:text-lg

/* Quote text */
.font-rhinetta font-normal italic
```

### Font Styles

```css
/* Italic */
italic                 /* Rhinetta quotes, subheadings */
```

**Usage:**
- Quote sections with `.font-rhinetta italic`
- "AI-Powered, Nature-Inspired" subheading
- Emphasis text in CTA sections

### Letter Spacing

```css
/* Wide tracking */
tracking-wide          /* Navigation links, taglines */

/* Wider tracking */
tracking-wider         /* Hero tagline */
```

**Usage:**
```html
<!-- Hero tagline -->
<h2 class="font-adolphus italic tracking-wider">
    Beauty Manufacturing Made Simple
</h2>
```

### Line Height

```css
/* Tight */
leading-tight          /* Multi-line headings */

/* Relaxed */
leading-relaxed        /* Body paragraphs, descriptions */
```

**Common Combinations:**

```css
/* Display heading */
.text-6xl .font-bold .text-white .leading-tight

/* Body paragraph */
.text-base .md:text-lg .leading-relaxed .text-white

/* Quote text */
.text-5xl .font-rhinetta .italic .leading-relaxed
```

### Typography Component Examples

#### Hero Heading
```html
<h1 class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-rhinetta font-script text-white italic leading-tight">
    Ready to Build the Future of <br class="hidden md:block">
    Beauty Together?
</h1>
```

#### Section Heading (Light BG)
```html
<h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-blue-900">
    Lunaray <br> Beauty Innovation
</h2>
```

#### Section Heading (Dark BG)
```html
<h2 class="text-3xl md:text-5xl lg:text-6xl font-rhinetta text-white font-normal leading-tight">
    The Scientist's Choice
</h2>
```

#### Body Paragraph
```html
<p class="text-base md:text-lg text-white leading-relaxed">
    Lunaray Beauty Factory hadir sebagai solusi end-to-end jasa
    <span class="text-cyan-300">maklon kosmetik terbaik</span> untuk pebisnis...
</p>
```

#### Quote Block
```html
<p class="font-rhinetta text-2xl md:text-4xl lg:text-5xl tracking-wide italic font-normal text-blue-900 leading-relaxed">
    "From research to radiance <br class="hidden md:block">
    every drop tells the story of science meet beauty."
</p>
```

#### Category Tab
```html
<button class="px-3 py-1 font-semibold text-[21px] text-cyan-400 rounded-lg">
    Skincare
</button>
```

#### Product Name
```html
<span class="justify-center ml-auto text-xl text-center text-black flex mt-4">
    Facial Mask
</span>
```

---

## Spacing System

### Container Spacing

#### Padding Classes

**Section Vertical Padding:**
```css
/* Standard section */
py-12                          /* 3rem (48px) mobile */
py-16 md:py-20                 /* 4rem → 5rem responsive */

/* Large section */
py-12 md:py-16                 /* 3rem → 4rem */

/* Tagline section */
py-12                          /* Consistent 3rem */
```

**Section Horizontal Padding:**
```css
/* Standard content padding */
px-4 md:px-12                  /* 1rem → 3rem */
px-6 md:px-12 lg:px-16         /* 1.5rem → 3rem → 4rem */
px-8                           /* Product section: 2rem */
```

**Card Internal Padding:**
```css
/* Pricing cards */
p-8                            /* 2rem all sides */

/* Tab container */
p-2                            /* 0.5rem (tight) */

/* Navigation header */
p-4 md:px-12                   /* 1rem → 3rem horizontal */

/* Product container */
p-4                            /* 1rem */
```

#### Margin Classes

**Component Spacing (Vertical):**
```css
/* Section header to content */
mb-8 md:mb-12                  /* 2rem → 3rem */
mb-12 md:mb-16                 /* 3rem → 4rem (larger gap) */

/* Heading to subheading */
mb-4                           /* 1rem */
mb-6                           /* 1.5rem */

/* Text block spacing */
mb-8                           /* 2rem */

/* Product name spacing */
mt-4                           /* 1rem top margin */

/* Card offset */
-mt-10                         /* -2.5rem (negative offset for visual effect) */
```

**Component Spacing (Horizontal):**
```css
/* Auto-centering */
mx-auto                        /* Center horizontally */

/* Specific margins */
m-auto                         /* All sides auto */
ml-auto                        /* Left auto (right align) */
```

#### Gap (Flexbox/Grid Spacing)

**Navigation:**
```css
space-x-6                      /* 1.5rem horizontal gap */
```

**Card Grids:**
```css
gap-2                          /* 0.5rem (category tabs - tight) */
gap-4                          /* 1rem (standard cards) */
gap-4 md:gap-6                 /* 1rem → 1.5rem (innovation cards) */
gap-6                          /* 1.5rem (social media icons) */
gap-8 md:gap-10 lg:gap-12      /* 2rem → 2.5rem → 3rem (large card grids) */
gap-6 md:gap-8 lg:gap-12       /* 1.5rem → 2rem → 3rem (service cards) */
```

**Text Spacing:**
```css
space-y-3                      /* 0.75rem vertical (card content) */
space-y-4                      /* 1rem vertical (paragraphs, section content) */
```

### Layout Widths

#### Max Width Constraints

```css
/* Content containers */
max-w-7xl                      /* 80rem (1280px) - main content */
max-w-6xl                      /* 72rem (1152px) - hero content */
max-w-5xl                      /* 64rem (1024px) - CTA text */
max-w-4xl                      /* 56rem (896px) - long text blocks */
max-w-3xl                      /* 48rem (768px) - pricing intro */
max-w-2xl                      /* 42rem (672px) - centered content */
max-w-xl                       /* 36rem (576px) - quotes, narrow text */

/* Cards and components */
max-w-xs                       /* 20rem (320px) - chat widget */
max-w-md                       /* 28rem (448px) - featured product image */

/* Centering pattern */
.max-w-7xl.mx-auto            /* Center with max width */
```

#### Fixed Widths

```css
/* Product cards */
w-80                           /* 20rem (320px) */
w-full                         /* 100% */

/* Innovation cards */
w-32 md:w-36 lg:w-40          /* 8rem → 9rem → 10rem */
w-32 md:w-36 lg:w-52          /* Last card: 8rem → 9rem → 13rem */

/* Service cards */
w-40 md:w-48                   /* 10rem → 12rem */

/* Circular elements */
w-32 h-32 md:w-40 md:h-40 lg:w-48 lg:h-48  /* Service circles */
w-16 h-16 md:w-20 md:h-20                   /* Social icons */
w-24 h-24 md:w-32 md:h-32                   /* Certification badges */

/* Icon sizes */
w-24 h-24                      /* Large placeholder icon */
w-8 h-8 md:w-10 md:h-10       /* Social media icons */
```

### Spacing Utility Patterns

#### Common Section Structure
```html
<section class="py-16 md:py-20 px-6 md:px-12 lg:px-16">
    <div class="max-w-7xl mx-auto">
        <!-- Content with mb-8 md:mb-12 for header -->
        <!-- Content blocks with space-y-4 -->
    </div>
</section>
```

#### Common Card Spacing
```html
<div class="p-8 space-y-3">
    <h3 class="mb-8">Title</h3>
    <div class="mb-6">Content</div>
    <div class="mb-8">More content</div>
</div>
```

#### Grid Layouts
```html
<!-- 3-column responsive grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10 lg:gap-12">
    <!-- Cards -->
</div>

<!-- Flex with gap -->
<div class="flex flex-wrap gap-4 md:gap-6 justify-center">
    <!-- Items -->
</div>
```

---

## Component Styles

### Navigation Components

#### Top Navigation Bar
```html
<header class="absolute top-0 left-0 right-0 p-4 md:px-12 text-center flex m-auto mt-10 z-30">
    <nav class="flex items-center text-center m-auto justify-between">
        <div class="hidden lg:flex items-center space-x-6 text-sm">
            <!-- Links -->
        </div>
    </nav>
</header>
```

**Characteristics:**
- Absolute positioning over hero
- High z-index (30) for stacking
- Hidden on mobile (`hidden lg:flex`)
- Small text size (`text-sm`)
- Generous link spacing (`space-x-6`)

#### Navigation Links
```css
/* Default state */
.text-white .hover:text-cyan-400 .transition .duration-300

/* Active state */
.text-cyan-400 .hover:text-white .transition .duration-300
```

#### User Dropdown
```html
<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="text-white hover:text-cyan-400 transition duration-300">
        {{ auth()->user()->name }}
    </button>
    <div x-show="open" @click.away="open = false" x-transition
        class="absolute right-0 mt-2 w-48 bg-neutral-900 rounded-md shadow-lg py-1 z-50 border border-neutral-700">
        <!-- Dropdown items -->
    </div>
</div>
```

**Characteristics:**
- Alpine.js state management
- Dark background (`bg-neutral-900`)
- Rounded corners (`rounded-md`)
- Shadow (`shadow-lg`)
- Subtle border (`border-neutral-700`)
- Full-width items with hover
- Right-aligned positioning

### Button Components

#### Primary CTA Button (Golden)
```html
<button class="w-full bg-[#FDB913] hover:bg-[#e5a710] text-white font-bold py-4 px-6 rounded-full transition duration-300 shadow-lg">
    Order Now
</button>
```

**Characteristics:**
- Golden yellow background
- Darker hover state
- Full rounded (`rounded-full`)
- Bold white text
- Generous padding (`py-4 px-6`)
- Shadow for elevation
- Smooth transition

#### Secondary CTA Button (Outlined)
```html
<a href="#" class="border border-blue-400 text-blue-600 font-semibold rounded-lg px-5 py-2 text-xl hover:bg-blue-50 transition inline-block bg-white/90 backdrop-blur-sm text-center">
    DISCOVER
    <span class="block text-xs text-blue-400 font-normal -mt-1">
        our product range
    </span>
</a>
```

**Characteristics:**
- Blue outline border
- Blue text
- Two-line text (main + subtitle)
- Semi-transparent background (`bg-white/90`)
- Backdrop blur effect
- Hover fill (`hover:bg-blue-50`)
- Less rounded (`rounded-lg`)

#### Tab Button (Active State)
```html
<button class="px-3 py-1 font-semibold text-[21px] text-cyan-400 cursor-pointer rounded-lg hover:bg-gray-700 transition-colors">
    Skincare
</button>
```

**Characteristics:**
- Active: cyan text
- Inactive: white text
- Dark hover background
- Compact padding
- Custom font size (21px)
- Color transition only

### Card Components

#### Pricing Card
```html
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <div class="p-8 text-center">
        <h3 class="text-2xl md:text-3xl font-bold text-[#4A9FD8] mb-8">
            Premium
        </h3>
        <div class="flex justify-center mb-8">
            <!-- Icon -->
        </div>
        <div class="mb-6">
            <span class="text-4xl md:text-5xl font-bold text-[#4A9FD8]">
                $19.00
            </span>
        </div>
        <p class="text-sm md:text-base text-[#4A9FD8] mb-8 leading-relaxed">
            Description text
        </p>
        <button class="w-full bg-[#FDB913] hover:bg-[#e5a710] text-white font-bold py-4 px-6 rounded-full transition duration-300 shadow-lg">
            Order Now
        </button>
    </div>
</div>
```

**Characteristics:**
- White background
- Extra-large rounded corners (`rounded-2xl`)
- Strong shadow (`shadow-xl`)
- Centered content
- Consistent internal spacing
- Blue accent color for text
- Golden CTA button

#### Article Card
```html
<div class="flex flex-col">
    <div class="mb-4">
        <div class="aspect-[4/3] overflow-hidden rounded">
            <img src="..." alt="..." class="w-full h-full object-cover">
        </div>
    </div>
    <div class="space-y-3">
        <h3 class="text-xl md:text-2xl font-bold text-blue-950">
            Article Title
        </h3>
        <p class="text-sm md:text-base text-blue-950 leading-relaxed">
            Excerpt text
        </p>
        <a href="#" class="inline-block text-blue-950 font-semibold hover:text-blue-600 transition">
            Baca selengkapnya >>
        </a>
    </div>
</div>
```

**Characteristics:**
- Vertical flex layout
- 4:3 aspect ratio image
- Simple rounded corners
- Object-cover for images
- Vertical spacing with `space-y-3`
- Semibold link with arrow
- Hover state on link

#### Product Card (in Slider)
```html
<li class="splide__slide">
    <div class="flex-shrink-0 w-full relative overflow-hidden rounded-lg">
        <div class="relative flex flex-col items-center justify-center">
            <img class="w-full h-72 object-cover" src="..." alt="..." loading="lazy">
            <div>
                <span class="justify-center ml-auto text-xl text-center text-black flex mt-4">
                    Product Name
                </span>
            </div>
        </div>
    </div>
</li>
```

**Characteristics:**
- Fixed height (`h-72` = 18rem = 288px)
- Object-cover for consistent sizing
- Lazy loading
- Centered product name below image
- Rounded container (`rounded-lg`)
- Black text on light/transparent background

#### Service Card (Circular)
```html
<div class="text-center w-40 md:w-48">
    <div class="w-32 h-32 md:w-40 md:h-40 lg:w-48 lg:h-48 rounded-full border-4 md:border-[6px] border-white flex items-center justify-center mb-4 bg-transparent backdrop-blur-sm">
        <div class="text-center">
            <h3 class="text-xl md:text-2xl font-bold text-white leading-tight">
                PRIVATE<br>LABEL
            </h3>
        </div>
    </div>
</div>
```

**Characteristics:**
- Perfect circle (`rounded-full`)
- White border (4-6px responsive)
- Transparent background
- Backdrop blur effect
- Centered multi-line text
- Responsive sizing
- White text for dark backgrounds

### Form Components

#### Input Field (Dropdown Item Pattern)
```html
<button type="submit" class="w-full text-left px-4 py-2 text-sm text-white hover:bg-neutral-800">
    Sign Out
</button>
```

**Characteristics:**
- Full width
- Text-left alignment
- Small padding (`px-4 py-2`)
- Hover background change
- Small text size

### Tab Components

#### Category Tabs Container
```html
<div class="flex flex-wrap gap-2 justify-center text-center">
    <div class="bg-black p-2 rounded-lg">
        <!-- Tab buttons -->
    </div>
</div>
```

**Characteristics:**
- Black background container
- Small padding (`p-2`)
- Rounded corners (`rounded-lg`)
- Centered layout
- Wrappable on mobile
- Tight gap between tabs

### Image Components

#### Hero Background Slider
```html
<div class="hero-slider-container">
    <div class="splide hero-slider">
        <div class="splide__track">
            <ul class="splide__list">
                <li class="splide__slide">
                    <img src="..." alt="..." class="w-full">
                </li>
            </ul>
        </div>
    </div>
</div>
```

**Characteristics:**
- Full-width images
- Splide.js integration
- Seamless transitions
- No visible controls by default

#### Hexagonal Container (Decorative)
Used in product section background - creates hexagonal tile pattern

#### Certification Badges
```html
<div class="flex-shrink-0 flex items-center gap-4">
    <img src="..." alt="CPKB Certification" class="w-24 h-24 md:w-32 md:h-32 object-contain">
    <img src="..." alt="BPOM Certification" class="w-24 h-24 md:w-32 md:h-32 object-contain">
    <img src="..." alt="HALAL Certification" class="w-24 h-24 md:w-32 md:h-32 object-contain">
</div>
```

**Characteristics:**
- Square aspect ratio
- Object-contain to preserve logos
- Consistent sizing
- Small gap between badges
- Responsive sizing

### Social Media Icons

```html
<a href="#" class="group">
    <div class="w-16 h-16 md:w-20 md:h-20 border-4 border-cyan-400 rounded-xl flex items-center justify-center hover:bg-cyan-400 transition duration-300">
        <svg class="w-8 h-8 md:w-10 md:h-10 text-cyan-400 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24">
            <!-- SVG path -->
        </svg>
    </div>
</a>
```

**Characteristics:**
- Square with rounded corners (`rounded-xl`)
- Cyan border (4px)
- Outlined default, filled on hover
- Icon color inverts on hover
- Group hover pattern
- Smooth transition

---

## Shadows & Elevation

### Shadow Scale

#### Light Shadows
```css
/* No shadows used on most cards in current design */
/* Clean, flat aesthetic preferred */
```

#### Medium Shadows
```css
shadow-lg                      /* 0 10px 15px -3px rgba(0, 0, 0, 0.1) */
```

**Usage:**
- User dropdown menu
- Pricing card buttons

#### Heavy Shadows
```css
shadow-xl                      /* 0 20px 25px -5px rgba(0, 0, 0, 0.1) */
```

**Usage:**
- Pricing cards
- Modal overlays
- Elevated content blocks

### Elevation Levels

**Level 0 - Flat (No Shadow):**
- Hero images
- Section backgrounds
- Most cards
- Navigation bar
- Tab containers

**Level 1 - Subtle (`shadow-lg`):**
- Dropdown menus
- Button hover states
- Inline CTAs

**Level 2 - Elevated (`shadow-xl`):**
- Pricing cards
- Modal dialogs
- Important cards

**Level 3 - Floating:**
```css
/* Combination of shadow and backdrop blur */
.shadow-xl .backdrop-blur-sm
```
- Service circular cards (transparent background + blur)
- "Discover" button (bg-white/90 + backdrop-blur-sm)

### Shadow with Overlay Patterns

#### Image Overlays
```html
<!-- Dark overlay on CTA section -->
<div class="absolute inset-0 bg-black/20"></div>
```

**Usage:**
- CTA section (20% black over background image)
- Improves text readability
- Creates depth

#### Backdrop Blur (Glass Effect)
```css
backdrop-blur-sm               /* Glass morphism effect */
```

**Usage:**
```html
<!-- Button with glass effect -->
<a class="bg-white/90 backdrop-blur-sm">DISCOVER</a>

<!-- Service card with glass effect -->
<div class="bg-transparent backdrop-blur-sm border-white">PRIVATE LABEL</div>
```

---

## Animations & Transitions

### Transition Properties

#### Standard Transitions
```css
transition                     /* All properties */
transition duration-300        /* 300ms duration */
transition-colors             /* Color properties only */
```

**Usage:**
- Navigation links
- Button hover states
- Tab switching
- Link color changes

#### Alpine.js Transitions
```html
<!-- Dropdown animation -->
x-transition

<!-- Custom entry animation -->
x-transition:enter="transition ease-out duration-300"
x-transition:enter-start="opacity-0"
x-transition:enter-end="opacity-100"
```

**Usage:**
- User dropdown menu
- Category tab content switching
- Modal open/close

### Hover States

#### Navigation Links
```css
/* From white to cyan */
.text-white.hover:text-cyan-400.transition.duration-300

/* From cyan to white (active state) */
.text-cyan-400.hover:text-white.transition.duration-300
```

#### Buttons
```css
/* Golden CTA */
.bg-[#FDB913].hover:bg-[#e5a710].transition.duration-300

/* Outlined button */
.hover:bg-blue-50.transition

/* Tab button */
.hover:bg-gray-700.transition-colors
```

#### Cards & Links
```css
/* Article link */
.text-blue-950.hover:text-blue-600.transition

/* Social media icon */
.hover:bg-cyan-400.transition.duration-300
/* Icon color with group hover */
.text-cyan-400.group-hover:text-white.transition
```

### Slider Animations

#### Splide.js Hero Slider
```javascript
// Assumed config from initialization
{
    type: 'fade',           // Crossfade transition
    autoplay: true,
    interval: 5000,
    speed: 1000,
    pauseOnHover: false
}
```

#### Splide.js Product Slider
```javascript
// Assumed config from initialization
{
    type: 'slide',          // Horizontal slide
    perPage: 3,
    perMove: 1,
    gap: '1rem',
    pagination: false,
    arrows: true,
    breakpoints: {
        768: { perPage: 2 },
        640: { perPage: 1 }
    }
}
```

### Loading States

#### Image Lazy Loading
```html
<img loading="lazy" src="..." alt="...">
```

**Usage:**
- Product images in sliders
- Improves initial page load
- Reduces bandwidth

### Animation Timing

```css
duration-300                   /* 300ms - Standard transitions */
```

**No custom animation durations found** - Project consistently uses 300ms for smooth, professional feel

---

## Border Radius

### Radius Scale

#### Sharp Corners (No Radius)
```css
/* Not used in design - all elements have some rounding */
```

#### Small Radius
```css
rounded                        /* 0.25rem (4px) */
```

**Usage:**
- Article card images
- Small decorative elements

#### Medium Radius
```css
rounded-md                     /* 0.375rem (6px) */
rounded-lg                     /* 0.5rem (8px) */
```

**Usage:**
- User dropdown menu (`rounded-md`)
- Tab containers (`rounded-lg`)
- Tab buttons (`rounded-lg`)
- Product cards (`rounded-lg`)
- Category tab container (`rounded-lg`)

#### Large Radius
```css
rounded-xl                     /* 0.75rem (12px) */
rounded-2xl                    /* 1rem (16px) */
```

**Usage:**
- Social media icon boxes (`rounded-xl`)
- Pricing cards (`rounded-2xl`)

#### Full Rounding (Pills/Circles)
```css
rounded-full                   /* 9999px - Perfect circle/pill */
```

**Usage:**
- CTA buttons (pill shape)
- Service cards (perfect circles)
- Circular decorative elements
- Avatar/chatbot icons

### Component-Specific Patterns

#### Cards
```css
/* Pricing cards - soft, friendly */
.rounded-2xl

/* Article cards - subtle */
.rounded

/* Product cards - modern */
.rounded-lg
```

#### Buttons
```css
/* Primary CTA - pill shape */
.rounded-full

/* Secondary buttons - moderate */
.rounded-lg
```

#### Containers
```css
/* Tab container - moderate */
.rounded-lg

/* Dropdown menu - subtle */
.rounded-md
```

---

## Opacity & Transparency

### Opacity Scale

#### Text Opacity
```css
/* No text opacity used - prefers solid colors */
```

#### Background Opacity

**Overlays:**
```css
bg-black/20                    /* 20% black overlay */
bg-white/90                    /* 90% white (semi-transparent) */
```

**Usage:**
```html
<!-- CTA section dark overlay -->
<div class="absolute inset-0 bg-black/20"></div>

<!-- Button with transparency -->
<a class="bg-white/90 backdrop-blur-sm">DISCOVER</a>
```

#### Border Opacity
```css
/* Solid borders only - no opacity variations */
border-white                   /* Solid white borders */
border-cyan-400                /* Solid cyan borders */
border-neutral-700             /* Solid gray borders */
```

### Transparency Patterns

#### Glass Morphism (Frosted Glass Effect)
```html
<div class="bg-white/90 backdrop-blur-sm">
    <!-- Content -->
</div>

<div class="bg-transparent backdrop-blur-sm border-white">
    <!-- Service cards -->
</div>
```

**Characteristics:**
- Semi-transparent background
- Backdrop blur filter
- Border for definition
- Creates depth and modern look

#### Image Overlays
```html
<!-- Dark overlay for text readability -->
<div class="absolute inset-0 bg-black/20"></div>
```

**Usage:**
- Over CTA background images
- Ensures white text is readable
- Adds atmospheric depth

### Z-Index Layering

```css
/* Z-index hierarchy */
z-10                           /* Content layer (sections) */
z-20                           /* Decorative elements */
z-30                           /* Navigation header */
z-50                           /* Dropdown menus, modals */
```

**Stacking Context:**
1. Background images (no z-index)
2. Overlays (`z-10`)
3. Content (`z-10`)
4. Decorative graphics (`z-20`)
5. Navigation (`z-30`)
6. Dropdowns/Modals (`z-50`)

---

## Layout Patterns

### Full-Width Sections

#### Hero Section Pattern
```html
<div class="relative w-full overflow-hidden">
    <!-- Background/Image -->
    <header class="absolute top-0 left-0 right-0 p-4 md:px-12 z-30">
        <!-- Navigation -->
    </header>
    <div class="hero-slider-container">
        <!-- Slider content -->
    </div>
</div>
```

**Characteristics:**
- Full viewport width
- Overflow hidden
- Absolute positioned navigation
- Background image or slider

#### Standard Section Pattern
```html
<section class="relative w-full min-h-screen overflow-hidden">
    <!-- Background Image (optional) -->
    <div class="absolute inset-0">
        <img src="..." class="w-full h-full object-cover">
    </div>

    <!-- Overlay (optional) -->
    <div class="absolute inset-0 bg-black/20"></div>

    <!-- Content -->
    <div class="relative z-10 min-h-screen px-6 md:px-12 lg:px-16 py-12 md:py-16">
        <div class="max-w-7xl mx-auto">
            <!-- Section content -->
        </div>
    </div>
</section>
```

**Characteristics:**
- Full viewport width
- Minimum height of viewport (`min-h-screen`)
- Layered structure (bg → overlay → content)
- Centered content container with max-width
- Responsive padding

### Centered Content Pattern

```html
<div class="max-w-7xl mx-auto">
    <div class="text-center">
        <!-- Centered content -->
    </div>
</div>
```

**Common Widths:**
- `max-w-7xl` - Main content areas
- `max-w-6xl` - Hero content
- `max-w-5xl` - Long-form text
- `max-w-4xl` - Descriptions
- `max-w-3xl` - Narrow content
- `max-w-2xl` - Quotes, centered blocks

### Grid Layouts

#### 3-Column Responsive Grid
```html
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10 lg:gap-12">
    <!-- Cards -->
</div>
```

**Usage:**
- Beautyversity article cards
- Pricing cards
- Breakpoints: 1 col → 2 col (md) → 3 col (lg)

#### Flex Wrap Grid (Alternative)
```html
<div class="flex flex-wrap gap-4 md:gap-6 justify-center">
    <!-- Innovation cards -->
</div>
```

**Usage:**
- Innovation cards (non-uniform sizing)
- Service cards (circular)
- Category tabs

### Two-Column Layouts

#### Map + Address Layout
```html
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12">
    <!-- Left: Map -->
    <div class="w-full">
        <iframe>...</iframe>
    </div>

    <!-- Right: Address -->
    <div class="relative flex items-center justify-center">
        <!-- Address frame -->
    </div>
</div>
```

**Characteristics:**
- Stacks on mobile (`grid-cols-1`)
- Side-by-side on desktop (`lg:grid-cols-2`)
- Large gap between columns

### Flexbox Patterns

#### Space-Between Header
```html
<div class="flex items-center justify-between">
    <!-- Left: Logo -->
    <!-- Right: Navigation -->
</div>
```

#### Centered Footer Elements
```html
<div class="flex flex-col md:flex-row items-center justify-between gap-8">
    <!-- Certifications -->
    <!-- Social media -->
    <!-- Spacer -->
</div>
```

**Characteristics:**
- Stacks vertically on mobile
- Horizontal on desktop
- Space between items
- Centered alignment

### Absolute Positioning Patterns

#### Overlaid Navigation
```html
<header class="absolute top-0 left-0 right-0 ... z-30">
```

#### Decorative Elements
```html
<div class="absolute -top-20 -right-20 z-20">
    <a href="#">DISCOVER</a>
</div>
```

**Note:** Negative positioning can cause overflow issues on small screens

---

## Decorative Elements

### Futuristic Line Graphics

**Description:**
- Cyan/blue glowing lines
- Circuit board aesthetic
- Hexagonal connection points
- Visible in screenshots on dark backgrounds

**Implementation:**
Likely SVG overlays or CSS pseudo-elements (not in provided code, appears to be part of background images)

### Hexagonal Patterns

**Description:**
- Light hexagonal outlines
- Scientific/molecular aesthetic
- Background decorative elements
- Creates depth and tech feel

**Visible in:**
- Product section background
- Scientific section overlays
- Innovation section background

### Molecular Diagrams

**Description:**
- Chemical structure graphics
- Connected dots and lines
- Scientific credibility visual
- Overlaid on blue backgrounds

**Visible in:**
- "The Scientist's Choice" section
- Innovation section
- Background decorative layer

### Geometric Shapes

**Circles:**
```html
<!-- Service cards -->
<div class="rounded-full border-white">
```

**Rounded Squares:**
```html
<!-- Social media icons -->
<div class="rounded-xl border-cyan-400">
```

### Gradient Overlays

**Used in background images:**
- Light blue to white (product section)
- Dark navy to blue (hero sections)
- Atmospheric depth effect

---

## Common Tailwind CSS Usage in Project

### Most Frequent Utility Combinations

#### Section Container
```css
.relative .w-full .min-h-screen .overflow-hidden
```

#### Centered Content
```css
.max-w-7xl .mx-auto
```

#### Responsive Padding
```css
.px-6 .md:px-12 .lg:px-16 .py-12 .md:py-16
```

#### Heading Styles
```css
.text-4xl .md:text-5xl .lg:text-6xl .font-bold .text-white .leading-tight
```

#### Body Text
```css
.text-base .md:text-lg .text-white .leading-relaxed
```

#### Button Base
```css
.px-6 .py-4 .rounded-full .font-bold .transition .duration-300
```

#### Card Base
```css
.bg-white .rounded-2xl .shadow-xl .p-8
```

#### Flex Centering
```css
.flex .items-center .justify-center
```

#### Grid Responsive
```css
.grid .grid-cols-1 .md:grid-cols-2 .lg:grid-cols-3 .gap-8
```

### Responsive Breakpoints Usage

```css
/* Mobile First - Default styles apply to all sizes */

/* sm: 640px - Small tablets (rarely used in project) */

/* md: 768px - Tablets */
.md:text-5xl          /* Larger text */
.md:px-12             /* More padding */
.md:grid-cols-2       /* 2 columns */

/* lg: 1024px - Desktop */
.lg:flex              /* Show navigation */
.lg:text-6xl          /* Even larger text */
.lg:px-16             /* Maximum padding */
.lg:grid-cols-3       /* 3 columns */

/* xl: 1280px - Large desktop */
.xl:text-7xl          /* Hero text */
```

**Common Pattern:**
```html
<h1 class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl">
    <!-- Scales up with screen size -->
</h1>
```

### Display Utilities

**Responsive Display:**
```css
.hidden .lg:flex               /* Hidden on mobile, flex on desktop */
.hidden .md:block              /* Hidden on mobile, block on tablet+ */
.block .md:hidden              /* Show on mobile, hide on tablet+ */
```

### Positioning

**Absolute Positioning:**
```css
.absolute .inset-0             /* Full coverage */
.absolute .top-0 .left-0 .right-0  /* Top bar */
.absolute .-top-20 .-right-20  /* Offset positioning */
```

**Relative Parent:**
```css
.relative                      /* Parent for absolute children */
```

### Overflow

```css
.overflow-hidden               /* Clip content */
.overflow-x-hidden            /* Horizontal scroll prevention */
```

### Object Fit

```css
.object-cover                  /* Fill container, crop if needed */
.object-contain                /* Fit within container, no crop */
```

---

## Component Reference Code

### Complete Hero Section
```html
<div class="relative w-full overflow-hidden">
    <!-- Navigation Header -->
    <header class="absolute top-0 left-0 right-0 p-4 md:px-12 text-center flex m-auto mt-10 z-30">
        <nav class="flex items-center text-center m-auto justify-between">
            <div class="hidden lg:flex items-center space-x-6 text-sm">
                <!-- Main Navigation Links -->
                <a href="/" class="text-cyan-400 hover:text-white transition duration-300">
                    HOME
                </a>
                <a href="#" class="text-white hover:text-cyan-400 transition duration-300">
                    ABOUT
                </a>
                <a href="#" class="text-white hover:text-cyan-400 transition duration-300">
                    SERVICES
                </a>
                <a href="#" class="text-white hover:text-cyan-400 transition duration-300">
                    PRODUCT
                </a>

                <span class="text-gray-500">|</span>

                <a href="#" class="text-white hover:text-cyan-400 transition duration-300">
                    FAQ
                </a>

                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="text-white hover:text-cyan-400 transition duration-300">
                        Username
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-48 bg-neutral-900 rounded-md shadow-lg py-1 z-50 border border-neutral-700">
                        <a href="#" class="block px-4 py-2 text-sm text-white hover:bg-neutral-800">
                            Profile
                        </a>
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-white hover:bg-neutral-800">
                            Sign Out
                        </button>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Background Slider -->
    <div class="hero-slider-container">
        <div class="splide hero-slider">
            <div class="splide__track">
                <ul class="splide__list">
                    <li class="splide__slide">
                        <img src="hero-image.jpg" alt="Hero Image" class="w-full">
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
```

### Tagline Section
```html
<div class="bg-[#000d1a] py-12 px-4 md:px-12 text-center font-adolphus">
    <h2 class="text-3xl md:text-5xl lg:text-6xl font-script text-white italic tracking-wider">
        Beauty Manufacturing Made Simple
    </h2>
</div>
```

### Product Section with Tabs
```html
<div class="min-h-screen bg-[url('/images/bg-section2.webp')] bg-cover bg-center overflow-hidden px-8">

    <!-- Section Header -->
    <div class="pt-16 pb-10 space-y-4 max-w-6xl mx-auto">
        <div class="text-right">
            <h1 class="text-6xl text-blue-900 font-script">
                Transforming <span class="font-bold">Dreams</span> <br>
                Into <span class="font-bold">Reality</span>
            </h1>
        </div>
        <div class="text-right">
            <p class="text-base text-blue-900 font-script">
                Description text here
            </p>
        </div>
    </div>

    <!-- Product Categories & Grid -->
    <div x-data="{ activeTab: 'skincare' }">
        <!-- Category Tabs -->
        <div class="flex flex-wrap gap-2 justify-center text-center">
            <div class="bg-black p-2 rounded-lg">
                <button @click="activeTab = 'skincare'"
                    :class="activeTab === 'skincare' ? 'text-cyan-400' : 'text-white'"
                    class="px-3 py-1 font-semibold text-[21px] hover:text-cyan-300 cursor-pointer rounded-lg hover:bg-gray-700 transition-colors">
                    Skincare
                </button>
                <button @click="activeTab = 'bodycare'"
                    :class="activeTab === 'bodycare' ? 'text-cyan-400' : 'text-white'"
                    class="px-3 py-1 font-semibold text-[21px] hover:text-cyan-300 cursor-pointer rounded-lg hover:bg-gray-700 transition-colors">
                    Bodycare
                </button>
            </div>
        </div>

        <!-- Products Slider -->
        <div class="product-slider-container">
            <div x-show="activeTab === 'skincare'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="splide category-slider"
                 data-category="skincare">
                <div class="splide__track">
                    <ul class="splide__list">
                        <li class="splide__slide">
                            <div class="flex-shrink-0 w-full relative overflow-hidden rounded-lg">
                                <div class="relative flex flex-col items-center justify-center">
                                    <img class="w-full h-72 object-cover" src="product.jpg" alt="Product" loading="lazy">
                                    <div>
                                        <span class="justify-center ml-auto text-xl text-center text-black flex mt-4">
                                            Product Name
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Quote Section -->
    <section class="relative py-16 md:py-20 px-4 md:px-8 text-center">
        <div class="max-w-4xl mx-auto relative z-10">
            <div class="mb-8 md:mb-12">
                <p class="font-rhinetta text-2xl md:text-4xl lg:text-5xl tracking-wide italic font-normal text-blue-900 leading-relaxed">
                    "From research to radiance <br class="hidden md:block">
                    every drop tells the story of science meet beauty."
                </p>
            </div>

            <div class="max-w-6xl mx-auto relative">
                <div class="absolute -top-20 -right-20 z-20">
                    <a href="#" class="border border-blue-400 text-blue-600 font-semibold rounded-lg px-5 py-2 text-xl hover:bg-blue-50 transition inline-block bg-white/90 backdrop-blur-sm text-center">
                        DISCOVER
                        <span class="block text-xs text-blue-400 font-normal -mt-1">
                            our product range
                        </span>
                    </a>
                </div>
                <p class="text-base md:text-lg text-black leading-relaxed text-center">
                    Description paragraph here...
                </p>
            </div>
        </div>
    </section>
</div>
```

### Scientific Section with Full-Screen Layout
```html
<section class="relative w-full min-h-screen overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="bg-science.jpg" class="w-full h-full object-cover" alt="Science Background">
    </div>

    <!-- Content Container -->
    <div class="relative z-10 min-h-screen flex items-center justify-end px-6 md:px-12 lg:px-16 py-12 max-w-7xl mx-auto">
        <div class="w-full max-w-2xl flex flex-col items-center justify-center">
            <!-- Section Title -->
            <div class="mb-8">
                <h2 class="text-3xl md:text-5xl lg:text-6xl font-rhinetta text-white font-normal leading-tight">
                    The Scientist's Choice
                </h2>
            </div>

            <!-- Featured Product Image -->
            <div class="mb-8 flex justify-center">
                <img src="product-featured.webp" class="w-full max-w-md h-96 object-contain" alt="Featured Product">
            </div>

            <!-- Description Text -->
            <div>
                <p class="text-base md:text-lg text-white leading-relaxed max-w-xl text-center">
                    Setiap formulasi unggulan ini kami pilih berdasarkan hasil riset ilmiah dan pengujian mendalam.
                </p>
            </div>
        </div>
    </div>
</section>
```

### Innovation Section with Cards
```html
<section class="relative w-full min-h-screen overflow-hidden">
    <!-- Background Container -->
    <div class="absolute inset-0">
        <img src="innovation-background.png" alt="Innovation Background" class="w-full h-full object-cover">
    </div>

    <!-- Content Container -->
    <div class="relative z-10 min-h-screen px-6 md:px-12 lg:px-16 py-12">
        <div class="max-w-7xl mx-auto">

            <!-- Text Content Section -->
            <div class="mb-12 md:mb-16">
                <!-- Main Header -->
                <div class="mb-4">
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-blue-900">
                        Lunaray <br> Beauty Innovation
                    </h2>
                </div>

                <!-- Sub Header -->
                <div class="mb-6">
                    <h3 class="text-xl md:text-2xl lg:text-3xl text-blue-900 italic">
                        AI-Powered, Nature-Inspired.
                    </h3>
                </div>

                <!-- Description Paragraphs -->
                <div class="space-y-4 max-w-4xl">
                    <p class="text-base md:text-lg text-blue-900 leading-relaxed">
                        Kami melihat riset bukan sekadar data tapi seni untuk memahami kebutuhan manusia melalui sains.
                    </p>
                    <p class="text-base md:text-lg text-blue-900 leading-relaxed">
                        Additional description paragraphs...
                    </p>
                </div>
            </div>

            <!-- Innovation Cards Section -->
            <div class="flex flex-wrap gap-4 md:gap-6">
                <!-- Card 1 -->
                <div class="w-32 md:w-36 lg:w-40">
                    <img src="innovation-card-1.webp" alt="Innovation Card" class="w-full h-auto object-cover">
                </div>

                <!-- Card 2 -->
                <div class="w-32 md:w-36 lg:w-40">
                    <img src="innovation-card-2.webp" alt="Innovation Card" class="w-full h-auto object-cover">
                </div>

                <!-- Card 3 -->
                <div class="w-32 md:w-36 lg:w-40">
                    <img src="innovation-card-3.webp" alt="Innovation Card" class="w-full h-auto object-cover">
                </div>

                <!-- Card 4 - Larger with offset -->
                <div class="w-32 md:w-36 lg:w-52 -mt-10">
                    <img src="innovation-card-4.webp" alt="Innovation Card" class="w-full h-auto object-cover">
                </div>
            </div>

        </div>
    </div>
</section>
```

### Service Journey Section with Circular Cards
```html
<section class="relative w-full min-h-screen overflow-hidden">
    <!-- Background Container -->
    <div class="absolute inset-0">
        <img src="journey-background.webp" alt="Journey Background" class="w-full h-full object-cover">
    </div>

    <!-- Content Container -->
    <div class="relative z-10 min-h-screen px-6 md:px-12 lg:px-16 py-12">
        <div class="max-w-7xl mx-auto">

            <!-- Header Section -->
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4">
                    Create Your <span class="text-white">Journey...</span>
                </h2>
                <p class="text-base md:text-lg text-white leading-relaxed max-w-4xl mx-auto">
                    Lunaray hadir untuk mendampingi beautypreneur di setiap tahap perjalanan
                </p>
            </div>

            <!-- Circular Service Cards -->
            <div class="flex flex-wrap justify-center items-start gap-6 md:gap-8 lg:gap-12 mb-12 md:mb-16">

                <!-- Card 1: Private Label -->
                <div class="text-center w-40 md:w-48">
                    <div class="w-32 h-32 md:w-40 md:h-40 lg:w-48 lg:h-48 rounded-full border-4 md:border-[6px] border-white flex items-center justify-center mb-4 bg-transparent backdrop-blur-sm">
                        <div class="text-center">
                            <h3 class="text-xl md:text-2xl font-bold text-white leading-tight">
                                PRIVATE<br>LABEL
                            </h3>
                        </div>
                    </div>
                </div>

                <!-- Card 2: OEM / ODM -->
                <div class="text-center w-40 md:w-48">
                    <div class="w-32 h-32 md:w-40 md:h-40 lg:w-48 lg:h-48 rounded-full border-4 md:border-[6px] border-white flex items-center justify-center mb-4 bg-transparent backdrop-blur-sm">
                        <div class="text-center">
                            <h3 class="text-xl md:text-2xl font-bold text-white leading-tight">
                                OEM /<br>ODM
                            </h3>
                        </div>
                    </div>
                </div>

                <!-- Additional cards... -->

            </div>

            <!-- Bottom Description -->
            <div class="max-w-5xl mx-auto text-center">
                <p class="text-sm md:text-base lg:text-lg text-white leading-relaxed">
                    Melalui ekosistem manufaktur kosmetik terpadu, kami menyediakan layanan maklon kosmetik terbaik...
                </p>
            </div>

        </div>
    </div>
</section>
```

### Beautyversity Article Grid
```html
<section class="relative w-full min-h-screen overflow-hidden bg-blue-300 py-16 md:py-20">

    <!-- Content Container -->
    <div class="relative z-10 px-6 md:px-12 lg:px-16">
        <div class="max-w-7xl mx-auto">

            <!-- Section Header -->
            <div class="text-center mb-12 md:mb-16">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white">
                    Beauty<span class="font-normal">versity</span>
                </h2>
            </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10 lg:gap-12">

                <!-- Card 1 -->
                <div class="flex flex-col">
                    <!-- Image Container -->
                    <div class="mb-4">
                        <div class="aspect-[4/3] overflow-hidden rounded">
                            <img src="article-image.webp" alt="Article" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="space-y-3">
                        <h3 class="text-xl md:text-2xl font-bold text-blue-950">
                            Article Title Here
                        </h3>
                        <p class="text-sm md:text-base text-blue-950 leading-relaxed">
                            Article excerpt text goes here...
                        </p>
                        <a href="#" class="inline-block text-blue-950 font-semibold hover:text-blue-600 transition">
                            Baca selengkapnya >>
                        </a>
                    </div>
                </div>

                <!-- Additional cards... -->

            </div>

        </div>
    </div>

</section>
```

### Pricing Card
```html
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <div class="p-8 text-center">
        <!-- Plan Name -->
        <h3 class="text-2xl md:text-3xl font-bold text-[#4A9FD8] mb-8">
            Premium
        </h3>

        <!-- Icon/Image -->
        <div class="flex justify-center mb-8">
            <svg class="w-24 h-24 text-[#4A9FD8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5">
                </path>
            </svg>
        </div>

        <!-- Price -->
        <div class="mb-6">
            <span class="text-4xl md:text-5xl font-bold text-[#4A9FD8]">
                $19.00
            </span>
        </div>

        <!-- Description -->
        <p class="text-sm md:text-base text-[#4A9FD8] mb-8 leading-relaxed">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
        </p>

        <!-- Order Button -->
        <button class="w-full bg-[#FDB913] hover:bg-[#e5a710] text-white font-bold py-4 px-6 rounded-full transition duration-300 shadow-lg">
            Order Now
        </button>
    </div>
</div>
```

### CTA Section
```html
<section class="relative w-full min-h-screen overflow-hidden">

    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="cta-background.webp" alt="CTA Background" class="w-full h-full object-cover">
    </div>

    <!-- Dark Overlay -->
    <div class="absolute inset-0 bg-black/20"></div>

    <!-- Content Container -->
    <div class="relative z-10 min-h-screen flex flex-col justify-between items-center px-6 md:px-12 lg:px-16 py-12 md:py-16">

        <!-- Main Heading (Top) -->
        <div class="w-full max-w-6xl text-center pt-8 md:pt-12">
            <h2 class="font-rhinetta text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-script text-white italic leading-tight">
                Ready to Build the Future of <br class="hidden md:block">
                Beauty Together?
            </h2>
        </div>

        <!-- Description Paragraph (Bottom) -->
        <div class="w-full max-w-5xl text-center pb-8 md:pb-12">
            <p class="text-base md:text-lg lg:text-xl text-white leading-relaxed">
                Lunaray Beauty Factory hadir sebagai solusi end-to-end jasa
                <span class="text-cyan-300">maklon kosmetik terbaik</span> untuk pebisnis
                yang ingin menembus pasar dengan produk berkualitas
                <span class="text-cyan-300">tinggi dan legal</span>.
            </p>
        </div>

    </div>

</section>
```

### Contact Section with Map & Social Media
```html
<section class="relative w-full min-h-screen overflow-hidden">

    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="contact-background.webp" alt="Contact Background" class="w-full h-full object-cover">
    </div>

    <!-- Content Container -->
    <div class="relative z-10 min-h-screen px-6 md:px-12 lg:px-16 py-12 md:py-16">
        <div class="max-w-7xl mx-auto">

            <!-- Section Header -->
            <div class="mb-8 md:mb-12">
                <h2 class="font-rhinetta text-4xl md:text-5xl lg:text-6xl font-script text-white italic mb-6">
                    Contact Us
                </h2>
                <p class="text-base md:text-lg text-white leading-relaxed max-w-4xl">
                    Mari mulai perjalanan kolaborasi yang berlandaskan riset, inovasi, dan kepercayaan.
                </p>
            </div>

            <!-- Map and Address Container -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 mb-12 md:mb-16">

                <!-- Map Container -->
                <div class="w-full">
                    <div class="bg-white rounded-lg overflow-hidden shadow-xl">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=..."
                            width="100%"
                            height="400"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy">
                        </iframe>
                    </div>
                </div>

                <!-- Address Container with Frame -->
                <div class="relative flex items-center justify-center">
                    <!-- Background Frame Image -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <img src="address-container.webp" alt="Address Frame" class="w-full h-auto max-w-2xl">
                    </div>
                </div>

            </div>

            <!-- Bottom Section: Certifications & Social Media -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">

                <!-- Certification Badges -->
                <div class="flex-shrink-0 flex items-center gap-4">
                    <img src="CPKB.webp" alt="CPKB" class="w-24 h-24 md:w-32 md:h-32 object-contain">
                    <img src="BPOM.webp" alt="BPOM" class="w-24 h-24 md:w-32 md:h-32 object-contain">
                    <img src="HALAL.webp" alt="HALAL" class="w-24 h-24 md:w-32 md:h-32 object-contain">
                </div>

                <!-- Social Media Icons -->
                <div class="flex items-center gap-6">
                    <!-- Facebook -->
                    <a href="#" class="group">
                        <div class="w-16 h-16 md:w-20 md:h-20 border-4 border-cyan-400 rounded-xl flex items-center justify-center hover:bg-cyan-400 transition duration-300">
                            <svg class="w-8 h-8 md:w-10 md:h-10 text-cyan-400 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </div>
                    </a>

                    <!-- Instagram -->
                    <a href="#" class="group">
                        <div class="w-16 h-16 md:w-20 md:h-20 border-4 border-cyan-400 rounded-xl flex items-center justify-center hover:bg-cyan-400 transition duration-300">
                            <svg class="w-8 h-8 md:w-10 md:h-10 text-cyan-400 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </div>
                    </a>

                    <!-- YouTube -->
                    <a href="#" class="group">
                        <div class="w-16 h-16 md:w-20 md:h-20 border-4 border-cyan-400 rounded-xl flex items-center justify-center hover:bg-cyan-400 transition duration-300">
                            <svg class="w-8 h-8 md:w-10 md:h-10 text-cyan-400 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg>
                        </div>
                    </a>
                </div>

            </div>

        </div>
    </div>

</section>
```

---

## Design System Summary

### Key Design Principles

1. **Science Meets Beauty**
   - Molecular/chemical graphics overlay
   - Lab coat imagery for credibility
   - Futuristic tech elements

2. **Premium & Modern**
   - Generous white space
   - Large, bold typography
   - High-quality product photography
   - Sophisticated color palette

3. **Responsive & Accessible**
   - Mobile-first approach (with desktop focus)
   - Readable text hierarchy
   - Clear call-to-actions
   - Consistent spacing

4. **Brand Identity**
   - Cyan accent for interactivity
   - Deep navy for sophistication
   - Golden yellow for conversion
   - Blue tones for trust and science

### Typography Hierarchy

```
Display (Hero) → font-rhinetta, 4xl-7xl, italic
H1 (Section) → font-rhinetta/bold, 4xl-6xl
H2 (Subsection) → bold, 2xl-4xl
H3 (Card) → bold, xl-2xl
Body → normal, base-lg
```

### Spacing Rhythm

```
Section: py-16 md:py-20, px-6 md:px-12 lg:px-16
Content: max-w-7xl mx-auto
Gap: gap-8 md:gap-10 lg:gap-12
Margin: mb-8 md:mb-12 (standard section spacing)
```

### Color Application

```
Dark Sections → Navy BG + Cyan accents + White text
Light Sections → Light blue BG + Dark blue text + Cyan highlights
CTAs → Golden yellow BG + White text
Interactive → Cyan hover states
```

### Component Patterns

```
Section → relative + min-h-screen + overflow-hidden
Container → max-w-7xl mx-auto
Card → rounded-2xl + shadow-xl + p-8
Button → rounded-full + py-4 px-6 + transition
```

---

## Browser Support & Performance Notes

### Recommended CSS Features
- CSS Grid & Flexbox (full support)
- CSS Custom Properties (for theme customization)
- Backdrop-filter (for glass morphism)
- CSS Transitions (for smooth interactions)

### Image Optimization
- Use WebP format where possible
- Implement lazy loading (`loading="lazy"`)
- Provide multiple sizes for responsive images
- Compress hero/background images

### JavaScript Dependencies
- Alpine.js v3.x (lightweight reactivity)
- Splide.js (slider functionality)
- No jQuery dependency (modern vanilla JS)

---

**End of Style Guide**

*This document should be updated as the design system evolves. Version control recommended.*
