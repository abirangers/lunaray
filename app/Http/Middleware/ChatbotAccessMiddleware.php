<?php

namespace App\Http\Middleware;

use App\Models\ChatbotConfiguration;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChatbotAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if chatbot is active
        $isActive = ChatbotConfiguration::getValue('chatbot_active', 'false') === 'true';
        
        if (!$isActive) {
            return response()->json([
                'error' => 'Chatbot is currently disabled',
                'message' => 'The chatbot service is temporarily unavailable. Please try again later.',
            ], 503);
        }

        // Check if user is authenticated
        if (auth()->check()) {
            // Authenticated user - check permissions
            $user = auth()->user();
            if (!$user->can('access chat')) {
                return response()->json([
                    'error' => 'Access denied',
                    'message' => 'You do not have permission to use the chatbot.',
                ], 403);
            }
        }
        // Guest users are allowed without authentication

        // Check rate limiting (basic implementation)
        $this->checkRateLimit($request);

        return $next($request);
    }

    /**
     * Check rate limiting for chatbot requests.
     */
    protected function checkRateLimit(Request $request): void
    {
        $userId = auth()->id();
        $ipAddress = $request->ip();
        
        // Use user ID for authenticated users, IP for guests
        $cacheKey = $userId ? "chatbot_rate_limit_user_{$userId}" : "chatbot_rate_limit_ip_{$ipAddress}";
        
        $requests = cache()->get($cacheKey, []);
        $now = now();
        
        // Remove requests older than 1 minute
        $requests = array_filter($requests, function ($timestamp) use ($now) {
            return $now->diffInMinutes($timestamp) < 1;
        });
        
        // Check if user has exceeded rate limit (60 requests per minute)
        if (count($requests) >= 60) {
            abort(429, 'Too many chatbot requests. Please wait a moment before trying again.');
        }
        
        // Add current request
        $requests[] = $now;
        cache()->put($cacheKey, $requests, 60); // Cache for 1 minute
    }
}
