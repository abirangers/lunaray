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

### Requirement: User Profile Management
The system SHALL provide comprehensive profile management functionality for all user types (users, content managers, and admins) with role-based features and permissions.

#### Scenario: User views their profile
- **WHEN** a logged-in user clicks on their profile or avatar
- **THEN** they see their profile page with personal information, avatar, bio, and activity history
- **AND** the profile page displays their role, registration date, and account statistics
- **AND** they can edit their profile information and upload an avatar

#### Scenario: User edits their profile
- **WHEN** a user updates their profile information
- **THEN** the changes are validated and saved to the database
- **AND** the updated information is reflected immediately on their profile page
- **AND** they receive confirmation of successful updates
- **AND** profile changes are logged for audit purposes

#### Scenario: User uploads avatar
- **WHEN** a user uploads a new avatar image
- **THEN** the image is processed and resized appropriately
- **AND** the avatar is displayed across all user interfaces
- **AND** the old avatar is replaced and stored securely
- **AND** image validation ensures proper format and size

#### Scenario: Content manager profile features
- **WHEN** a content manager views their profile
- **THEN** they see extended profile information including content statistics
- **AND** they can view their article creation history and performance metrics
- **AND** they have access to content management preferences and settings
- **AND** they can manage their content creation workflow settings

#### Scenario: Admin profile features
- **WHEN** an admin views their profile
- **THEN** they see comprehensive profile information with admin-specific statistics
- **AND** they can view system administration metrics and user management statistics
- **AND** they have access to admin preferences and system settings
- **AND** they can manage their administrative workflow and preferences

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

### Requirement: Permission-Based Access Control
The system SHALL implement granular permission-based access control using Spatie Laravel Permission package.

#### Scenario: User permission check
- **WHEN** a user attempts to access a protected resource
- **THEN** the system SHALL check if the user has the required permission
- **AND** grant access only if permission is present

#### Scenario: Role-based permission inheritance
- **WHEN** a user is assigned to a role
- **THEN** the user SHALL inherit all permissions assigned to that role
- **AND** permissions SHALL be checked at route, controller, and view levels

### Requirement: Permission Structure
The system SHALL define specific permissions for different user types.

#### Scenario: User permissions
- **WHEN** a user with 'user' role logs in
- **THEN** they SHALL have access to 'access chat' and 'view articles' permissions

#### Scenario: Content manager permissions
- **WHEN** a user with 'content_manager' role logs in
- **THEN** they SHALL have access to all user permissions plus content management permissions
- **AND** they SHALL have access to 'view admin dashboard' permission

#### Scenario: Admin permissions
- **WHEN** a user with 'admin' role logs in
- **THEN** they SHALL have access to all permissions in the system
- **AND** they SHALL have access to user management and system settings permissions

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

### Requirement: User Dashboard Integration
The existing user management dashboard SHALL be enhanced with modern design and improved data visualization.

#### Scenario: Admin views user statistics
- **WHEN** admin accesses user management dashboard
- **THEN** they see modern statistics cards with user metrics
- **AND** charts display user growth trends and role distribution
- **AND** recent user activity is shown in an interactive timeline
- **AND** quick action buttons provide shortcuts to common tasks

### Requirement: User Role Management
The existing role management interface SHALL be enhanced with better UX and visual design.

#### Scenario: Admin manages user roles
- **WHEN** admin assigns or changes user roles
- **THEN** they see clear role indicators and permissions
- **AND** role changes are confirmed with appropriate warnings
- **AND** role history is tracked and displayed
- **AND** bulk role changes are supported for multiple users

### Requirement: Enhanced User Management Interface
The system SHALL provide a redesigned user management interface with modern table design and advanced functionality.

#### Scenario: Admin views user list
- **WHEN** admin accesses the user management page
- **THEN** they see a modern data table with search, filter, and sort capabilities
- **AND** table displays user information with avatars, roles, and status indicators
- **AND** bulk selection allows multiple user operations
- **AND** pagination controls are clearly visible and functional

### Requirement: Advanced User Search and Filtering
The system SHALL provide comprehensive search and filtering options for user management.

#### Scenario: Admin searches and filters users
- **WHEN** admin uses search and filter options
- **THEN** they can search by name, email, role, or registration date
- **AND** filters can be combined for precise results
- **AND** search results update in real-time without page reload
- **AND** filter state is preserved during navigation

### Requirement: Bulk User Operations
The system SHALL provide bulk operations for user management tasks.

