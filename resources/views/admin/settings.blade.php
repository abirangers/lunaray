@extends('layouts.admin')

@section('title', 'System Settings - Lunaray Beauty Factory')
@section('pageTitle', 'System Settings')
@section('pageDescription', 'Configure system settings, manage integrations, and maintain the Lunaray Beauty Factory platform')

@section('content')
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
@endsection
