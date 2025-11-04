<!-- Floating Chat Component - Beauty High Tech Design -->
<div x-data="floatingChatbot()" x-init="initFloatingChat()">

    <!-- Video Introduction Modal -->
    <div x-show="showVideoModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 md:p-6 bg-black/70 backdrop-blur-sm"
         style="display: none;"
         @click.self="skipVideo()">

        <div class="relative w-full max-w-xs sm:max-w-md md:max-w-lg lg:max-w-2xl bg-[#000d1a] rounded-xl sm:rounded-2xl shadow-2xl overflow-hidden border border-cyan-400/30"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="transform scale-95 opacity-0"
             x-transition:enter-end="transform scale-100 opacity-100"
             @click.stop>

            <!-- Close Button (Top Right) -->
            <button @click="skipVideo()"
                    class="absolute top-2 right-2 sm:top-3 sm:right-3 z-20 w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center bg-black/50 hover:bg-black/70 text-white rounded-full transition duration-300 backdrop-blur-sm touch-manipulation"
                    title="Close">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Video Container -->
            <div class="relative aspect-video bg-black">
                <video x-ref="introVideo"
                       @ended="onVideoEnd()"
                       @loadedmetadata="onVideoLoaded()"
                       class="w-full h-full object-contain"
                       playsinline>
                    <source src="{{ asset('videos/luna-intro.mp4') }}" type="video/mp4">
                    <source src="{{ asset('videos/luna-intro.webm') }}" type="video/webm">
                    Your browser does not support the video tag.
                </video>

                <!-- Loading Indicator (shows while video is actually loading) -->
                <div class="absolute inset-0 flex items-center justify-center bg-black/70"
                     x-show="videoLoading"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    <div class="flex flex-col items-center space-y-3">
                        <div class="animate-spin rounded-full h-10 w-10 sm:h-12 sm:w-12 border-3 border-cyan-400/20 border-t-cyan-400"></div>
                        <span class="text-white text-xs sm:text-sm font-medium">Loading video...</span>
                    </div>
                </div>

                <!-- Video Controls Overlay -->
                <div class="absolute bottom-0 left-0 right-0 p-2 sm:p-3 md:p-4 bg-gradient-to-t from-black/90 to-transparent">
                    <div class="flex items-center justify-between gap-2">

                        <!-- Unmute Button -->
                        <button @click="toggleMute()"
                                class="flex items-center space-x-1 sm:space-x-2 px-2 py-1.5 sm:px-3 sm:py-2 bg-cyan-400/20 hover:bg-cyan-400/30 text-white rounded-lg transition duration-300 border border-cyan-400/30 touch-manipulation min-w-[44px] min-h-[44px]">
                            <svg x-show="videoMuted" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" clip-rule="evenodd"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"/>
                            </svg>
                            <svg x-show="!videoMuted" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                            </svg>
                            <span class="hidden sm:inline text-xs sm:text-sm font-medium" x-text="videoMuted ? 'Unmute' : 'Mute'"></span>
                        </button>

                        <!-- Skip Button (appears after 2 seconds) -->
                        <button x-show="canSkip"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                @click="skipVideo()"
                                class="px-3 py-1.5 sm:px-4 sm:py-2 bg-cyan-400 hover:bg-cyan-500 text-white font-semibold rounded-lg transition duration-300 shadow-lg text-xs sm:text-sm touch-manipulation">
                            Skip Intro
                        </button>
                    </div>
                </div>
            </div>

            <!-- Video Caption/Subtitle Area -->
            <div class="p-3 sm:p-4 bg-[#000d1a] border-t border-cyan-400/20">
                <p class="text-cyan-300 text-xs sm:text-sm text-center leading-relaxed">
                    👋 Hi, I'm Luna! Your AI beauty expert assistant
                </p>
            </div>
        </div>
    </div>

    <!-- Floating Avatar Button -->
    <div
        @click="toggleChat()"
        x-show="!isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="transform scale-0 opacity-0"
        x-transition:enter-end="transform scale-100 opacity-100"
        class="fixed bottom-3 right-3 sm:bottom-4 sm:right-4 md:bottom-10 md:right-10 w-20 h-20 sm:w-24 sm:h-24 md:w-36 md:h-36 overflow-hidden z-30 cursor-pointer group"
    >
        <div class="flex flex-col items-center justify-end h-full pb-2 relative">
            <img src="{{ asset('images/lunaray-landing/luna-ask-me-update.webp') }}"
                 alt="Luna AI Assistant"
                 class="w-full h-full object-cover absolute top-0 left-0 transition duration-300 group-hover:scale-105">

            <!-- Online Status Indicator (Cyan accent) -->
            <div class="absolute top-0.5 right-0.5 sm:top-1 sm:right-1 md:top-2 md:right-2 w-2.5 h-2.5 sm:w-3 sm:h-3 md:w-4 md:h-4 rounded-full border-2 border-white shadow-lg z-10 transition duration-300"
                 :class="status.active ? 'bg-cyan-400' : 'bg-neutral-400'"></div>
        </div>
    </div>

    <!-- Chat Panel - Beauty High Tech Style -->
    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="transform translate-y-4 opacity-0 scale-95"
        x-transition:enter-end="transform translate-y-0 opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="transform translate-y-0 opacity-100 scale-100"
        x-transition:leave-end="transform translate-y-4 opacity-0 scale-95"
        class="fixed inset-x-2 bottom-2 md:inset-x-auto md:bottom-6 md:right-6 md:left-auto w-auto md:w-full md:max-w-sm bg-white rounded-2xl shadow-xl overflow-hidden z-30 flex flex-col"
        style="max-height: calc(100vh - 100px); max-height: calc(100dvh - 100px); display: none;"
        @click.away="isOpen && closeChat()"
    >
        <!-- Chat Header - Deep Navy with Cyan Accents -->
        <div class="bg-[#000d1a] text-white px-3 py-3 md:px-4 md:py-4 flex items-center justify-between border-b border-cyan-400/20">
            <div class="flex items-center space-x-2 md:space-x-3 min-w-0">
                <div class="h-8 w-8 md:h-10 md:w-10 bg-cyan-400/10 rounded-lg flex items-center justify-center border border-cyan-400/30 flex-shrink-0">
                    <svg class="h-5 w-5 md:h-6 md:w-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="text-xs md:text-sm font-semibold tracking-wide truncate">Luna AI Assistant</h3>
                    <div class="flex items-center space-x-1.5 text-xs">
                        <div class="w-2 h-2 rounded-full transition duration-300 flex-shrink-0" :class="status.active ? 'bg-cyan-400' : 'bg-neutral-400'"></div>
                        <span x-text="status.active ? 'Online' : 'Offline'" class="text-cyan-300"></span>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-1 md:space-x-2 flex-shrink-0">
                <!-- Reset Button -->
                <button
                    @click="resetChat()"
                    class="p-1.5 md:p-2 hover:bg-cyan-400/10 rounded-lg transition duration-300 group"
                    :disabled="loading || !status.active"
                    title="Reset Chat"
                >
                    <svg class="w-4 h-4 text-cyan-400 group-hover:text-cyan-300 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
                <!-- Close Button -->
                <button
                    @click="closeChat()"
                    class="p-1.5 md:p-2 hover:bg-cyan-400/10 rounded-lg transition duration-300 group"
                >
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-white group-hover:text-cyan-400 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Chat Messages - Light background -->
        <div class="flex-1 overflow-y-auto p-2 sm:p-3 md:p-4 space-y-2 sm:space-y-3 md:space-y-4 bg-white" x-ref="chatMessages" style="min-height: 250px;">
            <!-- Loading State -->
            <div x-show="loading && messages.length === 0" class="flex items-center justify-center py-12">
                <div class="flex flex-col items-center space-y-3">
                    <div class="animate-spin rounded-full h-8 w-8 border-3 border-cyan-400/20 border-t-cyan-400"></div>
                    <span class="text-blue-900 text-sm font-medium">Loading chat...</span>
                </div>
            </div>

            <!-- Welcome Message (when no messages) -->
            <div x-show="!loading && messages.length === 0" class="flex flex-col items-center justify-center py-6 sm:py-8 md:py-12 text-center">
                <div class="h-14 w-14 sm:h-16 sm:w-16 md:h-20 md:w-20 bg-[#000d1a] rounded-xl flex items-center justify-center mb-2 sm:mb-3 md:mb-4 border border-cyan-400/30">
                    <svg class="h-7 w-7 sm:h-8 sm:w-8 md:h-10 md:w-10 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <h4 class="text-blue-900 font-bold text-sm sm:text-base md:text-lg mb-1 sm:mb-2">Welcome to Luna AI</h4>
                <p class="text-blue-600 text-xs md:text-sm px-3 sm:px-4 md:px-6 leading-relaxed">Your beauty expert powered by science. <br>Ask me anything!</p>
            </div>

            <!-- Messages -->
            <template x-for="message in messages" :key="message.id">
                <div class="flex" :class="message.type === 'user' ? 'justify-end' : 'justify-start'">
                    <div class="flex items-end space-x-1.5 md:space-x-2 max-w-[90%] md:max-w-[85%]"
                         :class="message.type === 'user' ? 'flex-row-reverse space-x-reverse' : ''">
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            <div class="h-7 w-7 md:h-8 md:w-8 rounded-lg flex items-center justify-center transition duration-300"
                                 :class="message.type === 'user' ? 'bg-[#000d1a] border border-cyan-400/30' : 'bg-cyan-400/10 border border-cyan-400/30'">
                                <span x-show="message.type === 'user'" class="text-cyan-400 font-semibold text-xs">
                                    {{ auth()->user() ? substr(auth()->user()->name, 0, 1) : 'G' }}
                                </span>
                                <svg x-show="message.type !== 'user'" class="h-4 w-4 md:h-5 md:w-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Message Bubble -->
                        <div class="flex flex-col min-w-0">
                            <div class="rounded-2xl px-3 py-2 md:px-4 md:py-3 transition duration-300"
                                 :class="message.type === 'user' ? 'bg-[#000d1a] text-white rounded-br-md border border-cyan-400/20' : 'bg-blue-50 text-blue-900 rounded-bl-md border border-blue-200'">
                                <div x-html="message.formatted_content || message.content" class="text-xs md:text-sm leading-relaxed break-words"></div>
                            </div>
                            <span class="text-xs text-blue-600 mt-1 md:mt-1.5 px-1 md:px-2" x-text="formatTime(message.sent_at)"></span>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div x-show="typing" class="flex justify-start">
                <div class="flex items-end space-x-1.5 md:space-x-2">
                    <div class="h-7 w-7 md:h-8 md:w-8 rounded-lg bg-cyan-400/10 border border-cyan-400/30 flex items-center justify-center">
                        <svg class="h-4 w-4 md:h-5 md:w-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <div class="bg-blue-50 rounded-2xl rounded-bl-md px-3 py-2 md:px-4 md:py-3 border border-blue-200">
                        <div class="flex space-x-1.5">
                            <div class="w-2 h-2 bg-cyan-400 rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-cyan-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                            <div class="w-2 h-2 bg-cyan-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Offline Message -->
            <div x-show="!status.active" class="bg-cyan-50 border border-cyan-200 rounded-lg p-2.5 md:p-3">
                <div class="flex items-start space-x-2">
                    <svg class="h-4 w-4 md:h-5 md:w-5 text-cyan-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    <div class="min-w-0">
                        <h4 class="text-xs md:text-sm font-semibold text-blue-900">Chatbot Offline</h4>
                        <p class="text-xs text-blue-600 mt-0.5 md:mt-1 leading-relaxed">Please try again later or contact support.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Input - Beauty High Tech Style -->
        <div class="border-t border-cyan-400/20 bg-white p-2 sm:p-3 md:p-4">
            <form @submit.prevent="sendMessage()" class="flex items-end space-x-1.5 sm:space-x-2">
                @csrf
                <textarea
                    x-model="newMessage"
                    @input="autoResize($event.target)"
                    @keydown="handleKeydown($event)"
                    placeholder="Type your message..."
                    class="flex-1 px-2.5 py-2 sm:px-3 sm:py-2 md:px-4 md:py-3 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent text-xs sm:text-sm text-blue-900 placeholder-blue-400 resize-none overflow-hidden min-h-[40px] max-h-[100px] transition duration-300"
                    :disabled="loading || !status.active"
                    rows="1"
                ></textarea>
                <button
                    type="submit"
                    class="p-2.5 sm:px-3 sm:py-2 md:px-4 md:py-3 bg-[#000d1a] hover:bg-cyan-400 text-cyan-400 hover:text-white rounded-lg transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex-shrink-0 border border-cyan-400/30 min-w-[44px] min-h-[44px] flex items-center justify-center"
                    :disabled="loading || !status.active || !newMessage.trim()"
                >
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function floatingChatbot() {
        return {
            isOpen: false,
            messages: [],
            newMessage: '',
            loading: false,
            typing: false,
            sessionId: null,
            status: {
                active: true,
                webhook_configured: false
            },
            initialized: false,

            // Video modal states
            showVideoModal: false,
            videoMuted: false,  // Changed: Start with sound ON
            canSkip: false,
            videoLoading: true,  // New: Track loading state separately
            skipTimer: null,
            hasWatchedIntro: false,

            initFloatingChat() {
                // Check status immediately
                this.checkStatus();

                // Check if user has watched intro before
                this.hasWatchedIntro = localStorage.getItem('luna_intro_watched') === 'true';
            },

            toggleChat() {
                // If first time, show video modal
                if (!this.hasWatchedIntro && !this.showVideoModal) {
                    this.openVideoModal();
                    return;
                }

                // Otherwise, open chat normally
                this.isOpen = !this.isOpen;

                // Lazy initialize chat when first opened
                if (this.isOpen && !this.initialized) {
                    this.init();
                }
            },

            openVideoModal() {
                this.showVideoModal = true;
                this.videoLoading = true;  // Reset loading state

                // Wait for modal to be visible, then play video
                this.$nextTick(() => {
                    const video = this.$refs.introVideo;
                    if (video) {
                        // Listen for 'playing' event (video actually starts playing)
                        video.addEventListener('playing', () => {
                            this.videoLoading = false;  // Hide loading when video plays
                        }, { once: true });

                        // Try to play (browsers may block autoplay)
                        video.play().catch(error => {
                            console.log('Autoplay prevented:', error);
                            this.videoLoading = false;  // Hide loading even if autoplay blocked
                        });

                        // Enable skip button after 2 seconds (independent of loading)
                        this.skipTimer = setTimeout(() => {
                            this.canSkip = true;
                        }, 2000);
                    }
                });
            },

            onVideoLoaded() {
                console.log('Video metadata loaded');
                // Don't hide loading here - wait for actual playback
            },

            onVideoEnd() {
                // Video finished naturally
                this.completeIntro();
            },

            skipVideo() {
                // User clicked skip or close
                this.completeIntro();
            },

            completeIntro() {
                // Clear skip timer
                if (this.skipTimer) {
                    clearTimeout(this.skipTimer);
                }

                // Mark as watched
                this.hasWatchedIntro = true;
                localStorage.setItem('luna_intro_watched', 'true');

                // Close video modal
                this.showVideoModal = false;
                this.canSkip = false;
                this.videoLoading = true;  // Reset loading state for next time

                // Pause and reset video
                const video = this.$refs.introVideo;
                if (video) {
                    video.pause();
                    video.currentTime = 0;
                }

                // Open chat panel
                this.isOpen = true;
                if (!this.initialized) {
                    this.init();
                }
            },

            toggleMute() {
                const video = this.$refs.introVideo;
                if (video) {
                    video.muted = !video.muted;
                    this.videoMuted = video.muted;
                }
            },

            closeChat() {
                this.isOpen = false;
            },

            async init() {
                if (this.initialized) return;

                this.initialized = true;

                // Try to get session ID from localStorage first (for guest persistence)
                this.sessionId = localStorage.getItem('guest_chat_session_id');

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
                if (this.sessionId) return;

                try {
                    const url = this.sessionId ? `/api/chatbot/session?session_id=${this.sessionId}` : '/api/chatbot/session';
                    const response = await fetch(url, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    const data = await response.json();
                    this.sessionId = data.session_id;

                    // Store session ID in localStorage for guest persistence
                    if (data.is_guest) {
                        localStorage.setItem('guest_chat_session_id', this.sessionId);
                    } else {
                        sessionStorage.setItem('chatbot_session_id', this.sessionId);
                    }
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
                    this.messages = [];
                } finally {
                    this.loading = false;
                }
            },

            async sendMessage() {
                if (!this.newMessage.trim() || this.loading || !this.status.active) return;

                const message = this.newMessage.trim();
                this.newMessage = '';

                // Add user message immediately
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

                // Show typing indicator
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

                    // Update user message status
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

                    // Show error message
                    let errorMessage = 'Sorry, there was an error. Please try again.';

                    if (error.message.includes('Too many requests')) {
                        errorMessage = 'You\'re sending messages too quickly. Please slow down.';
                    } else if (error.message.includes('Access denied')) {
                        errorMessage = 'Access denied. Please refresh the page.';
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

            async resetChat() {
                if (!confirm('Reset chat and start a new conversation?')) {
                    return;
                }

                try {
                    this.loading = true;

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
                    this.sessionId = data.new_session_id;

                    // Clear storage
                    localStorage.removeItem('guest_chat_session_id');
                    sessionStorage.removeItem('chatbot_session_id');

                    // Clear messages
                    this.messages = [];
                    this.typing = false;
                    this.newMessage = '';

                    // Show success message
                    this.messages.push({
                        id: Date.now(),
                        type: 'system',
                        content: 'Chat reset successfully. Start a new conversation!',
                        sent_at: new Date().toISOString()
                    });

                    setTimeout(() => {
                        this.messages = this.messages.filter(m => m.type !== 'system');
                    }, 3000);

                } catch (error) {
                    console.error('Failed to reset chat:', error);
                    alert('Failed to reset chat. Please try again.');
                } finally {
                    this.loading = false;
                }
            },

            handleKeydown(event) {
                if (event.key === 'Enter' && !event.shiftKey) {
                    event.preventDefault();
                    this.sendMessage();
                }
            },

            autoResize(textarea) {
                textarea.style.height = 'auto';
                const minHeight = 38;
                const maxHeight = 100;
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

                if (diff < 60000) {
                    return 'Just now';
                } else if (diff < 3600000) {
                    return Math.floor(diff / 60000) + 'm ago';
                } else if (diff < 86400000) {
                    return Math.floor(diff / 3600000) + 'h ago';
                } else {
                    return date.toLocaleDateString();
                }
            }
        }
    }
</script>
@endpush
