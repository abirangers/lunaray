## Why

Lunaray Beauty Factory currently uses WordPress for their website (lunaray.id), but needs to migrate to a modern Laravel-based platform to support advanced features like chatbot integration, better content management, and a more scalable architecture. The current WordPress setup limits the ability to integrate with modern services and provide a seamless user experience for their cosmetic manufacturing business.

## What Changes

- **BREAKING**: Complete migration from WordPress to Laravel framework
- **BREAKING**: New authentication system using Google OAuth instead of WordPress users
- **BREAKING**: New URL structure and routing system
- **BREAKING**: New database schema and data structure
- New modern UI/UX design using Tailwind CSS
- New chatbot integration via n8n webhook
- New content management system for articles and categories
- New user role system (user, content manager, admin)
- New article system with search, featured articles, and draft/publish status

## Impact

- **Affected specs**: web-platform, user-management, content-management, chatbot-integration
- **Affected code**: Complete website rebuild from scratch
- **Affected systems**: 
  - Current WordPress website will be replaced
  - New Laravel application will be deployed
  - Integration with n8n for chatbot functionality
  - Google OAuth integration for authentication
- **Migration strategy**: Fresh start (no data migration from WordPress)
- **Timeline**: Flexible implementation timeline
