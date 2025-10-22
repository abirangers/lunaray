@extends('layouts.admin')

@section('title', 'Manage Categories')
@section('pageTitle', 'Categories Management')
@section('pageDescription', 'Organize your content with categories and manage your content structure')

@section('content')
    <!-- Action Buttons -->
    <div class="mb-8">
        <div class="flex items-center justify-end">
            <a href="{{ route('categories.create') }}" class="btn-modern btn-modern-primary">
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
                <div class="card-modern-header" style="background: linear-gradient(135deg, {{ $category->color }}20, {{ $category->color }}10);">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $category->color }}"></div>
                            <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">{{ $category->name }}</h3>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('categories.edit', $category) }}" class="text-primary-500 hover:text-primary-600 dark:text-primary-400 dark:hover:text-primary-300" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
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
                        <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-4">{{ $category->description }}</p>
                    @endif
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <span class="badge-modern {{ $category->is_active ? 'badge-modern-success' : 'badge-modern-error' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <span class="text-sm text-neutral-500 dark:text-neutral-400">{{ $category->articles_count }} articles</span>
                        </div>
                        <a href="{{ route('categories.show', $category) }}" class="text-primary-500 hover:text-primary-600 dark:text-primary-400 dark:hover:text-primary-300 text-sm font-medium">
                            View Articles →
                        </a>
                    </div>
                </div>

                <!-- Category Stats -->
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-neutral-900 dark:text-neutral-100 mb-2">No categories found</h3>
                        <p class="text-neutral-600 dark:text-neutral-400 mb-6">Get started by creating your first category to organize your content.</p>
                        <a href="{{ route('categories.create') }}" class="btn-modern btn-modern-primary">
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
