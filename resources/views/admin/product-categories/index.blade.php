@extends('layouts.admin')

@section('title', 'Product Categories')
@section('pageTitle', 'Product Categories Management')
@section('pageDescription', 'Organize your products with categories and manage your product catalog structure')

@section('content')
    <!-- Action Buttons -->
    <div class="mb-8">
        <div class="flex items-center justify-end">
            <a href="{{ route('admin.product-categories.create') }}" class="btn-modern btn-modern-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create Category
            </a>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($categories as $category)
            <div class="card-modern hover:shadow-lg transition-all duration-200">
                <!-- Category Header -->
                <div class="card-modern-header">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-primary-100 dark:bg-primary-900/20 flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">{{ $category->name }}</h3>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.product-categories.edit', $category) }}" class="text-primary-500 hover:text-primary-600 dark:text-primary-400 dark:hover:text-primary-300" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('admin.product-categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-error-500 hover:text-error-600 dark:text-error-400 dark:hover:text-error-300" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    @if($category->description)
                        <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">{{ Str::limit($category->description, 100) }}</p>
                    @endif
                    
                    <!-- Slug Display -->
                    <div class="mb-4">
                        <code class="text-xs bg-neutral-100 dark:bg-neutral-800 px-2 py-1 rounded text-neutral-600 dark:text-neutral-400">
                            {{ $category->slug }}
                        </code>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <span class="badge-modern {{ $category->is_active ? 'badge-modern-success' : 'badge-modern-secondary' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <span class="text-sm text-neutral-500 dark:text-neutral-400">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                {{ $category->products_count }} products
                            </span>
                        </div>
                        <span class="text-xs text-neutral-500 dark:text-neutral-400">
                            Order: {{ $category->order }}
                        </span>
                    </div>
                </div>

                <!-- Category Footer -->
                <div class="card-modern-footer">
                    <div class="flex items-center justify-between text-sm text-neutral-600 dark:text-neutral-400">
                        <span>Created {{ $category->created_at->format('M j, Y') }}</span>
                        <span>Updated {{ $category->updated_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="card-modern">
                    <div class="card-modern-body text-center py-12">
                        <svg class="w-16 h-16 mx-auto mb-4 text-neutral-300 dark:text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-neutral-900 dark:text-neutral-100 mb-2">No product categories found</h3>
                        <p class="text-neutral-600 dark:text-neutral-400 mb-6">Get started by creating your first category to organize your products.</p>
                        <a href="{{ route('admin.product-categories.create') }}" class="btn-modern btn-modern-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create Category
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($categories->hasPages())
        <div class="mt-8">
            <div class="card-modern-footer">
                {{ $categories->links() }}
            </div>
        </div>
    @endif
@endsection
