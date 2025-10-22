## ADDED Requirements

### Requirement: Hybrid Authentication System
The system SHALL provide two authentication methods: Google OAuth for public users and email/password for staff (content managers and admins).

#### Scenario: User login with Google
- **WHEN** a user clicks the "Login with Google" button
- **THEN** they are redirected to Google's OAuth consent screen
- **AND** after granting permission, they are logged into the system with their Google account

#### Scenario: New user registration
- **WHEN** a new user logs in with Google for the first time
- **THEN** a new user account is automatically created with their Google profile information
- **AND** they are assigned the default "user" role

#### Scenario: Staff login with email/password
- **WHEN** a content manager or admin enters their email and password
- **THEN** they are authenticated using Laravel's built-in authentication system
- **AND** they are logged in with their assigned role (content_manager or admin)
- **AND** they cannot use Google OAuth for login

#### Scenario: Staff account creation
- **WHEN** an admin creates a new staff account
- **THEN** they must provide email and password for the account
- **AND** they assign the appropriate role (content_manager or admin)
- **AND** the staff member cannot use Google OAuth for this account

#### Scenario: User logout
- **WHEN** a logged-in user clicks the logout button
- **THEN** their session is terminated
- **AND** they are redirected to the landing page

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
