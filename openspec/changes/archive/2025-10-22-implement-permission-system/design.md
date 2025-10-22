# Permission System Design

## Architecture Overview

```
User → Role → Permissions → Features
```

### Permission Hierarchy
```
Admin Role
├── manage users
├── manage roles  
├── manage permissions
├── manage system settings
├── view admin dashboard
├── edit articles
├── create articles
├── delete articles
├── publish articles
├── unpublish articles
├── access chat
└── view articles

Content Manager Role
├── view admin dashboard
├── edit articles
├── create articles
├── delete articles
├── publish articles
├── unpublish articles
├── access chat
└── view articles

User Role
├── access chat
└── view articles
```

## Technical Implementation

### 1. Database Structure
```php
// Permissions table (spatie/laravel-permission)
permissions: id, name, guard_name, created_at, updated_at

// Roles table (spatie/laravel-permission)  
roles: id, name, guard_name, created_at, updated_at

// Role-Permission pivot table
role_has_permissions: permission_id, role_id

// User-Role pivot table
model_has_roles: role_id, model_type, model_id
```

### 2. Permission Seeder
```php
// Create permissions
$permissions = [
    'access chat', 'view articles', 'edit articles',
    'create articles', 'delete articles', 'publish articles',
    'unpublish articles', 'manage users', 'manage roles',
    'manage permissions', 'view admin dashboard', 'manage system settings'
];

// Assign to roles
$userRole->givePermissionTo(['access chat', 'view articles']);
$contentManagerRole->givePermissionTo([...all user permissions + content permissions]);
$adminRole->givePermissionTo([...all permissions]);
```

### 3. Route Middleware
```php
// Before (role-based)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', ...);
});

// After (permission-based)
Route::middleware(['auth', 'permission:access chat'])->group(function () {
    Route::get('/user/dashboard', ...);
});
```

### 4. Blade Templates
```blade
{{-- Before (role-based) --}}
@if(auth()->user()->hasRole('admin'))
    <a href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
@endif

{{-- After (permission-based) --}}
@can('view admin dashboard')
    <a href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
@endcan
```

### 5. OAuth Improvements
```php
// Stateless OAuth for better reliability
public function redirect()
{
    return Socialite::driver('google')->stateless()->redirect();
}

public function callback(Request $request)
{
    try {
        $googleUser = Socialite::driver('google')->stateless()->user();
        // ... rest of logic
    } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
        // Handle session expired gracefully
        return redirect('/login')->with('error', 'Session expired. Please try again.');
    }
}
```

## Security Considerations

### 1. Permission Inheritance
- Users inherit permissions through roles
- Direct permissions should be avoided (best practice)
- Permissions are checked at multiple levels (routes, controllers, views)

### 2. Middleware Protection
```php
// Route level protection
Route::middleware(['auth', 'permission:manage users'])->group(function () {
    // Admin-only routes
});

// Controller level protection
public function index()
{
    $this->authorize('view admin dashboard');
    // Controller logic
}
```

### 3. Blade Template Security
```blade
{{-- Permission-based UI elements --}}
@can('edit articles')
    <button>Edit Article</button>
@endcan

@can('delete articles')
    <button>Delete Article</button>
@endcan
```

## Performance Considerations

### 1. Permission Caching
- Spatie Laravel Permission automatically caches permissions
- Cache is cleared when permissions/roles are modified
- Use `php artisan permission:cache-reset` if needed

### 2. Database Queries
- Permissions are loaded once per request
- Use `with('roles.permissions')` for eager loading
- Avoid N+1 queries in permission checks

### 3. Middleware Optimization
- Permission middleware runs after authentication
- Cache permission checks within request lifecycle
- Use permission-based middleware instead of multiple role checks

## Testing Strategy

### 1. Permission Tests
```php
// Test permission assignment
$user->hasPermissionTo('access chat');
$user->can('view articles');

// Test role inheritance
$user->hasRole('admin');
$user->getAllPermissions();
```

### 2. Route Tests
```php
// Test protected routes
$response = $this->get('/admin/dashboard');
$response->assertStatus(403); // Unauthorized

$user->givePermissionTo('view admin dashboard');
$response = $this->actingAs($user)->get('/admin/dashboard');
$response->assertStatus(200); // Authorized
```

### 3. UI Tests
```php
// Test Blade directives
$this->assertSee('@can("access chat")');
$this->assertDontSee('@role("admin")');
```

## Migration Strategy

### 1. Database Migration
```bash
# Run permission seeder
php artisan migrate:fresh --seed
```

### 2. Code Migration
1. Update routes to use permission middleware
2. Update Blade templates to use `@can` directives
3. Update controllers to use permission checks
4. Test all permission-based functionality

### 3. OAuth Migration
1. Update GoogleAuthController to use stateless OAuth
2. Add proper error handling for InvalidStateException
3. Test OAuth flow with multiple scenarios

## Monitoring & Maintenance

### 1. Permission Auditing
- Regular audit of permission assignments
- Monitor permission usage in logs
- Review and update permissions as needed

### 2. Performance Monitoring
- Monitor permission check performance
- Cache hit rates for permission queries
- Database query optimization

### 3. Security Monitoring
- Log permission denials
- Monitor unauthorized access attempts
- Regular security reviews
