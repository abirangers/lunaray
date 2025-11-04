@extends('layouts.admin')

@section('title', 'Create Hero Slide')
@section('pageTitle', 'Create Hero Slide')
@section('pageDescription', 'Add a new hero slide to your landing page')

@section('content')

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.heroes.index') }}" class="btn-modern btn-modern-secondary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Heroes
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <strong>Validation Errors:</strong>
            </div>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.heroes.store') }}" enctype="multipart/form-data" class="space-y-6" x-data="{
        name: '{{ old('name') }}',
        slug: '{{ old('slug') }}',
        imagePreview: null,
        generateSlug() {
            this.slug = this.name.toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '');
        },
        previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    }">
        @csrf

        <!-- Basic Information -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Basic Information</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Enter the hero slide details</p>
            </div>
            <div class="card-modern-body space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="form-modern-label">
                        Hero Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           x-model="name"
                           @input="generateSlug()"
                           value="{{ old('name') }}"
                           class="form-modern @error('name') border-red-500 @enderror" 
                           placeholder="e.g. Summer Collection"
                           required
                           autofocus>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="form-modern-label">
                        Slug <span class="text-sm text-neutral-500">(auto-generated)</span>
                    </label>
                    <input type="text" 
                           name="slug" 
                           id="slug" 
                           x-model="slug"
                           value="{{ old('slug') }}"
                           class="form-modern @error('slug') border-red-500 @enderror" 
                           placeholder="e.g. summer-collection">
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                        URL-friendly version (auto-generated from name, can be customized)
                    </p>
                </div>

                <!-- Order -->
                <div>
                    <label for="order" class="form-modern-label">
                        Display Order
                    </label>
                    <input type="number" 
                           name="order" 
                           id="order" 
                           value="{{ old('order', 0) }}"
                           min="0"
                           class="form-modern @error('order') border-red-500 @enderror" 
                           placeholder="0">
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                        Lower numbers appear first. Default: 0
                    </p>
                </div>
            </div>
        </div>

        <!-- Hero Image -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Hero Image</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Upload a high-quality hero image</p>
            </div>
            <div class="card-modern-body space-y-6">
                <div>
                    <label for="hero_image" class="form-modern-label">
                        Image <span class="text-red-500">*</span>
                    </label>
                    <input type="file" 
                           name="hero_image" 
                           id="hero_image" 
                           accept="image/jpeg,image/png,image/webp"
                           @change="previewImage"
                           class="form-modern @error('hero_image') border-red-500 @enderror" 
                           required>
                    @error('hero_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                        Max 10MB. Supported formats: JPG, PNG, WEBP. Recommended size: 1920x1080px.
                    </p>
                </div>

                <!-- Image Preview -->
                <div x-show="imagePreview" class="mt-4">
                    <p class="text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Preview:</p>
                    <img :src="imagePreview" 
                         alt="Preview" 
                         class="w-full max-w-4xl h-64 object-cover rounded-lg border border-neutral-200 dark:border-neutral-700">
                </div>
            </div>
        </div>

        <!-- Display Settings -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Display Settings</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Configure how this hero slide appears</p>
            </div>
            <div class="card-modern-body space-y-6">
                <!-- Active Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="form-checkbox rounded text-primary-600 focus:ring-primary-500">
                        <span class="ml-2 text-sm font-medium text-neutral-900 dark:text-neutral-100">
                            Active
                        </span>
                    </label>
                    <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                        Only active hero slides are displayed on the landing page
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('admin.heroes.index') }}" class="btn-modern btn-modern-secondary">
                Cancel
            </a>
            <button type="submit" class="btn-modern btn-modern-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Create Hero Slide
            </button>
        </div>
    </form>

@endsection

