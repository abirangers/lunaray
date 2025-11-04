<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard - Lunaray Beauty Factory')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|playfair-display:400,500,600,700|jetbrains-mono:400,500,600" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full bg-neutral-50" x-data="{ sidebarOpen: false }">
    <div class="h-full">
        <!-- Modern Sidebar -->
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <div class="flex-1 flex flex-col min-h-0 sidebar-modern transition-colors duration-200">
                <!-- Modern Logo -->
                <div class="flex items-center h-16 flex-shrink-0 px-6 border-b border-neutral-200 dark:border-neutral-700">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 rounded-xl bg-primary-500 flex items-center justify-center shadow-sm">
                            <span class="text-white font-bold text-lg">L</span>
                        </div>
                        <div>
                            <span class="text-xl font-sans font-semibold text-neutral-900 dark:text-neutral-100">Lunaray</span>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">Beauty Factory</p>
                        </div>
                    </div>
                </div>
                
                <!-- Modern Navigation -->
                <div class="flex-1 flex flex-col overflow-y-auto">
                    <nav class="flex-1 px-4 py-6 space-y-2">
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'sidebar-modern-item-active' : 'sidebar-modern-item' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                            </svg>
                            Dashboard
                        </a>
                        
                        
                        <a href="{{ route('admin.articles.index') }}" class="{{ request()->routeIs('admin.articles.*') || request()->routeIs('articles.create') || request()->routeIs('articles.edit') ? 'sidebar-modern-item-active' : 'sidebar-modern-item' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Manage Articles
                        </a>
                        
                        <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'sidebar-modern-item-active' : 'sidebar-modern-item' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Categories
                        </a>
                        
                        @can('manage products')
                        <!-- Product Management Section -->
                        <div class="pt-2 pb-2">
                            <p class="px-3 text-xs font-semibold text-neutral-500 uppercase tracking-wider">Products</p>
                        </div>
                        
                        <a href="{{ route('admin.product-categories.index') }}" class="{{ request()->routeIs('admin.product-categories.*') ? 'sidebar-modern-item-active' : 'sidebar-modern-item' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                            </svg>
                            Product Categories
                        </a>
                        
                        <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'sidebar-modern-item-active' : 'sidebar-modern-item' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Products
                        </a>
                        @endcan
                        
                        @can('manage heroes')
                        <a href="{{ route('admin.heroes.index') }}" class="{{ request()->routeIs('admin.heroes.*') ? 'sidebar-modern-item-active' : 'sidebar-modern-item' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Hero Slider
                        </a>
                        @endcan
                        
                        <a href="{{ route('profile.show') }}" class="{{ request()->routeIs('profile.*') ? 'sidebar-modern-item-active' : 'sidebar-modern-item' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile
                        </a>
                        
                        {{-- <a href="{{ route('admin.analytics') }}" class="{{ request()->routeIs('admin.analytics') ? 'sidebar-modern-item-active' : 'sidebar-modern-item' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Analytics
                        </a> --}}
                        
                        @can('manage users')
                        <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'sidebar-modern-item-active' : 'sidebar-modern-item' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            User Management
                        </a>
                        @endcan
                        
                        @can('manage system settings')
                        {{-- <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'sidebar-modern-item-active' : 'sidebar-modern-item' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            System Settings
                        </a> --}}
                        @endcan
                    </nav>
                </div>
            </div>
        </div>

        <!-- Mobile sidebar -->
        <div class="md:hidden" x-show="sidebarOpen" x-transition>
            <div class="fixed inset-0 flex z-40">
                <div class="fixed inset-0 bg-gray-600 bg-opacity-75" @click="sidebarOpen = false"></div>
                <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white">
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button @click="sidebarOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                        <div class="flex-shrink-0 flex items-center px-4">
                            <div class="flex items-center space-x-2">
                                <div class="h-8 w-8 rounded-full bg-primary flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">L</span>
                                </div>
                                <span class="text-xl font-sans font-semibold text-primary">Lunaray</span>
                            </div>
                        </div>
                        <nav class="mt-5 px-2 space-y-1">
                            <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('admin.articles.index') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.articles.*') || request()->routeIs('articles.create') || request()->routeIs('articles.edit') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                Manage Articles
                            </a>
                            <a href="{{ route('categories.index') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('categories.*') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                Categories
                            </a>
                            @can('manage products')
                            <div class="pt-2 pb-2 px-2">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Products</p>
                            </div>
                            <a href="{{ route('admin.product-categories.index') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.product-categories.*') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                Product Categories
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.products.*') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                Products
                            </a>
                            @endcan
                            <a href="{{ route('profile.show') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('profile.*') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                Profile
                            </a>
                            {{-- <a href="{{ route('admin.analytics') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.analytics') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                Analytics
                            </a> --}}
                            @can('manage users')
                            <a href="{{ route('admin.users') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.users') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                User Management
                            </a>
                            @endcan
                            @can('manage system settings')
                            {{-- <a href="{{ route('admin.settings') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.settings') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                System Settings
                            </a> --}}
                            @endcan
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="md:pl-64 flex flex-col flex-1">
            <!-- Top navigation -->
            <header class="bg-white shadow-sm border-b border-neutral-200">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <button @click="sidebarOpen = true" class="md:hidden -ml-0.5 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-md text-neutral-500 hover:text-neutral-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-colors duration-200">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                            <div>
                                <h1 class="text-2xl font-sans font-semibold text-neutral-900">@yield('pageTitle', 'Dashboard')</h1>
                                @hasSection('pageDescription')
                                    <p class="mt-1 text-sm text-neutral-500">@yield('pageDescription')</p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- User menu -->
                        <div class="flex items-center space-x-4">
                            <!-- User menu -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 text-sm text-neutral-700 hover:text-primary-500 focus:outline-none transition-colors duration-200">
                                    {{-- profile avatar --}}
                                    @if(auth()->user()->hasMedia('avatar'))
                                        <img src="{{ auth()->user()->getFirstMediaUrl('avatar', 'thumb') }}" alt="{{ auth()->user()->name }}" 
                                             class="h-8 w-8 rounded-full object-cover">
                                    @else   
                                        <span class="text-primary-500 font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    @endif
                                    <span class="hidden sm:block">{{ auth()->user()->name }}</span>
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-neutral-200">
                                    <div class="px-4 py-2 text-sm text-neutral-700 border-b border-neutral-200">
                                        <div class="font-medium">{{ auth()->user()->name }}</div>
                                        <div class="text-neutral-500">{{ auth()->user()->email }}</div>
                                    </div>
                                    
                                    <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100 transition-colors duration-200">
                                        View Site
                                    </a>
                                    
                                    <form method="POST" action="{{ route('staff.logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100 transition-colors duration-200">
                                            Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <!-- Flash Messages -->
                        @if(session('success'))
                            <div class="mb-4 bg-success-50 border border-success-200 text-success-800 px-4 py-3 rounded-lg relative" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-4 bg-error-50 border border-error-200 text-error-800 px-4 py-3 rounded-lg relative" role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif

                        @if(session('warning'))
                            <div class="mb-4 bg-warning-50 border border-warning-200 text-warning-800 px-4 py-3 rounded-lg relative" role="alert">
                                <span class="block sm:inline">{{ session('warning') }}</span>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Floating Chat Component -->
    @include('components.floating-chat')

    @stack('scripts')
</body>
</html>

