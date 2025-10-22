<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\StaffAuthController;

Route::get('/', function () {
    return view('home');
});

// Public Login Route
Route::get('/login', function () {
    return view('auth.google-login');
})->name('login');

// Google OAuth Routes
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);
Route::post('/auth/logout', [GoogleAuthController::class, 'logout']);

// Staff Authentication Routes
Route::get('/staff/login', [StaffAuthController::class, 'showLoginForm'])->name('staff.login');
Route::post('/staff/login', [StaffAuthController::class, 'login']);
Route::post('/staff/logout', [StaffAuthController::class, 'logout'])->name('staff.logout');

// Staff Registration Routes (Admin only)
Route::get('/staff/register', [StaffAuthController::class, 'showRegisterForm'])->name('staff.register');
Route::post('/staff/register', [StaffAuthController::class, 'register']);

// Protected Routes with Role-based Access Control
Route::middleware(['auth', 'role:user,content_manager,admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'role:content_manager,admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    Route::get('/admin/articles', function () {
        return view('admin.articles');
    })->name('admin.articles');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', function () {
        return view('admin.users');
    })->name('admin.users');
    
    Route::get('/admin/settings', function () {
        return view('admin.settings');
    })->name('admin.settings');
});
