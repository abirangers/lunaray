<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\StaffAuthController;

Route::get('/', function () {
    return view('home');
})->name('home');

// Public Login Route
Route::get('/login', function () {
    return view('auth.google-login');
})->name('login');



// Google OAuth Routes
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);
Route::post('/auth/logout', [GoogleAuthController::class, 'logout'])->name('logout');

// Staff Authentication Routes
Route::get('/staff/login', [StaffAuthController::class, 'showLoginForm'])->name('staff.login');
Route::post('/staff/login', [StaffAuthController::class, 'login']);
Route::post('/staff/logout', [StaffAuthController::class, 'logout'])->name('staff.logout');

// Staff Registration Routes (Admin only)
Route::get('/staff/register', [StaffAuthController::class, 'showRegisterForm'])->name('staff.register');
Route::post('/staff/register', [StaffAuthController::class, 'register']);

// Public User Routes - using permissions
Route::middleware(['auth', 'permission:access chat'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
    
    Route::get('/chat', function () {
        return view('user.chat');
    })->name('user.chat');
});

// Content Management Routes - using permissions
Route::middleware(['auth', 'permission:view admin dashboard'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::middleware(['auth', 'permission:edit articles'])->group(function () {
    Route::get('/admin/articles', function () {
        return view('admin.articles');
    })->name('admin.articles');
});

// Admin Only Routes - using permissions
Route::middleware(['auth', 'permission:manage users'])->group(function () {
    Route::get('/admin/users', function () {
        return view('admin.users');
    })->name('admin.users');
});

Route::middleware(['auth', 'permission:manage system settings'])->group(function () {
    Route::get('/admin/settings', function () {
        return view('admin.settings');
    })->name('admin.settings');
});
