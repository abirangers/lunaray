@extends('layouts.app')

@section('title', 'Profile - ' . $user->name)

@section('content')
<div class="min-h-screen bg-neutral-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Profile Header -->
        <div class="bg-white rounded-lg shadow-sm border border-neutral-200 mb-8">
            <div class="px-6 py-8">
                <div class="flex items-start space-x-6">
                    <!-- Avatar -->
                    <div class="flex-shrink-0">
                        <div class="relative">
                            @if($user->hasMedia('avatar'))
                                <img src="{{ $user->getFirstMediaUrl('avatar', 'thumb') }}" alt="{{ $user->name }}" 
                                     class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-lg">
                            @else
                                <div class="h-24 w-24 rounded-full bg-primary flex items-center justify-center border-4 border-white shadow-lg">
                                    <span class="text-white text-2xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="absolute -bottom-2 -right-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($user->hasRole('admin')) bg-red-100 text-red-800
                                    @elseif($user->hasRole('content_manager')) bg-blue-100 text-blue-800
                                    @else bg-green-100 text-green-800 @endif">
                                    {{ ucfirst($user->roles->first()->name ?? 'user') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Info -->
                    <div class="flex-1 min-w-0">
                        <h1 class="text-2xl font-bold text-neutral-900 mb-2">{{ $user->name }}</h1>
                        <p class="text-neutral-600 mb-4">{{ $user->email }}</p>
                        
                        @if($user->bio)
                            <p class="text-neutral-700 mb-4">{{ $user->bio }}</p>
                        @endif

                        <div class="flex flex-wrap gap-4 text-sm text-neutral-500">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Joined {{ $stats['account_age'] }}
                            </div>
                            @if($user->location)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $user->location }}
                                </div>
                            @endif
                            @if($user->website)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    <a href="{{ $user->website }}" target="_blank" class="text-primary hover:text-primary-600">Website</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex-shrink-0">
                        <a href="{{ route('profile.edit') }}" class="btn-modern btn-modern-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Statistics -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Basic Stats -->
                <div class="bg-white rounded-lg shadow-sm border border-neutral-200 p-6">
                    <h2 class="text-lg font-semibold text-neutral-900 mb-4">Account Statistics</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-primary">{{ $stats['account_age'] }}</div>
                            <div class="text-sm text-neutral-500">Account Age</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-primary">{{ $stats['last_login'] }}</div>
                            <div class="text-sm text-neutral-500">Last Active</div>
                        </div>
                        @if(isset($stats['articles_created']))
                            <div class="text-center">
                                <div class="text-2xl font-bold text-primary">{{ $stats['articles_created'] }}</div>
                                <div class="text-sm text-neutral-500">Articles Created</div>
                            </div>
                        @endif
                        @if(isset($stats['total_views']))
                            <div class="text-center">
                                <div class="text-2xl font-bold text-primary">{{ number_format($stats['total_views']) }}</div>
                                <div class="text-sm text-neutral-500">Total Views</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Role-specific Stats -->
                @if($user->hasRole('content_manager') || $user->hasRole('admin'))
                    <div class="bg-white rounded-lg shadow-sm border border-neutral-200 p-6">
                        <h2 class="text-lg font-semibold text-neutral-900 mb-4">Content Statistics</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-primary">{{ $stats['articles_published'] ?? 0 }}</div>
                                <div class="text-sm text-neutral-500">Published Articles</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-primary">{{ $stats['articles_created'] ?? 0 }}</div>
                                <div class="text-sm text-neutral-500">Total Articles</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-primary">{{ number_format($stats['total_views'] ?? 0) }}</div>
                                <div class="text-sm text-neutral-500">Article Views</div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($user->hasRole('admin'))
                    <div class="bg-white rounded-lg shadow-sm border border-neutral-200 p-6">
                        <h2 class="text-lg font-semibold text-neutral-900 mb-4">System Statistics</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-primary">{{ $stats['system_stats']['total_users'] ?? 0 }}</div>
                                <div class="text-sm text-neutral-500">Total Users</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-primary">{{ $stats['system_stats']['total_articles'] ?? 0 }}</div>
                                <div class="text-sm text-neutral-500">Total Articles</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-primary">{{ $stats['system_stats']['admin_users'] ?? 0 }}</div>
                                <div class="text-sm text-neutral-500">Admin Users</div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Recent Activities -->
                <div class="bg-white rounded-lg shadow-sm border border-neutral-200 p-6">
                    <h2 class="text-lg font-semibold text-neutral-900 mb-4">Recent Activity</h2>
                    @if($activities->count() > 0)
                        <div class="space-y-3">
                            @foreach($activities as $activity)
                                <div class="flex items-center space-x-3 py-2 border-b border-neutral-100 last:border-b-0">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 rounded-full bg-primary bg-opacity-10 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-neutral-900">{{ $activity->description }}</p>
                                        <p class="text-xs text-neutral-500">{{ $activity->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-neutral-500 text-center py-4">No recent activity</p>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Profile Actions -->
                <div class="bg-white rounded-lg shadow-sm border border-neutral-200 p-6">
                    <h3 class="text-lg font-semibold text-neutral-900 mb-4">Profile Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('profile.edit') }}" class="w-full btn-modern btn-modern-primary flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Profile
                        </a>
                        <a href="{{ route('profile.password') }}" class="w-full btn-modern btn-modern-ghost flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                            Change Password
                        </a>
                    </div>
                </div>

                <!-- Social Links -->
                @if($user->social_links && count(array_filter($user->social_links)) > 0)
                    <div class="bg-white rounded-lg shadow-sm border border-neutral-200 p-6">
                        <h3 class="text-lg font-semibold text-neutral-900 mb-4">Social Links</h3>
                        <div class="space-y-2">
                            @foreach($user->social_links as $platform => $url)
                                @if($url)
                                    <a href="{{ $url }}" target="_blank" class="flex items-center text-sm text-neutral-600 hover:text-primary">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        {{ ucfirst($platform) }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
