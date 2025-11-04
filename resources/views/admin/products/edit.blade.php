@extends('layouts.admin')

@section('title', 'Edit Product')
@section('pageTitle', 'Edit Product')
@section('pageDescription', 'Update product information')

@section('content')

    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="btn-modern btn-modern-secondary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Products
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <strong>Validation Errors:</strong>
            <ul class="list-disc list-inside mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Product Info -->
    <div class="mb-6 card-modern">
        <div class="card-modern-body">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    @if($product->hasMedia('product_image'))
                        <img src="{{ $product->getFirstMediaUrl('product_image', 'thumb') }}" 
                             alt="{{ $product->name }}"
                             class="w-16 h-16 rounded object-cover">
                    @else
                        <div class="w-16 h-16 rounded bg-neutral-200 dark:bg-neutral-700 flex items-center justify-center">
                            <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    @endif
            <div>
                <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">
                            {{ $product->category->name }} • Created {{ $product->created_at->diffForHumans() }}
                        </p>
                    </div>
            </div>
            <div class="flex gap-2">
                @if($product->is_featured)
                    <span class="badge-modern badge-modern-warning">Featured</span>
                @endif
                @if($product->is_active)
                    <span class="badge-modern badge-modern-success">Active</span>
                @else
                    <span class="badge-modern badge-modern-secondary">Inactive</span>
                @endif
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-lg font-semibold">Basic Information</h2>
            </div>
            <div class="card-modern-body space-y-6">
                <!-- Category -->
                <div>
                    <label for="product_category_id" class="form-modern-label">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select name="product_category_id" id="product_category_id" class="form-modern" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('product_category_id', $product->product_category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="form-modern-label">
                        Product Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                           class="form-modern" required autofocus
                           x-data="{ name: '{{ old('name', $product->name) }}' }" x-model="name"
                           @input="$refs.slug.value = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')">
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="form-modern-label">Slug</label>
                    <input type="text" name="slug" id="slug" x-ref="slug" value="{{ old('slug', $product->slug) }}"
                           class="form-modern" placeholder="auto-generated">
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="form-modern-label">Description</label>
                    <textarea name="description" id="description" rows="3" class="form-modern">{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- Features -->
                <div>
                    <label for="features" class="form-modern-label">Features</label>
                    <textarea name="features" id="features" rows="3" class="form-modern" 
                              placeholder="Enter features (comma-separated or JSON)">{{ old('features', is_array($product->features) ? implode(', ', $product->features) : $product->features) }}</textarea>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">
                        Comma-separated: Feature 1, Feature 2, Feature 3<br>
                        JSON: ["Feature 1", "Feature 2", "Feature 3"]
                    </p>
                </div>
            </div>
        </div>

        <!-- Image Upload -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-lg font-semibold">Product Image</h2>
            </div>
            <div class="card-modern-body">
                <div x-data="{ preview: null }">
                    <!-- Current Image -->
                @if($product->hasMedia('product_image'))
                    <div class="mb-4">
                            <p class="text-sm font-medium mb-2">Current Image:</p>
                        <img src="{{ $product->getFirstMediaUrl('product_image', 'medium') }}" 
                             alt="{{ $product->name }}"
                             class="w-64 h-64 object-cover rounded">
                    </div>
                @endif
                
                    <!-- Upload New -->
                    <label class="block">
                        <span class="form-modern-label">Upload New Image (Max 5MB)</span>
                        <input type="file" name="product_image" accept="image/jpeg,image/png,image/jpg,image/webp"
                               class="form-modern"
                               @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
                    </label>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">
                        Leave empty to keep current image
                    </p>

                    <!-- Preview New Image -->
                    <div x-show="preview" class="mt-4">
                        <p class="text-sm font-medium mb-2">New Image Preview:</p>
                        <img :src="preview" class="w-64 h-64 object-cover rounded">
                    </div>
                </div>
            </div>
        </div>

        <!-- Display Settings -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-lg font-semibold">Display Settings</h2>
            </div>
            <div class="card-modern-body space-y-6">
                <!-- Order Info (Read-only) -->
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <p class="text-sm text-blue-900 dark:text-blue-100">
                        <strong>Current Display Order:</strong> {{ $product->order }} 
                        <br>
                        Use the "Reorder Products" feature on the products list page to change the display order.
                    </p>
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                               class="form-checkbox rounded text-primary-600">
                        <span class="ml-2 text-sm font-medium">Featured Product</span>
                    </label>
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                               class="form-checkbox rounded text-primary-600">
                        <span class="ml-2 text-sm font-medium">Active</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.products.index') }}" class="btn-modern btn-modern-secondary">Cancel</a>
            <button type="submit" class="btn-modern btn-modern-primary">Update Product</button>
        </div>
    </form>

    <!-- Danger Zone -->
    <div class="mt-8 card-modern border-error-300 dark:border-error-700">
        <div class="card-modern-header bg-error-50 dark:bg-error-900/20">
            <h2 class="text-lg font-semibold text-error-900 dark:text-error-100">Danger Zone</h2>
        </div>
        <div class="card-modern-body">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium">Delete Product</h3>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">
                        Permanently remove this product. This action cannot be undone.
                    </p>
                </div>
                <form action="{{ route('admin.products.destroy', $product) }}" 
                      method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-modern btn-modern-danger">
                        Delete Product
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection
