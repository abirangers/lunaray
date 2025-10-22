@extends('layouts.app')

@section('title', 'Chatbot Configuration')
@section('pageTitle', 'Chatbot Configuration')
@section('pageDescription', 'Manage chatbot settings and monitor chat activity')

@section('content')
    <div class="max-w-7xl mx-auto" x-data="chatbotAdmin()" x-init="init()">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Chatbot Configuration</h1>
            <p class="mt-2 text-gray-600">Manage chatbot settings, monitor activity, and configure webhook integration</p>
        </div>

        <!-- Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Chatbot Status</h3>
                        <p class="text-sm text-gray-500" x-text="status.active ? 'Active' : 'Inactive'"></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Webhook Status</h3>
                        <p class="text-sm text-gray-500" x-text="status.webhook_configured ? 'Configured' : 'Not Configured'"></p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Total Sessions</h3>
                        <p class="text-sm text-gray-500" x-text="statistics.sessions?.total || 0"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Configuration Form -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Configuration Settings</h2>
            </div>
            <div class="p-6">
                <form @submit.prevent="updateConfiguration()" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Webhook URL</label>
                            <input type="url" x-model="config.webhook_url" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary"
                                   placeholder="https://your-n8n-webhook.com/webhook/chatbot">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Timeout (seconds)</label>
                            <input type="number" x-model="config.webhook_timeout" min="5" max="120"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Retry Attempts</label>
                            <input type="number" x-model="config.webhook_retry_attempts" min="1" max="5"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary focus:border-primary">
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" x-model="config.chatbot_active" 
                                   class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label class="ml-2 text-sm text-gray-700">Enable Chatbot</label>
                        </div>
                    </div>
                    
                    <div class="flex space-x-4">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Save Configuration
                        </button>
                        
                        <button type="button" @click="testWebhook()" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Test Webhook
                        </button>
                        
                        <button type="button" @click="resetConfiguration()" 
                                class="inline-flex items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Reset to Defaults
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Statistics -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Statistics</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900" x-text="statistics.sessions?.total || 0"></div>
                        <div class="text-sm text-gray-500">Total Sessions</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900" x-text="statistics.sessions?.active || 0"></div>
                        <div class="text-sm text-gray-500">Active Sessions</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900" x-text="statistics.messages?.total || 0"></div>
                        <div class="text-sm text-gray-500">Total Messages</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900" x-text="statistics.messages?.bot || 0"></div>
                        <div class="text-sm text-gray-500">Bot Responses</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Chat Logs -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Recent Chat Sessions</h2>
            </div>
            <div class="p-6">
                <div x-show="loading" class="text-center py-4">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary mx-auto"></div>
                </div>
                
                <div x-show="!loading && chatLogs.length === 0" class="text-center py-8 text-gray-500">
                    No chat sessions found
                </div>
                
                <div x-show="!loading && chatLogs.length > 0" class="space-y-4">
                    <template x-for="session in chatLogs" :key="session.id">
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium text-gray-900" x-text="session.user?.name || 'Unknown User'"></span>
                                    <span class="text-xs text-gray-500" x-text="formatTime(session.last_activity_at)"></span>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                      :class="session.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'"
                                      x-text="session.status"></span>
                            </div>
                            <div class="text-sm text-gray-600" x-text="session.messages?.length || 0 + ' messages'"></div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function chatbotAdmin() {
            return {
                loading: false,
                config: {
                    webhook_url: '',
                    webhook_timeout: 30,
                    webhook_retry_attempts: 3,
                    chatbot_active: true
                },
                status: {
                    active: false,
                    webhook_configured: false
                },
                statistics: {
                    sessions: { total: 0, active: 0 },
                    messages: { total: 0, bot: 0 }
                },
                chatLogs: [],

                async init() {
                    await this.loadConfiguration();
                    await this.loadStatistics();
                    await this.loadChatLogs();
                },

                async loadConfiguration() {
                    try {
                        const response = await fetch('/api/admin/chatbot/config');
                        const data = await response.json();
                        
                        this.config = {
                            webhook_url: data.configurations.find(c => c.key === 'webhook_url')?.value || '',
                            webhook_timeout: data.configurations.find(c => c.key === 'webhook_timeout')?.value || 30,
                            webhook_retry_attempts: data.configurations.find(c => c.key === 'webhook_retry_attempts')?.value || 3,
                            chatbot_active: data.configurations.find(c => c.key === 'chatbot_active')?.value === 'true'
                        };
                        
                        this.status = data.status;
                    } catch (error) {
                        console.error('Failed to load configuration:', error);
                    }
                },

                async loadStatistics() {
                    try {
                        const response = await fetch('/api/admin/chatbot/statistics');
                        const data = await response.json();
                        this.statistics = data;
                    } catch (error) {
                        console.error('Failed to load statistics:', error);
                    }
                },

                async loadChatLogs() {
                    try {
                        this.loading = true;
                        const response = await fetch('/api/admin/chatbot/logs');
                        const data = await response.json();
                        this.chatLogs = data.sessions || [];
                    } catch (error) {
                        console.error('Failed to load chat logs:', error);
                    } finally {
                        this.loading = false;
                    }
                },

                async updateConfiguration() {
                    try {
                        const response = await fetch('/api/admin/chatbot/config', {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                key: 'webhook_url',
                                value: this.config.webhook_url,
                                description: 'n8n webhook URL for chatbot integration'
                            })
                        });

                        if (response.ok) {
                            alert('Configuration updated successfully!');
                            await this.loadConfiguration();
                        } else {
                            alert('Failed to update configuration');
                        }
                    } catch (error) {
                        console.error('Failed to update configuration:', error);
                        alert('Error updating configuration');
                    }
                },

                async testWebhook() {
                    try {
                        const response = await fetch('/api/admin/chatbot/test-webhook', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            alert('Webhook test successful! Response time: ' + data.response_time + 's');
                        } else {
                            alert('Webhook test failed: ' + data.error);
                        }
                    } catch (error) {
                        console.error('Failed to test webhook:', error);
                        alert('Error testing webhook');
                    }
                },

                async resetConfiguration() {
                    if (confirm('Are you sure you want to reset all configuration to defaults?')) {
                        try {
                            const response = await fetch('/api/admin/chatbot/reset', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            });

                            if (response.ok) {
                                alert('Configuration reset to defaults!');
                                await this.loadConfiguration();
                            } else {
                                alert('Failed to reset configuration');
                            }
                        } catch (error) {
                            console.error('Failed to reset configuration:', error);
                            alert('Error resetting configuration');
                        }
                    }
                },

                formatTime(timestamp) {
                    if (!timestamp) return 'Unknown';
                    const date = new Date(timestamp);
                    return date.toLocaleString();
                }
            }
        }
    </script>
    @endpush
@endsection
