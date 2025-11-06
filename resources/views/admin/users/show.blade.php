@extends('layouts.admin')

@section('title', 'User Details - Lunaray Beauty Factory')
@section('pageTitle', 'User Details')
@section('pageDescription', 'View detailed information about this user')

@section('content')
    <!-- Action Buttons -->
    <div class="mb-8">
        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('admin.users') }}" class="btn-modern btn-modern-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Users
            </a>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn-modern btn-modern-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit User
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- User Profile -->
            <div class="card-modern">
                <div class="card-modern-header">
                    <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">User Profile</h2>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Basic information and account details</p>
                </div>
                <div class="card-modern-body">
                    <div class="flex items-center space-x-6 mb-8">
                        @if($user->hasMedia('avatar'))
                            <img src="{{ $user->getFirstMediaUrl('avatar', 'thumb') }}" alt="{{ $user->name }}" 
                                 class="h-20 w-20 rounded-full object-cover border-4 border-white shadow-lg">
                        @else
                            <div class="h-20 w-20 rounded-full bg-gradient-to-r from-primary-500 to-secondary-500 flex items-center justify-center border-4 border-white shadow-lg">
                                <span class="text-white text-2xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">{{ $user->name }}</h3>
                            <p class="text-neutral-600 dark:text-neutral-400 mb-2">{{ $user->email }}</p>
                            <span class="badge-modern {{ $user->hasRole('admin') ? 'badge-modern-error' : ($user->hasRole('content_manager') ? 'badge-modern-primary' : 'badge-modern-success') }}">
                                {{ ucfirst($user->getRoleNames()->first()) }}
                            </span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-neutral-900 dark:text-neutral-100 mb-4">Account Details</h4>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                                    <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">User ID</span>
                                    <span class="text-sm text-neutral-900 dark:text-neutral-100 font-mono">{{ $user->id }}</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                                    <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Email Verified</span>
                                    <span class="text-sm {{ $user->email_verified_at ? 'text-success-600 dark:text-success-400' : 'text-error-600 dark:text-error-400' }}">
                                        {{ $user->email_verified_at ? 'Yes' : 'No' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                                    <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Login Method</span>
                                    <span class="text-sm text-primary-600 dark:text-primary-400">
                                        Email/Password
                                    </span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                                    <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Member Since</span>
                                    <span class="text-sm text-neutral-900 dark:text-neutral-100">{{ $user->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-neutral-50 dark:bg-neutral-800 rounded-xl">
                                    <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Last Updated</span>
                                    <span class="text-sm text-neutral-900 dark:text-neutral-100">{{ $user->updated_at->format('M d, Y H:i') }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-neutral-900 dark:text-neutral-100 mb-4">Activity</h4>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-primary-50 dark:bg-primary-900/20 rounded-xl">
                                    <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Articles Created</span>
                                    <span class="text-sm text-primary-600 dark:text-primary-400 font-bold">{{ $user->articles()->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-success-50 dark:bg-success-900/20 rounded-xl">
                                    <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Published Articles</span>
                                    <span class="text-sm text-success-600 dark:text-success-400 font-bold">{{ $user->articles()->published()->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-warning-50 dark:bg-warning-900/20 rounded-xl">
                                    <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Draft Articles</span>
                                    <span class="text-sm text-warning-600 dark:text-warning-400 font-bold">{{ $user->articles()->draft()->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-accent-50 dark:bg-accent-900/20 rounded-xl">
                                    <span class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Views</span>
                                    <span class="text-sm text-accent-600 dark:text-accent-400 font-bold">{{ number_format($user->articles()->sum('view_count')) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            <!-- Recent Articles -->
            <div class="card-modern">
                <div class="card-modern-header">
                    <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Recent Articles</h2>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Latest articles by this user</p>
                </div>
                <div class="card-modern-body">
                    @if($user->articles()->count() > 0)
                        <div class="space-y-3">
                            @foreach($user->articles()->latest()->limit(5)->get() as $article)
                                <div class="flex items-center justify-between p-3 bg-neutral-50 dark:bg-neutral-800 rounded-xl hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors duration-200">
                                    <div class="flex-1">
                                        <h3 class="font-medium text-neutral-900 dark:text-neutral-100 text-sm">{{ Str::limit($article->title, 30) }}</h3>
                                        <p class="text-xs text-neutral-600 dark:text-neutral-400">{{ $article->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $article->status === 'published' ? 'bg-success-100 text-success-800 dark:bg-success-900/20 dark:text-success-200' : 'bg-warning-100 text-warning-800 dark:bg-warning-900/20 dark:text-warning-200' }}">
                                            {{ ucfirst($article->status) }}
                                        </span>
                                        <a href="#" class="text-primary-500 hover:text-primary-600 dark:text-primary-400 dark:hover:text-primary-300 text-xs">
                                            View
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            <a href="#" 
                               class="text-primary-500 hover:text-primary-600 dark:text-primary-400 dark:hover:text-primary-300 font-medium text-sm">View all articles →</a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-neutral-900 dark:text-neutral-100">No articles yet</h3>
                            <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">This user hasn't created any articles.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card-modern">
                <div class="card-modern-header">
                    <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">Quick Actions</h2>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">Manage this user account</p>
                </div>
                <div class="card-modern-body">
                    <div class="space-y-3">
                        <a href="{{ route('admin.users.edit', $user) }}" class="w-full btn-modern btn-modern-primary flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit User
                        </a>
                        
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="w-full" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full btn-modern btn-modern-ghost text-error-600 hover:text-error-700 flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete User
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
