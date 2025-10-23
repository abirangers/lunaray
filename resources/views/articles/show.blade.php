@extends('layouts.guest')

@section('showHero', false)
@section('showFeatures', false)

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-neutral-500">
            <li><a href="{{ route('home') }}" class="hover:text-neutral-700 transition-colors">Home</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('articles.index') }}" class="hover:text-neutral-700 transition-colors">Articles</a></li>
            <li><span>/</span></li>
            <li class="text-neutral-900">{{ Str::limit($article->title, 30) }}</li>
        </ol>
    </nav>

    <!-- Article Header -->
    <div class="mb-12">
        <!-- Categories -->
        @if($article->categories->count() > 0)
            <div class="flex flex-wrap gap-2 mb-6">
                @foreach($article->categories as $category)
                    <a href="{{ route('categories.show', $category) }}" 
                       class="inline-flex items-center px-3 py-1 rounded text-sm font-medium bg-neutral-100 text-neutral-700 hover:bg-neutral-200 transition-colors">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        @endif

        <!-- Featured Badge -->
        @if($article->is_featured)
            <div class="inline-flex items-center px-3 py-1 rounded text-sm font-medium bg-neutral-900 text-white mb-6">
                Featured Article
            </div>
        @endif

        <!-- Article Title -->
        <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 mb-6 leading-tight">
            {{ $article->title }}
        </h1>

        <!-- Article Meta -->
        <div class="flex items-center space-x-4 text-sm text-neutral-500 mb-8">
            <span>By {{ $article->author_name }}</span>
            <span>•</span>
            <span>{{ $article->published_at ? $article->published_at->format('M j, Y') : $article->created_at->format('M j, Y') }}</span>
            <span>•</span>
            <span>{{ number_format($article->view_count) }} views</span>
        </div>

        <!-- Article Excerpt -->
        @if($article->excerpt)
            <div class="text-lg text-neutral-600 mb-8 leading-relaxed">
                {{ $article->excerpt }}
            </div>
        @endif

        <!-- Featured Image -->
        @if($article->featured_image)
            <div class="mb-12">
                <img src="{{ Storage::url($article->featured_image) }}" 
                     alt="{{ $article->title }}" 
                     class="w-full h-64 md:h-96 object-cover rounded-lg">
            </div>
        @else
            <div class="mb-12">
                <div class="w-full h-64 md:h-96 bg-neutral-100 rounded-lg flex items-center justify-center">
                    <svg class="w-16 h-16 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        @endif
    </div>

    <!-- Article Content -->
    <div class="prose prose-lg max-w-none mb-12 text-neutral-700">
        {!! $article->content ?? '' !!}
    </div>

    <!-- Article Footer -->
    <div class="border-t border-neutral-200 pt-8 mb-12">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-6 text-sm text-neutral-500">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span>{{ number_format($article->view_count) }} views</span>
                </div>
                <span>Last updated {{ $article->updated_at->format('M j, Y') }}</span>
            </div>
            <div class="flex space-x-2">
                <button onclick="window.print()" class="flex items-center space-x-1 text-sm text-neutral-600 hover:text-neutral-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    <span>Print</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Back to Articles -->
    <div class="text-center">
        <a href="{{ route('articles.index') }}" class="inline-flex items-center space-x-2 text-neutral-600 hover:text-neutral-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Back to Articles</span>
        </a>
    </div>
</div>
@endsection