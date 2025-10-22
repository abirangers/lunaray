@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary mb-2">Create New Category</h1>
        <p class="text-gray-600">Add a new category to organize your content</p>
    </div>

    <form action="{{ route('categories.store') }}" method="POST" class="max-w-2xl">
        @csrf

        <div class="bg-white rounded-lg shadow-md p-6 space-y-6">
            <!-- Basic Information -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Category Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('name') border-red-500 @enderror" 
                       placeholder="Enter category name" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('description') border-red-500 @enderror" 
                          placeholder="Brief description of this category">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Color Selection -->
            <div>
                <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Category Color</label>
                <div class="flex items-center space-x-4">
                    <input type="color" name="color" id="color" value="{{ old('color', '#3B82F6') }}" 
                           class="w-12 h-12 border border-gray-300 rounded-lg cursor-pointer @error('color') border-red-500 @enderror">
                    <div>
                        <p class="text-sm text-gray-600">Choose a color to represent this category</p>
                        <p class="text-xs text-gray-500">This color will be used in category displays and filters</p>
                    </div>
                </div>
                @error('color')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1" 
                       {{ old('is_active', true) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-primary focus:ring-primary">
                <label for="is_active" class="ml-2 text-sm text-gray-700">
                    Category is active (can be used for new articles)
                </label>
            </div>

            <!-- Preview -->
            <div class="border-t pt-6">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Preview</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center space-x-3">
                        <div id="preview-color" class="w-4 h-4 rounded-full" style="background-color: {{ old('color', '#3B82F6') }}"></div>
                        <div>
                            <div id="preview-name" class="font-medium text-gray-900">{{ old('name', 'Category Name') }}</div>
                            <div id="preview-description" class="text-sm text-gray-600">{{ old('description', 'Category description will appear here') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-4 mt-6">
            <a href="{{ route('categories.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 bg-primary hover:bg-primary-dark text-white rounded-lg transition-colors">
                Create Category
            </button>
        </div>
    </form>
</div>

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
