<!-- Avatar Upload Component -->
<div class="bg-white rounded-lg shadow-sm border border-neutral-200 p-6">
    <h3 class="text-lg font-semibold text-neutral-900 mb-4">Profile Picture</h3>
    
    <div class="flex items-start space-x-6">
        <!-- Current Avatar Display -->
        <div class="flex-shrink-0">
            <div class="relative">
                @if(auth()->user()->avatar)
                    <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" 
                         class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-lg" id="current-avatar">
                @else
                    <div class="h-24 w-24 rounded-full bg-primary flex items-center justify-center border-4 border-white shadow-lg" id="current-avatar">
                        <span class="text-white text-2xl font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Upload Controls -->
        <div class="flex-1">
            <div class="space-y-4">
                <!-- Upload Form -->
                <form id="avatar-upload-form" action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <!-- File Input (Hidden) -->
                    <input type="file" id="avatar-input" name="avatar" accept="image/*" class="hidden" 
                           onchange="handleFileSelect(event)">
                    
                    <!-- Upload Button -->
                    <div>
                        <button type="button" onclick="document.getElementById('avatar-input').click()" 
                                class="btn-modern btn-modern-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            Upload New Picture
                        </button>
                    </div>

                    <!-- Drag & Drop Zone -->
                    <div id="drop-zone" class="border-2 border-dashed border-neutral-300 rounded-lg p-6 text-center hover:border-primary hover:bg-primary hover:bg-opacity-5 transition-colors cursor-pointer"
                         onclick="document.getElementById('avatar-input').click()">
                        <svg class="mx-auto h-12 w-12 text-neutral-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="mt-2">
                            <p class="text-sm text-neutral-600">
                                <span class="font-medium text-primary hover:text-primary-600">Click to upload</span>
                                or drag and drop
                            </p>
                            <p class="text-xs text-neutral-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>

                    <!-- Preview -->
                    <div id="avatar-preview" class="hidden">
                        <div class="flex items-center space-x-4">
                            <img id="preview-image" class="h-16 w-16 rounded-full object-cover border-2 border-primary" alt="Preview">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-neutral-900">New profile picture</p>
                                <p class="text-sm text-neutral-500">Click upload to save changes</p>
                            </div>
                            <div class="flex space-x-2">
                                <button type="submit" class="btn-modern btn-modern-primary text-sm">
                                    Upload
                                </button>
                                <button type="button" onclick="cancelUpload()" class="btn-modern btn-modern-ghost text-sm">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Remove Avatar Button -->
                @if(auth()->user()->avatar)
                    <form action="{{ route('profile.avatar.delete') }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-modern btn-modern-ghost text-red-600 hover:text-red-700" 
                                onclick="return confirm('Are you sure you want to remove your profile picture?')">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Remove Picture
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// Handle file selection
function handleFileSelect(event) {
    const file = event.target.files[0];
    if (file) {
        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('Please select a valid image file.');
            return;
        }
        
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB.');
            return;
        }
        
        // Show preview
        showPreview(file);
    }
}

// Show image preview
function showPreview(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('preview-image').src = e.target.result;
        document.getElementById('avatar-preview').classList.remove('hidden');
        document.getElementById('drop-zone').classList.add('hidden');
    };
    reader.readAsDataURL(file);
}

// Cancel upload
function cancelUpload() {
    document.getElementById('avatar-input').value = '';
    document.getElementById('avatar-preview').classList.add('hidden');
    document.getElementById('drop-zone').classList.remove('hidden');
}

// Drag and drop functionality
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('drop-zone');
    
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('border-primary', 'bg-primary', 'bg-opacity-10');
    });
    
    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10');
    });
    
    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            document.getElementById('avatar-input').files = files;
            handleFileSelect({ target: { files: files } });
        }
    });
});
</script>
