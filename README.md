# 🌙 Lunaray Beauty Factory

<p align="center">
  <img src="https://via.placeholder.com/400x100/1e40af/ffffff?text=LUNARAY+BEAUTY+FACTORY" width="400" alt="Lunaray Beauty Factory Logo">
</p>

<p align="center">
  <strong>Solusi Total untuk Kosmetik Berkualitas</strong>
</p>

<p align="center">
  <a href="https://laravel.com" target="_blank"><img src="https://img.shields.io/badge/Laravel-11.x-red.svg" alt="Laravel Version"></a>
  <a href="https://tailwindcss.com" target="_blank"><img src="https://img.shields.io/badge/TailwindCSS-4.x-blue.svg" alt="TailwindCSS Version"></a>
  <a href="https://openspec.dev" target="_blank"><img src="https://img.shields.io/badge/OpenSpec-Spec%20Driven-green.svg" alt="OpenSpec"></a>
  <a href="https://opensource.org/licenses/MIT" target="_blank"><img src="https://img.shields.io/badge/License-MIT-yellow.svg" alt="License"></a>
</p>

## 🎯 About Lunaray Beauty Factory

Lunaray Beauty Factory adalah platform comprehensive untuk industri kosmetik yang menyediakan solusi lengkap dari ide hingga produk siap edar. Kami membantu brand kosmetik tumbuh melalui inovasi, legalitas resmi, dan layanan menyeluruh.

**"Beauty is a journey, not a destination: it's about unveiling the masterpiece that you already are."**

### 🌟 Key Features

- **🔐 Hybrid Authentication System** - Google OAuth untuk public users, email/password untuk staff
- **👥 Role-Based Access Control** - 3 level roles (user, content_manager, admin)
- **🎨 Modern UI/UX** - Responsive design dengan custom TailwindCSS theme
- **📱 Mobile-First Design** - Optimized untuk semua devices
- **🤖 AI Chatbot Integration** - Production-ready chatbot dengan n8n webhook
- **📝 Content Management** - Complete article & category management system
- **👤 User Profile System** - Comprehensive profile management dengan avatar upload
- **📊 Advanced Analytics** - View count tracking dengan bot protection
- **⚡ Bulk Operations** - Advanced bulk actions untuk content management
- **🔒 Security First** - Implementasi security best practices
- **📊 Comprehensive Testing** - Complete test coverage dengan credentials
- **🖼️ Advanced Media Management** - Spatie MediaLibrary dengan automatic image conversions, responsive images, dan optimization

## 🖼️ Media Management

Lunaray Beauty Factory menggunakan **Spatie MediaLibrary v11** untuk comprehensive media management:

### **Features**
- **Automatic Image Conversions** - Thumb (300x200), Medium (800x600), Large (1200x800)
- **Responsive Images** - Automatic responsive image generation untuk optimal loading
- **Image Optimization** - Built-in optimization dengan multiple format support (JPEG, PNG, WebP, AVIF)
- **Queue Processing** - Background image processing untuk better performance
- **Media Collections** - Organized media storage dengan collections (featured, gallery, avatar)
- **Custom Properties** - Rich metadata support untuk media files

### **Usage Examples**
```php
// Article featured image
$article->addMediaFromRequest('featured_image')
    ->toMediaCollection('featured');

// User avatar
$user->addMediaFromRequest('avatar')
    ->toMediaCollection('avatar');

// Display with conversions
$article->getFirstMediaUrl('featured', 'large')
$user->getFirstMediaUrl('avatar', 'thumb')
```

### **Queue Setup**
```bash
# Start queue worker for image processing
php artisan queue:work

# Process conversions
php artisan queue:work --queue=media-conversions
```

## 🚀 Quick Start

### Prerequisites

- **PHP >= 8.2**
- **Composer** - PHP dependency manager
- **Node.js >= 20.19.0** - For frontend assets
- **MySQL/PostgreSQL** - Database
- **Google OAuth** - For authentication (optional)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/lunaray-beauty-factory.git
   cd lunaray-beauty-factory
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Build frontend assets**
   ```bash
   npm run build
   ```

7. **Start development server**
   ```bash
   php artisan serve
   ```

## 🔐 Authentication System

### User Types

- **👤 Public Users** - Google OAuth authentication
- **👨‍💼 Content Managers** - Email/password authentication
- **👑 Admins** - Email/password authentication with full access

### Test Credentials

See `TESTING_CREDENTIALS.md` for complete test user credentials.

## 🏗️ Project Structure

```
lunaray/
├── app/
│   ├── Http/Controllers/Auth/     # Authentication controllers
│   ├── Http/Middleware/           # Role-based middleware
│   └── Models/                    # User model with roles
├── database/
│   ├── migrations/                # Database schema
│   └── seeders/                   # Test data
├── resources/
│   ├── css/                       # Custom TailwindCSS theme
│   ├── views/
│   │   ├── auth/                  # Login pages
│   │   ├── admin/                 # Admin dashboard
│   │   └── home.blade.php         # Landing page
│   └── js/                        # Frontend JavaScript
├── openspec/                      # OpenSpec documentation
└── routes/web.php                 # Application routes
```

## 🛠️ Development

### OpenSpec Integration

