<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Authentication - Lunaray Beauty Factory')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|playfair-display:400,500,600,700|jetbrains-mono:400,500,600" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full bg-gradient-to-br from-primary/5 via-secondary/5 to-accent/5">
    <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="flex justify-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="h-12 w-12 rounded-full bg-primary flex items-center justify-center">
                        <span class="text-white font-bold text-lg">L</span>
                    </div>
                    <span class="text-2xl font-serif font-semibold text-primary">Lunaray</span>
                </a>
            </div>
            <h2 class="mt-6 text-center text-3xl font-serif font-bold text-gray-900">
                @yield('header', 'Welcome Back')
            </h2>
            @hasSection('subheader')
                <p class="mt-2 text-center text-sm text-gray-600">
                    @yield('subheader')
                </p>
            @endif
        </div>

        <!-- Main Content -->
        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-xl rounded-lg sm:px-10 border border-gray-200">
                @yield('content')
            </div>
        </div>

        <!-- Footer Links -->
        <div class="mt-8 text-center">
            <div class="flex justify-center space-x-6 text-sm">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary">
                    ← Back to Home
                </a>
                @hasSection('footerLinks')
                    @yield('footerLinks')
                @endif
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>

