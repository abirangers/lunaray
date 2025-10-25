<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ChatbotRateLimitMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $ipAddress = $request->ip();
        
        // Use user ID for authenticated users, IP for guests
        $key = $user ? 'chatbot_rate_limit_user:' . $user->id : 'chatbot_rate_limit_ip:' . $ipAddress;
        $maxAttempts = 60; // 60 requests per minute
        $decayMinutes = 1;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $retryAfter = RateLimiter::availableIn($key);
            
            Log::warning('Chatbot rate limit exceeded', [
                'user_id' => $user ? $user->id : null,
                'ip' => $ipAddress,
                'user_agent' => $request->userAgent(),
                'retry_after' => $retryAfter,
                'is_guest' => !$user,
            ]);

            return response()->json([
                'error' => 'Too many requests. Please slow down.',
                'retry_after' => $retryAfter,
            ], 429);
        }

        RateLimiter::hit($key, $decayMinutes * 60);

        return $next($request);
    }
}