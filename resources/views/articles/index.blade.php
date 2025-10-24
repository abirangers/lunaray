@extends('layouts.guest')

@section('showHero', false)
@section('showFeatures', false)

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
    <!-- Header -->
    <div class="text-center mb-12 sm:mb-16">
        <h1 class="text-3xl sm:text-4xl font-bold text-neutral-900 mb-3 sm:mb-4">Beauty Articles</h1>
        <p class="text-base sm:text-lg text-neutral-600 max-w-2xl mx-auto">Discover the latest beauty tips, tutorials, and insights from our experts</p>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white border border-neutral-200 rounded-lg p-4 sm:p-6 mb-8 sm:mb-12">
        <form method="GET" class="flex flex-col sm:flex-row gap-3 sm:gap-4">
            <!-- Search -->
            <div class="flex-1">
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                       placeholder="Search articles..." 
                       class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:border-transparent text-sm">
            </div>

            <!-- Category Filter -->
            <div class="sm:w-64">
                <select name="category" id="category" class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:border-transparent text-sm">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                            {{ $category->name }} ({{ $category->articles_count }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Button -->
            <div>
                <button type="submit" class="w-full sm:w-auto bg-neutral-900 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg hover:bg-neutral-800 transition-colors text-sm font-medium">
                    Search
                </button>
            </div>
        </form>
    </div>

    <!-- Featured Articles -->
    @if($featured_articles->count() > 0)
        <div class="mb-12 sm:mb-16">
            <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-6 sm:mb-8">Featured Articles</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($featured_articles as $article)
                    <article class="bg-white border border-neutral-200 rounded-lg overflow-hidden hover:border-neutral-300 transition-colors">
                        @if($article->hasMedia('featured'))
                            <img src="{{ $article->getFirstMediaUrl('featured', 'medium') }}" alt="{{ $article->title }}" 
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-neutral-100 flex items-center justify-center">
                                <svg class="w-12 h-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center space-x-2 mb-4">
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-neutral-900 text-white">
                                    Featured
                                </span>
                                @foreach($article->categories as $category)
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-neutral-100 text-neutral-700">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                            <h3 class="text-lg font-semibold text-neutral-900 mb-3 line-clamp-2">
                                <a href="{{ route('articles.show', $article) }}" class="hover:text-neutral-600 transition-colors">
                                    {{ $article->title }}
                                </a>
                            </h3>
                            @if($article->excerpt)
                                <p class="text-neutral-600 mb-4 line-clamp-3 text-sm">{{ $article->excerpt }}</p>
                            @endif
                            <div class="flex items-center justify-between text-xs text-neutral-500">
                                <span>By {{ $article->author_name }}</span>
                                <span>{{ $article->published_at->format('M j, Y') }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    @endif

    <!-- All Articles -->
    <div class="mb-8 sm:mb-12">
        <h2 class="text-xl sm:text-2xl font-bold text-neutral-900 mb-6 sm:mb-8">All Articles</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse($articles as $article)
                <article class="bg-white border border-neutral-200 rounded-lg overflow-hidden hover:border-neutral-300 transition-colors">
                    @if($article->hasMedia('featured'))
                        <img src="{{ $article->getFirstMediaUrl('featured', 'medium') }}" alt="{{ $article->title }}" 
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-neutral-100 flex items-center justify-center">
                            <svg class="w-12 h-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center space-x-2 mb-4">
                            @foreach($article->categories as $category)
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-neutral-100 text-neutral-700">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                        <h3 class="text-lg font-semibold text-neutral-900 mb-3 line-clamp-2">
                            <a href="{{ route('articles.show', $article) }}" class="hover:text-neutral-600 transition-colors">
                                {{ $article->title }}
                            </a>
                        </h3>
                        @if($article->excerpt)
                            <p class="text-neutral-600 mb-4 line-clamp-3 text-sm">{{ $article->excerpt }}</p>
                        @endif
                        <div class="flex items-center justify-between text-xs text-neutral-500">
                            <span>By {{ $article->author->name }}</span>
                            <div class="flex items-center space-x-3">
                                <span>{{ $article->published_at->format('M j, Y') }}</span>
                                <span class="flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    {{ number_format($article->view_count) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full">
                    <div class="bg-white border border-neutral-200 rounded-lg p-12 text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-neutral-900 mb-2">No articles found</h3>
                        <p class="text-neutral-600">Try adjusting your search criteria or check back later for new content.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($articles->hasPages())
        <div class="flex justify-center mb-16">
            <div class="flex items-center space-x-2">
                {{ $articles->appends(request()->query())->links() }}
            </div>
        </div>
    @endif

    <!-- Popular Articles -->
    @if($popular_articles->count() > 0)
        <div class="bg-neutral-50 border border-neutral-200 rounded-lg p-6 sm:p-8">
            <h3 class="text-lg sm:text-xl font-bold text-neutral-900 mb-4 sm:mb-6">Popular Articles</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @foreach($popular_articles as $article)
                    <div class="flex items-start space-x-4">
                        @if($article->hasMedia('featured'))
                            <img src="{{ $article->getFirstMediaUrl('featured', 'thumb') }}" alt="{{ $article->title }}" 
                                 class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                        @else
                            <div class="w-16 h-16 bg-neutral-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-neutral-900 line-clamp-2 mb-2">
                                <a href="{{ route('articles.show', $article) }}" class="hover:text-neutral-600 transition-colors">
                                    {{ $article->title }}
                                </a>
                            </h4>
                            <div class="flex items-center space-x-2 text-xs text-neutral-500">
                                <span>{{ $article->published_at->format('M j') }}</span>
                                <span>•</span>
                                <span>{{ number_format($article->view_count) }} views</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection