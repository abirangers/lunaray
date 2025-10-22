@extends('layouts.admin')

@section('title', 'Content Manager Dashboard')
@section('pageTitle', 'Content Manager Dashboard')
@section('pageDescription', 'Manage your content and track performance')

@section('content')

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Articles</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_articles'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Published</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['published_articles'] }}</p>
            </div>
        </div>
    </div>

        <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Drafts</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['draft_articles'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Featured</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['featured_articles'] }}</p>
                </div>
            </div>
                    </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-2 bg-indigo-100 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Categories</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_categories'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Views</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_views']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Articles -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Recent Articles</h2>
            </div>
            <div class="p-6">
                @if($recent_articles->count() > 0)
                    <div class="space-y-4">
                        @foreach($recent_articles as $article)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-900">{{ $article->title }}</h3>
                                    <p class="text-sm text-gray-600">By {{ $article->author->name }} • {{ $article->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($article->status) }}
                                    </span>
                                    @if($article->is_featured)
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                            Featured
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('articles.index') }}" class="text-primary hover:text-primary-dark font-medium">View all articles →</a>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No articles yet. <a href="{{ route('articles.create') }}" class="text-primary hover:text-primary-dark">Create your first article</a></p>
                @endif
            </div>
        </div>

        <!-- Draft Articles -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Draft Articles</h2>
            </div>
            <div class="p-6">
                @if($draft_articles->count() > 0)
                    <div class="space-y-4">
                        @foreach($draft_articles as $article)
                            <div class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg">
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-900">{{ $article->title }}</h3>
                                    <p class="text-sm text-gray-600">By {{ $article->author->name }} • {{ $article->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('articles.edit', $article) }}" class="text-primary hover:text-primary-dark text-sm font-medium">Edit</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No draft articles</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Popular Articles -->
    <div class="bg-white rounded-lg shadow-md mb-8">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Popular Articles</h2>
        </div>
        <div class="p-6">
            @if($popular_articles->count() > 0)
                <div class="space-y-4">
                    @foreach($popular_articles as $article)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">{{ $article->title }}</h3>
                                <p class="text-sm text-gray-600">By {{ $article->author->name }} • {{ $article->view_count }} views</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-600">{{ $article->view_count }} views</span>
                                <a href="{{ route('articles.show', $article) }}" class="text-primary hover:text-primary-dark text-sm font-medium">View</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No popular articles yet</p>
            @endif
        </div>
    </div>

    <!-- Categories Overview -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Categories Overview</h2>
        </div>
        <div class="p-6">
            @if($articles_by_category->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($articles_by_category as $category)
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-gray-900">{{ $category->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $category->articles_count }} articles</p>
                                </div>
                                <div class="w-3 h-3 rounded-full" style="background-color: {{ $category->color ?? '#3B82F6' }}"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No categories yet. <a href="{{ route('categories.create') }}" class="text-primary hover:text-primary-dark">Create your first category</a></p>
            @endif
            </div>
    </div>
@endsection