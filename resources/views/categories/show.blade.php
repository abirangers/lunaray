@extends('layouts.app')

@section('title', $category->name . ' Articles')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Category Header -->
    <div class="text-center mb-12">
        <div class="flex items-center justify-center mb-4">
            <div class="w-6 h-6 rounded-full mr-3" style="background-color: {{ $category->color }}"></div>
            <h1 class="text-4xl font-bold text-gray-900">{{ $category->name }}</h1>
        </div>
        @if($category->description)
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">{{ $category->description }}</p>
        @endif
        <div class="mt-4 text-sm text-gray-500">
            {{ $articles->total() }} {{ Str::plural('article', $articles->total()) }} in this category
        </div>
    </div>

    <!-- Articles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @forelse($articles as $article)
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                @if($article->featured_image)
                    <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" 
                         class="w-full h-48 object-cover">
                @endif
                <div class="p-6">
                    <div class="flex items-center space-x-2 mb-3">
                        @if($article->is_featured)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                Featured
                            </span>
                        @endif
                        @foreach($article->categories as $cat)
                            @if($cat->id !== $category->id)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" style="background-color: {{ $cat->color }}20; color: {{ $cat->color }}">
                                    {{ $cat->name }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2 line-clamp-2">
                        <a href="{{ route('articles.show', $article) }}" class="hover:text-primary transition-colors">
                            {{ $article->title }}
                        </a>
                    </h3>
                    @if($article->excerpt)
                        <p class="text-gray-600 mb-4 line-clamp-3">{{ $article->excerpt }}</p>
                    @endif
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>By {{ $article->author->name }}</span>
                        <div class="flex items-center space-x-4">
                            <span>{{ $article->published_at->format('M j, Y') }}</span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No articles found</h3>
                    <p class="text-gray-600">There are no published articles in this category yet.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($articles->hasPages())
        <div class="flex justify-center">
            {{ $articles->links() }}
        </div>
    @endif

    <!-- Back to Articles -->
    <div class="text-center mt-12">
        <a href="{{ route('articles.index') }}" class="inline-flex items-center text-primary hover:text-primary-dark transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to All Articles
        </a>
    </div>
</div>
@endsection
