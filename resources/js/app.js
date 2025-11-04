import "./libs/trix";
import './bootstrap';

// Import Sortable.js
import Sortable from 'sortablejs';
window.Sortable = Sortable;

// Import Splide.js
import Splide from '@splidejs/splide';
import '@splidejs/splide/css';

// Import Alpine.js
import Alpine from 'alpinejs';

// Dark mode toggle component
Alpine.data('darkMode', () => ({
    isDark: localStorage.getItem('darkMode') === 'true' || false,
    
    init() {
        this.updateTheme();
    },
    
    toggle() {
        this.isDark = !this.isDark;
        localStorage.setItem('darkMode', this.isDark);
        this.updateTheme();
    },
    
    updateTheme() {
        if (this.isDark) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
}));

// Make Alpine available globally
window.Alpine = Alpine;

// Start Alpine.js
Alpine.start();

// Store Splide instances
window.productSliders = {};
window.heroSlider = null;

// Initialize category slider
window.initCategorySlider = function(categorySlug) {
    // Destroy existing slider for this category
    if (window.productSliders[categorySlug]) {
        window.productSliders[categorySlug].destroy();
    }
    
    // Find slider element
    const sliderElement = document.querySelector(`.category-slider[data-category="${categorySlug}"]`);
    
    if (!sliderElement) return;
    
    // Check if category has products (not just empty state)
    const slideCount = sliderElement.querySelectorAll('.splide__slide').length;
    
    if (slideCount <= 1) {
        // Only empty state, don't initialize slider
        return;
    }
    
    // Initialize new Splide instance
    window.productSliders[categorySlug] = new Splide(sliderElement, {
        type: 'loop',
        perPage: 4,
        perMove: 1,
        gap: '1.5rem',
        padding: '0',
        autoplay: true,
        interval: 4000,
        pauseOnHover: true,
        pauseOnFocus: true,
        arrows: true,
        pagination: true,
        lazyLoad: 'nearby',
        breakpoints: {
            1280: {
                perPage: 3,
                gap: '1.25rem',
            },
            1024: {
                perPage: 2,
                gap: '1rem',
            },
            640: {
                perPage: 1,
                gap: '0.75rem',
            },
        },
    }).mount();
};

// Initialize hero slider
function initHeroSlider() {
    const heroSliderElement = document.querySelector('.hero-slider');
    
    if (heroSliderElement && window.heroSlider === null) {
        window.heroSlider = new Splide(heroSliderElement, {
            type: 'loop',
            perPage: 1,
            perMove: 1,
            gap: '0',
            padding: '0',
            autoplay: true,
            interval: 6000,
            pauseOnHover: false,
            pauseOnFocus: false,
            arrows: false,
            pagination: false,
            lazyLoad: 'nearby',
            speed: 600,
            heightRatio: 0.5625, // 16:9 aspect ratio (9/16 = 0.5625)
            cover: true,
        }).mount();
    }
}

// Initialize first slider on page load
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        // Initialize hero slider
        initHeroSlider();
        
        // Get first category slug
        const firstSlider = document.querySelector('.category-slider');
        if (firstSlider) {
            const firstCategory = firstSlider.getAttribute('data-category');
            initCategorySlider(firstCategory);
        }
    }, 150);
});
