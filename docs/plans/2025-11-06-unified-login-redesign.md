# Unified Login Redesign Implementation Plan

> **For Claude:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task.

**Goal:** Remove Google OAuth authentication, unify staff and user login into single page, and redesign login page following the "Beauty High Tech" style guide.

**Architecture:** Consolidate authentication to email/password only, remove Google OAuth dependencies, merge login routes and controllers, redesign UI with cyan accents, deep navy backgrounds, and futuristic aesthetic per style guide.

**Tech Stack:** Laravel 11.x, TailwindCSS 4, Alpine.js, Blade templates

---

## Task 1: Database Migration - Remove Google OAuth Columns

**Files:**
- Create: `database/migrations/2025_11_06_000001_remove_google_oauth_columns.php`

**Step 1: Write the migration file**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'google_id',
                'google_token',
                'google_refresh_token'
            ]);

            // Make password required (was nullable for Google OAuth users)
            $table->string('password')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable()->unique();
            $table->text('google_token')->nullable();
            $table->text('google_refresh_token')->nullable();
            $table->string('password')->nullable()->change();
        });
    }
};
```

**Step 2: Run the migration**

Run: `php artisan migrate`

Expected: Migration runs successfully, Google columns removed from users table

**Step 3: Commit**

```bash
git add database/migrations/2025_11_06_000001_remove_google_oauth_columns.php
git commit -m "feat: remove Google OAuth columns from users table"
```

---

## Task 2: Update User Model - Remove Google OAuth Support

**Files:**
- Modify: `app/Models/User.php:25-66`

**Step 1: Remove Google OAuth fields from fillable array**

In `app/Models/User.php`, update the `$fillable` array:

```php
protected $fillable = [
    'name',
    'email',
    'password',
    // Removed: 'google_id', 'google_token', 'google_refresh_token'
    'bio',
    'phone',
    'location',
    'website',
    'social_links',
];
```

**Step 2: Remove Google OAuth fields from hidden array**

In `app/Models/User.php`, update the `$hidden` array:

```php
protected $hidden = [
    'password',
    'remember_token',
    // Removed: 'google_token', 'google_refresh_token'
];
```

**Step 3: Remove Google OAuth casts**

In `app/Models/User.php`, update the `casts()` method:

```php
protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        // Removed: 'google_token' => 'encrypted', 'google_refresh_token' => 'encrypted'
        'social_links' => 'array',
    ];
}
```

**Step 4: Commit**

```bash
git add app/Models/User.php
git commit -m "refactor: remove Google OAuth fields from User model"
```

---

## Task 3: Create Unified AuthController

**Files:**
- Create: `app/Http/Controllers/Auth/AuthController.php`

**Step 1: Write the unified AuthController**

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show unified login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            // Redirect based on role
            if ($user->hasAnyRole(['admin', 'content_manager'])) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('home'));
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Show registration form (admin only)
     */
    public function showRegisterForm()
    {
        // Only allow if user is admin
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        return view('auth.register');
    }

    /**
     * Handle registration (admin only)
     */
    public function register(Request $request)
    {
        // Only allow if user is admin
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,content_manager,admin',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }
}
```

**Step 2: Commit**

```bash
git add app/Http/Controllers/Auth/AuthController.php
git commit -m "feat: create unified AuthController for email/password authentication"
```

---

## Task 4: Update Routes - Unify Login Routes

**Files:**
- Modify: `routes/web.php:17-36`

**Step 1: Replace authentication routes**

In `routes/web.php`, replace the Google OAuth and Staff routes (lines 17-36) with:

```php
// Unified Login Route
Route::get('/login', [App\Http\Controllers\Auth\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');

// User Registration Routes (Admin only)
Route::get('/register', [App\Http\Controllers\Auth\AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\AuthController::class, 'register']);
```

**Step 2: Remove old controller imports**

Remove these imports from the top of `routes/web.php`:

```php
// Remove:
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\StaffAuthController;
```

**Step 3: Commit**

```bash
git add routes/web.php
git commit -m "refactor: unify authentication routes to single login endpoint"
```

---

## Task 5: Design Unified Login Page - "Beauty High Tech" Style

**Files:**
- Create: `resources/views/auth/login.blade.php`
- Modify: `resources/views/layouts/auth.blade.php:18-59`

**Step 1: Update auth layout with "Beauty High Tech" styling**

