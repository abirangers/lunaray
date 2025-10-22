<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Settings - Lunaray Beauty Factory</title>
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
                        System Settings ⚙️
                    </h1>
                    <p class="text-lg text-gray-600 mb-6">
                        Configure system settings, manage integrations, and maintain the Lunaray Beauty Factory platform.
                    </p>
                </div>
            </div>

            <!-- Settings Sections -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- General Settings -->
                <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">General Settings</h2>
                        
                        <form class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Site Name</label>
                                <input type="text" value="Lunaray Beauty Factory" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Site Description</label>
                                <textarea rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">Your trusted partner in beauty manufacturing</textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Admin Email</label>
                                <input type="email" value="admin@lunaray.com" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                            </div>
                            
                            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Save Settings
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Authentication Settings -->
                <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Authentication Settings</h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Google OAuth</h3>
                                    <p class="text-sm text-gray-500">Enable Google OAuth for public users</p>
                                </div>
                                <div class="relative inline-block w-10 mr-2 align-middle select-none">
                                    <input type="checkbox" checked class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                    <label class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Staff Authentication</h3>
                                    <p class="text-sm text-gray-500">Enable email/password for staff</p>
                                </div>
                                <div class="relative inline-block w-10 mr-2 align-middle select-none">
                                    <input type="checkbox" checked class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                    <label class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Two-Factor Authentication</h3>
                                    <p class="text-sm text-gray-500">Require 2FA for staff accounts</p>
                                </div>
                                <div class="relative inline-block w-10 mr-2 align-middle select-none">
                                    <input type="checkbox" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                    <label class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email Settings -->
                <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Email Settings</h2>
                        
                        <form class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">SMTP Host</label>
                                <input type="text" placeholder="smtp.gmail.com" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">SMTP Port</label>
                                <input type="number" placeholder="587" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">From Email</label>
                                <input type="email" placeholder="noreply@lunaray.com" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                            </div>
                            
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                Test Email
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Backup & Maintenance -->
                <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Backup & Maintenance</h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Database Backup</h3>
                                    <p class="text-sm text-gray-500">Last backup: Never</p>
                                </div>
                                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                    Create Backup
                                </button>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">Cache Management</h3>
                                    <p class="text-sm text-gray-500">Clear application cache</p>
                                </div>
                                <button class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                    Clear Cache
                                </button>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">System Logs</h3>
                                    <p class="text-sm text-gray-500">View and manage system logs</p>
                                </div>
                                <button class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                    View Logs
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
