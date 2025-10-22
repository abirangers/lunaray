@extends('layouts.admin')

@section('title', 'Create Category')
@section('pageTitle', 'Create New Category')
@section('pageDescription', 'Add a new category to organize your content')

@section('content')
    <!-- Action Buttons -->
    <div class="mb-8">
        <div class="flex items-center justify-end">
            <a href="{{ route('categories.index') }}" class="btn-modern btn-modern-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Categories
            </a>
        </div>
    </div>

    <form action="{{ route('categories.store') }}" method="POST" class="max-w-2xl space-y-8">
        @csrf

        <!-- Basic Information -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Basic Information</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Enter the category details</p>
            </div>
            <div class="card-modern-body space-y-6">
                <div>
                    <label for="name" class="form-modern-label">Category Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="form-modern @error('name') border-error-500 @enderror" 
                           placeholder="Enter category name" required>
                    @error('name')
                        <p class="form-modern-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="form-modern-label">Description</label>
                    <textarea name="description" id="description" rows="3" 
                              class="form-modern @error('description') border-error-500 @enderror" 
                              placeholder="Brief description of this category">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="form-modern-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Color Selection -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Category Color</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Choose a color to represent this category</p>
            </div>
            <div class="card-modern-body">
                <div class="flex items-center space-x-4">
                    <input type="color" name="color" id="color" value="{{ old('color', '#3B82F6') }}" 
                           class="w-12 h-12 border border-neutral-300 dark:border-neutral-600 rounded-lg cursor-pointer @error('color') border-error-500 @enderror">
                    <div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">Choose a color to represent this category</p>
                        <p class="text-xs text-neutral-500 dark:text-neutral-500">This color will be used in category displays and filters</p>
                    </div>
                </div>
                @error('color')
                    <p class="form-modern-error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Status -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Status</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Set the category status</p>
            </div>
            <div class="card-modern-body">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" 
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="rounded border-neutral-300 dark:border-neutral-600 text-primary-500 focus:ring-primary-500 dark:bg-neutral-800">
                    <label for="is_active" class="ml-2 text-sm text-neutral-700 dark:text-neutral-300">
                        Category is active (can be used for new articles)
                    </label>
                </div>
            </div>
        </div>

        <!-- Preview -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Preview</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">See how your category will look</p>
            </div>
            <div class="card-modern-body">
                <div class="bg-neutral-50 dark:bg-neutral-800 rounded-lg p-4">
                    <div class="flex items-center space-x-3">
                        <div id="preview-color" class="w-4 h-4 rounded-full" style="background-color: {{ old('color', '#3B82F6') }}"></div>
                        <div>
                            <div id="preview-name" class="font-medium text-neutral-900 dark:text-neutral-100">{{ old('name', 'Category Name') }}</div>
                            <div id="preview-description" class="text-sm text-neutral-600 dark:text-neutral-400">{{ old('description', 'Category description will appear here') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="card-modern">
            <div class="card-modern-footer">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('categories.index') }}" class="btn-modern btn-modern-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn-modern btn-modern-primary">
                        Create Category
                    </button>
                </div>
            </div>
        </div>
    </form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const colorInput = document.getElementById('color');
    const previewName = document.getElementById('preview-name');
    const previewDescription = document.getElementById('preview-description');
    const previewColor = document.getElementById('preview-color');

    // Update preview on input change
    function updatePreview() {
        previewName.textContent = nameInput.value || 'Category Name';
        previewDescription.textContent = descriptionInput.value || 'Category description will appear here';
        previewColor.style.backgroundColor = colorInput.value;
    }

    nameInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
    colorInput.addEventListener('input', updatePreview);

    // Initial preview update
    updatePreview();
});
</script>
@endpush
@endsection
