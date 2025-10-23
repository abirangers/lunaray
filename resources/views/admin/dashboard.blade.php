@extends('layouts.admin')

@section('title', 'Content Manager Dashboard')
@section('pageTitle', 'Content Manager Dashboard')
@section('pageDescription', 'Manage your content and track performance')

@section('content')
    <!-- Modern Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Articles -->
        <div class="card-modern hover:shadow-lg transition-all duration-300">
            <div class="card-modern-body">
                <div class="flex items-center">
                    <div class="p-3 bg-primary-100 rounded-xl">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600">Total Articles</p>
                        <p class="text-2xl font-bold text-neutral-900">{{ $stats['total_articles'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Published Articles -->
        <div class="card-modern hover:shadow-lg transition-all duration-300">
            <div class="card-modern-body">
                <div class="flex items-center">
                    <div class="p-3 bg-success-100 rounded-xl">
                        <svg class="w-6 h-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600">Published</p>
                        <p class="text-2xl font-bold text-neutral-900">{{ $stats['published_articles'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Views -->
        <div class="card-modern hover:shadow-lg transition-all duration-300">
            <div class="card-modern-body">
                <div class="flex items-center">
                    <div class="p-3 bg-info-100 rounded-xl">
                        <svg class="w-6 h-6 text-info-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-neutral-600">Total Views</p>
                        <p class="text-2xl font-bold text-neutral-900">{{ number_format($stats['total_views']) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Articles -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900">Recent Articles</h2>
                <p class="text-sm text-neutral-600">Latest articles from your team</p>
            </div>
            <div class="card-modern-body">
                @if($recent_articles->count() > 0)
                    <div class="space-y-4">
                        @foreach($recent_articles as $article)
                            <div class="flex items-center justify-between p-4 bg-neutral-50 rounded-xl transition-colors duration-200 hover:bg-neutral-100">
                                <div class="flex-1">
                                    <h3 class="font-medium text-neutral-900">{{ $article->title }}</h3>
                                    <p class="text-sm text-neutral-600">By {{ $article->author_name }} • {{ $article->created_at->diffForHumans() }}</p>
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
                        <a href="{{ route('articles.index') }}" class="text-primary-500 hover:text-primary-600 font-medium transition-colors duration-200">View all articles →</a>
                    </div>
                @else
                    <p class="text-neutral-500 text-center py-8">No articles yet. <a href="{{ route('admin.articles.index') }}" class="text-primary-500 hover:text-primary-600 transition-colors duration-200">Manage Articles</a></p>
                @endif
            </div>
        </div>

        <!-- Draft Articles -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900">Draft Articles</h2>
                <p class="text-sm text-neutral-600">Articles pending publication</p>
            </div>
            <div class="card-modern-body">
                @if($draft_articles->count() > 0)
                    <div class="space-y-4">
                        @foreach($draft_articles as $article)
                            <div class="flex items-center justify-between p-4 bg-warning-50 dark:bg-warning-900/10 rounded-xl transition-colors duration-200 hover:bg-warning-100 dark:hover:bg-warning-900/20">
                                <div class="flex-1">
                                    <h3 class="font-medium text-neutral-900">{{ $article->title }}</h3>
                                    <p class="text-sm text-neutral-600">By {{ $article->author_name }} • {{ $article->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('articles.edit', $article) }}" class="text-primary-500 hover:text-primary-600 dark:text-primary-400 dark:hover:text-primary-300 text-sm font-medium transition-colors duration-200">Edit</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-neutral-500 text-center py-8">No draft articles</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Popular Articles -->
    <div class="card-modern mb-8">
        <div class="card-modern-header">
            <h2 class="text-xl font-semibold text-neutral-900">Popular Articles</h2>
            <p class="text-sm text-neutral-600">Most viewed articles this month</p>
        </div>
        <div class="card-modern-body">
            @if($popular_articles->count() > 0)
                <div class="space-y-4">
                    @foreach($popular_articles as $article)
                        <div class="flex items-center justify-between p-4 bg-neutral-50 rounded-xl transition-colors duration-200 hover:bg-neutral-100">
                            <div class="flex-1">
                                <h3 class="font-medium text-neutral-900">{{ $article->title }}</h3>
                                <p class="text-sm text-neutral-600">By {{ $article->author_name }} • {{ $article->view_count }} views</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-neutral-600">{{ $article->view_count }} views</span>
                                <a href="{{ route('articles.show', $article) }}" class="text-primary-500 hover:text-primary-600 dark:text-primary-400 dark:hover:text-primary-300 text-sm font-medium transition-colors duration-200">View</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-neutral-500 text-center py-8">No popular articles yet</p>
            @endif
        </div>
    </div>

    <!-- Categories Overview -->
    <div class="card-modern mb-8">
        <div class="card-modern-header">
            <h2 class="text-xl font-semibold text-neutral-900">Categories Overview</h2>
            <p class="text-sm text-neutral-600">Content distribution by category</p>
        </div>
        <div class="card-modern-body">
            @if($articles_by_category->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($articles_by_category as $category)
                        <div class="p-4 bg-neutral-50 rounded-xl transition-colors duration-200 hover:bg-neutral-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-neutral-900">{{ $category->name }}</h3>
                                    <p class="text-sm text-neutral-600">{{ $category->articles_count }} articles</p>
                                </div>
                                <div class="w-3 h-3 rounded-full" style="background-color: {{ $category->color ?? '#3B82F6' }}"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-neutral-500 text-center py-8">No categories yet. <a href="{{ route('categories.create') }}" class="text-primary-500 hover:text-primary-600 dark:text-primary-400 dark:hover:text-primary-300 transition-colors duration-200">Create your first category</a></p>
            @endif
            </div>
    </div>

    @can('manage users')
    <!-- Admin-specific sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Users -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900">Recent Users</h2>
                <p class="text-sm text-neutral-600">Latest user registrations</p>
            </div>
            <div class="card-modern-body">
                @if(isset($admin_data['recent_users']) && $admin_data['recent_users']->count() > 0)
                    <div class="space-y-4">
                        @foreach($admin_data['recent_users'] as $user)
                            <div class="flex items-center justify-between p-4 bg-neutral-50 rounded-xl transition-colors duration-200 hover:bg-neutral-100">
                                <div class="flex-1">
                                    <h3 class="font-medium text-neutral-900">{{ $user->name }}</h3>
                                    <p class="text-sm text-neutral-600">{{ $user->email }} • {{ $user->created_at->diffForHumans() }}</p>
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
                    <p class="text-neutral-500 text-center py-8">No users yet</p>
                @endif
            </div>
        </div>

        <!-- System Metrics -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900">System Metrics</h2>
                <p class="text-sm text-neutral-600">Current system performance</p>
            </div>
            <div class="card-modern-body">
                @if(isset($admin_data['system_metrics']))
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-4 bg-neutral-50 rounded-xl transition-colors duration-200 hover:bg-neutral-100">
                            <span class="text-sm font-medium text-neutral-600">PHP Version</span>
                            <span class="text-sm text-neutral-900 font-mono">{{ $admin_data['system_metrics']['php_version'] }}</span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-neutral-50 rounded-xl transition-colors duration-200 hover:bg-neutral-100">
                            <span class="text-sm font-medium text-neutral-600">Laravel Version</span>
                            <span class="text-sm text-neutral-900 font-mono">{{ $admin_data['system_metrics']['laravel_version'] }}</span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-neutral-50 rounded-xl transition-colors duration-200 hover:bg-neutral-100">
                            <span class="text-sm font-medium text-neutral-600">Memory Usage</span>
                            <span class="text-sm text-neutral-900 font-mono">{{ number_format($admin_data['system_metrics']['memory_usage'] / 1024 / 1024, 2) }} MB</span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-neutral-50 rounded-xl transition-colors duration-200 hover:bg-neutral-100">
                            <span class="text-sm font-medium text-neutral-600">Peak Memory</span>
                            <span class="text-sm text-neutral-900 font-mono">{{ number_format($admin_data['system_metrics']['peak_memory'] / 1024 / 1024, 2) }} MB</span>
                        </div>
                    </div>
                @else
                    <p class="text-neutral-500 text-center py-8">System metrics not available</p>
                @endif
            </div>
        </div>
    </div>

    <!-- User Registration Statistics -->
    <div class="card-modern mb-8">
        <div class="card-modern-header">
            <h2 class="text-xl font-semibold text-neutral-900">User Registration Statistics</h2>
            <p class="text-sm text-neutral-600">User growth over time</p>
        </div>
        <div class="card-modern-body">
            @if(isset($admin_data['user_registrations']))
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-primary-500 dark:text-primary-400">{{ $admin_data['user_registrations']['this_month'] }}</div>
                        <div class="text-sm text-neutral-600">This Month</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-secondary-500 dark:text-secondary-400">{{ $admin_data['user_registrations']['last_month'] }}</div>
                        <div class="text-sm text-neutral-600">Last Month</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-accent-500 dark:text-accent-400">{{ $admin_data['user_registrations']['this_year'] }}</div>
                        <div class="text-sm text-neutral-600">This Year</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-neutral-900">{{ $admin_data['user_registrations']['total_registrations'] }}</div>
                        <div class="text-sm text-neutral-600">Total Users</div>
                    </div>
                </div>
            @else
                <p class="text-neutral-500 text-center py-8">Registration statistics not available</p>
            @endif
        </div>
    </div>
    @endcan
@endsection