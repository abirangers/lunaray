@extends('layouts.admin')

@section('title', 'Manage Articles')
@section('pageTitle', 'Articles Management')
@section('pageDescription', 'Create, edit, and manage your articles with advanced tools and insights')

@section('content')

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <strong>Validation Errors:</strong>
            </div>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="mb-8">
        <div class="flex items-center justify-end">
            <a href="{{ route('articles.create') }}" class="btn-modern btn-modern-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Article
        </a>
        </div>
    </div>

    <!-- Modern Filters -->
    <div class="card-modern mb-6">
        <div class="card-modern-header">
            <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Search & Filters</h2>
            <p class="text-sm text-neutral-600 dark:text-neutral-400">Find articles with advanced filtering options</p>
        </div>
        <div class="card-modern-body">
            <form method="GET" class="space-y-6">
                <!-- Search and Quick Filters -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Modern Search -->
            <div>
                        <label for="search" class="form-modern-label">Search Articles</label>
                        <div class="input-group-modern">
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                   placeholder="Search by title, content..." 
                                   class="input-group-modern-input">
                            <div class="input-group-modern-icon">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
            </div>

            <!-- Category Filter -->
            <div>
                        <label for="category" class="form-modern-label">Category</label>
                        <select name="category" id="category" class="form-modern">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->articles_count ?? 0 }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                        <label for="status" class="form-modern-label">Status</label>
                        <select name="status" id="status" class="form-modern">
                    <option value="">All Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

                    <!-- Author Filter -->
                    <div>
                        <label for="author" class="form-modern-label">Author</label>
                        <select name="author" id="author" class="form-modern">
                            <option value="">All Authors</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Modern Advanced Options -->
                <div class="flex flex-wrap items-center gap-6 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="featured" id="featured" value="1" {{ request('featured') ? 'checked' : '' }} 
                               class="w-4 h-4 text-primary-600 bg-neutral-100 border-neutral-300 rounded focus:ring-primary-500 focus:ring-2">
                        <label for="featured" class="text-sm font-medium text-neutral-700 dark:text-neutral-300">
                            Featured Only
                </label>
            </div>

                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="has_image" id="has_image" value="1" {{ request('has_image') ? 'checked' : '' }} 
                               class="w-4 h-4 text-primary-600 bg-neutral-100 border-neutral-300 rounded focus:ring-primary-500 focus:ring-2">
                        <label for="has_image" class="text-sm font-medium text-neutral-700 dark:text-neutral-300">
                            With Featured Image
                        </label>
                    </div>

                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="high_views" id="high_views" value="1" {{ request('high_views') ? 'checked' : '' }} 
                               class="w-4 h-4 text-primary-600 bg-neutral-100 border-neutral-300 rounded focus:ring-primary-500 focus:ring-2">
                        <label for="high_views" class="text-sm font-medium text-neutral-700 dark:text-neutral-300">
                            High Views (100+)
                        </label>
                    </div>
                </div>

                <!-- Modern Filter Actions -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                    <button type="submit" class="btn-modern btn-modern-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                    Apply Filters
                </button>
                    <a href="{{ route('admin.articles.index') }}" class="btn-modern btn-modern-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    Clear Filters
                </a>
            </div>
        </form>
    </div>
    </div>

    <!-- Modern Articles Table -->
    <div class="card-modern">
        <div class="card-modern-header">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Articles</h2>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">{{ $articles->total() }} articles found</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto" x-data="bulkActions()">
            <!-- Modern Bulk Actions -->
            <div class="mb-4 p-4 bg-neutral-50 rounded-lg border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-neutral-600">
                            <span x-text="selectedArticles.length"></span> articles selected
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <select class="form-modern text-sm" x-model="selectedAction">
                            <option value="">Bulk Actions</option>
                            <option value="publish">Publish Selected</option>
                            <option value="unpublish">Unpublish Selected</option>
                            <option value="feature">Mark as Featured</option>
                            <option value="unfeature">Remove Featured</option>
                            <option value="delete">Delete Selected</option>
                        </select>
                        <button type="button" class="btn-modern btn-modern-secondary" @click="applyBulkAction()" :disabled="selectedArticles.length === 0 || !selectedAction || isProcessing">
                            <span x-show="!isProcessing">
                                Apply (<span x-text="selectedArticles.length"></span>)
                            </span>
                            <span x-show="isProcessing" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            
            <table class="table-modern">
                <thead class="table-modern-header">
                    <tr>
                        <th class="table-modern-header-cell w-12">
                            <input type="checkbox" class="w-4 h-4 text-primary-600 bg-neutral-100 border-neutral-300 rounded focus:ring-primary-500 focus:ring-2" @change="toggleAll($event)" x-ref="selectAll">
                        </th>
                        <th class="table-modern-header-cell">Article</th>
                        <th class="table-modern-header-cell">Author</th>
                        <th class="table-modern-header-cell">Categories</th>
                        <th class="table-modern-header-cell">Status</th>
                        <th class="table-modern-header-cell">Views</th>
                        <th class="table-modern-header-cell">Created</th>
                        <th class="table-modern-header-cell">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-modern-body">
                    @forelse($articles as $article)
                        <tr class="table-modern-row">
                            <td class="table-modern-cell w-12">
                                <input type="checkbox" 
                                       name="article_checkbox" 
                                       data-article-id="{{ $article->id }}"
                                       class="w-4 h-4 text-primary-600 bg-neutral-100 border-neutral-300 rounded focus:ring-primary-500 focus:ring-2" 
                                       @change="updateSelection({{ $article->id }}, $event.target.checked)">
                            </td>
                            <td class="table-modern-cell">
                                <div class="flex items-center space-x-4">
                                    @if($article->hasMedia('featured'))
                                        <img class="h-12 w-12 rounded-lg object-cover flex-shrink-0" src="{{ $article->getFirstMediaUrl('featured', 'thumb') }}" alt="{{ $article->title }}">
                                    @else
                                        <div class="h-12 w-12 rounded-lg bg-gradient-to-br from-primary-100 to-secondary-100 dark:from-primary-900/20 dark:to-secondary-900/20 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-primary-500 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <h3 class="text-sm font-medium text-neutral-900 dark:text-neutral-100 truncate">
                                            {{ $article->title }}
                                            </h3>
                                            @if($article->is_featured)
                                                <span class="badge badge-accent">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                    Featured
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-neutral-600 dark:text-neutral-400 truncate">{{ Str::limit($article->excerpt, 60) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="table-modern-cell">
                                <div class="flex items-center space-x-3">
                                    <div class="h-8 w-8 rounded-full bg-primary-100 dark:bg-primary-900/20 flex items-center justify-center">
                                        <span class="text-primary-600 dark:text-primary-400 font-medium text-sm">{{ substr($article->author_name, 0, 1) }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ $article->author_name }}</span>
                                </div>
                            </td>
                            <td class="table-modern-cell">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($article->categories as $category)
                                        <span class="badge-modern badge-modern-primary" style="background-color: {{ $category->color }}15; color: {{ $category->color }}; border: 1px solid {{ $category->color }}30;">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="table-modern-cell">
                                @if($article->status === 'published')
                                    <span class="badge-modern badge-modern-success">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Published
                                    </span>
                                @else
                                    <span class="badge-modern badge-modern-warning">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="table-modern-cell">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ number_format($article->view_count) }}</span>
                                </div>
                            </td>
                            <td class="table-modern-cell">
                                <div class="text-sm text-neutral-600 dark:text-neutral-400">
                                {{ $article->created_at->format('M j, Y') }}
                                </div>
                            </td>
                            <td class="table-modern-cell">
                                <div class="flex items-center space-x-1">
                                    <a href="#" class="btn-modern btn-modern-ghost p-2" title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('articles.edit', $article) }}" class="btn-modern btn-modern-ghost p-2" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('articles.duplicate', $article) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn-modern btn-modern-ghost p-2" title="Duplicate">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this article?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-modern btn-modern-ghost p-2 text-error-600 hover:text-error-700" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="table-modern-cell">
                                <div class="text-center py-12">
                                    <div class="mx-auto w-24 h-24 bg-neutral-100 dark:bg-neutral-800 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-12 h-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100 mb-2">No articles found</h3>
                                    <p class="text-neutral-600 dark:text-neutral-400 mb-6">Get started by creating your first article or adjust your search criteria.</p>
                                    <a href="{{ route('articles.create') }}" class="btn-modern btn-modern-primary">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Create First Article
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modern Pagination -->
        @if($articles->hasPages())
            <div class="card-modern-footer">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">
                        Showing {{ $articles->firstItem() ?? 0 }} to {{ $articles->lastItem() ?? 0 }} of {{ $articles->total() }} results
                    </div>
                    <div class="flex items-center space-x-2">
                {{ $articles->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Toast Notifications -->
    <div x-data="toastNotifications()" class="fixed top-4 right-4 z-50 space-y-2">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.show" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-x-full"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform translate-x-full"
                 :class="{
                     'bg-green-500': toast.type === 'success',
                     'bg-red-500': toast.type === 'error',
                     'bg-yellow-500': toast.type === 'warning',
                     'bg-blue-500': toast.type === 'info'
                 }"
                 class="px-4 py-3 rounded-lg shadow-lg text-white max-w-sm">
                <div class="flex items-center justify-between">
                    <span x-text="toast.message"></span>
                    <button @click="removeToast(toast.id)" class="ml-4 text-white hover:text-gray-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </template>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('bulkActions', () => ({
            selectedArticles: [],
            selectedAction: '',
            isProcessing: false,
            
            init() {
                // Initialize the component
                this.$watch('selectedArticles', () => {
                    this.updateSelectAllState();
                });
                
                // Initial state update
                this.$nextTick(() => {
                    this.updateSelectAllState();
                });
            },
            
            toggleAll(event) {
                const isChecked = event.target.checked;
                const checkboxes = document.querySelectorAll('input[type="checkbox"][name="article_checkbox"]');
                
                // Clear and rebuild selectedArticles array
                this.selectedArticles = [];
                
                checkboxes.forEach(checkbox => {
                    const articleId = parseInt(checkbox.dataset.articleId);
                    
                    if (isChecked) {
                        checkbox.checked = true;
                        this.selectedArticles.push(articleId);
                    } else {
                        checkbox.checked = false;
                    }
                });
                
                // Force update the UI
                this.$nextTick(() => {
                    this.updateSelectAllState();
                });
            },
            
            updateSelection(articleId, isSelected) {
                if (isSelected) {
                    if (!this.selectedArticles.includes(articleId)) {
                        this.selectedArticles.push(articleId);
                    }
                } else {
                    this.selectedArticles = this.selectedArticles.filter(id => id !== articleId);
                }
                
                // Force update the UI
                this.$nextTick(() => {
                    this.updateSelectAllState();
                });
            },
            
            updateSelectAllState() {
                const totalCheckboxes = document.querySelectorAll('input[type="checkbox"][name="article_checkbox"]').length;
                const selectedCount = this.selectedArticles.length;
                
                if (this.$refs.selectAll) {
                    if (selectedCount === 0) {
                        this.$refs.selectAll.indeterminate = false;
                        this.$refs.selectAll.checked = false;
                    } else if (selectedCount === totalCheckboxes) {
                        this.$refs.selectAll.indeterminate = false;
                        this.$refs.selectAll.checked = true;
                    } else {
                        this.$refs.selectAll.indeterminate = true;
                        this.$refs.selectAll.checked = false;
                    }
                }
                
                // Update individual checkboxes to match selectedArticles
                const checkboxes = document.querySelectorAll('input[type="checkbox"][name="article_checkbox"]');
                checkboxes.forEach(checkbox => {
                    const articleId = parseInt(checkbox.dataset.articleId);
                    checkbox.checked = this.selectedArticles.includes(articleId);
                });
            },
            
            async applyBulkAction() {
                if (this.selectedArticles.length === 0) {
                    this.showAlert('Please select articles first', 'warning');
                    return;
                }
                
                if (!this.selectedAction) {
                    this.showAlert('Please select an action', 'warning');
                    return;
                }
                
                const actionText = this.getActionText(this.selectedAction);
                const confirmMessage = `Are you sure you want to ${actionText.toLowerCase()} ${this.selectedArticles.length} article(s)?`;
                
                if (confirm(confirmMessage)) {
                    this.isProcessing = true;
                    
                    try {
                        // Create form data
                        const formData = new FormData();
                        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                        formData.append('action', this.selectedAction);
                        
                        // Add articles array
                        this.selectedArticles.forEach(articleId => {
                            formData.append('articles[]', articleId);
                        });
                        
                        // Submit via fetch
                        const response = await fetch('{{ route("articles.bulk-action") }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                            }
                        });
                        
                        if (response.ok) {
                            // Reload page to show results
                            window.location.reload();
                        } else {
                            const errorData = await response.json();
                            this.showAlert('Error: ' + (errorData.message || 'Unknown error occurred'), 'error');
                        }
                        
                    } catch (error) {
                        console.error('Error submitting bulk action:', error);
                        this.showAlert('An error occurred while processing your request', 'error');
                    } finally {
                        this.isProcessing = false;
                    }
                }
            },
            
            getActionText(action) {
                const actionTexts = {
                    'publish': 'Publish',
                    'unpublish': 'Unpublish',
                    'feature': 'Mark as Featured',
                    'unfeature': 'Remove Featured',
                    'delete': 'Delete'
                };
                return actionTexts[action] || action;
            },
            
            showAlert(message, type = 'info') {
                // Use toast notifications instead of alert
                this.$dispatch('show-toast', { message, type });
            }
        }));

        // Toast Notifications Component
        Alpine.data('toastNotifications', () => ({
            toasts: [],
            toastId: 0,
            
            init() {
                this.$el.addEventListener('show-toast', (e) => {
                    this.addToast(e.detail.message, e.detail.type);
                });
            },
            
            addToast(message, type = 'info') {
                const id = ++this.toastId;
                const toast = {
                    id,
                    message,
                    type,
                    show: true
                };
                
                this.toasts.push(toast);
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    this.removeToast(id);
                }, 5000);
            },
            
            removeToast(id) {
                const toastIndex = this.toasts.findIndex(toast => toast.id === id);
                if (toastIndex !== -1) {
                    this.toasts[toastIndex].show = false;
                    setTimeout(() => {
                        this.toasts.splice(toastIndex, 1);
                    }, 200);
                }
            }
        }));
    });
    </script>
    @endpush
@endsection