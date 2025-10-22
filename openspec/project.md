# Project Context - Lunaray Beauty Factory

## Purpose
Lunaray Beauty Factory is a comprehensive platform for the cosmetics industry that provides complete solutions from concept to market-ready products. The platform helps beauty brands grow through innovation, official legality, and comprehensive services.

**Mission**: "Beauty is a journey, not a destination: it's about unveiling the masterpiece that you already are."

## Tech Stack

### Backend
- **Framework**: Laravel 11.x with PHP 8.2+
- **Database**: MySQL/PostgreSQL with migrations and seeders
- **Authentication**: Laravel Socialite (Google OAuth) + Email/Password
- **Permissions**: Spatie Laravel Permission for role-based access
- **Rich Text**: tonysm/rich-text-laravel for content editing
- **SEO**: ralphjsmit/laravel-seo for search optimization

### Frontend
- **Styling**: TailwindCSS 4 with custom brand theme
- **Interactivity**: Alpine.js for dynamic components
- **Templates**: Template Inheritance (@extends/@section)
- **Build Tool**: Vite for asset compilation

### Development
- **Spec Management**: OpenSpec for spec-driven development
- **Testing**: PestPHP for comprehensive testing
- **Version Control**: Git with conventional commits

## Project Conventions

### Code Style
- **PHP/Laravel**: Follow PSR-12 coding standards
- **Naming**: Use meaningful variable and function names
- **Comments**: Add PHPDoc comments for complex functions
- **Helpers**: Use Laravel's built-in helpers and facades
- **Conventions**: Follow Laravel naming conventions (controllers, models, migrations)

### Architecture Patterns
- **Template Inheritance**: Use @extends/@section instead of Blade components
- **MVC Pattern**: Clear separation of concerns with controllers, models, views
- **Service Layer**: Business logic in dedicated service classes
- **Repository Pattern**: Data access abstraction where needed
- **Middleware**: Permission-based route protection

### Testing Strategy
- **Unit Tests**: Test models, services, and business logic
- **Feature Tests**: Test complete user workflows
- **Integration Tests**: Test external API integrations (n8n webhook)
- **Coverage**: Aim for 80%+ test coverage on critical paths
- **Credentials**: Use provided test credentials from TESTING_CREDENTIALS.md

### Git Workflow
- **Conventional Commits**: `type(scope): description`
  - `feat(auth): add Google OAuth integration`
  - `fix(ui): resolve button styling issue`
  - `chore(deps): update TailwindCSS to v4`
- **Branch Strategy**: Feature branches for new development
- **Review Process**: Pull request reviews before merging
- **OpenSpec Integration**: All changes tracked through OpenSpec workflow

## Domain Context

### Business Domain
- **Industry**: Cosmetics and beauty manufacturing
- **Target Users**: Beauty brands, content managers, administrators
- **Core Services**: Content management, AI chatbot support, user management

### User Types
1. **Public Users** (Google OAuth) - Role: `user`
   - Access: Chatbot, view articles
   - Authentication: Google OAuth via Laravel Socialite

2. **Content Managers** (Email/Password) - Role: `content_manager`
   - Access: All user permissions + content management + admin dashboard
   - Authentication: Email/password traditional

3. **Admins** (Email/Password) - Role: `admin`
   - Access: Full system access + user management + system settings
   - Authentication: Email/password traditional

### Key Features
- **Hybrid Authentication**: Google OAuth for public users, email/password for staff
- **Content Management**: Article CRUD with rich text editor and SEO optimization
- **AI Chatbot**: n8n webhook integration for customer support
- **Role-Based Access**: Granular permissions using Spatie Laravel Permission

## Important Constraints

### Technical Constraints
- **PHP Version**: Must use PHP 8.2+ for Laravel 11.x compatibility
- **Database**: MySQL/PostgreSQL required for production
- **Security**: All user data must be encrypted at rest
- **Performance**: Page load times must be under 3 seconds
- **Responsive**: Mobile-first design required

### Business Constraints
- **Authentication**: Must support both Google OAuth and traditional login
- **Permissions**: Granular role-based access control required
- **Content**: Rich text editing with image upload capabilities
- **SEO**: All content must be SEO-optimized
- **Chatbot**: Must integrate with external n8n webhook service

### Regulatory Constraints
- **Data Protection**: User data handling according to privacy policies
- **Security**: Secure webhook communication with HTTPS
- **Audit**: User activity logging for security and audit purposes

## External Dependencies

### Authentication Services
- **Google OAuth**: Laravel Socialite integration
- **Configuration**: Google OAuth credentials in environment variables
- **Redirect URIs**: Must be configured in Google Console

### AI/Chatbot Services
- **n8n Webhook**: External chatbot service integration
- **Configuration**: Webhook URL and timeout settings
- **Security**: HTTPS communication with error handling

### Content Services
- **Rich Text Editor**: tonysm/rich-text-laravel package
- **SEO Optimization**: ralphjsmit/laravel-seo package
- **Image Storage**: Laravel file storage system

### Development Tools
- **OpenSpec**: Specification-driven development workflow
- **Testing**: PestPHP testing framework
- **Build Tools**: Vite for frontend asset compilation
- **Version Control**: Git with conventional commit messages

## Brand Identity

### Color Scheme
- **Primary**: Deep Blue (oklch(0.45 0.15 240))
- **Secondary**: Light Blue (oklch(0.75 0.12 200))
- **Accent**: Bright Blue (oklch(0.85 0.08 200))
- **Neutral**: White/Light Gray (oklch(0.95 0.02 0))

### Typography
- **Sans-serif**: Inter for body text
- **Serif**: Playfair Display for headings
- **Monospace**: JetBrains Mono for code

## Development Workflow

### OpenSpec Process
1. **Create Change Proposal** - Plan new features using OpenSpec
2. **Implement Changes** - Build according to specifications
3. **Archive Changes** - Complete and document changes

### Quality Assurance
- **Code Review**: All changes reviewed before merging
- **Testing**: Comprehensive test coverage for all features
- **Documentation**: All changes documented in CHANGELOG.md
- **Specifications**: All capabilities defined in OpenSpec specs
