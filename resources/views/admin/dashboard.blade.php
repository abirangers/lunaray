<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Lunaray Beauty Factory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gradient-to-br from-purple-50 to-indigo-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <div class="h-8 w-8 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-bold">L</span>
                        </div>
                        <span class="ml-2 text-xl font-bold text-gray-900">Lunaray Admin</span>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Welcome, {{ Auth::user()->name }}!</span>
                    <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs font-medium rounded-full">
                        {{ Auth::user()->getRoleNames()->first() }}
                    </span>
                    <form action="/staff/logout" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow-xl rounded-lg mb-8">
                <div class="px-4 py-5 sm:p-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">
                        Admin Dashboard 🚀
                    </h1>
                    <p class="text-lg text-gray-600 mb-6">
                        Welcome to the Lunaray Beauty Factory admin panel. You have 
                        <span class="font-semibold text-purple-600">{{ Auth::user()->getRoleNames()->first() }}</span> 
                        privileges.
                    </p>
                    
                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">0</div>
                            <div class="text-sm text-blue-800">Total Users</div>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">0</div>
                            <div class="text-sm text-green-800">Articles</div>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-yellow-600">0</div>
                            <div class="text-sm text-yellow-800">Categories</div>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-purple-600">0</div>
                            <div class="text-sm text-purple-800">Chat Sessions</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Features -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Content Management -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Content Management</h3>
                                <p class="text-sm text-gray-500">Manage articles and categories</p>
                            </div>
                        </div>
                        <div class="mt-4 space-y-2">
                            <a href="/admin/articles" class="block text-blue-600 hover:text-blue-500 font-medium">Manage Articles →</a>
                            <a href="#" class="block text-blue-600 hover:text-blue-500 font-medium">Manage Categories →</a>
                        </div>
                    </div>
                </div>

                <!-- User Management -->
                @if(Auth::user()->hasRole('admin'))
                <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">User Management</h3>
                                <p class="text-sm text-gray-500">Manage users and roles</p>
                            </div>
                        </div>
                        <div class="mt-4 space-y-2">
                            <a href="/admin/users" class="block text-red-600 hover:text-red-500 font-medium">Manage Users →</a>
                            <a href="/staff/register" class="block text-red-600 hover:text-red-500 font-medium">Create Staff →</a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- System Settings -->
                @if(Auth::user()->hasRole('admin'))
                <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">System Settings</h3>
                                <p class="text-sm text-gray-500">Configure system settings</p>
                            </div>
                        </div>
                        <div class="mt-4 space-y-2">
                            <a href="/admin/settings" class="block text-yellow-600 hover:text-yellow-500 font-medium">System Settings →</a>
                            <a href="#" class="block text-yellow-600 hover:text-yellow-500 font-medium">Backup & Restore →</a>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Recent Activity -->
            <div class="mt-8 bg-white overflow-hidden shadow-xl rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Recent Activity</h2>
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No recent activity</h3>
                        <p class="mt-1 text-sm text-gray-500">Activity will appear here as users interact with the system.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
