@extends('layouts.admin')

@section('title', 'Edit Article')
@section('pageTitle', 'Edit Article')
@section('pageDescription', 'Update your article content and settings')

@section('content')
    <!-- Action Buttons -->
    <div class="mb-8">
        <div class="flex items-center justify-end">
            <a href="{{ route('articles.index') }}" class="btn-modern btn-modern-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Articles
            </a>
        </div>
    </div>

    <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="{ 
        showPreview: false,
        autoSave: false,
        lastSaved: null,
        saveStatus: 'idle'
    }">
        @csrf
        @method('PUT')

        <!-- Modern Basic Information -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Basic Information</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Update the essential details for your article</p>
            </div>
            <div class="card-modern-body">
                <div class="space-y-6">
                    <div>
                        <label for="title" class="form-modern-label">Article Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" 
                               class="form-modern @error('title') form-modern-error @enderror" 
                               placeholder="Enter a compelling article title" required>
                    @error('title')
                            <p class="form-modern-error">{{ $message }}</p>
                    @enderror
                </div>

                    <div>
                        <label for="excerpt" class="form-modern-label">Article Excerpt</label>
                    <textarea name="excerpt" id="excerpt" rows="3" 
                                  class="form-modern @error('excerpt') form-modern-error @enderror" 
                                  placeholder="Brief description of the article (optional but recommended for SEO)">{{ old('excerpt', $article->excerpt) }}</textarea>
                        <p class="form-modern-help">A compelling excerpt helps improve search engine visibility and social media sharing.</p>
                    @error('excerpt')
                            <p class="form-modern-error">{{ $message }}</p>
                    @enderror
                    </div>

                    <div>
                        <label for="author_name" class="form-modern-label">Author Name</label>
                        <input type="text" name="author_name" id="author_name" 
                               value="{{ old('author_name', $article->author_name ?: $article->author->name) }}" 
                               class="form-modern @error('author_name') form-modern-error @enderror" 
                               placeholder="Enter author name">
                        <p class="form-modern-help">Leave blank to use your name as the author</p>
                        @error('author_name')
                            <p class="form-modern-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Featured Image -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Featured Image</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Update the visual that represents your article</p>
            </div>
            <div class="card-modern-body">
                <div class="space-y-4">
            @if($article->featured_image)
                <div class="mb-4">
                            <label class="form-modern-label">Current Image</label>
                            <div class="flex items-center space-x-4 p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                        <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}" 
                             class="w-32 h-20 object-cover rounded-lg">
                        <div>
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Current featured image</p>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-500">Upload a new image to replace it</p>
                        </div>
                    </div>
                </div>
            @endif
            
                    <div x-data="imageUpload()">
                        <label for="featured_image" class="form-modern-label">
                            {{ $article->featured_image ? 'Replace Image' : 'Upload Featured Image' }}
                </label>
                        <div 
                            @dragover.prevent="isDragging = true"
                            @dragleave.prevent="isDragging = false"
                            @drop.prevent="handleDrop($event)"
                            @click="$refs.fileInput.click()"
                            :class="isDragging ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20 scale-105' : 'border-neutral-300 dark:border-neutral-600'"
                            class="mt-1 relative flex justify-center px-6 pt-8 pb-8 border-2 border-dashed rounded-xl hover:border-primary-400 dark:hover:border-primary-500 transition-all duration-300 cursor-pointer bg-neutral-50 dark:bg-neutral-800/50">
                            <div class="space-y-3 text-center">
                                <!-- Drag Overlay -->
                                <div x-show="isDragging" class="absolute inset-0 bg-primary-500/10 dark:bg-primary-400/10 rounded-xl flex items-center justify-center z-10">
                                    <div class="text-center">
                                        <svg class="mx-auto h-16 w-16 text-primary-500 dark:text-primary-400 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <p class="text-lg font-semibold text-primary-600 dark:text-primary-400 mt-2">Drop image here!</p>
                                    </div>
                                </div>

                                <!-- Image Preview -->
                                <div x-show="previewUrl && !isDragging" class="mb-4 relative">
                                    <img :src="previewUrl" alt="Preview" class="mx-auto h-32 w-auto rounded-lg object-cover shadow-lg">
                                    <div class="absolute top-2 right-2 bg-success-500 text-white rounded-full p-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                
                                <!-- Upload Icon -->
                                <svg x-show="!previewUrl && !isDragging" class="mx-auto h-12 w-12 text-neutral-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                
                                <div x-show="!isDragging" class="flex text-sm text-neutral-600 dark:text-neutral-400">
                                    <span x-text="previewUrl ? 'Change image' : 'Upload a file'"></span>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p x-show="!isDragging" class="text-xs text-neutral-500 dark:text-neutral-400">
                                    PNG, JPG, GIF up to 2MB. Recommended: 1200x630px
                                </p>
                                
                                <!-- Remove Image Button -->
                                <button x-show="previewUrl && !isDragging" @click.stop="removeImage()" type="button" class="mt-2 text-sm text-error-600 hover:text-error-700 dark:text-error-400 dark:hover:text-error-300">
                                    Remove image
                                </button>
                            </div>
                        </div>
                        <input x-ref="fileInput" type="file" name="featured_image" id="featured_image" accept="image/*" 
                               class="sr-only @error('featured_image') form-modern-error @enderror" @change="handleFileSelect($event)">
                @error('featured_image')
                            <p class="form-modern-error">{{ $message }}</p>
                @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Content Editor -->
        <div class="card-modern">
            <div class="card-modern-header">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Article Content</h2>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">Update your article using our rich text editor</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="button" @click="showPreview = !showPreview" class="btn-modern btn-modern-ghost">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <span x-text="showPreview ? 'Edit' : 'Preview'"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-modern-body">
            <div>
                    <label for="content" class="form-modern-label">Article Content *</label>
                    <div x-show="!showPreview" class="mt-1">
                        <div id="rich-text-editor" class="min-h-96 border border-neutral-300 dark:border-neutral-600 rounded-xl focus-within:ring-2 focus-within:ring-primary-500 focus-within:border-transparent transition-colors duration-200 bg-white dark:bg-neutral-800">
                    <!-- Rich text editor will be initialized here -->
                        </div>
                    </div>
                    <div x-show="showPreview" class="mt-1 min-h-96 border border-neutral-300 dark:border-neutral-600 rounded-xl p-6 bg-neutral-50 dark:bg-neutral-800">
                        <div id="preview-content" class="prose prose-sm max-w-none dark:prose-invert">
                            <!-- Preview content will be rendered here -->
                        </div>
                </div>
                <textarea name="content" id="content" style="display: none;">{{ old('content', $article->content) }}</textarea>
                @error('content')
                        <p class="form-modern-error">{{ $message }}</p>
                @enderror
                </div>
            </div>
        </div>

        <!-- Modern Settings -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Article Settings</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Update categories, status, and visibility options</p>
            </div>
            <div class="card-modern-body">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Modern Categories -->
                <div>
                        <label class="form-modern-label">Categories</label>
                        <div class="space-y-3 max-h-48 overflow-y-auto border border-neutral-300 dark:border-neutral-600 rounded-xl p-4 bg-neutral-50 dark:bg-neutral-800">
                        @foreach($categories as $category)
                                <label class="flex items-center space-x-3 p-3 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors duration-200 cursor-pointer">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                                       {{ in_array($category->id, old('categories', $article->categories->pluck('id')->toArray())) ? 'checked' : '' }}
                                           class="w-4 h-4 text-primary-600 bg-neutral-100 border-neutral-300 rounded focus:ring-primary-500 focus:ring-2">
                                    <span class="flex items-center space-x-2 text-sm text-neutral-700 dark:text-neutral-300">
                                        <span class="w-3 h-3 rounded-full" style="background-color: {{ $category->color }}"></span>
                                        <span>{{ $category->name }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                        <p class="form-modern-help">Select relevant categories to help readers find your article.</p>
                    @error('categories')
                            <p class="form-modern-error">{{ $message }}</p>
                    @enderror
                </div>

                    <!-- Modern Status and Options -->
                    <div class="space-y-6">
                    <div>
                            <label for="status" class="form-modern-label">Publication Status *</label>
                        <select name="status" id="status" 
                                    class="form-modern @error('status') form-modern-error @enderror" required>
                                <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Draft - Save for later editing</option>
                                <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Published - Make visible to readers</option>
                        </select>
                            <p class="form-modern-help">Choose whether to publish immediately or save as draft.</p>
                        @error('status')
                                <p class="form-modern-error">{{ $message }}</p>
                        @enderror
                    </div>

                        <div class="space-y-4">
                            <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors duration-200">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" 
                               {{ old('is_featured', $article->is_featured) ? 'checked' : '' }}
                                       class="w-4 h-4 text-primary-600 bg-neutral-100 border-neutral-300 rounded focus:ring-primary-500 focus:ring-2">
                                <div>
                                    <label for="is_featured" class="text-sm font-medium text-neutral-700 dark:text-neutral-300 cursor-pointer">
                            Mark as featured article
                        </label>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400">Featured articles appear prominently on the homepage</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Article Stats -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Article Statistics</h3>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Overview of your article performance</p>
            </div>
            <div class="card-modern-body">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center p-4 bg-primary-50 dark:bg-primary-900/20 rounded-xl">
                        <div class="text-2xl font-bold text-primary-600 dark:text-primary-400">{{ number_format($article->view_count) }}</div>
                        <div class="text-sm text-neutral-600 dark:text-neutral-400">Views</div>
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

        <!-- Modern Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4 pt-6 border-t border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2 text-sm text-neutral-600 dark:text-neutral-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Last updated: {{ $article->updated_at->format('M j, Y g:i A') }}</span>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('articles.index') }}" class="btn-modern btn-modern-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                Cancel
            </a>
                <button type="submit" class="btn-modern btn-modern-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                Update Article
            </button>
            </div>
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
    const previewContent = document.getElementById('preview-content');
    
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
        // Update preview
        if (previewContent) {
            previewContent.innerHTML = trixEditor.innerHTML;
        }
    });
    
    // Set initial content if exists
    if (hiddenInput.value) {
        trixEditor.innerHTML = hiddenInput.value;
        if (previewContent) {
            previewContent.innerHTML = hiddenInput.value;
        }
    }
    
    // Auto-save functionality
    let autoSaveInterval;
    let lastSavedContent = '';
    
    function performAutoSave() {
        const title = document.getElementById('title').value;
        const excerpt = document.getElementById('excerpt').value;
        const content = hiddenInput.value;
        
        // Only save if content has changed
        if (content !== lastSavedContent && content.trim() !== '') {
            fetch('{{ route("articles.auto-save") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    title: title,
                    excerpt: excerpt,
                    content: content,
                    article_id: {{ $article->id }}
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    lastSavedContent = content;
                    // Update last saved time
                    const lastSavedElement = document.querySelector('[x-text*="lastSaved"]');
                    if (lastSavedElement) {
                        lastSavedElement.textContent = 'Last saved: ' + data.saved_at;
                    }
                }
            })
            .catch(error => {
                console.error('Auto-save failed:', error);
            });
        }
    }
    
    // Auto-save every 30 seconds when enabled
    function startAutoSave() {
        if (autoSaveInterval) {
            clearInterval(autoSaveInterval);
        }
        autoSaveInterval = setInterval(performAutoSave, 30000);
    }
    
    function stopAutoSave() {
        if (autoSaveInterval) {
            clearInterval(autoSaveInterval);
            autoSaveInterval = null;
        }
    }
    
    // Listen for content changes
    trixEditor.addEventListener('trix-change', function() {
        // Trigger auto-save if enabled
        if (window.Alpine && Alpine.store && Alpine.store('autoSave')) {
            performAutoSave();
        }
    });
    
    // Image upload functionality
    Alpine.data('imageUpload', () => ({
        previewUrl: null,
        isDragging: false,
        
        init() {
            console.log('Image upload component initialized');
        },
        
        handleFileSelect(event) {
            console.log('File selected:', event.target.files[0]);
            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                this.createPreview(file);
            } else {
                alert('Please select a valid image file.');
            }
        },
        
        handleDrop(event) {
            console.log('File dropped');
            this.isDragging = false;
            event.preventDefault();
            
            if (!event.dataTransfer.items) return;
            
            const files = event.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                if (file.type.startsWith('image/')) {
                    this.createPreview(file);
                    // Update the file input
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    this.$refs.fileInput.files = dataTransfer.files;
                } else {
                    alert('Please drop a valid image file.');
                }
            }
        },
        
        createPreview(file) {
            console.log('Creating preview for:', file.name);
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.previewUrl = e.target.result;
                    console.log('Preview created:', this.previewUrl);
                };
                reader.readAsDataURL(file);
            }
        },
        
        removeImage() {
            console.log('Removing image');
            this.previewUrl = null;
            this.$refs.fileInput.value = '';
        }
    }));

    // Auto-save toggle functionality
    document.addEventListener('alpine:init', () => {
        Alpine.data('autoSaveToggle', () => ({
            autoSave: false,
            
            toggle() {
                this.autoSave = !this.autoSave;
                if (this.autoSave) {
                    startAutoSave();
                } else {
                    stopAutoSave();
                }
            }
        }));
    });
});
</script>
@endpush
@endsection
