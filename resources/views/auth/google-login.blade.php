@extends('layouts.auth')

@section('title', 'Welcome to Lunaray - Beauty Factory')
@section('header', 'Welcome to Lunaray')
@section('subheader', 'Beauty Factory - Your Trusted Partner')

@section('content')
    <div class="space-y-6">
        <!-- Google OAuth Button -->
        <div>
            <a href="/auth/google/redirect" 
               class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-300 transform hover:scale-105">
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-white" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                </span>
                Continue with Google
            </a>
        </div>

        <!-- Staff Login Link -->
        <div class="text-center">
            <p class="text-sm text-gray-600">
                Are you a staff member?
                <a href="/staff/login" class="font-medium text-primary hover:text-accent transition-all duration-300">
                    Staff Login
                </a>
            </p>
        </div>
    </div>

    <!-- Features -->
    <div class="mt-8">
        <div class="text-center">
            <h3 class="text-lg font-medium text-primary mb-4">What you can do:</h3>
            <div class="space-y-3">
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="h-5 w-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Read our latest articles
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="h-5 w-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Get instant support via chatbot
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="h-5 w-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Access exclusive content
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footerLinks')
    <a href="#" class="text-gray-600 hover:text-primary">Terms of Service</a>
    <a href="#" class="text-gray-600 hover:text-primary">Privacy Policy</a>
@endsection