Replace the entire `resources/views/layouts/auth.blade.php` with:

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Authentication - Lunaray Beauty Factory')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full bg-[#000d1a] overflow-hidden">
    <!-- Background decorative elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Hexagonal pattern overlay -->
        <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(0deg, transparent, transparent 50px, #22d3ee 50px, #22d3ee 51px), repeating-linear-gradient(90deg, transparent, transparent 50px, #22d3ee 50px, #22d3ee 51px);"></div>

        <!-- Glowing cyan accents -->
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-cyan-400 rounded-full opacity-10 blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-cyan-400 rounded-full opacity-5 blur-3xl"></div>
    </div>

    <div class="relative h-full flex items-center justify-center p-4 sm:p-6">
        <div class="w-full max-w-md">
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-cyan-400 to-blue-600 rounded-xl mb-4 shadow-lg shadow-cyan-400/50">
                    <span class="text-white text-2xl sm:text-3xl font-bold">L</span>
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-2">
                    @yield('header', 'Welcome Back')
                </h1>
                @hasSection('subheader')
                    <p class="text-sm sm:text-base text-cyan-300">
                        @yield('subheader')
                    </p>
                @endif
            </div>

            <!-- Main Content Card -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl border border-cyan-400/30 shadow-xl overflow-hidden">
                <div class="p-6 sm:p-8">
                    @if(session('error'))
                        <div class="mb-4 p-3 bg-red-500/20 border border-red-500/50 rounded-lg text-red-300 text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mb-4 p-3 bg-cyan-500/20 border border-cyan-500/50 rounded-lg text-cyan-300 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}"
                   class="inline-flex items-center text-sm text-cyan-400 hover:text-cyan-300 transition duration-300">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Home
                </a>
                @hasSection('footerLinks')
                    <div class="mt-4 space-x-4">
                        @yield('footerLinks')
                    </div>
                @endif
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
```

**Step 2: Create unified login page with "Beauty High Tech" design**

Create `resources/views/auth/login.blade.php`:

```blade
@extends('layouts.auth')

@section('title', 'Login - Lunaray Beauty Factory')
@section('header', 'Lunaray Beauty Factory')
@section('subheader', 'Science Meets Beauty')

@section('content')
<form class="space-y-5" action="{{ route('login') }}" method="POST" x-data="{ loading: false }" @submit="loading = true">
    @csrf

    <!-- Email Field -->
    <div>
        <label for="email" class="block text-sm font-semibold text-white mb-2">
            Email Address
        </label>
        <input
            id="email"
            name="email"
            type="email"
            autocomplete="email"
            required
            value="{{ old('email') }}"
            class="w-full px-4 py-3 bg-white/10 border border-cyan-400/30 rounded-lg text-white placeholder-neutral-400
                   focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent
                   backdrop-blur-sm transition duration-300
                   @error('email') border-red-500 ring-2 ring-red-500 @enderror"
            placeholder="Enter your email">
        @error('email')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password Field -->
    <div>
        <label for="password" class="block text-sm font-semibold text-white mb-2">
            Password
        </label>
        <input
            id="password"
            name="password"
            type="password"
            autocomplete="current-password"
            required
            class="w-full px-4 py-3 bg-white/10 border border-cyan-400/30 rounded-lg text-white placeholder-neutral-400
                   focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent
                   backdrop-blur-sm transition duration-300
                   @error('password') border-red-500 ring-2 ring-red-500 @enderror"
            placeholder="Enter your password">
        @error('password')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Remember Me -->
    <div class="flex items-center">
        <input
            id="remember"
            name="remember"
            type="checkbox"
            class="h-4 w-4 text-cyan-400 focus:ring-cyan-400 focus:ring-offset-0
                   border-cyan-400/30 rounded bg-white/10 backdrop-blur-sm">
        <label for="remember" class="ml-2 block text-sm text-neutral-300">
            Remember me
        </label>
    </div>

    <!-- Submit Button -->
    <button
        type="submit"
        class="w-full bg-gradient-to-r from-cyan-400 to-blue-600 text-white font-bold py-3 px-6 rounded-lg
               hover:from-cyan-300 hover:to-blue-500
               focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-[#000d1a]
               shadow-lg shadow-cyan-400/30 transition duration-300 transform hover:scale-[1.02]"
        :disabled="loading"
        :class="{ 'opacity-50 cursor-not-allowed': loading }">
        <span x-show="!loading" class="flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
            Sign In
        </span>
        <span x-show="loading" class="flex items-center justify-center">
            <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Signing in...
        </span>
    </button>
</form>

<!-- Tech decoration -->
<div class="mt-6 pt-6 border-t border-cyan-400/20">
    <p class="text-center text-xs text-neutral-400">
        Secured by advanced encryption technology
    </p>
</div>
@endsection

@section('footerLinks')
    <a href="#" class="text-xs text-cyan-400 hover:text-cyan-300 transition duration-300">Privacy Policy</a>
    <span class="text-neutral-600">|</span>
    <a href="#" class="text-xs text-cyan-400 hover:text-cyan-300 transition duration-300">Terms of Service</a>
@endsection
```

**Step 3: Commit**

```bash
git add resources/views/layouts/auth.blade.php resources/views/auth/login.blade.php
git commit -m "feat: redesign login page with Beauty High Tech style guide"
```

---

## Task 6: Remove Old Authentication Files

**Files:**
- Delete: `app/Http/Controllers/Auth/GoogleAuthController.php`
- Delete: `app/Http/Controllers/Auth/StaffAuthController.php`
- Delete: `resources/views/auth/google-login.blade.php`
- Delete: `resources/views/auth/staff-login.blade.php`
- Delete: `resources/views/auth/staff-register.blade.php` (if exists)

**Step 1: Delete old controller files**

Run: `rm app/Http/Controllers/Auth/GoogleAuthController.php app/Http/Controllers/Auth/StaffAuthController.php`

Expected: Files removed successfully

**Step 2: Delete old view files**

Run: `rm resources/views/auth/google-login.blade.php resources/views/auth/staff-login.blade.php`

Expected: Files removed successfully

**Step 3: Commit**

```bash
git add -A
git commit -m "chore: remove old Google OAuth and staff authentication files"
```

---

## Task 7: Remove Google OAuth Configuration

**Files:**
- Modify: `config/services.php:38-42`

**Step 1: Remove Google OAuth config**

In `config/services.php`, delete lines 38-42:

```php
// DELETE THESE LINES:
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],
```

**Step 2: Remove Laravel Socialite package**

Run: `composer remove laravel/socialite`

Expected: Package removed successfully

**Step 3: Commit**

```bash
git add config/services.php composer.json composer.lock
git commit -m "chore: remove Google OAuth configuration and Socialite package"
```

---

## Task 8: Update Navigation Links - Remove Staff Login

**Files:**
- Search and update: All Blade files referencing `/staff/login` or Google login

**Step 1: Search for staff login references**

Run: `grep -r "staff/login" resources/views`

Expected: List of files referencing staff login route

**Step 2: Search for Google login references**

Run: `grep -r "google/redirect" resources/views`

Expected: List of files referencing Google OAuth

**Step 3: Update navigation links in layouts**

Check and update these files if they reference old routes:
- `resources/views/layouts/app.blade.php`
- `resources/views/layouts/guest.blade.php`
- `resources/views/layouts/admin.blade.php`

Replace any instances of:
- `/staff/login` → `/login`
- `route('staff.login')` → `route('login')`
- `route('staff.logout')` → `route('logout')`

**Step 4: Commit**

```bash
git add resources/views/layouts/
git commit -m "refactor: update navigation links to unified login route"
```

---

## Task 9: Update Tests - Remove Google OAuth Tests

**Files:**
- Search: `tests/Feature/Auth/` and `tests/Unit/Auth/`
- Modify/Delete: Any tests referencing Google OAuth or staff login

**Step 1: Find authentication tests**

Run: `ls -la tests/Feature/Auth/ tests/Unit/Auth/ 2>/dev/null || echo "No auth tests found"`

Expected: List of authentication test files

**Step 2: Update or remove Google OAuth tests**

If Google OAuth tests exist, delete them:

Run: `rm tests/Feature/Auth/GoogleAuthTest.php tests/Unit/Auth/GoogleAuthTest.php 2>/dev/null || echo "No Google auth tests"`

**Step 3: Create unified login test**

Create `tests/Feature/Auth/LoginTest.php`:

```php
<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginPageDisplayed(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function testUserCanLoginWithCorrectCredentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    public function testUserCannotLoginWithIncorrectPassword(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function testAdminRedirectsToDashboard(): void
    {
        $admin = $this->createAdmin();

        $response = $this->post(route('login'), [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function testContentManagerRedirectsToDashboard(): void
    {
        $manager = $this->createContentManager();

        $response = $this->post(route('login'), [
            'email' => $manager->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($manager);
    }

    public function testRememberMeFunctionality(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'password123',
            'remember' => true,
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
        $this->assertNotNull(auth()->user()->getRememberToken());
    }
}
```

**Step 4: Run tests**

Run: `php artisan test --filter=LoginTest`

Expected: All tests pass

**Step 5: Commit**

```bash
git add tests/Feature/Auth/LoginTest.php
git commit -m "test: add unified login tests and remove Google OAuth tests"
```

---

## Task 10: Update Documentation

**Files:**
- Modify: `CLAUDE.md` (project instructions)
- Modify: `README.md` (if it mentions Google OAuth)

**Step 1: Update CLAUDE.md authentication section**

In `CLAUDE.md`, find the "Authentication System" section and replace with:

```markdown
### Authentication System
The application uses **email/password authentication** for all users:

1. **All Users** (public, staff, admins)
   - Email/password authentication
   - Standard Laravel authentication
   - Single unified login at `/login`
   - Password hashing with bcrypt

2. **Guest Users**
   - Can access chatbot without authentication
   - Session tracked via localStorage with IP address
   - 7-day session expiry with automated cleanup

**Role-based Access:**
- `role:user` - Public users with basic access
- `role:content_manager` - Content editing and management
- `role:admin` - Full system administration
```

**Step 2: Remove Google OAuth references**

Search for and remove any mentions of:
- "Google OAuth"
- "Google Socialite"
- "google_id", "google_token"
- Hybrid authentication

**Step 3: Update common pitfalls section**

In `CLAUDE.md`, remove the "Authentication Guards" pitfall about mixing authentication types.

**Step 4: Commit**

```bash
git add CLAUDE.md README.md
git commit -m "docs: update authentication documentation to reflect unified login"
```

---

## Task 11: Environment Variables Cleanup

**Files:**
- Reference: `.env.example`

**Step 1: Update .env.example**

Remove these lines from `.env.example`:

```env
# DELETE THESE:
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"
```

**Step 2: Create environment cleanup guide**

Add note in commit message about cleaning local `.env` file:

```
Note: Developers should remove GOOGLE_* variables from local .env files
```

**Step 3: Commit**

```bash
git add .env.example
git commit -m "chore: remove Google OAuth environment variables from example"
```

---

## Task 12: Database Seeder Updates

**Files:**
- Review: `database/seeders/StaffSeeder.php`
- Review: `database/seeders/AdvancedStaffSeeder.php`

**Step 1: Verify seeders don't reference Google fields**

Run: `grep -n "google" database/seeders/*.php`

Expected: No results (or only comments)

**Step 2: Update user factory if needed**

Check `database/factories/UserFactory.php` for Google OAuth fields:

Run: `grep -n "google" database/factories/UserFactory.php`

If found, remove those fields from the factory definition.

**Step 3: Commit if changes made**

```bash
git add database/factories/UserFactory.php
git commit -m "refactor: remove Google OAuth fields from user factory"
```

---

## Task 13: Middleware and Route Review

**Files:**
- Review: `bootstrap/app.php`
- Review: `routes/web.php`

**Step 1: Verify no orphaned middleware**

Check if any middleware specifically handles Google OAuth:

Run: `grep -rn "google" app/Http/Middleware/`

Expected: No results

**Step 2: Test all authentication routes**

Run: `php artisan route:list | grep -i auth`

Expected output should show:
- GET /login
- POST /login
- POST /logout
- GET /register (admin only)
- POST /register (admin only)

**Step 3: Verify CSRF exclusions**

Check `bootstrap/app.php` for any Google OAuth callback CSRF exclusions. Remove if found.

**Step 4: Commit if changes made**

```bash
git add bootstrap/app.php
git commit -m "chore: remove Google OAuth CSRF exclusions"
```

---

## Task 14: Integration Testing

**Files:**
- Create: `tests/Feature/Auth/LoginFlowTest.php`

**Step 1: Write comprehensive login flow test**

```php
<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginFlowTest extends TestCase
{
    use RefreshDatabase;

    public function testCompleteUserLoginFlow(): void
    {
        // Create user
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
        ]);
        $user->assignRole('user');

        // Visit login page
        $response = $this->get(route('login'));
        $response->assertStatus(200);

        // Submit login form
        $response = $this->post(route('login'), [
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);

        // Assert redirected to home
        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);

        // Visit home page
        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }

    public function testCompleteAdminLoginFlow(): void
    {
        // Create admin
        $admin = $this->createAdmin();

        // Visit login page
        $response = $this->get(route('login'));
        $response->assertStatus(200);

        // Submit login form
        $response = $this->post(route('login'), [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        // Assert redirected to dashboard
        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);

        // Visit dashboard
        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(200);
    }

    public function testLogoutFlow(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        // Login
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        // Logout
        $response = $this->post(route('logout'));
        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function testGuestCannotAccessProtectedRoutes(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function testLoginPageStyleInclusions(): void
    {
        $response = $this->get(route('login'));

        // Check for Beauty High Tech design elements
        $response->assertSee('Lunaray Beauty Factory');
        $response->assertSee('Science Meets Beauty');

        // Check for correct styling classes (partial match)
        $content = $response->getContent();
        $this->assertStringContainsString('bg-[#000d1a]', $content); // Deep navy
        $this->assertStringContainsString('cyan-400', $content); // Cyan accents
    }
}
```

**Step 2: Run integration tests**

Run: `php artisan test --filter=LoginFlowTest`

Expected: All tests pass

**Step 3: Commit**

```bash
git add tests/Feature/Auth/LoginFlowTest.php
git commit -m "test: add comprehensive login flow integration tests"
```

---

## Task 15: Final Verification and Cleanup

**Step 1: Run full test suite**

Run: `php artisan test`

Expected: All tests pass

**Step 2: Clear application cache**

Run: `php artisan config:clear && php artisan cache:clear && php artisan route:clear`

Expected: Cache cleared successfully

**Step 3: Test login manually**

1. Start dev server: `php artisan serve`
2. Visit `http://localhost:8000/login`
3. Verify "Beauty High Tech" design:
   - Deep navy background (#000d1a)
   - Cyan accents and glowing effects
   - Glass morphism card with backdrop blur
   - Hexagonal pattern overlay
4. Test login with seeded credentials
5. Verify redirect based on role

**Step 4: Check for orphaned references**

Run: `grep -rn "google" app/ resources/ config/ --include="*.php" --include="*.blade.php"`

Expected: No results or only comments

**Step 5: Create final commit**

```bash
git add -A
git commit -m "feat: complete unified login redesign with Beauty High Tech style

- Removed Google OAuth authentication system
- Unified staff and public user login into single endpoint
- Redesigned login page following Beauty High Tech style guide
- Updated all routes, controllers, and views
- Removed Laravel Socialite dependency
- Updated documentation and tests
- All tests passing"
```

---

## Verification Checklist

After completing all tasks, verify:

- [ ] `/login` displays new "Beauty High Tech" design
- [ ] Users can login with email/password
- [ ] Admins redirect to `/admin/dashboard`
- [ ] Regular users redirect to home
- [ ] Logout works correctly
- [ ] No broken links to `/staff/login` or Google OAuth
- [ ] All tests pass (`php artisan test`)
- [ ] No Google OAuth references in codebase
- [ ] Database migration removes Google columns
- [ ] Socialite package removed from composer.json
- [ ] Documentation updated (CLAUDE.md)
- [ ] Environment example updated (.env.example)

---

## Rollback Plan

If issues arise, rollback steps:

1. Revert migration: `php artisan migrate:rollback --step=1`
2. Restore Google OAuth columns manually
3. Reinstall Socialite: `composer require laravel/socialite:^5.0`
4. Restore old authentication files from git history
5. Revert route changes

---

## Notes

**Design References:**
- Style guide: `docs/STYLE_GUIDE.md`
- Color palette: Deep navy (#000d1a), Cyan (#22d3ee), Blue (#2563eb)
- Typography: Inter for UI, responsive scaling
- Effects: Backdrop blur, glass morphism, hexagonal patterns

**Security Considerations:**
- All passwords hashed with bcrypt
- Session regeneration on login/logout
- CSRF protection on all forms
- Rate limiting on login attempts (consider adding)

**Browser Compatibility:**
- Backdrop blur requires modern browsers
- Fallback: Semi-transparent background without blur
- Test on Chrome, Firefox, Safari, Edge
