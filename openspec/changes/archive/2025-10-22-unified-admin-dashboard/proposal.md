## Why
Currently, the admin dashboard is designed only for content managers, but we need to support both content managers and admins with different permission levels. We need a unified dashboard that shows different content and navigation based on user roles while maintaining a consistent UI/UX experience.

## What Changes
- **Unified Admin Dashboard**: Single dashboard layout for both content managers and admins
- **Role-Based Navigation**: Sidebar items completely hidden based on permissions (not disabled)
- **Dynamic Dashboard Content**: Different cards and metrics based on user role
- **Permission-Based UI**: Conditional rendering throughout the dashboard
- **Consistent Branding**: Same styling and colors for all roles

## Impact
- **Affected specs**: user-management (role-based access control)
- **Affected code**: 
  - `resources/views/layouts/admin.blade.php` (sidebar navigation)
  - `resources/views/admin/dashboard.blade.php` (dashboard content)
  - `app/Http/Controllers/ContentManagerController.php` (dashboard data logic)
  - Routes and middleware (permission-based access)
- **Breaking changes**: None - this is an enhancement to existing functionality
