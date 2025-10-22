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
<body class="h-full bg-gray-50" x-data="{ sidebarOpen: false }">
    <div class="h-full">
        <!-- Sidebar -->
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <div class="flex-1 flex flex-col min-h-0 bg-white border-r border-gray-200">
                <!-- Logo -->
                <div class="flex items-center h-16 flex-shrink-0 px-4 bg-primary">
                    <div class="flex items-center space-x-2">
                        <div class="h-8 w-8 rounded-full bg-white flex items-center justify-center">
                            <span class="text-primary font-bold text-sm">L</span>
                        </div>
                        <span class="text-xl font-serif font-semibold text-white">Lunaray</span>
                    </div>
                </div>
                
                <!-- Navigation -->
                <div class="flex-1 flex flex-col overflow-y-auto">
                    <nav class="flex-1 px-2 py-4 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                            </svg>
                            Dashboard
                        </a>
                        
                        <a href="{{ route('articles.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('articles.*') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Articles
                        </a>
                        
                        <a href="{{ route('categories.index') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('categories.*') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Categories
                        </a>
                        
                        <a href="{{ route('admin.analytics') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.analytics') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Analytics
                        </a>
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
                                <span class="text-xl font-serif font-semibold text-primary">Lunaray</span>
                            </div>
                        </div>
                        <nav class="mt-5 px-2 space-y-1">
                            <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('articles.index') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('articles.*') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                Articles
                            </a>
                            <a href="{{ route('categories.index') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('categories.*') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                Categories
                            </a>
                            <a href="{{ route('admin.analytics') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('admin.analytics') ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                Analytics
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="md:pl-64 flex flex-col flex-1">
            <!-- Top navigation -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <button @click="sidebarOpen = true" class="md:hidden -ml-0.5 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                            <div>
                                <h1 class="text-2xl font-serif font-semibold text-gray-900">@yield('pageTitle', 'Dashboard')</h1>
                                @hasSection('pageDescription')
                                    <p class="mt-1 text-sm text-gray-500">@yield('pageDescription')</p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- User menu -->
                        <div class="flex items-center space-x-4">
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 text-sm text-gray-700 hover:text-primary focus:outline-none">
                                    <div class="h-8 w-8 rounded-full bg-secondary flex items-center justify-center">
                                        <span class="text-primary font-medium text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                    <span class="hidden sm:block">{{ auth()->user()->name }}</span>
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                    <div class="px-4 py-2 text-sm text-gray-700 border-b">
                                        <div class="font-medium">{{ auth()->user()->name }}</div>
                                        <div class="text-gray-500">{{ auth()->user()->email }}</div>
                                    </div>
                                    
                                    <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        View Site
                                    </a>
                                    
                                    <form method="POST" action="{{ route('staff.logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
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
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>