#### Scenario: Admin performs bulk operations
- **WHEN** admin selects multiple users
- **THEN** they can perform bulk operations (delete, change role, export)
- **AND** confirmation dialogs prevent accidental operations
- **AND** operation results are clearly communicated to the admin
- **AND** bulk operations are logged for audit purposes

### Requirement: Enhanced User Forms
The system SHALL provide improved user creation and editing forms.

#### Scenario: Admin creates or edits user
- **WHEN** admin opens user create/edit form
- **THEN** they see modern form layout with floating labels and validation
- **AND** role selection uses enhanced dropdown with search
- **AND** form provides real-time validation feedback
- **AND** file upload for avatar supports drag & drop
- **AND** form is responsive and works on mobile devices

### Requirement: Profile Navigation Integration
The system SHALL integrate profile access into all navigation layouts with appropriate role-based access.

#### Scenario: Profile navigation in user layout
- **WHEN** a user is logged in and viewing the app layout
- **THEN** they see a profile link or avatar in the navigation
- **AND** clicking on it takes them to their profile page
- **AND** the navigation clearly indicates profile access

#### Scenario: Profile navigation in admin layout
- **WHEN** a content manager or admin is logged in and viewing the admin layout
- **THEN** they see profile access in the admin navigation
- **AND** clicking on it takes them to their profile page with role-appropriate features
- **AND** the navigation integrates seamlessly with existing admin functionality

### Requirement: Avatar Management System
The system SHALL provide comprehensive avatar upload and management functionality.

#### Scenario: Avatar upload process
- **WHEN** a user uploads an avatar image
- **THEN** the system validates image format (JPEG, PNG, WebP)
- **AND** the image is resized to standard dimensions (150x150px)
- **AND** the image is stored securely in the public storage
- **AND** the user's avatar is updated across all interfaces

#### Scenario: Avatar display
- **WHEN** a user's avatar is displayed anywhere in the system
- **THEN** it shows their uploaded avatar or a default avatar if none exists
- **AND** the avatar is displayed consistently across all user interfaces
- **AND** the avatar is properly sized and formatted for each context

### Requirement: Profile Activity Tracking
The system SHALL track and display user activity history on their profile page.

#### Scenario: Activity tracking display
- **WHEN** a user views their profile page
- **THEN** they see a timeline of their recent activities
- **AND** activities include article views, profile updates, and system interactions
- **AND** the activity feed is paginated and shows recent actions first
- **AND** different user types see appropriate activity information

#### Scenario: Activity logging
- **WHEN** a user performs actions in the system
- **THEN** relevant activities are logged to their profile
- **AND** activities include timestamps and contextual information
- **AND** activity logging respects user privacy and data protection

### Requirement: Profile Statistics and Analytics
The system SHALL provide role-appropriate statistics and analytics on user profile pages.

#### Scenario: User profile statistics
- **WHEN** a regular user views their profile
- **THEN** they see basic statistics like account age, articles viewed, and profile completeness
- **AND** statistics are displayed in an easy-to-understand format
- **AND** statistics help users understand their platform usage

#### Scenario: Content manager profile statistics
- **WHEN** a content manager views their profile
- **THEN** they see content creation statistics including articles created, views received, and performance metrics
- **AND** they can view their content creation timeline and success rates
- **AND** statistics help them track their content management performance

#### Scenario: Admin profile statistics
- **WHEN** an admin views their profile
- **THEN** they see comprehensive system statistics including user management metrics and system health
- **AND** they can view administrative activity and system performance data
- **AND** statistics help them monitor system usage and administrative effectiveness

### Requirement: Profile Security and Permissions
The system SHALL implement proper security measures for profile management.

#### Scenario: Profile access control
- **WHEN** a user attempts to access profile functionality
- **THEN** the system verifies their authentication and permissions
- **AND** users can only access and modify their own profile information
- **AND** admins can view other user profiles but with appropriate restrictions

#### Scenario: Profile data protection
- **WHEN** profile data is stored or transmitted
- **THEN** sensitive information is properly encrypted and protected
- **AND** profile updates are validated to prevent malicious input
- **AND** profile access is logged for security auditing

### Requirement: Profile Form Validation and Error Handling
The system SHALL provide comprehensive validation and error handling for profile management.

#### Scenario: Profile form validation
- **WHEN** a user submits profile information
- **THEN** the system validates all input fields according to appropriate rules
- **AND** validation errors are displayed clearly to the user
- **AND** the form preserves valid data while highlighting errors

#### Scenario: Profile update error handling
- **WHEN** a profile update fails
- **THEN** the system provides clear error messages to the user
- **AND** the user's current profile data remains unchanged
- **AND** errors are logged for debugging and improvement purposes

