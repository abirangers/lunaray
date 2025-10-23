@extends('layouts.auth')

@section('title', 'Staff Login - Lunaray Beauty Factory')
@section('header', 'Staff Portal')
@section('subheader', 'Content Management & Administration')

@section('content')
    <form class="space-y-4" action="/staff/login" method="POST" x-data="{ loading: false }" @submit="loading = true">
        @csrf
        
        <!-- Email Field -->
        <div>
            <label for="email" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Email</label>
            <input id="email" 
                   name="email" 
                   type="email" 
                   autocomplete="email" 
                   required 
                   class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-md text-neutral-900 dark:text-white bg-white dark:bg-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('email') border-red-500 @enderror"
                   placeholder="Enter your email"
                   value="{{ old('email') }}">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Field -->
        <div>
            <label for="password" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Password</label>
            <input id="password" 
                   name="password" 
                   type="password" 
                   autocomplete="current-password" 
                   required 
                   class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-md text-neutral-900 dark:text-white bg-white dark:bg-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('password') border-red-500 @enderror"
                   placeholder="Enter your password">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember-me" 
                   name="remember-me" 
                   type="checkbox" 
                   class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 dark:border-neutral-600 rounded">
            <label for="remember-me" class="ml-2 block text-sm text-neutral-700 dark:text-neutral-300">
                Remember me
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full bg-primary-600 text-white py-2 px-4 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors"
                :disabled="loading"
                :class="{ 'opacity-50 cursor-not-allowed': loading }">
            <span x-show="!loading">Sign In</span>
            <span x-show="loading">Signing in...</span>
        </button>
    </form>
@endsection
