@extends('layouts.auth')

@section('title', 'Login - Lunaray Beauty Factory')
@section('header', 'Lunaray Beauty Factory')
@section('subheader', 'Science Meets Beauty')

@section('content')
<form class="space-y-5" action="{{ route('login') }}" method="POST" x-data="{ loading: false }" @submit="loading = true">
    @csrf

    <!-- Email Field -->
    <div>
        <label for="email" class="block text-sm font-semibold text-white mb-2">
            Email Address
        </label>
        <input
            id="email"
            name="email"
            type="email"
            autocomplete="email"
            required
            value="{{ old('email') }}"
            class="w-full px-4 py-3 bg-white/10 border border-cyan-400/30 rounded-lg text-white placeholder-neutral-400
                   focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent
                   backdrop-blur-sm transition duration-300
                   @error('email') border-red-500 ring-2 ring-red-500 @enderror"
            placeholder="Enter your email">
        @error('email')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password Field -->
    <div>
        <label for="password" class="block text-sm font-semibold text-white mb-2">
            Password
        </label>
        <input
            id="password"
            name="password"
            type="password"
            autocomplete="current-password"
            required
            class="w-full px-4 py-3 bg-white/10 border border-cyan-400/30 rounded-lg text-white placeholder-neutral-400
                   focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent
                   backdrop-blur-sm transition duration-300
                   @error('password') border-red-500 ring-2 ring-red-500 @enderror"
            placeholder="Enter your password">
        @error('password')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Remember Me -->
    <div class="flex items-center">
        <input
            id="remember"
            name="remember"
            type="checkbox"
            class="h-4 w-4 text-cyan-400 focus:ring-cyan-400 focus:ring-offset-0
                   border-cyan-400/30 rounded bg-white/10 backdrop-blur-sm">
        <label for="remember" class="ml-2 block text-sm text-neutral-300">
            Remember me
        </label>
    </div>

    <!-- Submit Button -->
    <button
        type="submit"
        class="w-full bg-gradient-to-r from-cyan-400 to-blue-600 text-white font-bold py-3 px-6 rounded-lg
               hover:from-cyan-300 hover:to-blue-500
               focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-[#000d1a]
               shadow-lg shadow-cyan-400/30 transition duration-300 transform hover:scale-[1.02]"
        :disabled="loading"
        :class="{ 'opacity-50 cursor-not-allowed': loading }">
        <span x-show="!loading" class="flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
            Sign In
        </span>
        <span x-show="loading" class="flex items-center justify-center">
            <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Signing in...
        </span>
    </button>
</form>

<!-- Tech decoration -->
<div class="mt-6 pt-6 border-t border-cyan-400/20">
    <p class="text-center text-xs text-neutral-400">
        Secured by advanced encryption technology
    </p>
</div>
@endsection

@section('footerLinks')
    <a href="#" class="text-xs text-cyan-400 hover:text-cyan-300 transition duration-300">Privacy Policy</a>
    <span class="text-neutral-600">|</span>
    <a href="#" class="text-xs text-cyan-400 hover:text-cyan-300 transition duration-300">Terms of Service</a>
@endsection
