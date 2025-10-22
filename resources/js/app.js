import "./libs/trix";
import './bootstrap';

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
