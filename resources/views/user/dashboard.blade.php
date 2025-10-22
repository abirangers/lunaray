<x-layouts.app pageTitle="User Dashboard" pageDescription="Welcome to your personal dashboard">
    <!-- Welcome Section -->
    <div class="bg-white overflow-hidden shadow-xl rounded-lg mb-8">
        <div class="px-4 py-5 sm:p-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                Welcome to Lunaray! 🎉
            </h1>
            <p class="text-lg text-gray-600 mb-6">
                You have successfully logged in using 
                <span class="font-semibold text-primary">Google OAuth</span> 
                authentication.
            </p>
            
            <!-- User Info Card -->
            <div class="bg-gradient-to-r from-primary/5 to-secondary/5 rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Your Account Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Name</p>
                        <p class="text-lg text-gray-900">{{ Auth::user()->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Email</p>
                        <p class="text-lg text-gray-900">{{ Auth::user()->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Role</p>
                        <p class="text-lg text-gray-900">{{ Auth::user()->getRoleNames()->first() }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Login Method</p>
                        <p class="text-lg text-gray-900">
                            @if(Auth::user()->google_id)
                                Google OAuth
                            @else
                                Email/Password
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Chatbot Card -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">AI Chatbot</h3>
                        <p class="text-sm text-gray-500">Get instant support and answers</p>
                    </div>
                </div>
                <div class="mt-4">
                    @can('access chat')
                        <a href="{{ route('user.chat') }}" class="text-green-600 hover:text-green-500 font-medium">Start Chat →</a>
                    @else
                        <span class="text-gray-400 font-medium">Chat not available</span>
                    @endcan
                </div>
            </div>
        </div>

        <!-- Articles Card -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Articles</h3>
                        <p class="text-sm text-gray-500">Read our latest content</p>
                    </div>
                </div>
                <div class="mt-4">
                    @can('view articles')
                        <a href="#" class="text-blue-600 hover:text-blue-500 font-medium">View Articles →</a>
                    @else
                        <span class="text-gray-400 font-medium">Articles not available</span>
                    @endcan
                </div>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Profile</h3>
                        <p class="text-sm text-gray-500">Manage your account</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="#" class="text-purple-600 hover:text-purple-500 font-medium">Edit Profile →</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Information Section -->
    <div class="mt-8 bg-white overflow-hidden shadow-xl rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">What You Can Do</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium text-gray-900">AI Chatbot Support</h3>
                        <p class="text-sm text-gray-500">Get instant answers to your questions about our beauty products and services.</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium text-gray-900">Read Articles</h3>
                        <p class="text-sm text-gray-500">Access our latest beauty tips, product guides, and industry insights.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
