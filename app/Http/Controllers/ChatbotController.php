<?php

namespace App\Http\Controllers;

use App\Models\ChatSession;
use App\Models\ChatMessage;
use App\Models\ChatbotConfiguration;
use App\Services\ChatbotWebhookService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    protected ChatbotWebhookService $webhookService;

    public function __construct(ChatbotWebhookService $webhookService)
    {
        $this->webhookService = $webhookService;
    }

    /**
     * Check if the request is from a bot or crawler.
     */
    protected function isBotRequest(Request $request): bool
    {
        $userAgent = $request->userAgent();
        
        if (!$userAgent) {
            return true;
        }

        $botPatterns = [
            'bot', 'crawler', 'spider', 'scraper', 'curl', 'wget',
            'googlebot', 'bingbot', 'slurp', 'duckduckbot', 'baiduspider',
            'yandexbot', 'facebookexternalhit', 'twitterbot', 'linkedinbot'
        ];

        $userAgentLower = strtolower($userAgent);
        
        foreach ($botPatterns as $pattern) {
            if (str_contains($userAgentLower, $pattern)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check rate limiting for the user.
     */
    protected function checkRateLimit(Request $request): bool
    {
        $key = 'chatbot_rate_limit:' . Auth::id();
        $maxAttempts = 30; // 30 requests per minute
        $decayMinutes = 1;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            return false;
        }

        RateLimiter::hit($key, $decayMinutes * 60);
        return true;
    }

    /**
     * Get or create a chat session for the authenticated user.
     */
    public function getSession(): JsonResponse
    {
        $user = Auth::user();
        
        // Get or create active session
        $session = ChatSession::where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (!$session) {
            $session = ChatSession::create([
                'user_id' => $user->id,
                'session_id' => Str::uuid(),
                'status' => 'active',
                'last_activity_at' => now(),
            ]);
        }

        return response()->json([
            'session_id' => $session->session_id,
            'status' => $session->status,
            'last_activity' => $session->last_activity_at,
        ]);
    }

    /**
     * Get chat history for the current session.
     */
    public function getHistory(Request $request): JsonResponse
    {
        $sessionId = $request->input('session_id');
        $user = Auth::user();

        $session = ChatSession::where('session_id', $sessionId)
            ->where('user_id', $user->id)
            ->first();

        if (!$session) {
            return response()->json(['error' => 'Session not found'], 404);
        }

        $messages = $session->messages()
            ->orderBy('sent_at')
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'type' => $message->type,
                    'content' => $message->content,
                    'formatted_content' => $message->formatted_content,
                    'sent_at' => $message->sent_at,
                    'metadata' => $message->metadata,
                ];
            });

        return response()->json([
            'session_id' => $session->session_id,
            'messages' => $messages,
        ]);
    }

    /**
     * Send a message to the chatbot.
     */
    public function sendMessage(Request $request): JsonResponse
    {
        // Bot detection
        if ($this->isBotRequest($request)) {
            Log::info('Bot request blocked', [
                'user_agent' => $request->userAgent(),
                'ip' => $request->ip(),
            ]);
            return response()->json(['error' => 'Bot requests not allowed'], 403);
        }

        // Rate limiting
        if (!$this->checkRateLimit($request)) {
            Log::warning('Rate limit exceeded', [
                'user_id' => Auth::id(),
                'ip' => $request->ip(),
            ]);
            return response()->json(['error' => 'Too many requests. Please slow down.'], 429);
        }

        $request->validate([
            'session_id' => 'required|string',
            'message' => 'required|string|max:2000|min:1',
        ]);

        $user = Auth::user();
        $sessionId = $request->input('session_id');
        $message = trim($request->input('message'));

        // Get or create session
        $session = ChatSession::where('session_id', $sessionId)
            ->where('user_id', $user->id)
            ->first();

        if (!$session) {
            return response()->json(['error' => 'Session not found'], 404);
        }

        // Create user message with optimistic UI support
        $userMessage = ChatMessage::create([
            'chat_session_id' => $session->id,
            'user_id' => $user->id,
            'type' => 'user',
            'content' => $message,
            'sent_at' => now(),
        ]);

        // Update session activity
        $session->updateActivity();

        // Log user message for analytics
        Log::info('User message sent', [
            'user_id' => $user->id,
            'session_id' => $sessionId,
            'message_length' => strlen($message),
        ]);

        try {
            // Send to webhook and get response
            $botResponse = $this->webhookService->sendMessage($session, $userMessage);
            
            // Create bot message
            $botMessage = ChatMessage::create([
                'chat_session_id' => $session->id,
                'user_id' => $user->id,
                'type' => 'bot',
                'content' => $botResponse['content'],
                'metadata' => $botResponse['metadata'] ?? null,
                'sent_at' => now(),
            ]);

            // Log successful bot response
            Log::info('Bot response received', [
                'user_id' => $user->id,
                'session_id' => $sessionId,
                'response_length' => strlen($botResponse['content']),
            ]);

            return response()->json([
                'user_message' => [
                    'id' => $userMessage->id,
                    'type' => $userMessage->type,
                    'content' => $userMessage->content,
                    'sent_at' => $userMessage->sent_at,
                ],
                'bot_message' => [
                    'id' => $botMessage->id,
                    'type' => $botMessage->type,
                    'content' => $botMessage->content,
                    'formatted_content' => $botMessage->formatted_content,
                    'sent_at' => $botMessage->sent_at,
                    'metadata' => $botMessage->metadata,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Chatbot webhook error', [
                'user_id' => $user->id,
                'session_id' => $sessionId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Create error message
            $errorMessage = ChatMessage::create([
                'chat_session_id' => $session->id,
                'user_id' => $user->id,
                'type' => 'system',
                'content' => 'Sorry, I\'m having trouble connecting right now. Please try again in a moment.',
                'metadata' => [
                    'error' => $e->getMessage(),
                    'error_type' => get_class($e),
                ],
                'sent_at' => now(),
            ]);

            return response()->json([
                'user_message' => [
                    'id' => $userMessage->id,
                    'type' => $userMessage->type,
                    'content' => $userMessage->content,
                    'sent_at' => $userMessage->sent_at,
                ],
                'bot_message' => [
                    'id' => $errorMessage->id,
                    'type' => $errorMessage->type,
                    'content' => $errorMessage->content,
                    'sent_at' => $errorMessage->sent_at,
                ],
            ]);
        }
    }

    /**
     * Close the current chat session.
     */
    public function closeSession(Request $request): JsonResponse
    {
        $sessionId = $request->input('session_id');
        $user = Auth::user();

        $session = ChatSession::where('session_id', $sessionId)
            ->where('user_id', $user->id)
            ->first();

        if (!$session) {
            return response()->json(['error' => 'Session not found'], 404);
        }

        $session->close();

        return response()->json(['message' => 'Session closed successfully']);
    }

    /**
     * Reset chat session - create new session and clear messages.
     */
    public function resetSession(Request $request): JsonResponse
    {
        $sessionId = $request->input('session_id');
        $user = Auth::user();

        $session = ChatSession::where('session_id', $sessionId)
            ->where('user_id', $user->id)
            ->first();

        if (!$session) {
            return response()->json(['error' => 'Session not found'], 404);
        }

        // Close current session
        $session->close();

        // Create new session
        $newSession = ChatSession::create([
            'user_id' => $user->id,
            'session_id' => Str::uuid(),
            'status' => 'active',
            'last_activity_at' => now(),
        ]);

        Log::info('Chat session reset', [
            'user_id' => $user->id,
            'old_session_id' => $sessionId,
            'new_session_id' => $newSession->session_id,
        ]);

        return response()->json([
            'message' => 'Chat reset successfully',
            'new_session_id' => $newSession->session_id,
        ]);
    }

    /**
     * Get chatbot status and configuration.
     */
    public function getStatus(): JsonResponse
    {
        $webhookUrl = ChatbotConfiguration::where('key', 'webhook_url')->first()?->value;
        $isActive = ChatbotConfiguration::where('key', 'chatbot_active')->first()?->value === 'true';

        return response()->json([
            'active' => $isActive,
            'webhook_configured' => !empty($webhookUrl),
            'last_updated' => now(),
        ]);
    }
}
