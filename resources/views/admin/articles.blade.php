<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Management - Lunaray Beauty Factory</title>
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
                    <a href="/admin/dashboard" class="text-gray-700 hover:text-purple-600">Dashboard</a>
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
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-xl rounded-lg mb-8">
                <div class="px-4 py-5 sm:p-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">
                        Article Management 📝
                    </h1>
                    <p class="text-lg text-gray-600 mb-6">
                        Manage articles, categories, and content for the Lunaray Beauty Factory website.
                    </p>
                    
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-4">
                            <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Create New Article
                            </button>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Manage Categories
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Articles Table -->
            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">All Articles</h2>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Article
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Category
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Author
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Created
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No articles found. Create your first article to get started.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Content Management Features -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Create Article -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Create Article</h3>
                                <p class="text-sm text-gray-500">Write new content for the website</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button class="text-green-600 hover:text-green-500 font-medium">Create New →</button>
                        </div>
                    </div>
                </div>

                <!-- Manage Categories -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Categories</h3>
                                <p class="text-sm text-gray-500">Organize content by categories</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button class="text-blue-600 hover:text-blue-500 font-medium">Manage →</button>
                        </div>
                    </div>
                </div>

                <!-- SEO Management -->
                <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">SEO Management</h3>
                                <p class="text-sm text-gray-500">Optimize content for search engines</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button class="text-yellow-600 hover:text-yellow-500 font-medium">Manage SEO →</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
