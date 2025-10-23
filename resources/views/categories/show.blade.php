@extends('layouts.guest')

@section('title', $category->name . ' Articles - Lunaray Beauty Factory')
@section('showHero', false)
@section('showFeatures', false)

@section('content')
<div class="max-w-6xl mx-auto px-6 py-12">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-neutral-500">
            <li><a href="{{ route('home') }}" class="hover:text-neutral-700 transition-colors">Home</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('articles.index') }}" class="hover:text-neutral-700 transition-colors">Articles</a></li>
            <li><span>/</span></li>
            <li class="text-neutral-900">{{ $category->name }}</li>
        </ol>
    </nav>

    <!-- Category Header -->
    <div class="text-center mb-16">
        <div class="flex items-center justify-center mb-6">
            <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $category->color }}"></div>
            <h1 class="text-4xl font-bold text-neutral-900">{{ $category->name }}</h1>
        </div>
        @if($category->description)
            <p class="text-lg text-neutral-600 max-w-2xl mx-auto mb-4">{{ $category->description }}</p>
        @endif
        <div class="text-sm text-neutral-500">
            {{ $articles->total() }} {{ Str::plural('article', $articles->total()) }} in this category
        </div>
    </div>

    <!-- Articles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        @forelse($articles as $article)
            <article class="bg-white border border-neutral-200 rounded-lg overflow-hidden hover:border-neutral-300 transition-colors">
                @if($article->featured_image)
                    <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" 
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
                        @if($article->is_featured)
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-neutral-900 text-white">
                                Featured
                            </span>
                        @endif
                        @foreach($article->categories as $cat)
                            @if($cat->id !== $category->id)
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-neutral-100 text-neutral-700">
                                    {{ $cat->name }}
                                </span>
                            @endif
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
                    <p class="text-neutral-600">There are no published articles in this category yet.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($articles->hasPages())
        <div class="flex justify-center mb-16">
            <div class="flex items-center space-x-2">
                {{ $articles->links() }}
            </div>
        </div>
    @endif

    <!-- Back to Articles -->
    <div class="text-center">
        <a href="{{ route('articles.index') }}" class="inline-flex items-center space-x-2 text-neutral-600 hover:text-neutral-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Back to All Articles</span>
        </a>
    </div>
</div>
@endsection
