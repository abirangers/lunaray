<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Lunaray Beauty Factory')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|playfair-display:400,500,600,700|jetbrains-mono:400,500,600" rel="stylesheet" />
    
    <!-- Google Analytics 4 -->
    @if(config('services.ga4.measurement_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.ga4.measurement_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config("services.ga4.measurement_id") }}');
        </script>
    @endif

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full bg-white">
    <div class="min-h-full">
        <!-- Navigation -->
        <nav class="bg-white border-b border-neutral-200">
            <div class="mx-auto max-w-4xl px-6">
                <div class="flex h-16 justify-between items-center">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="h-8 w-8 rounded-lg bg-neutral-900 flex items-center justify-center">
                            <span class="text-white font-bold text-sm">L</span>
                        </div>
                        <span class="text-lg font-medium text-neutral-900">Lunaray</span>
                    </a>
                    
                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ route('home') }}" class="text-neutral-600 hover:text-neutral-900 transition-colors {{ request()->routeIs('home') ? 'text-neutral-900 font-medium' : '' }}">
                            Home
                        </a>
                        <a href="{{ route('articles.index') }}" class="text-neutral-600 hover:text-neutral-900 transition-colors {{ request()->routeIs('articles.*') ? 'text-neutral-900 font-medium' : '' }}">
                            Articles
                        </a>
                        <a href="{{ route('user.chat') }}" class="text-neutral-600 hover:text-neutral-900 transition-colors">
                            Chat
                        </a>
                        <a href="#" class="text-neutral-600 hover:text-neutral-900 transition-colors">
                            About
                        </a>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="flex items-center space-x-4">
                        @auth
                            <!-- User Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 text-sm text-neutral-700 hover:text-neutral-900 focus:outline-none">
                                    <span class="hidden sm:block">{{ auth()->user()->name }}</span>
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-neutral-200 py-1 z-50">
                                    <div class="px-4 py-2 text-sm text-neutral-700 border-b border-neutral-200">
                                        <div class="font-medium">{{ auth()->user()->name }}</div>
                                        <div class="text-neutral-500">{{ auth()->user()->email }}</div>
                                    </div>
                                    
                                    @can('view admin dashboard')
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 transition-colors">
                                            Admin Dashboard
                                        </a>
                                    @else
                                        <a href="{{ route('user.chat') }}" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 transition-colors">
                                            Chat
                                        </a>
                                    @endcan
                                    
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 transition-colors">
                                        Profile Settings
                                    </a>
                                    
                                    @can('view admin dashboard')
                                        <form method="POST" action="{{ route('staff.logout') }}" class="block">
                                            @csrf
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 transition-colors">
                                                Sign Out
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('logout') }}" class="block">
                                            @csrf
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50 transition-colors">
                                                Sign Out
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        @else
                            <!-- Guest Menu -->
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('login') }}" class="bg-neutral-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-neutral-800 transition-colors">
                                    Get Started
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-neutral-50 border-t border-neutral-200">
            <div class="mx-auto max-w-4xl px-6 py-8">
                <p class="text-center text-sm text-neutral-500">
                    &copy; {{ date('Y') }} Lunaray Beauty Factory. All rights reserved.
                </p>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>

