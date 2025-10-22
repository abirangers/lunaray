## MODIFIED Requirements
### Requirement: Role-Based Access Control
The system SHALL implement three user roles with different permissions: user (Google OAuth), content_manager (email/password), and admin (email/password) using spatie/laravel-permission package with granular permission-based access control.

#### Scenario: User role permissions
- **WHEN** a user with "user" role accesses the system
- **THEN** they can view articles and use the chatbot
- **AND** they have access to 'access chat' and 'view articles' permissions
- **BUT** they cannot access admin functions or content management

#### Scenario: Content manager role permissions
- **WHEN** a user with "content_manager" role accesses the system
- **THEN** they can create, edit, and delete articles and categories
- **AND** they can use the chatbot
- **AND** they have access to all user permissions plus content management permissions
- **AND** they have access to 'view admin dashboard' permission
- **AND** they see a unified admin dashboard with content management features
- **BUT** they cannot manage other users or access system settings
- **AND** User Management and System Settings menu items are completely hidden from the sidebar

#### Scenario: Admin role permissions
- **WHEN** a user with "admin" role accesses the system
- **THEN** they have full access to all features including user management
- **AND** they can assign roles to other users
- **AND** they can access all content management functions
- **AND** they have access to all permissions in the system
- **AND** they have access to user management and system settings permissions
- **AND** they see a unified admin dashboard with all features including user management and system settings
- **AND** they see additional admin-specific dashboard cards for user statistics and system health

## ADDED Requirements
### Requirement: Unified Admin Dashboard
The system SHALL provide a unified admin dashboard that serves both content managers and admins with role-based content and navigation.

#### Scenario: Content manager dashboard view
- **WHEN** a content manager accesses the admin dashboard
- **THEN** they see dashboard cards for article statistics, recent articles, content performance
- **AND** they see navigation items for Dashboard, Articles, Categories, Analytics
- **AND** User Management and System Settings menu items are completely hidden
- **AND** the dashboard shows content management focused metrics and data

#### Scenario: Admin dashboard view
- **WHEN** an admin accesses the admin dashboard
- **THEN** they see all content manager dashboard cards
- **AND** they see additional admin-specific cards for user count, system health, admin analytics
- **AND** they see navigation items for Dashboard, Articles, Categories, Analytics, User Management, System Settings
- **AND** the dashboard shows comprehensive system metrics and administrative data

#### Scenario: Role-based navigation
- **WHEN** a content manager views the admin sidebar
- **THEN** they see only Dashboard, Articles, Categories, Analytics menu items
- **AND** User Management and System Settings items are completely hidden (not visible)
- **AND** the navigation is clean and focused on content management tasks

#### Scenario: Admin navigation
- **WHEN** an admin views the admin sidebar
- **THEN** they see all menu items including Dashboard, Articles, Categories, Analytics, User Management, System Settings
- **AND** all navigation items are visible and accessible
- **AND** the navigation provides access to all administrative functions

### Requirement: Dynamic Dashboard Content
The system SHALL provide different dashboard content based on user role while maintaining consistent UI/UX.

#### Scenario: Content manager dashboard content
- **WHEN** a content manager views the dashboard
- **THEN** they see cards for total articles, published articles, draft articles, featured articles, categories, total views
- **AND** they see sections for recent articles, draft articles, popular articles, categories overview
- **AND** all content is focused on content management and performance

#### Scenario: Admin dashboard content
- **WHEN** an admin views the dashboard
- **THEN** they see all content manager dashboard cards and sections
- **AND** they see additional cards for user count, system health metrics, admin analytics
- **AND** they see comprehensive system overview with administrative insights
- **AND** the dashboard provides full system visibility and control

#### Scenario: Consistent branding and styling
- **WHEN** any staff user (content manager or admin) views the dashboard
- **THEN** they see consistent brand colors, typography, and styling
- **AND** the UI/UX experience is identical regardless of role
- **AND** only the content and navigation items differ based on permissions
