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
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full bg-gradient-to-br from-primary/5 via-secondary/5 to-accent/5">
    <div class="min-h-full">
        <!-- Navigation -->
        <nav class="bg-white/80 backdrop-blur-sm shadow-sm border-b border-gray-200">
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
                            <a href="#" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                                Contact
                            </a>
                        </div>
                    </div>
                    
                    <!-- CTA Button -->
                    <div class="flex items-center">
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors duration-200">
                            Get Started
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        @hasSection('showHero')
            <div class="relative bg-gradient-to-r from-primary to-secondary">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                    <div class="text-center">
                        <h1 class="text-4xl md:text-6xl font-serif font-bold text-white mb-6">
                            @yield('heroTitle', 'Beauty Manufacturing Excellence')
                        </h1>
                        <p class="text-xl text-white/90 mb-8 max-w-3xl mx-auto">
                            @yield('heroSubtitle', 'Your trusted partner in creating exceptional beauty products for the modern cosmetics industry.')
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-primary bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition-colors duration-200">
                                Start Your Journey
                            </a>
                            <a href="#" class="inline-flex items-center px-8 py-3 border-2 border-white text-base font-medium rounded-md text-white hover:bg-white hover:text-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transition-colors duration-200">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>

        <!-- Features Section -->
        @hasSection('showFeatures')
            <div class="py-16 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-serif font-bold text-gray-900 mb-4">
                            Why Choose Lunaray?
                        </h2>
                        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                            We combine cutting-edge technology with decades of beauty industry expertise.
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="text-center">
                            <div class="h-16 w-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="h-8 w-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Innovation</h3>
                            <p class="text-gray-600">Cutting-edge formulations and manufacturing processes.</p>
                        </div>
                        
                        <div class="text-center">
                            <div class="h-16 w-16 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="h-8 w-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Quality</h3>
                            <p class="text-gray-600">Rigorous testing and quality control standards.</p>
                        </div>
                        
                        <div class="text-center">
                            <div class="h-16 w-16 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="h-8 w-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Partnership</h3>
                            <p class="text-gray-600">Collaborative approach to bring your vision to life.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Footer -->
        <footer class="bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="h-8 w-8 rounded-full bg-primary flex items-center justify-center">
                                <span class="text-white font-bold text-sm">L</span>
                            </div>
                            <span class="text-xl font-serif font-semibold">Lunaray Beauty Factory</span>
                        </div>
                        <p class="text-gray-300 text-sm mb-4">
                            Your trusted partner in beauty and cosmetics manufacturing. 
                            Creating exceptional products for the modern beauty industry.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-semibold text-white mb-4">Company</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-sm text-gray-300 hover:text-white">About Us</a></li>
                            <li><a href="#" class="text-sm text-gray-300 hover:text-white">Our Services</a></li>
                            <li><a href="#" class="text-sm text-gray-300 hover:text-white">Contact</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-semibold text-white mb-4">Support</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-sm text-gray-300 hover:text-white">Help Center</a></li>
                            <li><a href="#" class="text-sm text-gray-300 hover:text-white">Privacy Policy</a></li>
                            <li><a href="#" class="text-sm text-gray-300 hover:text-white">Terms of Service</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="mt-8 pt-8 border-t border-gray-800">
                    <p class="text-center text-sm text-gray-400">
                        &copy; {{ date('Y') }} Lunaray Beauty Factory. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>

