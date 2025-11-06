<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
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
<body class="h-full bg-[#000d1a] overflow-hidden">
    <!-- Background decorative elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Hexagonal pattern overlay -->
        <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(0deg, transparent, transparent 50px, #22d3ee 50px, #22d3ee 51px), repeating-linear-gradient(90deg, transparent, transparent 50px, #22d3ee 50px, #22d3ee 51px);"></div>

        <!-- Glowing cyan accents -->
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-cyan-400 rounded-full opacity-10 blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-cyan-400 rounded-full opacity-5 blur-3xl"></div>
    </div>

    <div class="relative h-full flex items-center justify-center p-4 sm:p-6">
        <div class="w-full max-w-md">
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-cyan-400 to-blue-600 rounded-xl mb-4 shadow-lg shadow-cyan-400/50">
                    <span class="text-white text-2xl sm:text-3xl font-bold">L</span>
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-2">
                    @yield('header', 'Welcome Back')
                </h1>
                @hasSection('subheader')
                    <p class="text-sm sm:text-base text-cyan-300">
                        @yield('subheader')
                    </p>
                @endif
            </div>

            <!-- Main Content Card -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl border border-cyan-400/30 shadow-xl overflow-hidden">
                <div class="p-6 sm:p-8">
                    @if(session('error'))
                        <div class="mb-4 p-3 bg-red-500/20 border border-red-500/50 rounded-lg text-red-300 text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mb-4 p-3 bg-cyan-500/20 border border-cyan-500/50 rounded-lg text-cyan-300 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}"
                   class="inline-flex items-center text-sm text-cyan-400 hover:text-cyan-300 transition duration-300">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Home
                </a>
                @hasSection('footerLinks')
                    <div class="mt-4 space-x-4">
                        @yield('footerLinks')
                    </div>
                @endif
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
