@extends('layouts.admin')

@section('title', 'User Management - Lunaray Beauty Factory')
@section('pageTitle', 'User Management')
@section('pageDescription', 'Manage users, roles, and permissions for the Lunaray Beauty Factory system')

@section('content')
    <!-- Action Buttons -->
    <div class="mb-8">
        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('admin.users.create') }}" class="btn-modern btn-modern-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create New User
            </a>
            <button class="btn-modern btn-modern-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                                Export Users
                            </button>
                        </div>
                    </div>

    <!-- Modern Users Table -->
    <div class="card-modern mb-8">
        <div class="card-modern-header">
            <h2 class="text-xl font-semibold text-neutral-900 dark:text-neutral-100">All Users</h2>
            <p class="text-sm text-neutral-600 dark:text-neutral-400">Manage user accounts and permissions</p>
                </div>
        <div class="card-modern-body">
                    <div class="overflow-x-auto">
                <table class="table-modern">
                    <thead class="table-modern-header">
                        <tr>
                            <th class="table-modern-header-cell">User</th>
                            <th class="table-modern-header-cell">Email</th>
                            <th class="table-modern-header-cell">Role</th>
                            <th class="table-modern-header-cell">Login Method</th>
                            <th class="table-modern-header-cell">Created</th>
                            <th class="table-modern-header-cell">Actions</th>
                                </tr>
                            </thead>
                    <tbody class="table-modern-body">
                        @forelse($users as $user)
                            <tr class="table-modern-row">
                                <td class="table-modern-cell">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-primary-500 to-secondary-500 flex items-center justify-center">
                                                    <span class="text-white text-sm font-medium">{{ substr($user->name, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                            <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ $user->name }}</div>
                                            <div class="text-sm text-neutral-500 dark:text-neutral-400">ID: {{ $user->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                <td class="table-modern-cell">
                                    <div class="text-sm text-neutral-900 dark:text-neutral-100">{{ $user->email }}</div>
                                    </td>
                                <td class="table-modern-cell">
                                    <span class="badge-modern {{ $user->hasRole('admin') ? 'badge-modern-error' : ($user->hasRole('content_manager') ? 'badge-modern-primary' : 'badge-modern-success') }}">
                                            {{ $user->getRoleNames()->first() }}
                                        </span>
                                    </td>
                                <td class="table-modern-cell">
                                    <div class="text-sm text-neutral-900 dark:text-neutral-100">
                                        <span class="text-primary-600 dark:text-primary-400">Email/Password</span>
                                    </div>
                                </td>
                                <td class="table-modern-cell">
                                    <div class="text-sm text-neutral-500 dark:text-neutral-400">{{ $user->created_at->format('M d, Y') }}</div>
                                    </td>
                                <td class="table-modern-cell">
                                    <div class="flex items-center space-x-1">
                                        <a href="{{ route('admin.users.show', $user) }}" class="btn-modern btn-modern-ghost p-2" title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn-modern btn-modern-ghost p-2" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-modern btn-modern-ghost p-2 text-error-600 hover:text-error-700" title="Delete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                <td colspan="6" class="table-modern-cell">
                                    <div class="text-center py-12">
                                        <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-neutral-900 dark:text-neutral-100">No users found</h3>
                                        <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Get started by creating a new user.</p>
                                        <div class="mt-6">
                                            <a href="{{ route('admin.users.create') }}" class="btn-modern btn-modern-primary">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                Create First User
                                            </a>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

    <!-- Modern Role Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card-modern hover:shadow-lg transition-all duration-300">
            <div class="card-modern-body">
                        <div class="flex items-center">
                    <div class="p-3 bg-success-100 dark:bg-success-900/20 rounded-xl">
                        <svg class="h-8 w-8 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                        <h3 class="text-lg font-medium text-neutral-900 dark:text-neutral-100">Public Users</h3>
                        <p class="text-2xl font-bold text-success-600 dark:text-success-400">{{ $userStats['public_users'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

        <div class="card-modern hover:shadow-lg transition-all duration-300">
            <div class="card-modern-body">
                        <div class="flex items-center">
                    <div class="p-3 bg-primary-100 dark:bg-primary-900/20 rounded-xl">
                        <svg class="h-8 w-8 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                        <h3 class="text-lg font-medium text-neutral-900 dark:text-neutral-100">Content Managers</h3>
                        <p class="text-2xl font-bold text-primary-600 dark:text-primary-400">{{ $userStats['content_managers'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>

        <div class="card-modern hover:shadow-lg transition-all duration-300">
            <div class="card-modern-body">
                        <div class="flex items-center">
                    <div class="p-3 bg-error-100 dark:bg-error-900/20 rounded-xl">
                        <svg class="h-8 w-8 text-error-600 dark:text-error-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                        <h3 class="text-lg font-medium text-neutral-900 dark:text-neutral-100">Admins</h3>
                        <p class="text-2xl font-bold text-error-600 dark:text-error-400">{{ $userStats['admin_users'] ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
