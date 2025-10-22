@extends('layouts.admin')

@section('title', 'Edit Article')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary mb-2">Edit Article</h1>
        <p class="text-gray-600">Update your article content and settings</p>
    </div>

    <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Basic Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Article Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('title') border-red-500 @enderror" 
                           placeholder="Enter article title" required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Excerpt</label>
                    <textarea name="excerpt" id="excerpt" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('excerpt') border-red-500 @enderror" 
                              placeholder="Brief description of the article">{{ old('excerpt', $article->excerpt) }}</textarea>
                    @error('excerpt')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Featured Image -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Featured Image</h2>
            
            @if($article->featured_image)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                    <div class="flex items-center space-x-4">
                        <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" 
                             class="w-32 h-20 object-cover rounded-lg">
                        <div>
                            <p class="text-sm text-gray-600">Current featured image</p>
                            <p class="text-xs text-gray-500">Upload a new image to replace it</p>
                        </div>
                    </div>
                </div>
            @endif
            
            <div>
                <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $article->featured_image ? 'Replace Image' : 'Upload Image' }}
                </label>
                <input type="file" name="featured_image" id="featured_image" accept="image/*" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('featured_image') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">Recommended size: 1200x630px. Max file size: 2MB.</p>
                @error('featured_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Content Editor -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Content</h2>
            
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Article Content *</label>
                <div id="rich-text-editor" class="min-h-96 border border-gray-300 rounded-lg focus-within:ring-2 focus-within:ring-primary focus-within:border-transparent">
                    <!-- Rich text editor will be initialized here -->
                </div>
                <textarea name="content" id="content" style="display: none;">{{ old('content', $article->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Settings -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Settings</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Categories -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categories</label>
                    <div class="space-y-2 max-h-40 overflow-y-auto border border-gray-300 rounded-lg p-3">
                        @foreach($categories as $category)
                            <label class="flex items-center">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                                       {{ in_array($category->id, old('categories', $article->categories->pluck('id')->toArray())) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-primary focus:ring-primary">
                                <span class="ml-2 text-sm text-gray-700 flex items-center">
                                    <span class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $category->color }}"></span>
                                    {{ $category->name }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('categories')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status and Featured -->
                <div class="space-y-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                        <select name="status" id="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('status') border-red-500 @enderror" required>
                            <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" 
                               {{ old('is_featured', $article->is_featured) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-primary focus:ring-primary">
                        <label for="is_featured" class="ml-2 text-sm text-gray-700">
                            Mark as featured article
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Article Stats -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Article Statistics</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-primary">{{ number_format($article->view_count) }}</div>
                    <div class="text-sm text-gray-600">Views</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900">{{ $article->created_at->format('M j') }}</div>
                    <div class="text-sm text-gray-600">Created</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900">{{ $article->updated_at->format('M j') }}</div>
                    <div class="text-sm text-gray-600">Last Updated</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900">{{ $article->categories->count() }}</div>
                    <div class="text-sm text-gray-600">Categories</div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('articles.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 bg-primary hover:bg-primary-dark text-white rounded-lg transition-colors">
                Update Article
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://unpkg.com/trix@2.0.0/dist/trix.js"></script>
<link rel="stylesheet" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Trix editor
    const editor = document.getElementById('rich-text-editor');
    const hiddenInput = document.getElementById('content');
    
    // Set initial content
    if (hiddenInput.value) {
        editor.innerHTML = hiddenInput.value;
    }
    
    // Create Trix editor
    const trixEditor = document.createElement('trix-editor');
    trixEditor.setAttribute('input', 'content');
    trixEditor.setAttribute('placeholder', 'Start writing your article...');
    trixEditor.classList.add('trix-content');
    
    // Replace the div with trix-editor
    editor.parentNode.replaceChild(trixEditor, editor);
    
    // Sync with hidden input
    trixEditor.addEventListener('trix-change', function() {
        hiddenInput.value = trixEditor.innerHTML;
    });
    
    // Set initial content if exists
    if (hiddenInput.value) {
        trixEditor.innerHTML = hiddenInput.value;
    }
});
</script>
@endpush
@endsection
