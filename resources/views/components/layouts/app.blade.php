<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Lunaray Beauty Factory' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|playfair-display:400,500,600,700|jetbrains-mono:400,500,600" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full bg-neutral-50 font-sans antialiased">
    <div class="min-h-full">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex flex-shrink-0 items-center">
                            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                                <div class="h-8 w-8 rounded-full bg-primary flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">L</span>
                                </div>
                                <span class="text-xl font-serif font-semibold text-primary">Lunaray</span>
                            </a>
                        </div>
                        
                        <!-- Navigation Links -->
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="{{ route('home') }}" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 {{ request()->routeIs('home') ? 'border-primary text-primary' : '' }}">
                                Home
                            </a>
                            <a href="#" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                                Products
                            </a>
                            <a href="#" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                                About
                            </a>
                        </div>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="flex items-center space-x-4">
                        @auth
                            <!-- User Dropdown -->
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
                                    
                                    @can('view admin dashboard')
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Admin Dashboard
                                        </a>
                                    @else
                                        <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Dashboard
                                        </a>
                                    @endcan
                                    
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Profile Settings
                                    </a>
                                    
                                    @can('view admin dashboard')
                                        <form method="POST" action="{{ route('staff.logout') }}" class="block">
                                            @csrf
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Sign Out
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('logout') }}" class="block">
                                            @csrf
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Sign Out
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        @else
                            <!-- Guest Menu -->
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    Sign In
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="h-8 w-8 rounded-full bg-primary flex items-center justify-center">
                                <span class="text-white font-bold text-sm">L</span>
                            </div>
                            <span class="text-xl font-serif font-semibold text-primary">Lunaray Beauty Factory</span>
                        </div>
                        <p class="text-gray-600 text-sm">
                            Your trusted partner in beauty and cosmetics manufacturing. 
                            Creating exceptional products for the modern beauty industry.
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-4">Company</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-sm text-gray-600 hover:text-primary">About Us</a></li>
                            <li><a href="#" class="text-sm text-gray-600 hover:text-primary">Our Services</a></li>
                            <li><a href="#" class="text-sm text-gray-600 hover:text-primary">Contact</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-4">Support</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-sm text-gray-600 hover:text-primary">Help Center</a></li>
                            <li><a href="#" class="text-sm text-gray-600 hover:text-primary">Privacy Policy</a></li>
                            <li><a href="#" class="text-sm text-gray-600 hover:text-primary">Terms of Service</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <p class="text-center text-sm text-gray-500">
                        &copy; {{ date('Y') }} Lunaray Beauty Factory. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
