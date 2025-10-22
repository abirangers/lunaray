@extends('layouts.app')

@section('title', 'AI Chatbot')
@section('pageTitle', 'AI Chatbot')
@section('pageDescription', 'Get instant support with our AI chatbot')

@section('content')
    <!-- Chat Interface -->
    <div class="max-w-4xl mx-auto" x-data="chatbot()" x-init="init()">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <!-- Chat Header -->
            <div class="bg-primary text-white px-6 py-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h1 class="text-xl font-semibold">Lunaray AI Assistant</h1>
                        <p class="text-primary/80 text-sm">Your beauty expert is here to help</p>
                    </div>
                    <div class="ml-auto">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                              :class="status.active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                            <span x-text="status.active ? 'Online' : 'Offline'"></span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Chat Messages -->
            <div class="h-96 overflow-y-auto p-6 space-y-4" x-ref="chatMessages">
                <!-- Loading State -->
                <div x-show="loading" class="flex items-center justify-center py-8">
                    <div class="flex items-center space-x-2">
                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-primary"></div>
                        <span class="text-gray-500">Loading chat...</span>
                    </div>
                </div>

                <!-- Messages -->
                <template x-for="message in messages" :key="message.id">
                    <div class="flex items-start space-x-3" :class="message.type === 'user' ? 'flex-row-reverse space-x-reverse' : ''">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full flex items-center justify-center" 
                                 :class="message.type === 'user' ? 'bg-secondary' : 'bg-primary'">
                                <span x-show="message.type === 'user'" class="text-primary font-medium text-sm">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </span>
                                <svg x-show="message.type !== 'user'" class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="rounded-lg px-4 py-2" 
                                 :class="message.type === 'user' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-900'">
                                <div x-html="message.formatted_content || message.content"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1" x-text="formatTime(message.sent_at)"></p>
                        </div>
                    </div>
                </template>

                <!-- Typing Indicator -->
                <div x-show="typing" class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 bg-primary rounded-full flex items-center justify-center">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="bg-gray-100 rounded-lg px-4 py-2">
                            <div class="flex space-x-1">
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Input -->
            <div class="border-t bg-gray-50 px-6 py-4">
                <form @submit.prevent="sendMessage()" class="flex space-x-4">
                    @csrf
                    <div class="flex-1">
                        <input 
                            type="text" 
                            x-model="newMessage"
                            placeholder="Type your message here..." 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            :disabled="loading || !status.active"
                            required
                        >
                    </div>
                    <button 
                        type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary disabled:opacity-50"
                        :disabled="loading || !status.active || !newMessage.trim()"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-6" x-show="status.active">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Questions</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <button @click="sendQuickQuestion('What services do you offer?')" 
                        class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow text-left">
                    <h4 class="font-medium text-gray-900">What services do you offer?</h4>
                    <p class="text-sm text-gray-500 mt-1">Learn about our beauty manufacturing services</p>
                </button>
                
                <button @click="sendQuickQuestion('How to get started?')" 
                        class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow text-left">
                    <h4 class="font-medium text-gray-900">How to get started?</h4>
                    <p class="text-sm text-gray-500 mt-1">Find out how to begin your beauty journey</p>
                </button>
                
                <button @click="sendQuickQuestion('What are your product quality standards?')" 
                        class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow text-left">
                    <h4 class="font-medium text-gray-900">Product quality standards</h4>
                    <p class="text-sm text-gray-500 mt-1">Learn about our quality assurance</p>
                </button>
            </div>
        </div>

        <!-- Offline Message -->
        <div x-show="!status.active" class="mt-6">
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Chatbot Temporarily Unavailable</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>The chatbot is currently offline. Please try again later or contact our support team directly.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function chatbot() {
            return {
                messages: [],
                newMessage: '',
                loading: false,
                typing: false,
                sessionId: null,
                status: {
                    active: false,
                    webhook_configured: false
                },

                async init() {
                    await this.checkStatus();
                    if (this.status.active) {
                        await this.getSession();
                        await this.loadHistory();
                    }
                },

                async checkStatus() {
                    try {
                        const response = await fetch('/api/chatbot/status');
                        const data = await response.json();
                        this.status = data;
                    } catch (error) {
                        console.error('Failed to check status:', error);
                    }
                },

                async getSession() {
                    try {
                        const response = await fetch('/api/chatbot/session');
                        const data = await response.json();
                        this.sessionId = data.session_id;
                    } catch (error) {
                        console.error('Failed to get session:', error);
                    }
                },

                async loadHistory() {
                    if (!this.sessionId) return;
                    
                    try {
                        this.loading = true;
                        const response = await fetch(`/api/chatbot/history?session_id=${this.sessionId}`);
                        const data = await response.json();
                        this.messages = data.messages || [];
                        this.scrollToBottom();
                    } catch (error) {
                        console.error('Failed to load history:', error);
                    } finally {
                        this.loading = false;
                    }
                },

                async sendMessage() {
                    if (!this.newMessage.trim() || this.loading || !this.status.active) return;

                    const message = this.newMessage.trim();
                    this.newMessage = '';
                    this.typing = true;

                    try {
                        const response = await fetch('/api/chatbot/send', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                session_id: this.sessionId,
                                message: message
                            })
                        });

                        const data = await response.json();
                        
                        if (data.user_message) {
                            this.messages.push(data.user_message);
                        }
                        
                        if (data.bot_message) {
                            this.messages.push(data.bot_message);
                        }

                        this.scrollToBottom();
                    } catch (error) {
                        console.error('Failed to send message:', error);
                        this.messages.push({
                            id: Date.now(),
                            type: 'system',
                            content: 'Sorry, there was an error sending your message. Please try again.',
                            sent_at: new Date().toISOString()
                        });
                    } finally {
                        this.typing = false;
                    }
                },

                async sendQuickQuestion(question) {
                    this.newMessage = question;
                    await this.sendMessage();
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        const chatMessages = this.$refs.chatMessages;
                        if (chatMessages) {
                            chatMessages.scrollTop = chatMessages.scrollHeight;
                        }
                    });
                },

                formatTime(timestamp) {
                    const date = new Date(timestamp);
                    const now = new Date();
                    const diff = now - date;
                    
                    if (diff < 60000) { // Less than 1 minute
                        return 'Just now';
                    } else if (diff < 3600000) { // Less than 1 hour
                        return Math.floor(diff / 60000) + 'm ago';
                    } else if (diff < 86400000) { // Less than 1 day
                        return Math.floor(diff / 3600000) + 'h ago';
                    } else {
                        return date.toLocaleDateString();
                    }
                }
            }
        }
    </script>
    @endpush
@endsection
