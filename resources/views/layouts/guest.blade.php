<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Tags -->
    @if(isset($article))
        {!! seo($article) !!}
    @elseif(request()->routeIs('home'))
        {!! seo(new \RalphJSmit\Laravel\SEO\Support\SEOData(
            title: 'Lunaray Beauty Factory - Solusi Total untuk Kosmetik Berkualitas',
            description: 'Solusi total untuk kosmetik berkualitas. Membantu brand kosmetik tumbuh melalui inovasi, legalitas resmi, dan layanan menyeluruh dari ide hingga produk siap edar.',
            url: route('home')
        )) !!}
    @elseif(request()->routeIs('articles.index'))
        {!! seo(new \RalphJSmit\Laravel\SEO\Support\SEOData(
            title: 'Beauty Articles - Tips & Tutorials',
            description: 'Discover the latest beauty tips, tutorials, and insights from our experts. Learn about cosmetics manufacturing, beauty trends, and industry best practices.',
            url: route('articles.index')
        )) !!}
    @else
        {!! seo() !!}
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
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
                        @can('access chat')
                            <a href="{{ route('user.chat') }}" class="text-neutral-600 hover:text-neutral-900 transition-colors">
                                Chat
                            </a>
                        @endcan
                        <a href="#" class="text-neutral-600 hover:text-neutral-900 transition-colors">
                            About
                        </a>
                    </div>
                    
                    <!-- CTA Button / User Menu -->
                    @auth
                        @if(auth()->user()->hasRole(['admin', 'content_manager']))
                            <!-- Staff User Menu -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 text-sm text-neutral-700 hover:text-neutral-900 focus:outline-none transition-colors duration-200">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" 
                                             class="h-8 w-8 rounded-full object-cover">
                                    @else
                                        <div class="h-8 w-8 rounded-full bg-primary flex items-center justify-center">
                                            <span class="text-white text-xs font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <span class="hidden sm:block">{{ auth()->user()->name }}</span>
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-neutral-200">
                                    <div class="px-4 py-2 text-sm text-neutral-700 border-b border-neutral-200">
                                        <div class="font-medium">{{ auth()->user()->name }}</div>
                                        <div class="text-neutral-500 text-xs">{{ ucfirst(auth()->user()->roles->first()->name ?? 'user') }}</div>
                                    </div>
                                    
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100 transition-colors duration-200">
                                        Dashboard
                                    </a>
                                    
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100 transition-colors duration-200">
                                        Profile
                                    </a>
                                    
                                    <form method="POST" action="{{ route('staff.logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100 transition-colors duration-200">
                                            Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <!-- Regular User Menu -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 text-sm text-neutral-700 hover:text-neutral-900 focus:outline-none transition-colors duration-200">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" 
                                             class="h-8 w-8 rounded-full object-cover">
                                    @else
                                        <div class="h-8 w-8 rounded-full bg-primary flex items-center justify-center">
                                            <span class="text-white text-xs font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <span class="hidden sm:block">{{ auth()->user()->name }}</span>
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-neutral-200">
                                    <div class="px-4 py-2 text-sm text-neutral-700 border-b border-neutral-200">
                                        <div class="font-medium">{{ auth()->user()->name }}</div>
                                        <div class="text-neutral-500 text-xs">{{ auth()->user()->email }}</div>
                                    </div>
                                    
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100 transition-colors duration-200">
                                        Profile
                                    </a>
                                    
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-100 transition-colors duration-200">
                                            Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- CTA Button for Guests -->
                    <a href="{{ route('login') }}" class="bg-neutral-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-neutral-800 transition-colors">
                        Get Started
                    </a>
                    @endauth
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

