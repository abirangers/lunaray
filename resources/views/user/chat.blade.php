@extends('layouts.app')

@section('title', 'AI Chatbot')
@section('pageTitle', 'AI Chatbot')
@section('pageDescription', 'Get instant support with our AI chatbot')

@section('content')
    <!-- Chat Interface -->
    <div class="max-w-4xl mx-auto" x-data="chatbot()" x-init="init()">
        <div class="bg-white border border-neutral-200 rounded-lg overflow-hidden">
            <!-- Chat Header -->
            <div class="bg-neutral-50 border-b border-neutral-200 px-4 sm:px-6 py-3 sm:py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <div class="h-8 w-8 sm:h-10 sm:w-10 bg-neutral-900 rounded-lg flex items-center justify-center">
                            <svg class="h-4 w-4 sm:h-6 sm:w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-base sm:text-lg font-semibold text-neutral-900">Lunaray AI Assistant</h1>
                            <p class="text-xs sm:text-sm text-neutral-600">Your beauty expert is here to help</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center space-x-1 sm:space-x-2">
                            <div class="w-2 h-2 rounded-full" :class="status.active ? 'bg-green-500' : 'bg-neutral-400'"></div>
                            <span class="text-xs sm:text-sm text-neutral-600" x-text="status.active ? 'Online' : 'Offline'"></span>
                        </div>
                        
                        <!-- Reset Chat Button -->
                        <button @click="resetChat()" 
                                class="inline-flex items-center px-2 py-1 border border-neutral-300 rounded-md text-xs text-neutral-600 hover:bg-neutral-50 hover:border-neutral-400 transition-colors duration-200"
                                :disabled="loading || !status.active"
                                :class="loading ? 'opacity-50 cursor-not-allowed' : 'hover:bg-red-50 hover:border-red-300 hover:text-red-600'"
                                title="Reset Chat">
                            <!-- Loading Spinner -->
                            <svg x-show="loading" class="h-3 w-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <!-- Reset Icon -->
                            <svg x-show="!loading" class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span class="ml-1 hidden sm:inline">Reset</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Chat Messages -->
            <div class="h-80 sm:h-96 overflow-y-auto p-4 sm:p-6 space-y-4 sm:space-y-6" x-ref="chatMessages">
                <!-- Loading State -->
                <div x-show="loading" class="flex items-center justify-center py-8">
                    <div class="flex items-center space-x-3">
                        <div class="animate-spin rounded-full h-5 w-5 border-2 border-neutral-300 border-t-neutral-900"></div>
                        <span class="text-neutral-600">Loading chat...</span>
                    </div>
                </div>

                <!-- Messages -->
                <template x-for="message in messages" :key="message.id">
                    <div class="mb-6" :class="message.type === 'user' ? 'flex justify-end' : 'flex justify-start'">
                        <div class="flex items-end space-x-3 max-w-xs sm:max-w-md lg:max-w-lg" 
                             :class="message.type === 'user' ? 'flex-row-reverse space-x-reverse' : ''">
                            <!-- Avatar -->
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 rounded-full flex items-center justify-center" 
                                     :class="message.type === 'user' ? 'bg-neutral-900' : 'bg-neutral-100'">
                                    <span x-show="message.type === 'user'" class="text-white font-medium text-sm">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </span>
                                    <svg x-show="message.type !== 'user'" class="h-4 w-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Message Content -->
                            <div class="flex flex-col group" :class="message.type === 'user' ? 'items-end' : 'items-start'">
                                <div class="flex items-start space-x-2" :class="message.type === 'user' ? 'flex-row-reverse space-x-reverse' : ''">
                                    <div class="rounded-2xl px-4 py-2 max-w-full" 
                                         :class="message.type === 'user' ? 'bg-neutral-900 text-white rounded-br-md' : 'bg-neutral-100 text-neutral-900 rounded-bl-md border border-neutral-200'">
                                        <div x-html="message.formatted_content || message.content" class="text-sm leading-relaxed break-words"></div>
                                    </div>
                                    
                                    <!-- Copy Button -->
                                    <button @click="copyMessage(message.content, $event)" 
                                            class="opacity-0 group-hover:opacity-100 transition-opacity duration-200 p-1 rounded-md hover:bg-neutral-200"
                                            :class="message.type === 'user' ? 'hover:bg-neutral-800' : 'hover:bg-neutral-200'"
                                            :title="message.copied ? 'Copied!' : 'Copy message'">
                                        <!-- Copy Icon -->
                                        <svg x-show="!message.copied" class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        <!-- Check Icon -->
                                        <svg x-show="message.copied" class="h-3 w-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="flex items-center space-x-1 mt-1" :class="message.type === 'user' ? 'justify-end' : 'justify-start'">
                                    <p class="text-xs text-neutral-500" x-text="formatTime(message.sent_at)"></p>
                                    <!-- Message Status (only for user messages) -->
                                    <div x-show="message.type === 'user'" class="flex items-center space-x-1">
                                        <span x-show="message.status === 'sent'" class="text-xs text-neutral-400">✓</span>
                                        <span x-show="message.status === 'delivered'" class="text-xs text-neutral-400">✓✓</span>
                                        <span x-show="message.status === 'read'" class="text-xs text-blue-500">✓✓</span>
                                        <span x-show="message.status === 'failed'" class="text-xs text-red-500" title="Failed to send">✗</span>
                                        <span x-show="!message.status" class="text-xs text-neutral-400">✓</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Typing Indicator -->
                <div x-show="typing" class="mb-6 flex justify-start">
                    <div class="flex items-end space-x-3 max-w-xs sm:max-w-md lg:max-w-lg">
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-neutral-100 flex items-center justify-center">
                                <svg class="h-4 w-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Typing Content -->
                        <div class="flex flex-col items-start">
                            <div class="bg-neutral-100 rounded-2xl rounded-bl-md px-4 py-2 border">
                                <div class="flex space-x-1">
                                    <div class="w-2 h-2 bg-neutral-400 rounded-full animate-bounce"></div>
                                    <div class="w-2 h-2 bg-neutral-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                                    <div class="w-2 h-2 bg-neutral-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Input -->
            <div class="border-t border-neutral-200 bg-neutral-50 px-4 sm:px-6 py-3 sm:py-4" x-ref="chatInput">
                <form @submit.prevent="sendMessage()" class="flex space-x-2 sm:space-x-3">
                    @csrf
                    <div class="flex-1">
                        <textarea 
                            x-model="newMessage"
                            @input="autoResize($event.target)"
                            @keydown="handleKeydown($event)"
                            placeholder="Type your message... (Enter to send, Shift+Enter for new line)" 
                            class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-neutral-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:border-transparent text-xs sm:text-sm resize-none overflow-hidden min-h-[40px] max-h-[120px]"
                            :disabled="loading || !status.active"
                            rows="1"
                            required
                        ></textarea>
                    </div>
                    <button 
                        type="submit" 
                        class="inline-flex items-center px-3 sm:px-4 py-2 sm:py-3 border border-transparent text-xs sm:text-sm font-medium rounded-lg text-white bg-neutral-900 hover:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-900 disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="loading || !status.active || !newMessage.trim()"
                    >
                        <svg class="h-3 w-3 sm:h-4 sm:w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-6 sm:mt-8" x-show="status.active">
            <h3 class="text-base sm:text-lg font-medium text-neutral-900 mb-4 sm:mb-6">Quick Questions</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                <button @click="sendQuickQuestion('What services do you offer?')" 
                        class="bg-white border border-neutral-200 p-3 sm:p-4 rounded-lg hover:border-neutral-300 hover:shadow-md hover:scale-[1.02] transition-all duration-200 cursor-pointer text-left group">
                    <h4 class="font-medium text-neutral-900 mb-1 text-sm sm:text-base group-hover:text-neutral-700 transition-colors duration-200">What services do you offer?</h4>
                    <p class="text-xs sm:text-sm text-neutral-600 group-hover:text-neutral-500 transition-colors duration-200">Learn about our beauty manufacturing services</p>
                </button>
                
                <button @click="sendQuickQuestion('How to get started?')" 
                        class="bg-white border border-neutral-200 p-3 sm:p-4 rounded-lg hover:border-neutral-300 hover:shadow-md hover:scale-[1.02] transition-all duration-200 cursor-pointer text-left group">
                    <h4 class="font-medium text-neutral-900 mb-1 text-sm sm:text-base group-hover:text-neutral-700 transition-colors duration-200">How to get started?</h4>
                    <p class="text-xs sm:text-sm text-neutral-600 group-hover:text-neutral-500 transition-colors duration-200">Find out how to begin your beauty journey</p>
                </button>
                
                <button @click="sendQuickQuestion('What are your product quality standards?')" 
                        class="bg-white border border-neutral-200 p-3 sm:p-4 rounded-lg hover:border-neutral-300 hover:shadow-md hover:scale-[1.02] transition-all duration-200 cursor-pointer text-left sm:col-span-2 lg:col-span-1 group">
                    <h4 class="font-medium text-neutral-900 mb-1 text-sm sm:text-base group-hover:text-neutral-700 transition-colors duration-200">Product quality standards</h4>
                    <p class="text-xs sm:text-sm text-neutral-600 group-hover:text-neutral-500 transition-colors duration-200">Learn about our quality assurance</p>
                </button>
            </div>
        </div>

        <!-- Offline Message -->
        <div x-show="!status.active" class="mt-8">
            <div class="bg-neutral-50 border border-neutral-200 rounded-lg p-6">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 bg-neutral-200 rounded-lg flex items-center justify-center">
                            <svg class="h-4 w-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-neutral-900">Chatbot Temporarily Unavailable</h3>
                        <p class="text-sm text-neutral-600 mt-1">The chatbot is currently offline. Please try again later or contact our support team directly.</p>
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
                    active: true,
                    webhook_configured: false
                },

                async init() {
                    // Try to get session ID from sessionStorage first
                    this.sessionId = sessionStorage.getItem('chatbot_session_id');
                    
                    await this.checkStatus();
                    if (this.status.active) {
                        await this.getSession();
                        if (this.sessionId) {
                            await this.loadHistory();
                        }
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
                    if (this.sessionId) return; // Don't get session if we already have one
                    
                    try {
                        const response = await fetch('/api/chatbot/session');
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        const data = await response.json();
                        this.sessionId = data.session_id;
                        // Store session ID in sessionStorage
                        sessionStorage.setItem('chatbot_session_id', this.sessionId);
                    } catch (error) {
                        console.error('Failed to get session:', error);
                    }
                },

                async loadHistory() {
                    if (!this.sessionId) return;
                    
                    try {
                        this.loading = true;
                        const response = await fetch(`/api/chatbot/history?session_id=${this.sessionId}`);
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        const data = await response.json();
                        this.messages = data.messages || [];
                        this.scrollToBottom();
                    } catch (error) {
                        console.error('Failed to load history:', error);
                        this.messages = []; // Set empty array on error
                    } finally {
                        this.loading = false;
                    }
                },

                async sendMessage() {
                    if (!this.newMessage.trim() || this.loading || !this.status.active) return;

                    const message = this.newMessage.trim();
                    this.newMessage = '';
                    
                    // Add user message immediately (optimistic UI)
                    const userMessage = {
                        id: Date.now(),
                        type: 'user',
                        content: message,
                        sent_at: new Date().toISOString(),
                        formatted_content: message,
                        status: 'sent'
                    };
                    this.messages.push(userMessage);
                    this.scrollToBottom();
                    
                    // Show bot typing indicator
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

                        if (!response.ok) {
                            const errorData = await response.json().catch(() => ({}));
                            
                            if (response.status === 429) {
                                throw new Error('Too many requests. Please slow down.');
                            } else if (response.status === 403) {
                                throw new Error('Access denied. Please refresh the page.');
                            } else if (response.status === 404) {
                                throw new Error('Session not found. Please refresh the page.');
                            } else {
                                throw new Error(errorData.error || `HTTP error! status: ${response.status}`);
                            }
                        }

                        const data = await response.json();
                        
                        // Add bot message
                        if (data.bot_message) {
                            this.messages.push(data.bot_message);
                        }
                        
                        // Update user message status to delivered
                        const lastUserMessage = this.messages.filter(m => m.type === 'user').pop();
                        if (lastUserMessage) {
                            lastUserMessage.status = 'delivered';
                        }
                        
                        this.scrollToBottom();
                    } catch (error) {
                        console.error('Failed to send message:', error);
                        
                        // Update user message status to failed
                        const lastUserMessage = this.messages.filter(m => m.type === 'user').pop();
                        if (lastUserMessage) {
                            lastUserMessage.status = 'failed';
                        }
                        
                        // Show appropriate error message
                        let errorMessage = 'Sorry, there was an error sending your message. Please try again.';
                        
                        if (error.message.includes('Too many requests')) {
                            errorMessage = 'You\'re sending messages too quickly. Please slow down.';
                        } else if (error.message.includes('Access denied')) {
                            errorMessage = 'Access denied. Please refresh the page and try again.';
                        } else if (error.message.includes('Session not found')) {
                            errorMessage = 'Session expired. Please refresh the page.';
                        }
                        
                        this.messages.push({
                            id: Date.now(),
                            type: 'system',
                            content: errorMessage,
                            sent_at: new Date().toISOString()
                        });
                        
                        this.scrollToBottom();
                    } finally {
                        this.typing = false;
                    }
                },

                async sendQuickQuestion(question) {
                    if (!this.status.active || this.loading) return;
                    
                    this.newMessage = question;
                    await this.sendMessage();
                },

                async resetChat() {
                    // Confirmation dialog
                    if (!confirm('Are you sure you want to reset the chat? This will clear all messages and start a new conversation.')) {
                        return;
                    }
                    
                    try {
                        // Show loading state
                        this.loading = true;
                        
                        // Call backend reset endpoint
                        const response = await fetch('/api/chatbot/reset', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                session_id: this.sessionId
                            })
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();
                        
                        // Update session ID
                        this.sessionId = data.new_session_id;
                        sessionStorage.setItem('chatbot_session_id', this.sessionId);
                        
                        // Clear messages
                        this.messages = [];
                        
                        // Reset UI state
                        this.typing = false;
                        this.newMessage = '';
                        
                        // Reset textarea height
                        this.$nextTick(() => {
                            const textarea = this.$refs.chatInput?.querySelector('textarea');
                            if (textarea) {
                                textarea.style.height = '40px'; // Reset to min height
                                textarea.value = '';
                            }
                        });
                        
                        // Scroll to top
                        this.scrollToBottom();
                        
                        // Success feedback
                        console.log('Chat reset successfully');
                        
                        // Show success message briefly
                        this.messages.push({
                            id: Date.now(),
                            type: 'system',
                            content: 'Chat reset successfully. You can start a new conversation.',
                            sent_at: new Date().toISOString()
                        });
                        
                        // Remove success message after 3 seconds
                        setTimeout(() => {
                            this.messages = this.messages.filter(m => m.type !== 'system' || !m.content.includes('Chat reset successfully'));
                        }, 3000);
                        
                    } catch (error) {
                        console.error('Failed to reset chat:', error);
                        alert('Failed to reset chat. Please try again.');
                    } finally {
                        this.loading = false;
                    }
                },

                async copyMessage(content, event) {
                    try {
                        // Strip HTML tags for plain text copy
                        const plainText = content.replace(/<[^>]*>/g, '');
                        
                        await navigator.clipboard.writeText(plainText);
                        
                        // Find the message in messages array and mark as copied
                        const messageIndex = this.messages.findIndex(m => m.content === content);
                        if (messageIndex !== -1) {
                            this.messages[messageIndex].copied = true;
                            
                            // Reset copied status after 2 seconds
                            setTimeout(() => {
                                this.messages[messageIndex].copied = false;
                            }, 2000);
                        }
                        
                        console.log('Message copied to clipboard');
                    } catch (error) {
                        console.error('Failed to copy message:', error);
                        // Fallback for older browsers
                        const textArea = document.createElement('textarea');
                        textArea.value = content.replace(/<[^>]*>/g, '');
                        document.body.appendChild(textArea);
                        textArea.select();
                        document.execCommand('copy');
                        document.body.removeChild(textArea);
                        
                        // Still show success feedback
                        const messageIndex = this.messages.findIndex(m => m.content === content);
                        if (messageIndex !== -1) {
                            this.messages[messageIndex].copied = true;
                            setTimeout(() => {
                                this.messages[messageIndex].copied = false;
                            }, 2000);
                        }
                    }
                },

                handleKeydown(event) {
                    if (event.key === 'Enter') {
                        if (event.shiftKey) {
                            // Shift+Enter: Allow new line (default behavior)
                            return;
                        } else {
                            // Enter: Send message
                            event.preventDefault();
                            this.sendMessage();
                        }
                    }
                },

                autoResize(textarea) {
                    // Reset height to auto to get the correct scrollHeight
                    textarea.style.height = 'auto';
                    
                    // Set height to scrollHeight, but with min/max constraints
                    const minHeight = 40; // min-h-[40px]
                    const maxHeight = 120; // max-h-[120px]
                    const newHeight = Math.min(Math.max(textarea.scrollHeight, minHeight), maxHeight);
                    
                    textarea.style.height = newHeight + 'px';
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
