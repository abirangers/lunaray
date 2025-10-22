# user-management Specification

## Purpose
TBD - created by archiving change migrate-to-laravel. Update Purpose after archive.
## Requirements
### Requirement: Hybrid Authentication System
The system SHALL provide two authentication methods: Google OAuth for public users and email/password for staff members (content managers and admins).

#### Scenario: Public user login with Google OAuth
- **WHEN** a public user clicks the "Login with Google" button
- **THEN** they are redirected to Google's OAuth consent screen
- **AND** after granting permission, they are logged into the system with their Google account
- **AND** they are automatically assigned the "user" role

#### Scenario: Staff login with email/password
- **WHEN** a staff member enters their email and password
- **THEN** they are authenticated using Laravel's built-in authentication system
- **AND** they are logged in with their assigned role (content_manager or admin)
- **AND** they cannot use Google OAuth for login

#### Scenario: New Google OAuth user registration
- **WHEN** a new user logs in with Google for the first time
- **THEN** a new user account is automatically created with their Google profile information
- **AND** they are assigned the default "user" role
- **AND** their account is marked as Google OAuth user

#### Scenario: Staff account creation by admin
- **WHEN** an admin creates a new staff account
- **THEN** they must provide email and password for the account
- **AND** they assign the appropriate role (content_manager or admin)
- **AND** the staff member cannot use Google OAuth for this account

### Requirement: Role-Based Access Control
The system SHALL implement three user roles with different permissions: user (Google OAuth), content_manager (email/password), and admin (email/password) using spatie/laravel-permission package.

#### Scenario: User role permissions
- **WHEN** a user with "user" role accesses the system
- **THEN** they can view articles and use the chatbot
- **BUT** they cannot access admin functions or content management

#### Scenario: Content manager role permissions
- **WHEN** a user with "content_manager" role accesses the system
- **THEN** they can create, edit, and delete articles and categories
- **AND** they can use the chatbot
- **BUT** they cannot manage other users

#### Scenario: Admin role permissions
- **WHEN** a user with "admin" role accesses the system
- **THEN** they have full access to all features including user management
- **AND** they can assign roles to other users
- **AND** they can access all content management functions

### Requirement: User Profile Management
The system SHALL allow users to view and update their profile information.

#### Scenario: View user profile
- **WHEN** a logged-in user clicks on their profile
- **THEN** they see their profile information including name, email, role, and registration date
- **AND** the information is populated from their Google account

#### Scenario: Update profile information
- **WHEN** a user updates their profile information
- **THEN** the changes are saved to the database
- **AND** the updated information is reflected immediately

### Requirement: Admin User Management
The system SHALL provide admin interface for managing users and their roles.

#### Scenario: View all users
- **WHEN** an admin accesses the user management section
- **THEN** they see a list of all users with their roles and registration dates
- **AND** the list is paginated for performance

#### Scenario: Change user role
- **WHEN** an admin selects a user and changes their role
- **THEN** the user's permissions are updated immediately
- **AND** the change is logged for audit purposes

#### Scenario: Search users
- **WHEN** an admin searches for users by name or email
- **THEN** the system returns matching users
- **AND** the search is case-insensitive and supports partial matches

### Requirement: Session Management
The system SHALL properly manage user sessions and security.

#### Scenario: Session timeout
- **WHEN** a user is inactive for a specified period
- **THEN** their session expires and they are required to log in again
- **AND** they are redirected to the login page with an appropriate message

#### Scenario: Secure session handling
- **WHEN** a user logs in
- **THEN** their session is secured with proper tokens
- **AND** the session is protected against common security vulnerabilities

### Requirement: User Activity Logging
The system SHALL log important user activities for security and audit purposes.

#### Scenario: Login activity logging
- **WHEN** a user logs in
- **THEN** the system logs the login time, IP address, and user agent
- **AND** the log entry is stored securely

#### Scenario: Role change logging
- **WHEN** an admin changes a user's role
- **THEN** the system logs who made the change, when, and what the change was
- **AND** the log entry includes the target user information

### Requirement: Google OAuth Integration
The system SHALL integrate with Google OAuth for public user authentication using Laravel Socialite.

#### Scenario: Google OAuth configuration
- **WHEN** the system is configured for Google OAuth
- **THEN** Google OAuth credentials are properly set in environment variables
- **AND** OAuth routes and callbacks are configured
- **AND** error handling is implemented for OAuth failures

#### Scenario: Google OAuth user data handling
- **WHEN** a user authenticates with Google OAuth
- **THEN** their Google profile data is stored securely
- **AND** their email and name are extracted from Google profile
- **AND** their account is linked to their Google account

### Requirement: Staff Authentication System
The system SHALL provide email/password authentication for staff members with proper security measures.

#### Scenario: Staff account security
- **WHEN** a staff account is created
- **THEN** password is hashed using Laravel's built-in hashing
- **AND** account is marked as staff account
- **AND** role is assigned appropriately

#### Scenario: Staff login security
- **WHEN** a staff member attempts to log in
- **THEN** credentials are validated securely
- **AND** failed login attempts are logged
- **AND** account lockout is handled appropriately

### Requirement: Authentication UI Components
The system SHALL provide user-friendly login/logout interfaces for both authentication methods.

#### Scenario: Google OAuth login UI
- **WHEN** a user visits the login page
- **THEN** they see a clear "Login with Google" button
- **AND** the button is styled consistently with the site design
- **AND** the OAuth flow is initiated when clicked

#### Scenario: Staff login UI
- **WHEN** a staff member visits the login page
- **THEN** they see email and password input fields
- **AND** the form is styled consistently with the site design
- **AND** form validation provides clear error messages

#### Scenario: Logout functionality
- **WHEN** a logged-in user clicks logout
- **THEN** their session is terminated
- **AND** they are redirected to the appropriate page
- **AND** logout confirmation is provided

