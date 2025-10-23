<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" x-data="darkMode">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Authentication - Lunaray Beauty Factory')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full bg-neutral-50 dark:bg-neutral-900 overflow-hidden">
    <div class="h-full flex items-center justify-center p-4 sm:p-6">
        <div class="w-full max-w-sm">
            <!-- Logo -->
            <div class="text-center mb-6 sm:mb-8">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-primary-600 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <span class="text-white text-base sm:text-lg font-bold">L</span>
                </div>
                <h1 class="text-lg sm:text-xl font-semibold text-neutral-900 dark:text-white">
                    @yield('header', 'Welcome Back')
                </h1>
                @hasSection('subheader')
                    <p class="mt-1 text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">
                        @yield('subheader')
                    </p>
                @endif
            </div>

            <!-- Main Content -->
            <div class="bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700">
                <div class="p-4 sm:p-6">
                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-3 sm:mt-4 text-center">
                <a href="{{ route('home') }}" class="text-xs sm:text-sm text-neutral-500 dark:text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-200">
                    ← Back to Home
                </a>
                @hasSection('footerLinks')
                    <div class="mt-2 space-x-3 sm:space-x-4">
                        @yield('footerLinks')
                    </div>
                @endif
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>

