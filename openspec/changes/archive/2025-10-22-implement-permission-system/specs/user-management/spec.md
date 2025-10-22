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
- **BUT** they cannot manage other users

#### Scenario: Admin role permissions
- **WHEN** a user with "admin" role accesses the system
- **THEN** they have full access to all features including user management
- **AND** they can assign roles to other users
- **AND** they can access all content management functions
- **AND** they have access to all permissions in the system
- **AND** they have access to user management and system settings permissions

### Requirement: Google OAuth Integration
The system SHALL integrate with Google OAuth for public user authentication using Laravel Socialite with stateless authentication for improved reliability.

#### Scenario: Google OAuth configuration
- **WHEN** the system is configured for Google OAuth
- **THEN** Google OAuth credentials are properly set in environment variables
- **AND** OAuth routes and callbacks are configured
- **AND** stateless OAuth flow is implemented
- **AND** error handling is implemented for OAuth failures

#### Scenario: Google OAuth user data handling
- **WHEN** a user authenticates with Google OAuth
- **THEN** their Google profile data is stored securely
- **AND** their email and name are extracted from Google profile
- **AND** their account is linked to their Google account
- **AND** stateless OAuth prevents InvalidStateException errors
- **AND** provides better user experience across multiple tabs

#### Scenario: OAuth error handling
- **WHEN** an InvalidStateException occurs during OAuth
- **THEN** the system SHALL redirect user to login page with appropriate error message
- **AND** log the error for debugging purposes