This project uses [OpenSpec](https://openspec.dev) for spec-driven development:

```bash
# List active changes
openspec list

# View change details
openspec show <change-id>

# Validate specifications
openspec validate --strict

# Archive completed changes
openspec archive <change-id> --yes
```

### Available Commands

```bash
# Development
php artisan serve                    # Start development server
npm run dev                         # Start Vite dev server
npm run build                       # Build for production

# Database
php artisan migrate                 # Run migrations
php artisan db:seed                 # Seed database
php artisan migrate:fresh --seed    # Fresh migration with seeding

# Testing
php artisan test                    # Run PHP tests
```

### 🎯 Completed Features

#### **Phase 0-2: Core Foundation**
- ✅ **Laravel 11.x Migration** - Modern framework dengan TailwindCSS 4
- ✅ **Google OAuth Integration** - Laravel Socialite
- ✅ **Staff Authentication** - Email/password login
- ✅ **Role-Based Access Control** - 3 user roles dengan granular permissions
- ✅ **Custom TailwindCSS Theme** - OKLCH color palette dengan brand identity
- ✅ **Responsive UI Components** - Mobile-first design
- ✅ **Database Seeding** - Test data dan credentials
- ✅ **Middleware Protection** - Route-based access control

#### **Phase 3: Content & Chatbot Integration**
- ✅ **Content Management System** - Complete article & category CRUD
- ✅ **Rich Text Editor** - tonysm/rich-text-laravel integration
- ✅ **SEO Optimization** - ralphjsmit/laravel-seo package
- ✅ **AI Chatbot Integration** - Production-ready dengan n8n webhook
- ✅ **Chat History Management** - Database persistence dan session management
- ✅ **Rate Limiting** - 30 requests/minute per user
- ✅ **Advanced Chat UI** - Message copy, auto-resize, status indicators

#### **Phase 4-5: Modern UI/UX Redesign**
- ✅ **Admin Interface Redesign** - Modern minimalist dengan dark/light mode
- ✅ **Advanced Data Tables** - Search, filter, bulk operations
- ✅ **Enhanced Forms** - Floating labels, drag & drop, auto-save
- ✅ **Public Pages Redesign** - Modern minimalist public interface
- ✅ **Mobile Optimization** - Responsive design untuk semua devices
- ✅ **SEO Enhancement** - Meta tags, structured data, social sharing

#### **Phase 6: Advanced Features**
- ✅ **User Profile Management** - Comprehensive profile system dengan avatar upload
- ✅ **Enhanced View Count Tracking** - Session-based duplicate prevention
- ✅ **Bot Protection** - User agent filtering untuk accurate analytics
- ✅ **Bulk Actions** - Advanced bulk operations untuk content management
- ✅ **Performance Optimization** - Cache-based batch updates

## 📚 Documentation

- **[Project Context](./CONTEXT.md)** - Current focus, status, and project overview
- **[Changelog](./CHANGELOG.md)** - Detailed change history and version tracking
- **[OpenSpec Documentation](./openspec/AGENTS.md)** - Spec-driven development workflow
- **[Project Specifications](./openspec/specs/)** - Current requirements and capabilities
- **[Testing Credentials](./TESTING_CREDENTIALS.md)** - Complete test user credentials

## 🎨 Design System

### **Modern Minimalist Aesthetic**
- **Color Palette**: OKLCH color space dengan Deep Blue primary, Light Blue secondary
- **Typography**: Inter (sans-serif), Playfair Display (serif), JetBrains Mono (monospace)
- **Components**: Modern cards, buttons, forms dengan hover effects dan animations
- **Dark Mode**: Complete dark/light mode support dengan Alpine.js integration

### **Responsive Design**
- **Mobile-First**: Optimized untuk semua screen sizes
- **Touch-Friendly**: Appropriate sizing untuk mobile interactions
- **Performance**: Optimized loading times dan asset delivery

## 🤝 Contributing

We welcome contributions! Please follow these steps:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Follow OpenSpec workflow for changes
4. Commit your changes (`git commit -m 'Add amazing feature'`)
5. Push to the branch (`git push origin feature/amazing-feature`)
6. Open a Pull Request

### Development Guidelines

- Follow [Laravel conventions](https://laravel.com/docs/contributions)
- Use OpenSpec for all feature changes
- Write tests for new functionality
- Ensure responsive design compatibility
- Follow security best practices

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🚀 Production Status

### **✅ Ready for Production**
- **All Core Features**: Authentication, Content Management, Chatbot, User Profiles
- **Modern UI/UX**: Complete redesign dengan responsive design
- **Performance**: Optimized dengan cache-based updates dan session management
- **Security**: Enhanced dengan bot protection, rate limiting, dan input validation
- **Testing**: Comprehensive test coverage dengan complete credentials

### **📊 System Capabilities**
- **4 Complete Specifications**: user-management, content-management, chatbot-integration, web-platform
- **7 Completed Phases**: From Laravel migration to advanced features
- **Modern Tech Stack**: Laravel 11.x, TailwindCSS 4, Alpine.js, OpenSpec
- **Production-Ready**: All features tested dan optimized untuk production deployment

## 🙏 Acknowledgments

- Built with [Laravel](https://laravel.com) framework
- Styled with [TailwindCSS](https://tailwindcss.com)
- Spec-driven development with [OpenSpec](https://openspec.dev)
- Authentication powered by [Laravel Socialite](https://laravel.com/docs/socialite)
- Rich text editing with [tonysm/rich-text-laravel](https://github.com/tonysm/rich-text-laravel)
- SEO optimization with [ralphjsmit/laravel-seo](https://github.com/ralphjsmit/laravel-seo)
- Permissions with [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)

---

<p align="center">
  <strong>🌙 Lunaray Beauty Factory</strong><br>
  <em>Solusi Total untuk Kosmetik Berkualitas</em>
</p>
