@extends('layouts.admin')

@section('title', 'Edit Hero Slide')
@section('pageTitle', 'Edit Hero Slide')
@section('pageDescription', 'Update hero slide information')

@section('content')

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
            <strong>Validation Errors:</strong>
            <ul class="list-disc list-inside mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Hero Info -->
    <div class="mb-6 card-modern">
        <div class="card-modern-body">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    @if($hero->hasMedia('hero_image'))
                        <img src="{{ $hero->getFirstMediaUrl('hero_image', 'thumb') }}" 
                             alt="{{ $hero->name }}"
                             class="w-16 h-16 rounded object-cover">
                    @else
                        <div class="w-16 h-16 rounded bg-neutral-200 dark:bg-neutral-700 flex items-center justify-center">
                            <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h3 class="text-lg font-semibold">{{ $hero->name }}</h3>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">
                            Created {{ $hero->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
                <div class="flex gap-2">
                    @if($hero->is_active)
                        <span class="badge-modern badge-modern-success">Active</span>
                    @else
                        <span class="badge-modern badge-modern-secondary">Inactive</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.heroes.update', $hero) }}" enctype="multipart/form-data" class="space-y-6" x-data="{
        name: '{{ old('name', $hero->name) }}',
        slug: '{{ old('slug', $hero->slug) }}',
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
        @method('PUT')

        <!-- Basic Information -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Basic Information</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Update hero slide details</p>
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
                           value="{{ old('name', $hero->name) }}"
                           class="form-modern @error('name') border-red-500 @enderror" 
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
                           value="{{ old('slug', $hero->slug) }}"
                           class="form-modern @error('slug') border-red-500 @enderror">
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
                           value="{{ old('order', $hero->order) }}"
                           min="0"
                           class="form-modern @error('order') border-red-500 @enderror">
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
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Replace or update the hero image</p>
            </div>
            <div class="card-modern-body space-y-6">
                <!-- Current Image -->
                @if($hero->hasMedia('hero_image'))
                    <div>
                        <p class="text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Current Image:</p>
                        <img src="{{ $hero->getFirstMediaUrl('hero_image', 'medium') }}" 
                             alt="{{ $hero->name }}"
                             class="w-full max-w-4xl h-64 object-cover rounded-lg border border-neutral-200 dark:border-neutral-700 mb-4">
                    </div>
                @endif

                <!-- Upload New Image -->
                <div>
                    <label for="hero_image" class="form-modern-label">
                        {{ $hero->hasMedia('hero_image') ? 'Replace' : 'Upload' }} Image
                    </label>
                    <input type="file" 
                           name="hero_image" 
                           id="hero_image" 
                           accept="image/jpeg,image/png,image/webp"
                           @change="previewImage"
                           class="form-modern @error('hero_image') border-red-500 @enderror">
                    @error('hero_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                        Max 10MB. Supported formats: JPG, PNG, WEBP. Recommended size: 1920x1080px.
                    </p>
                </div>

                <!-- Image Preview -->
                <div x-show="imagePreview" class="mt-4">
                    <p class="text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">New Preview:</p>
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
                               {{ old('is_active', $hero->is_active) ? 'checked' : '' }}
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
                Update Hero Slide
            </button>
        </div>
    </form>

@endsection

