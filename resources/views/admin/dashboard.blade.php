@extends('layouts.admin')

@section('title', 'Content Manager Dashboard')
@section('pageTitle', 'Content Manager Dashboard')
@section('pageDescription', 'Manage your content and track performance')

@section('content')
    <!-- Modern Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-8">
        <!-- Total Articles -->
        <div class="card-modern hover:shadow-lg transition-all duration-300">
            <div class="card-modern-body">
                <div class="flex items-center">
                    <div class="p-3 bg-primary-100 dark:bg-primary-900/20 rounded-xl">
                        <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Articles</p>
                        <p class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $stats['total_articles'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Published Articles -->
        <div class="card-modern hover:shadow-lg transition-all duration-300">
            <div class="card-modern-body">
                <div class="flex items-center">
                    <div class="p-3 bg-success-100 dark:bg-success-900/20 rounded-xl">
                        <svg class="w-6 h-6 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Published</p>
                        <p class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $stats['published_articles'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Draft Articles -->
        <div class="card-modern hover:shadow-lg transition-all duration-300">
            <div class="card-modern-body">
                <div class="flex items-center">
                    <div class="p-3 bg-warning-100 dark:bg-warning-900/20 rounded-xl">
                        <svg class="w-6 h-6 text-warning-600 dark:text-warning-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Drafts</p>
                        <p class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $stats['draft_articles'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Articles -->
        <div class="card-modern hover:shadow-lg transition-all duration-300">
            <div class="card-modern-body">
                <div class="flex items-center">
                    <div class="p-3 bg-accent-100 dark:bg-accent-900/20 rounded-xl">
                        <svg class="w-6 h-6 text-accent-600 dark:text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Featured</p>
                        <p class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $stats['featured_articles'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="card-modern hover:shadow-lg transition-all duration-300">
            <div class="card-modern-body">
                <div class="flex items-center">
                    <div class="p-3 bg-secondary-100 dark:bg-secondary-900/20 rounded-xl">
                        <svg class="w-6 h-6 text-secondary-600 dark:text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Categories</p>
                        <p class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $stats['total_categories'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Views -->
        <div class="card-modern hover:shadow-lg transition-all duration-300">
            <div class="card-modern-body">
                <div class="flex items-center">
                    <div class="p-3 bg-info-100 dark:bg-info-900/20 rounded-xl">
                        <svg class="w-6 h-6 text-info-600 dark:text-info-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Views</p>
                        <p class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ number_format($stats['total_views']) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('manage users')
    <!-- Admin-specific cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-8">
        <!-- Total Users -->
        <div class="card-modern hover:shadow-lg transition-all duration-300">
            <div class="card-modern-body">
                <div class="flex items-center">
                    <div class="p-3 bg-primary-100 dark:bg-primary-900/20 rounded-xl">
                        <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Users</p>
                        <p class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $stats['total_users'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Google Users -->
        <div class="card-modern hover:shadow-lg transition-all duration-300">
            <div class="card-modern-body">
                <div class="flex items-center">
                    <div class="p-3 bg-success-100 dark:bg-success-900/20 rounded-xl">
                        <svg class="w-6 h-6 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Google Users</p>
                        <p class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $stats['google_users'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Staff Users -->
        <div class="card-modern hover:shadow-lg transition-all duration-300">
            <div class="card-modern-body">
                <div class="flex items-center">
                    <div class="p-3 bg-accent-100 dark:bg-accent-900/20 rounded-xl">
                        <svg class="w-6 h-6 text-accent-600 dark:text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Staff Users</p>
                        <p class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $stats['staff_users'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Sessions -->
        <div class="card-modern hover:shadow-lg transition-all duration-300">
            <div class="card-modern-body">
                <div class="flex items-center">
                    <div class="p-3 bg-info-100 dark:bg-info-900/20 rounded-xl">
                        <svg class="w-6 h-6 text-info-600 dark:text-info-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Active Sessions</p>
                        <p class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $stats['active_sessions'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Sessions -->
        <div class="card-modern hover:shadow-lg transition-all duration-300">
            <div class="card-modern-body">
                <div class="flex items-center">
                    <div class="p-3 bg-warning-100 dark:bg-warning-900/20 rounded-xl">
                        <svg class="w-6 h-6 text-warning-600 dark:text-warning-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Sessions</p>
                        <p class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $stats['total_sessions'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Health -->
        <div class="card-modern hover:shadow-lg transition-all duration-300">
            <div class="card-modern-body">
                <div class="flex items-center">
                    <div class="p-3 bg-error-100 dark:bg-error-900/20 rounded-xl">
                        <svg class="w-6 h-6 text-error-600 dark:text-error-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">System Health</p>
                        <p class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $stats['system_health']['cache_status'] ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Articles -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Recent Articles</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Latest articles from your team</p>
            </div>
            <div class="card-modern-body">
                @if($recent_articles->count() > 0)
                    <div class="space-y-4">
                        @foreach($recent_articles as $article)
                            <div class="flex items-center justify-between p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl transition-colors duration-200 hover:bg-neutral-100 dark:hover:bg-neutral-700">
                                <div class="flex-1">
                                    <h3 class="font-medium text-neutral-900 dark:text-neutral-100">{{ $article->title }}</h3>
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400">By {{ $article->author->name }} • {{ $article->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full {{ $article->status === 'published' ? 'bg-success-100 text-success-800 dark:bg-success-900/20 dark:text-success-200' : 'bg-warning-100 text-warning-800 dark:bg-warning-900/20 dark:text-warning-200' }}">
                                        {{ ucfirst($article->status) }}
                                    </span>
                                    @if($article->is_featured)
                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-accent-100 text-accent-800 dark:bg-accent-900/20 dark:text-accent-200">
                                            Featured
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('articles.index') }}" class="text-primary-500 hover:text-primary-600 dark:text-primary-400 dark:hover:text-primary-300 font-medium transition-colors duration-200">View all articles →</a>
                    </div>
                @else
                    <p class="text-neutral-500 dark:text-neutral-400 text-center py-8">No articles yet. <a href="{{ route('articles.create') }}" class="text-primary-500 hover:text-primary-600 dark:text-primary-400 dark:hover:text-primary-300 transition-colors duration-200">Create your first article</a></p>
                @endif
            </div>
        </div>

        <!-- Draft Articles -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Draft Articles</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Articles pending publication</p>
            </div>
            <div class="card-modern-body">
                @if($draft_articles->count() > 0)
                    <div class="space-y-4">
                        @foreach($draft_articles as $article)
                            <div class="flex items-center justify-between p-4 bg-warning-50 dark:bg-warning-900/10 rounded-xl transition-colors duration-200 hover:bg-warning-100 dark:hover:bg-warning-900/20">
                                <div class="flex-1">
                                    <h3 class="font-medium text-neutral-900 dark:text-neutral-100">{{ $article->title }}</h3>
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400">By {{ $article->author->name }} • {{ $article->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('articles.edit', $article) }}" class="text-primary-500 hover:text-primary-600 dark:text-primary-400 dark:hover:text-primary-300 text-sm font-medium transition-colors duration-200">Edit</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-neutral-500 dark:text-neutral-400 text-center py-8">No draft articles</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Popular Articles -->
    <div class="card-modern mb-8">
        <div class="card-modern-header">
            <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Popular Articles</h2>
            <p class="text-sm text-neutral-600 dark:text-neutral-400">Most viewed articles this month</p>
        </div>
        <div class="card-modern-body">
            @if($popular_articles->count() > 0)
                <div class="space-y-4">
                    @foreach($popular_articles as $article)
                        <div class="flex items-center justify-between p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl transition-colors duration-200 hover:bg-neutral-100 dark:hover:bg-neutral-700">
                            <div class="flex-1">
                                <h3 class="font-medium text-neutral-900 dark:text-neutral-100">{{ $article->title }}</h3>
                                <p class="text-sm text-neutral-600 dark:text-neutral-400">By {{ $article->author->name }} • {{ $article->view_count }} views</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-neutral-600 dark:text-neutral-400">{{ $article->view_count }} views</span>
                                <a href="{{ route('articles.show', $article) }}" class="text-primary-500 hover:text-primary-600 dark:text-primary-400 dark:hover:text-primary-300 text-sm font-medium transition-colors duration-200">View</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-neutral-500 dark:text-neutral-400 text-center py-8">No popular articles yet</p>
            @endif
        </div>
    </div>

    <!-- Categories Overview -->
    <div class="card-modern mb-8">
        <div class="card-modern-header">
            <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Categories Overview</h2>
            <p class="text-sm text-neutral-600 dark:text-neutral-400">Content distribution by category</p>
        </div>
        <div class="card-modern-body">
            @if($articles_by_category->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($articles_by_category as $category)
                        <div class="p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl transition-colors duration-200 hover:bg-neutral-100 dark:hover:bg-neutral-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-neutral-900 dark:text-neutral-100">{{ $category->name }}</h3>
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400">{{ $category->articles_count }} articles</p>
                                </div>
                                <div class="w-3 h-3 rounded-full" style="background-color: {{ $category->color ?? '#3B82F6' }}"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-neutral-500 dark:text-neutral-400 text-center py-8">No categories yet. <a href="{{ route('categories.create') }}" class="text-primary-500 hover:text-primary-600 dark:text-primary-400 dark:hover:text-primary-300 transition-colors duration-200">Create your first category</a></p>
            @endif
        </div>
    </div>

    @can('manage users')
    <!-- Admin-specific sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Users -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Recent Users</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Latest user registrations</p>
            </div>
            <div class="card-modern-body">
                @if(isset($admin_data['recent_users']) && $admin_data['recent_users']->count() > 0)
                    <div class="space-y-4">
                        @foreach($admin_data['recent_users'] as $user)
                            <div class="flex items-center justify-between p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl transition-colors duration-200 hover:bg-neutral-100 dark:hover:bg-neutral-700">
                                <div class="flex-1">
                                    <h3 class="font-medium text-neutral-900 dark:text-neutral-100">{{ $user->name }}</h3>
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400">{{ $user->email }} • {{ $user->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @foreach($user->roles as $role)
                                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-primary-100 text-primary-800 dark:bg-primary-900/20 dark:text-primary-200">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.users') }}" class="text-primary-500 hover:text-primary-600 dark:text-primary-400 dark:hover:text-primary-300 font-medium transition-colors duration-200">View all users →</a>
                    </div>
                @else
                    <p class="text-neutral-500 dark:text-neutral-400 text-center py-8">No users yet</p>
                @endif
            </div>
        </div>

        <!-- System Metrics -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">System Metrics</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Current system performance</p>
            </div>
            <div class="card-modern-body">
                @if(isset($admin_data['system_metrics']))
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl transition-colors duration-200 hover:bg-neutral-100 dark:hover:bg-neutral-700">
                            <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">PHP Version</span>
                            <span class="text-sm text-neutral-900 dark:text-neutral-100 font-mono">{{ $admin_data['system_metrics']['php_version'] }}</span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl transition-colors duration-200 hover:bg-neutral-100 dark:hover:bg-neutral-700">
                            <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Laravel Version</span>
                            <span class="text-sm text-neutral-900 dark:text-neutral-100 font-mono">{{ $admin_data['system_metrics']['laravel_version'] }}</span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl transition-colors duration-200 hover:bg-neutral-100 dark:hover:bg-neutral-700">
                            <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Memory Usage</span>
                            <span class="text-sm text-neutral-900 dark:text-neutral-100 font-mono">{{ number_format($admin_data['system_metrics']['memory_usage'] / 1024 / 1024, 2) }} MB</span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl transition-colors duration-200 hover:bg-neutral-100 dark:hover:bg-neutral-700">
                            <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Peak Memory</span>
                            <span class="text-sm text-neutral-900 dark:text-neutral-100 font-mono">{{ number_format($admin_data['system_metrics']['peak_memory'] / 1024 / 1024, 2) }} MB</span>
                        </div>
                    </div>
                @else
                    <p class="text-neutral-500 dark:text-neutral-400 text-center py-8">System metrics not available</p>
                @endif
            </div>
        </div>
    </div>

    <!-- User Registration Statistics -->
    <div class="card-modern mb-8">
        <div class="card-modern-header">
            <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">User Registration Statistics</h2>
            <p class="text-sm text-neutral-600 dark:text-neutral-400">User growth over time</p>
        </div>
        <div class="card-modern-body">
            @if(isset($admin_data['user_registrations']))
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-primary-500 dark:text-primary-400">{{ $admin_data['user_registrations']['this_month'] }}</div>
                        <div class="text-sm text-neutral-600 dark:text-neutral-400">This Month</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-secondary-500 dark:text-secondary-400">{{ $admin_data['user_registrations']['last_month'] }}</div>
                        <div class="text-sm text-neutral-600 dark:text-neutral-400">Last Month</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-accent-500 dark:text-accent-400">{{ $admin_data['user_registrations']['this_year'] }}</div>
                        <div class="text-sm text-neutral-600 dark:text-neutral-400">This Year</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $admin_data['user_registrations']['total_registrations'] }}</div>
                        <div class="text-sm text-neutral-600 dark:text-neutral-400">Total Users</div>
                    </div>
                </div>
            @else
                <p class="text-neutral-500 dark:text-neutral-400 text-center py-8">Registration statistics not available</p>
            @endif
        </div>
    </div>
    @endcan
@endsection