<x-layouts.app pageTitle="AI Chatbot" pageDescription="Get instant support with our AI chatbot">
    <!-- Chat Interface -->
    <div class="max-w-4xl mx-auto">
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
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Online
                        </span>
                    </div>
                </div>
            </div>

            <!-- Chat Messages -->
            <div class="h-96 overflow-y-auto p-6 space-y-4" id="chat-messages">
                <!-- Welcome Message -->
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 bg-primary rounded-full flex items-center justify-center">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="bg-gray-100 rounded-lg px-4 py-2">
                            <p class="text-sm text-gray-900">
                                Hello! I'm your Lunaray AI Assistant. I'm here to help you with questions about our beauty products, manufacturing services, and anything else you'd like to know. How can I assist you today?
                            </p>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Just now</p>
                    </div>
                </div>
            </div>

            <!-- Chat Input -->
            <div class="border-t bg-gray-50 px-6 py-4">
                <form id="chat-form" class="flex space-x-4">
                    @csrf
                    <div class="flex-1">
                        <input 
                            type="text" 
                            id="message-input"
                            placeholder="Type your message here..." 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            required
                        >
                    </div>
                    <button 
                        type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Questions</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <button class="quick-question bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow text-left">
                    <h4 class="font-medium text-gray-900">What services do you offer?</h4>
                    <p class="text-sm text-gray-500 mt-1">Learn about our beauty manufacturing services</p>
                </button>
                
                <button class="quick-question bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow text-left">
                    <h4 class="font-medium text-gray-900">How to get started?</h4>
                    <p class="text-sm text-gray-500 mt-1">Find out how to begin your beauty journey</p>
                </button>
                
                <button class="quick-question bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow text-left">
                    <h4 class="font-medium text-gray-900">Product quality standards</h4>
                    <p class="text-sm text-gray-500 mt-1">Learn about our quality assurance</p>
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatForm = document.getElementById('chat-form');
            const messageInput = document.getElementById('message-input');
            const chatMessages = document.getElementById('chat-messages');

            // Handle form submission
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const message = messageInput.value.trim();
                if (message) {
                    addMessage(message, 'user');
                    messageInput.value = '';
                    
                    // Simulate AI response
                    setTimeout(() => {
                        addMessage('Thank you for your question! I\'m here to help you with information about our beauty products and services. For more detailed assistance, please contact our support team.', 'ai');
                    }, 1000);
                }
            });

            // Handle quick questions
            document.querySelectorAll('.quick-question').forEach(button => {
                button.addEventListener('click', function() {
                    const question = this.querySelector('h4').textContent;
                    addMessage(question, 'user');
                    
                    // Simulate AI response
                    setTimeout(() => {
                        addMessage('Great question! Let me provide you with detailed information about that topic.', 'ai');
                    }, 1000);
                });
            });

            function addMessage(text, sender) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `flex items-start space-x-3 ${sender === 'user' ? 'flex-row-reverse space-x-reverse' : ''}`;
                
                const avatar = sender === 'user' ? 
                    `<div class="h-8 w-8 bg-secondary rounded-full flex items-center justify-center">
                        <span class="text-primary font-medium text-sm">${'{{ substr(auth()->user()->name, 0, 1) }}'}</span>
                    </div>` :
                    `<div class="h-8 w-8 bg-primary rounded-full flex items-center justify-center">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>`;

                const messageClass = sender === 'user' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-900';
                
                messageDiv.innerHTML = `
                    <div class="flex-shrink-0">
                        ${avatar}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="${messageClass} rounded-lg px-4 py-2">
                            <p class="text-sm">${text}</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Just now</p>
                    </div>
                `;
                
                chatMessages.appendChild(messageDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });
    </script>
    @endpush
</x-layouts.app>
