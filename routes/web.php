<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\StaffAuthController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Admin\ChatbotConfigurationController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContentManagerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');


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

// Chat Route - redirect to home (now using floating chat)
Route::get('/chat', function () {
    return redirect()->route('home');
})->name('user.chat');

// Profile Routes - accessible to all authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
    Route::get('/profile/password', [ProfileController::class, 'showPasswordForm'])->name('profile.password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// Chatbot API Routes - accessible to both authenticated and guest users
Route::middleware(['chatbot.access', 'chatbot.rate_limit'])->prefix('api/chatbot')->group(function () {
    Route::get('/session', [ChatbotController::class, 'getSession'])->name('chatbot.session');
    Route::get('/history', [ChatbotController::class, 'getHistory'])->name('chatbot.history');
    Route::post('/send', [ChatbotController::class, 'sendMessage'])->name('chatbot.send');
    Route::post('/close', [ChatbotController::class, 'closeSession'])->name('chatbot.close');
    Route::post('/reset', [ChatbotController::class, 'resetSession'])->name('chatbot.reset');
    Route::get('/status', [ChatbotController::class, 'getStatus'])->name('chatbot.status');
});

// Content Management Routes - using permissions
Route::middleware(['auth', 'permission:view admin dashboard'])->group(function () {
    Route::get('/admin/dashboard', [ContentManagerController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/analytics', [ContentManagerController::class, 'analytics'])->name('admin.analytics');
});

// Article Management Routes
Route::middleware(['auth', 'permission:edit articles'])->group(function () {
    Route::get('/admin/articles', [ArticleController::class, 'adminIndex'])->name('admin.articles.index');
    Route::resource('articles', ArticleController::class)->except(['index']);
    Route::resource('categories', CategoryController::class);
    
    // Additional article routes
    Route::post('/articles/bulk-action', [ArticleController::class, 'bulkAction'])->name('articles.bulk-action');
    Route::patch('/articles/{article}/toggle-status', [ArticleController::class, 'toggleStatus'])->name('articles.toggle-status');
    Route::patch('/articles/{article}/toggle-featured', [ArticleController::class, 'toggleFeatured'])->name('articles.toggle-featured');
    
    // Enhanced article features
    Route::post('/articles/auto-save', [ArticleController::class, 'autoSave'])->name('articles.auto-save');
    Route::get('/articles/{article}/preview', [ArticleController::class, 'preview'])->name('articles.preview');
    Route::post('/articles/{article}/duplicate', [ArticleController::class, 'duplicate'])->name('articles.duplicate');
    Route::get('/articles/export', [ArticleController::class, 'export'])->name('articles.export');
});

// Public Article Routes
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Product Management Routes - Content Managers & Admins
Route::middleware(['auth', 'permission:manage products'])->prefix('admin')->name('admin.')->group(function () {
    // Product Categories
    Route::resource('product-categories', \App\Http\Controllers\Admin\ProductCategoryController::class);
    Route::post('product-categories/bulk-action', [\App\Http\Controllers\Admin\ProductCategoryController::class, 'bulkAction'])
        ->name('product-categories.bulk-action');
    
    // Products
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::post('products/bulk-action', [\App\Http\Controllers\Admin\ProductController::class, 'bulkAction'])
        ->name('products.bulk-action');
    Route::post('products/reorder', [\App\Http\Controllers\Admin\ProductController::class, 'reorder'])
        ->name('products.reorder');
    Route::post('products/{product}/move-up', [\App\Http\Controllers\Admin\ProductController::class, 'moveUp'])
        ->name('products.move-up');
    Route::post('products/{product}/move-down', [\App\Http\Controllers\Admin\ProductController::class, 'moveDown'])
        ->name('products.move-down');
});

// Hero Management Routes - Content Managers & Admins
Route::middleware(['auth', 'permission:manage heroes'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('heroes', \App\Http\Controllers\Admin\HeroController::class);
});

// Admin Only Routes - using permissions
Route::middleware(['auth', 'permission:manage users'])->group(function () {
    Route::get('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('admin.users.show');
    Route::get('/admin/users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
    
    // Avatar upload routes
    Route::post('/admin/users/{user}/avatar', [\App\Http\Controllers\Admin\UserController::class, 'updateAvatar'])->name('admin.users.avatar.update');
    Route::delete('/admin/users/{user}/avatar', [\App\Http\Controllers\Admin\UserController::class, 'deleteAvatar'])->name('admin.users.avatar.delete');
});

Route::middleware(['auth', 'permission:manage system settings'])->group(function () {
    Route::get('/admin/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('admin.settings');
    Route::put('/admin/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('admin.settings.update');
    Route::post('/admin/settings/clear-cache', [\App\Http\Controllers\Admin\SettingsController::class, 'clearCache'])->name('admin.settings.clear-cache');
    Route::post('/admin/settings/backup', [\App\Http\Controllers\Admin\SettingsController::class, 'createBackup'])->name('admin.settings.backup');
    
    Route::get('/admin/chatbot', function () {
        return view('admin.chatbot');
    })->name('admin.chatbot');
});

// Admin Chatbot Configuration Routes
Route::middleware(['auth', 'permission:manage system settings'])->prefix('api/admin/chatbot')->group(function () {
    Route::get('/config', [ChatbotConfigurationController::class, 'index'])->name('admin.chatbot.config');
    Route::put('/config', [ChatbotConfigurationController::class, 'update'])->name('admin.chatbot.config.update');
    Route::post('/test-webhook', [ChatbotConfigurationController::class, 'testWebhook'])->name('admin.chatbot.test');
    Route::get('/statistics', [ChatbotConfigurationController::class, 'statistics'])->name('admin.chatbot.stats');
    Route::get('/logs', [ChatbotConfigurationController::class, 'chatLogs'])->name('admin.chatbot.logs');
    Route::post('/reset', [ChatbotConfigurationController::class, 'reset'])->name('admin.chatbot.reset');
});
