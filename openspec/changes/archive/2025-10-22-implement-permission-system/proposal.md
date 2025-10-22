# Implement Permission System

## Why

The current authentication system only uses role-based access control, which is not granular enough for a professional application. We need a permission-based system that follows Laravel best practices to provide:

- **Granular access control** - specific permissions instead of broad roles
- **Better maintainability** - permission-based middleware and Blade directives
- **Laravel best practices** - using `@can` and `can()` instead of role checks
- **Future scalability** - easy to add new permissions without changing roles

## What Changes

### 1. Permission System Implementation
- Create specific permissions for different features
- Assign permissions to roles (not users directly)
- Use permission-based middleware instead of role-based
- Update Blade templates to use `@can` directives

### 2. Permission Structure
**User Permissions:**
- `access chat` - access to chatbot feature
- `view articles` - view published articles

**Content Manager Permissions:**
- All user permissions +
- `edit articles` - edit existing articles
- `create articles` - create new articles
- `delete articles` - delete articles
- `publish articles` - publish articles
- `unpublish articles` - unpublish articles
- `view admin dashboard` - access admin dashboard

**Admin Permissions:**
- All content manager permissions +
- `manage users` - manage user accounts
- `manage roles` - manage user roles
- `manage permissions` - manage permissions
- `manage system settings` - access system settings

### 3. Technical Implementation
- **PermissionSeeder** - create permissions and assign to roles
- **Route middleware** - use `permission:` instead of `role:`
- **Blade templates** - use `@can('permission-name')` instead of role checks
- **Google OAuth fixes** - stateless OAuth for better reliability

## Impact

### Positive Impact
- ✅ **Better security** - granular permission control
- ✅ **Laravel best practices** - following framework conventions
- ✅ **Maintainable code** - permission-based instead of role-based
- ✅ **Better user experience** - stateless OAuth prevents session errors
- ✅ **Future-proof** - easy to add new permissions

### Breaking Changes
- ❌ **Route middleware** - changed from `role:` to `permission:`
- ❌ **Blade templates** - changed from role checks to permission checks
- ❌ **OAuth behavior** - now stateless instead of stateful

### Migration Required
- Database seeding with new permissions
- Route middleware updates
- Blade template updates
- OAuth configuration changes

## Success Criteria
- [ ] All permissions created and assigned to roles
- [ ] Routes use permission-based middleware
- [ ] Blade templates use `@can` directives
- [ ] Google OAuth works without `InvalidStateException`
- [ ] User experience improved with stateless OAuth
- [ ] Code follows Laravel best practices
