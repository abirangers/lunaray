@extends('layouts.app')

@section('title', $article->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Article Header -->
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('home') }}" class="hover:text-primary">Home</a></li>
                <li><span>/</span></li>
                <li><a href="{{ route('articles.index') }}" class="hover:text-primary">Articles</a></li>
                <li><span>/</span></li>
                <li class="text-gray-900">{{ $article->title }}</li>
            </ol>
        </nav>

        <!-- Article Meta -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 text-sm text-gray-600 mb-4">
                <span>By {{ $article->author->name }}</span>
                <span>•</span>
                <span>{{ $article->published_at ? $article->published_at->format('M j, Y') : $article->created_at->format('M j, Y') }}</span>
                <span>•</span>
                <span>{{ $article->view_count }} views</span>
            </div>

            <!-- Categories -->
            @if($article->categories->count() > 0)
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($article->categories as $category)
                        <a href="{{ route('categories.show', $category) }}" 
                           class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 hover:bg-gray-200 transition-colors">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            <!-- Featured Badge -->
            @if($article->is_featured)
                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800 mb-4">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    Featured Article
                </div>
            @endif
        </div>

        <!-- Featured Image -->
        @if($article->featured_image)
            <div class="mb-8">
                <img src="{{ Storage::url($article->featured_image) }}" 
                     alt="{{ $article->title }}" 
                     class="w-full h-64 md:h-96 object-cover rounded-lg shadow-lg">
            </div>
        @endif

        <!-- Article Title -->
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
            {{ $article->title }}
        </h1>

        <!-- Article Excerpt -->
        @if($article->excerpt)
            <div class="text-xl text-gray-600 mb-8 leading-relaxed">
                {{ $article->excerpt }}
            </div>
        @endif

        <!-- Article Content -->
        <div class="prose prose-lg max-w-none mb-12">
            {!! $article->content !!}
        </div>

        <!-- Article Footer -->
        <div class="border-t border-gray-200 pt-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span>{{ number_format($article->view_count) }} views</span>
                    </div>
                    <div class="text-sm text-gray-500">
                        Last updated {{ $article->updated_at->format('M j, Y') }}
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button onclick="window.print()" class="flex items-center space-x-1 text-sm text-gray-600 hover:text-primary transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        <span>Print</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection