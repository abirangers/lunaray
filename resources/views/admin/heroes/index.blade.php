@extends('layouts.admin')

@section('title', 'Hero Slider')
@section('pageTitle', 'Hero Slider Management')
@section('pageDescription', 'Manage your landing page hero slider')

@section('content')

    <!-- Action Buttons -->
    <div class="mb-8">
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.heroes.create') }}" class="btn-modern btn-modern-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Hero Slide
            </a>
        </div>
    </div>

    <!-- Modern Filters -->
    <div class="card-modern mb-6">
        <div class="card-modern-header">
            <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Search & Filters</h2>
        </div>
        <div class="card-modern-body">
            <form method="GET" class="flex gap-4">
                <div class="flex-1">
                    <label for="search" class="form-modern-label">Search Heroes</label>
                    <div class="input-group-modern">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               placeholder="Search by name..." 
                               class="input-group-modern-input">
                        <div class="input-group-modern-icon">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="w-48">
                    <label for="sort" class="form-modern-label">Sort By</label>
                    <select name="sort" id="sort" class="form-modern">
                        <option value="order" {{ request('sort') == 'order' ? 'selected' : '' }}>Display Order</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="btn-modern btn-modern-primary">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modern Heroes Grid -->
    <div class="card-modern">
        <div class="card-modern-header">
            <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Hero Slides</h2>
            <p class="text-sm text-neutral-600 dark:text-neutral-400">{{ $heroes->total() }} slides found</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
            @forelse($heroes as $hero)
                <div class="bg-neutral-50 dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 overflow-hidden hover:shadow-lg transition-shadow">
                    @if($hero->hasMedia('hero_image'))
                        <img class="w-full h-48 object-cover" 
                             src="{{ $hero->getFirstMediaUrl('hero_image', 'medium') }}" 
                             alt="{{ $hero->name }}">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-primary-100 to-secondary-100 dark:from-primary-900/20 dark:to-secondary-900/20 flex items-center justify-center">
                            <svg class="w-12 h-12 text-primary-500 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                    
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">
                                {{ $hero->name }}
                            </h3>
                            @if($hero->is_active)
                                <span class="badge-modern badge-modern-success">Active</span>
                            @else
                                <span class="badge-modern badge-modern-secondary">Inactive</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-between text-sm text-neutral-600 dark:text-neutral-400 mb-4">
                            <span>Order: {{ $hero->order }}</span>
                            <span>{{ $hero->created_at->format('M d, Y') }}</span>
                        </div>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('admin.heroes.edit', $hero) }}" 
                               class="flex-1 btn-modern btn-modern-primary btn-modern-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                            <form method="POST" 
                                  action="{{ route('admin.heroes.destroy', $hero) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this hero slide?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-modern btn-modern-danger btn-modern-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-16 h-16 mx-auto mb-4 text-neutral-300 dark:text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-neutral-900 dark:text-neutral-100 mb-2">No hero slides found</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 mb-6">Get started by adding your first hero slide.</p>
                    <a href="{{ route('admin.heroes.create') }}" class="btn-modern btn-modern-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Hero Slide
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($heroes->hasPages())
            <div class="card-modern-footer">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">
                        Showing {{ $heroes->firstItem() }} to {{ $heroes->lastItem() }} of {{ $heroes->total() }} slides
                    </div>
                    <div>
                        {{ $heroes->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection

