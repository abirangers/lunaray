@extends('layouts.admin')

@section('title', 'Edit User - Lunaray Beauty Factory')
@section('pageTitle', 'Edit User')
@section('pageDescription', 'Update user information and permissions')

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

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
                
        <!-- Basic Information -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Basic Information</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Update user's personal details and contact information</p>
            </div>
            <div class="card-modern-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="form-modern-label">Full Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                               class="form-modern @error('name') form-modern-error @enderror" 
                               placeholder="Enter user's full name" required>
                        @error('name')
                            <p class="form-modern-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="form-modern-label">Email Address *</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                               class="form-modern @error('email') form-modern-error @enderror" 
                               placeholder="Enter user's email address" required>
                        @error('email')
                            <p class="form-modern-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Settings -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Security Settings</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Update password and authentication settings</p>
            </div>
            <div class="card-modern-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="form-modern-label">New Password</label>
                        <input type="password" name="password" id="password" 
                               class="form-modern @error('password') form-modern-error @enderror" 
                               placeholder="Leave blank to keep current password">
                        <p class="form-modern-help">Leave blank to keep current password. Minimum 8 characters with letters and numbers.</p>
                        @error('password')
                            <p class="form-modern-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="form-modern-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="form-modern" 
                               placeholder="Confirm the new password">
                    </div>
                </div>
            </div>
        </div>

        <!-- Role & Permissions -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Role & Permissions</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Update user's access level and permissions</p>
            </div>
            <div class="card-modern-body">
                <div>
                    <label for="role" class="form-modern-label">User Role *</label>
                    <select name="role" id="role" 
                            class="form-modern @error('role') form-modern-error @enderror" 
                            required>
                        <option value="">Select a role</option>
                        <option value="user" {{ old('role', $user->getRoleNames()->first()) == 'user' ? 'selected' : '' }}>Public User - Can view content only</option>
                        <option value="content_manager" {{ old('role', $user->getRoleNames()->first()) == 'content_manager' ? 'selected' : '' }}>Content Manager - Can manage articles and content</option>
                        <option value="admin" {{ old('role', $user->getRoleNames()->first()) == 'admin' ? 'selected' : '' }}>Admin - Full system access</option>
                    </select>
                    <p class="form-modern-help">Choose the appropriate access level for this user</p>
                    @error('role')
                        <p class="form-modern-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- User Information -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">User Information</h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">Account details and metadata</p>
            </div>
            <div class="card-modern-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center justify-between p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                        <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Created</span>
                        <span class="text-sm text-neutral-900 dark:text-neutral-100 font-mono">{{ $user->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                        <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Last Updated</span>
                        <span class="text-sm text-neutral-900 dark:text-neutral-100 font-mono">{{ $user->updated_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                        <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Login Method</span>
                        <span class="text-sm {{ $user->google_id ? 'text-error-600 dark:text-error-400' : 'text-primary-600 dark:text-primary-400' }}">
                            {{ $user->google_id ? 'Google OAuth' : 'Email/Password' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                        <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">User ID</span>
                        <span class="text-sm text-neutral-900 dark:text-neutral-100 font-mono">{{ $user->id }}</span>
                    </div>
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
                    <span>Last updated: {{ $user->updated_at->format('M j, Y g:i A') }}</span>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update User
                </button>
            </div>
        </div>
    </form>
@endsection
