@extends('layouts.admin')

@section('title', 'View Article')
@section('pageTitle', 'View Article')
@section('pageDescription', 'Preview and manage article details')

@section('content')
    <!-- Action Buttons -->
    <div class="mb-8">
        <div class="flex items-center justify-end space-x-3">
            <a href="#" class="btn-modern btn-modern-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Articles
            </a>
            <a href="{{ route('articles.edit', $article) }}" class="btn-modern btn-modern-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Article
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Article Content -->
            <div class="card-modern">
                <div class="card-modern-header">
                    <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Article Content</h2>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Full article content and details</p>
                </div>
                <div class="card-modern-body">
                    @if($article->hasMedia('featured'))
                        <div class="mb-6">
                            <img src="{{ $article->getFirstMediaUrl('featured', 'large') }}" alt="{{ $article->title }}" 
                                 class="w-full h-64 object-cover rounded-xl">
                        </div>
                    @else
                        <div class="mb-6">
                            <div class="w-full h-64 rounded-xl bg-gradient-to-br from-primary-100 to-secondary-100 dark:from-primary-900/20 dark:to-secondary-900/20 flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-primary-500 dark:text-primary-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-sm text-primary-600 dark:text-primary-400 font-medium">No featured image</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if($article->excerpt)
                        <div class="mb-6 p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                            <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100 mb-2">Excerpt</h3>
                            <p class="text-neutral-700 dark:text-neutral-300">{{ $article->excerpt }}</p>
                        </div>
                    @endif
                    
                    <div class="prose prose-lg max-w-none dark:prose-invert">
                        {!! $article->content ?? '' !!}
                    </div>
                </div>
            </div>

            <!-- Article Statistics -->
            <div class="card-modern">
                <div class="card-modern-header">
                    <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Article Statistics</h2>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Performance metrics and analytics</p>
                </div>
                <div class="card-modern-body">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="text-center p-4 bg-primary-50 dark:bg-primary-900/20 rounded-xl">
                            <div class="text-2xl font-bold text-primary-600 dark:text-primary-400">{{ number_format($article->view_count) }}</div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400">Total Views</div>
                        </div>
                        <div class="text-center p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                            <div class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $article->created_at->format('M j') }}</div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400">Created</div>
                        </div>
                        <div class="text-center p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                            <div class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $article->updated_at->format('M j') }}</div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400">Last Updated</div>
                        </div>
                        <div class="text-center p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                            <div class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $article->categories->count() }}</div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400">Categories</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            <!-- Article Details -->
            <div class="card-modern">
                <div class="card-modern-header">
                    <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Article Details</h2>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Basic information and settings</p>
                </div>
                <div class="card-modern-body">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                            <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Status</span>
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $article->status === 'published' ? 'bg-success-100 text-success-800 dark:bg-success-900/20 dark:text-success-200' : 'bg-warning-100 text-warning-800 dark:bg-warning-900/20 dark:text-warning-200' }}">
                                {{ ucfirst($article->status) }}
                            </span>
                        </div>
                        
                        @if($article->is_featured)
                            <div class="flex items-center justify-between p-3 bg-accent-50 dark:bg-accent-900/20 rounded-xl">
                                <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Featured</span>
                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-accent-100 text-accent-800 dark:bg-accent-900/20 dark:text-accent-200">
                                    Yes
                                </span>
                            </div>
                        @endif
                        
                        <div class="flex items-center justify-between p-3 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                            <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Author</span>
                            <span class="text-sm text-neutral-900 dark:text-neutral-100">{{ $article->author_name }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                            <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Created</span>
                            <span class="text-sm text-neutral-900 dark:text-neutral-100">{{ $article->created_at->format('M j, Y') }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                            <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Last Updated</span>
                            <span class="text-sm text-neutral-900 dark:text-neutral-100">{{ $article->updated_at->format('M j, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories -->
            @if($article->categories->count() > 0)
                <div class="card-modern">
                    <div class="card-modern-header">
                        <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Categories</h2>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">Article categories and tags</p>
                    </div>
                    <div class="card-modern-body">
                        <div class="space-y-3">
                            @foreach($article->categories as $category)
                                <div class="flex items-center space-x-3 p-3 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                                    <div class="w-3 h-3 rounded-full" style="background-color: {{ $category->color ?? '#3B82F6' }}"></div>
                                    <span class="text-sm text-neutral-900 dark:text-neutral-100">{{ $category->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="card-modern">
                <div class="card-modern-header">
                    <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Quick Actions</h2>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Manage this article</p>
                </div>
                <div class="card-modern-body">
                    <div class="space-y-3">
                        <a href="{{ route('articles.edit', $article) }}" class="w-full btn-modern btn-modern-primary flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Article
                        </a>
                        
                        @if($article->status === 'draft')
                            <form action="{{ route('articles.publish', $article) }}" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full btn-modern btn-modern-secondary flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Publish Article
                                </button>
                            </form>
                        @else
                            <form action="{{ route('articles.unpublish', $article) }}" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full btn-modern btn-modern-secondary flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Unpublish Article
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('articles.duplicate', $article) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full btn-modern btn-modern-ghost flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Duplicate Article
                            </button>
                        </form>
                        
                        <form action="{{ route('articles.destroy', $article) }}" method="POST" class="w-full" onsubmit="return confirm('Are you sure you want to delete this article? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full btn-modern btn-modern-ghost text-error-600 hover:text-error-700 flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete Article
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
