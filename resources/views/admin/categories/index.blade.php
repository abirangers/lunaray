@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-primary mb-2">Manage Categories</h1>
            <p class="text-gray-600">Organize your content with categories</p>
        </div>
        <a href="{{ route('categories.create') }}" class="bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-lg transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Category
        </a>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($categories as $category)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <!-- Category Header -->
                <div class="p-6" style="background: linear-gradient(135deg, {{ $category->color }}20, {{ $category->color }}10);">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $category->color }}"></div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('categories.edit', $category) }}" class="text-blue-600 hover:text-blue-900" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    @if($category->description)
                        <p class="text-sm text-gray-600 mb-4">{{ $category->description }}</p>
                    @endif
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <span class="text-sm text-gray-500">{{ $category->articles_count }} articles</span>
                        </div>
                        <a href="{{ route('categories.show', $category) }}" class="text-primary hover:text-primary-dark text-sm font-medium">
                            View Articles →
                        </a>
                    </div>
                </div>

                <!-- Category Stats -->
                <div class="px-6 py-4 bg-gray-50">
                    <div class="flex items-center justify-between text-sm text-gray-600">
                        <span>Created {{ $category->created_at->format('M j, Y') }}</span>
                        <span>Updated {{ $category->updated_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No categories found</h3>
                    <p class="text-gray-600 mb-6">Get started by creating your first category to organize your content.</p>
                    <a href="{{ route('categories.create') }}" class="bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-lg transition-colors inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Category
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($categories->hasPages())
        <div class="mt-8">
            {{ $categories->links() }}
        </div>
    @endif
</div>
@endsection
