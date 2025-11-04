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
<body class="h-full">
    <div class="min-h-full">
        <!-- Navigation -->
        @if(!View::hasSection('hideDefaultNavigation'))
        <nav class="bg-white border-b border-neutral-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between items-center">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="h-8 w-8 rounded-lg bg-neutral-900 flex items-center justify-center">
                            <span class="text-white font-bold text-sm">L</span>
                        </div>
                        <span class="text-lg font-medium text-neutral-900">Lunaray</span>
                    </a>
                    
                    <!-- Desktop Navigation Links -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ route('home') }}" class="text-neutral-700 hover:text-primary transition {{ request()->routeIs('home') ? 'text-primary font-medium' : '' }}">
                            Home
                        </a>
                        <a href="{{ route('articles.index') }}" class="text-neutral-700 hover:text-primary transition {{ request()->routeIs('articles.*') ? 'text-primary font-medium' : '' }}">
                            Articles
                        </a>
                        @auth
                            <a href="{{ route('user.chat') }}" class="text-neutral-700 hover:text-primary transition {{ request()->routeIs('user.chat') ? 'text-primary font-medium' : '' }}">
                                Chat
                            </a>
                        @endauth
                    </div>

                    <!-- User Menu / Auth Links -->
                    <div class="flex items-center space-x-4">
                        @auth
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 text-neutral-700 hover:text-primary transition">
                                    <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-neutral-200">
                                    @if(auth()->user()->hasRole(['admin', 'content_manager']))
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50">Dashboard</a>
                                    @endif
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50">Profile</a>
                                    @if(auth()->user()->hasRole(['admin', 'content_manager']))
                                        <form method="POST" action="{{ route('staff.logout') }}" class="block">
                                            @csrf
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50">Sign Out</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('logout') }}" class="block">
                                            @csrf
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-neutral-700 hover:bg-neutral-50">Sign Out</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-neutral-700 hover:text-primary transition">
                                Sign In
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden" x-data="{ mobileOpen: false }">
                        <button @click="mobileOpen = !mobileOpen" class="text-neutral-700 hover:text-primary">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        
                        <!-- Mobile Menu -->
                        <div x-show="mobileOpen" @click.away="mobileOpen = false" x-transition class="absolute top-16 left-0 right-0 bg-white border-b border-neutral-200 shadow-lg z-50">
                            <div class="px-4 py-3 space-y-3">
                                <a href="{{ route('home') }}" class="block text-neutral-700 hover:text-primary transition {{ request()->routeIs('home') ? 'text-primary font-medium' : '' }}">
                                    Home
                                </a>
                                <a href="{{ route('articles.index') }}" class="block text-neutral-700 hover:text-primary transition {{ request()->routeIs('articles.*') ? 'text-primary font-medium' : '' }}">
                                    Articles
                                </a>
                                @auth
                                    <a href="{{ route('user.chat') }}" class="block text-neutral-700 hover:text-primary transition {{ request()->routeIs('user.chat') ? 'text-primary font-medium' : '' }}">
                                        Chat
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        @endif

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

        <footer class="bg-[#2d2d2d] text-white py-12 md:py-16">
            <div class="max-w-7xl mx-auto px-6 md:px-12 lg:px-16">

                {{-- Footer Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-12">

                    {{-- Column 1: About Company --}}
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold mb-4">
                            Title Here
                        </h3>
                        <p class="text-sm leading-relaxed text-gray-300">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at dignissim nunc,
                            id maximus ex. Etiam nec dignissim elit, at dignissim enim.
                        </p>

                        {{-- Social Media Icons --}}
                        <div class="flex items-center space-x-3 pt-4">
                            <a href="#"
                                class="w-10 h-10 rounded-full bg-white flex items-center justify-center hover:bg-gray-200 transition">
                                <svg class="w-5 h-5 text-[#2d2d2d]" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-10 h-10 rounded-full bg-white flex items-center justify-center hover:bg-gray-200 transition">
                                <svg class="w-5 h-5 text-[#2d2d2d]" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-10 h-10 rounded-full bg-white flex items-center justify-center hover:bg-gray-200 transition">
                                <svg class="w-5 h-5 text-[#2d2d2d]" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-10 h-10 rounded-full bg-white flex items-center justify-center hover:bg-gray-200 transition">
                                <svg class="w-5 h-5 text-[#2d2d2d]" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Column 2: About --}}
                    <div>
                        <h3 class="text-xl font-bold mb-6">
                            About
                        </h3>
                        <ul class="space-y-3 text-sm">
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition">
                                    History
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition">
                                    Our Team
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition">
                                    Brand Guidelines
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition">
                                    Terms & Condition
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition">
                                    Privacy Policy
                                </a>
                            </li>
                        </ul>
                    </div>

                    {{-- Column 3: Services --}}
                    <div>
                        <h3 class="text-xl font-bold mb-6">
                            Services
                        </h3>
                        <ul class="space-y-3 text-sm">
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition">
                                    How to Order
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition">
                                    Our Product
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition">
                                    Order Status
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition">
                                    Promo
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition">
                                    Payment Method
                                </a>
                            </li>
                        </ul>
                    </div>

                    {{-- Column 4: Other --}}
                    <div>
                        <h3 class="text-xl font-bold mb-6">
                            Other
                        </h3>
                        <ul class="space-y-3 text-sm">
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition">
                                    Contact Us
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition">
                                    Help
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-300 hover:text-white transition">
                                    Privacy
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>
        </footer>
    </div>

    <!-- Floating Chat Component -->
    @include('components.floating-chat')

    @stack('scripts')
</body>
</html>

