@extends('layouts.admin')

@section('title', 'Create User - Lunaray Beauty Factory')
@section('pageTitle', 'Create New User')
@section('pageDescription', 'Add a new user to the system')

@section('content')
    <!-- Action Buttons -->
    <div class="mb-8">
        <div class="flex items-center justify-end">
            <a href="{{ route('admin.users') }}" class="btn-modern btn-modern-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Users
            </a>
        </div>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-8">
        @csrf
                
        <!-- Basic Information -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Basic Information</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">User's personal details and contact information</p>
            </div>
            <div class="card-modern-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="form-modern-label">Full Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" 
                               class="form-modern @error('name') form-modern-error @enderror" 
                               placeholder="Enter user's full name" required>
                        @error('name')
                            <p class="form-modern-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="form-modern-label">Email Address *</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" 
                               class="form-modern @error('email') form-modern-error @enderror" 
                               placeholder="Enter user's email address" required>
                        @error('email')
                            <p class="form-modern-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Avatar Upload -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Profile Picture</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Upload a profile picture for the user (optional)</p>
            </div>
            <div class="card-modern-body">
                <div class="flex items-start space-x-6">
                    <!-- Avatar Preview -->
                    <div class="flex-shrink-0">
                        <div class="relative">
                            <div id="avatar-preview" class="h-24 w-24 rounded-full bg-gradient-to-r from-primary-500 to-secondary-500 flex items-center justify-center border-4 border-white shadow-lg">
                                <span class="text-white text-2xl font-bold" id="avatar-initial">?</span>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Controls -->
                    <div class="flex-1">
                        <div class="space-y-4">
                            <div x-data="{
                                previewUrl: null,
                                isDragging: false,
                                
                                handleFileSelect(event) {
                                    const file = event.target.files[0];
                                    if (file) {
                                        this.createPreview(file);
                                    }
                                },
                                
                                handleDrop(event) {
                                    event.preventDefault();
                                    this.isDragging = false;
                                    
                                    const files = event.dataTransfer.files;
                                    if (files.length > 0) {
                                        const file = files[0];
                                        if (file.type.startsWith('image/')) {
                                            this.$refs.fileInput.files = files;
                                            this.createPreview(file);
                                        }
                                    }
                                },
                                
                                createPreview(file) {
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        this.previewUrl = e.target.result;
                                        // Update avatar preview
                                        this.updateAvatarPreview(e.target.result);
                                    };
                                    reader.readAsDataURL(file);
                                },
                                
                                updateAvatarPreview(imageUrl) {
                                    const avatarPreview = document.getElementById('avatar-preview');
                                    const newImg = document.createElement('img');
                                    newImg.src = imageUrl;
                                    newImg.alt = 'Avatar Preview';
                                    newImg.className = 'h-24 w-24 rounded-full object-cover border-4 border-white shadow-lg';
                                    newImg.id = 'avatar-preview';
                                    avatarPreview.parentNode.replaceChild(newImg, avatarPreview);
                                    
                                    // Show remove button
                                    document.getElementById('remove-avatar-btn').classList.remove('hidden');
                                },
                                
                                removeImage() {
                                    this.previewUrl = null;
                                    this.$refs.fileInput.value = '';
                                    
                                    // Reset to default state
                                    const avatarPreview = document.getElementById('avatar-preview');
                                    const defaultDiv = document.createElement('div');
                                    defaultDiv.className = 'h-24 w-24 rounded-full bg-gradient-to-r from-primary-500 to-secondary-500 flex items-center justify-center border-4 border-white shadow-lg';
                                    defaultDiv.id = 'avatar-preview';
                                    
                                    const initialSpan = document.createElement('span');
                                    initialSpan.className = 'text-white text-2xl font-bold';
                                    initialSpan.id = 'avatar-initial';
                                    initialSpan.textContent = '?';
                                    
                                    defaultDiv.appendChild(initialSpan);
                                    avatarPreview.parentNode.replaceChild(defaultDiv, avatarPreview);
                                    
                                    // Hide remove button
                                    document.getElementById('remove-avatar-btn').classList.add('hidden');
                                }
                            }">
                                <!-- File Input (Hidden) -->
                                <input x-ref="fileInput" type="file" name="avatar" accept="image/*" class="hidden" 
                                       @change="handleFileSelect($event)">
                                
                                <!-- Upload Button -->
                                <div>
                                    <button type="button" @click="$refs.fileInput.click()" 
                                            class="btn-modern btn-modern-primary">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        Choose Profile Picture
                                    </button>
                                </div>

                                <!-- Drag & Drop Zone -->
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
                                        <svg x-show="!previewUrl" class="mx-auto h-12 w-12 text-neutral-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        
                                        <div class="flex text-sm text-neutral-600 dark:text-neutral-400">
                                            <span x-text="previewUrl ? 'Change image' : 'Upload a file'"></span>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                            PNG, JPG, GIF up to 2MB. Recommended: 400x400px
                                        </p>
                                        
                                        <!-- Remove Image Button -->
                                        <button x-show="previewUrl && !isDragging" @click.stop="removeImage()" type="button" class="mt-2 text-sm text-error-600 hover:text-error-700 dark:text-error-400 dark:hover:text-error-300">
                                            Remove image
                                        </button>
                                    </div>
                                </div>
                                
                                <input x-ref="fileInput" type="file" name="avatar" accept="image/*" 
                                       class="sr-only @error('avatar') form-modern-error @enderror" @change="handleFileSelect($event)">
                                @error('avatar')
                                    <p class="form-modern-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remove Avatar Button -->
                            <div id="remove-avatar-btn" class="pt-2 hidden">
                                <button type="button" onclick="removeAvatar()" 
                                        class="text-sm text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Remove picture
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Settings -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Security Settings</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Set up password and authentication for the user</p>
            </div>
            <div class="card-modern-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="form-modern-label">Password *</label>
                        <input type="password" name="password" id="password" 
                               class="form-modern @error('password') form-modern-error @enderror" 
                               placeholder="Enter a secure password" required>
                        <p class="form-modern-help">Minimum 8 characters with letters and numbers</p>
                        @error('password')
                            <p class="form-modern-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="form-modern-label">Confirm Password *</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="form-modern" 
                               placeholder="Confirm the password" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role & Permissions -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Role & Permissions</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Assign appropriate role and access level</p>
            </div>
            <div class="card-modern-body">
                <div>
                    <label for="role" class="form-modern-label">User Role *</label>
                    <select name="role" id="role" 
                            class="form-modern @error('role') form-modern-error @enderror" 
                            required>
                        <option value="">Select a role</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Public User - Can view content only</option>
                        <option value="content_manager" {{ old('role') == 'content_manager' ? 'selected' : '' }}>Content Manager - Can manage articles and content</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin - Full system access</option>
                    </select>
                    <p class="form-modern-help">Choose the appropriate access level for this user</p>
                    @error('role')
                        <p class="form-modern-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4 pt-6 border-t border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2 text-sm text-neutral-600 dark:text-neutral-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>All fields are required</span>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.users') }}" class="btn-modern btn-modern-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancel
                </a>
                <button type="submit" class="btn-modern btn-modern-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create User
                </button>
            </div>
        </div>
    </form>

    <!-- Avatar Upload JavaScript -->
    <script>
        function removeAvatar() {
            const avatarPreview = document.getElementById('avatar-preview');
            const avatarInitial = document.getElementById('avatar-initial');
            
            // Reset to default state
            const defaultDiv = document.createElement('div');
            defaultDiv.className = 'h-24 w-24 rounded-full bg-gradient-to-r from-primary-500 to-secondary-500 flex items-center justify-center border-4 border-white shadow-lg';
            defaultDiv.id = 'avatar-preview';
            
            const initialSpan = document.createElement('span');
            initialSpan.className = 'text-white text-2xl font-bold';
            initialSpan.id = 'avatar-initial';
            initialSpan.textContent = '?';
            
            defaultDiv.appendChild(initialSpan);
            avatarPreview.parentNode.replaceChild(defaultDiv, avatarPreview);
            
            // Clear file input
            document.getElementById('avatar-input').value = '';
            
            // Hide remove button
            document.getElementById('remove-avatar-btn').classList.add('hidden');
        }

        // Update avatar initial when name changes
        document.getElementById('name').addEventListener('input', function() {
            const name = this.value.trim();
            const avatarInitial = document.getElementById('avatar-initial');
            if (avatarInitial) {
                avatarInitial.textContent = name.length > 0 ? name.charAt(0).toUpperCase() : '?';
            }
        });
    </script>
@endsection
