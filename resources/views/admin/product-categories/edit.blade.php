@extends('layouts.admin')

@section('title', 'Edit Product Category')
@section('pageTitle', 'Edit Product Category')
@section('pageDescription', 'Update category information')

@section('content')
    <!-- Action Buttons -->
    <div class="mb-8">
        <div class="flex items-center justify-end">
            <a href="{{ route('admin.product-categories.index') }}" class="btn-modern btn-modern-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Categories
            </a>
        </div>
    </div>

    <!-- Category Info Card -->
    <div class="mb-6 card-modern">
        <div class="card-modern-body">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-lg bg-primary-100 dark:bg-primary-900/20 flex items-center justify-center">
                        <svg class="w-7 h-7 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">{{ $productCategory->name }}</h3>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">
                            Created {{ $productCategory->created_at->diffForHumans() }} • 
                            {{ $productCategory->products_count ?? $productCategory->products()->count() }} products
                        </p>
                    </div>
                </div>
                <div>
                    @if($productCategory->is_active)
                        <span class="badge-modern badge-modern-success">Active</span>
                    @else
                        <span class="badge-modern badge-modern-secondary">Inactive</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.product-categories.update', $productCategory) }}" method="POST" class="max-w-2xl space-y-8" x-data="{ 
        name: '{{ old('name', $productCategory->name) }}',
        slug: '{{ old('slug', $productCategory->slug) }}',
        generateSlug() {
            this.slug = this.name.toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '');
        }
    }">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Basic Information</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Update the category details</p>
            </div>
            <div class="card-modern-body space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="form-modern-label">Category Name *</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           x-model="name"
                           @input="generateSlug()"
                           value="{{ old('name', $productCategory->name) }}" 
                           class="form-modern @error('name') border-error-500 @enderror" 
                           placeholder="e.g. Skincare, Bodycare, Makeup" 
                           required
                           autofocus>
                    @error('name')
                        <p class="form-modern-error">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                        This will be displayed as the category tab on the landing page
                    </p>
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="form-modern-label">
                        Slug 
                        <span class="text-xs text-neutral-500 font-normal">(auto-generated from name)</span>
                    </label>
                    <input type="text" 
                           name="slug" 
                           id="slug" 
                           x-model="slug"
                           value="{{ old('slug', $productCategory->slug) }}" 
                           class="form-modern @error('slug') border-error-500 @enderror" 
                           placeholder="e.g. skincare">
                    @error('slug')
                        <p class="form-modern-error">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                        URL-friendly version of the name (letters, numbers, and hyphens only)
                    </p>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="form-modern-label">Description</label>
                    <textarea name="description" 
                              id="description" 
                              rows="3" 
                              class="form-modern @error('description') border-error-500 @enderror" 
                              placeholder="Brief description of this category...">{{ old('description', $productCategory->description) }}</textarea>
                    @error('description')
                        <p class="form-modern-error">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                        Optional description for internal reference
                    </p>
                </div>
            </div>
        </div>

        <!-- Display Settings -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Display Settings</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Configure how this category appears</p>
            </div>
            <div class="card-modern-body space-y-6">
                <!-- Order -->
                <div>
                    <label for="order" class="form-modern-label">Display Order</label>
                    <input type="number" 
                           name="order" 
                           id="order" 
                           value="{{ old('order', $productCategory->order) }}" 
                           min="0"
                           class="form-modern @error('order') border-error-500 @enderror" 
                           placeholder="0">
                    @error('order')
                        <p class="form-modern-error">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                        Lower numbers appear first (use 10, 20, 30... for easy reordering)
                    </p>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Status</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Set the category status</p>
            </div>
            <div class="card-modern-body">
                <div class="flex items-center">
                    <input type="checkbox" 
                           name="is_active" 
                           id="is_active" 
                           value="1" 
                           {{ old('is_active', $productCategory->is_active) ? 'checked' : '' }}
                           class="rounded border-neutral-300 dark:border-neutral-600 text-primary-500 focus:ring-primary-500 dark:bg-neutral-800">
                    <label for="is_active" class="ml-2 text-sm text-neutral-700 dark:text-neutral-300">
                        Category is active (will be displayed on the landing page)
                    </label>
                </div>
            </div>
        </div>

        <!-- Preview -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Preview</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">See how your category will look</p>
            </div>
            <div class="card-modern-body">
                <div class="bg-neutral-50 dark:bg-neutral-800 rounded-lg p-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-lg bg-primary-100 dark:bg-primary-900/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-neutral-900 dark:text-neutral-100" x-text="name"></h3>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400" x-text="slug"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.product-categories.index') }}" class="btn-modern btn-modern-secondary">
                Cancel
            </a>
            <button type="submit" class="btn-modern btn-modern-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Update Category
            </button>
        </div>
    </form>

    <!-- Danger Zone -->
    @if($productCategory->products()->count() > 0)
    <div class="mt-8 max-w-2xl">
        <div class="card-modern border-error-300 dark:border-error-700">
            <div class="card-modern-header bg-error-50 dark:bg-error-900/20">
                <h2 class="text-lg font-semibold text-error-900 dark:text-error-100">Category Has Products</h2>
                <p class="text-sm text-error-700 dark:text-error-300">
                    This category has {{ $productCategory->products()->count() }} products. 
                    To delete this category, you must first reassign or delete all products.
                </p>
            </div>
        </div>
    </div>
    @else
    <div class="mt-8 max-w-2xl">
        <div class="card-modern border-error-300 dark:border-error-700">
            <div class="card-modern-header bg-error-50 dark:bg-error-900/20">
                <h2 class="text-lg font-semibold text-error-900 dark:text-error-100">Danger Zone</h2>
                <p class="text-sm text-error-700 dark:text-error-300">Irreversible actions for this category</p>
            </div>
            <div class="card-modern-body">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-neutral-900 dark:text-neutral-100">Delete Category</h3>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">
                            Permanently remove this category. This action cannot be undone.
                        </p>
                    </div>
                    <form action="{{ route('admin.product-categories.destroy', $productCategory) }}" 
                          method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-modern btn-modern-danger">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Category
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
