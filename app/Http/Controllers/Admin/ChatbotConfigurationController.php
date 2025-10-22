<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatbotConfiguration;
use App\Services\ChatbotWebhookService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ChatbotConfigurationController extends Controller
{
    protected ChatbotWebhookService $webhookService;

    public function __construct(ChatbotWebhookService $webhookService)
    {
        $this->webhookService = $webhookService;
    }

    /**
     * Get all chatbot configurations.
     */
    public function index(): JsonResponse
    {
        $configurations = ChatbotConfiguration::orderBy('key')->get();
        
        return response()->json([
            'configurations' => $configurations,
            'status' => $this->webhookService->getConfigurationStatus(),
        ]);
    }

    /**
     * Update chatbot configuration.
     */
    public function update(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required|string',
            'value' => 'required|string',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors(),
            ], 422);
        }

        $key = $request->input('key');
        $value = $request->input('value');
        $description = $request->input('description');

        // Validate webhook URL format
        if ($key === 'webhook_url' && !filter_var($value, FILTER_VALIDATE_URL)) {
            return response()->json([
                'error' => 'Invalid webhook URL format',
            ], 422);
        }

        // Validate boolean values
        if (in_array($key, ['chatbot_active', 'webhook_enabled'])) {
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';
        }

        // Validate numeric values
        if (in_array($key, ['webhook_timeout', 'webhook_retry_attempts'])) {
            $value = (string) max(1, (int) $value);
        }

        ChatbotConfiguration::setValue($key, $value, $description);

        return response()->json([
            'message' => 'Configuration updated successfully',
            'configuration' => [
                'key' => $key,
                'value' => $value,
                'description' => $description,
            ],
        ]);
    }

    /**
     * Test webhook connection.
     */
    public function testWebhook(): JsonResponse
    {
        $result = $this->webhookService->testConnection();
        
        return response()->json($result);
    }

    /**
     * Get chatbot statistics.
     */
    public function statistics(): JsonResponse
    {
        $totalSessions = \App\Models\ChatSession::count();
        $activeSessions = \App\Models\ChatSession::where('status', 'active')->count();
        $totalMessages = \App\Models\ChatMessage::count();
        $botMessages = \App\Models\ChatMessage::where('type', 'bot')->count();
        $userMessages = \App\Models\ChatMessage::where('type', 'user')->count();

        return response()->json([
            'sessions' => [
                'total' => $totalSessions,
                'active' => $activeSessions,
                'closed' => $totalSessions - $activeSessions,
            ],
            'messages' => [
                'total' => $totalMessages,
                'user' => $userMessages,
                'bot' => $botMessages,
                'system' => $totalMessages - $userMessages - $botMessages,
            ],
            'last_updated' => now(),
        ]);
    }

    /**
     * Get chat logs with filtering.
     */
    public function chatLogs(Request $request): JsonResponse
    {
        $query = \App\Models\ChatSession::with(['user', 'messages'])
            ->orderBy('last_activity_at', 'desc');

        // Filter by date range
        if ($request->has('date_from')) {
            $query->where('created_at', '>=', $request->input('date_from'));
        }

        if ($request->has('date_to')) {
            $query->where('created_at', '<=', $request->input('date_to'));
        }

        // Filter by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        $sessions = $query->paginate(20);

        return response()->json([
            'sessions' => $sessions->items(),
            'pagination' => [
                'current_page' => $sessions->currentPage(),
                'last_page' => $sessions->lastPage(),
                'per_page' => $sessions->perPage(),
                'total' => $sessions->total(),
            ],
        ]);
    }

    /**
     * Reset chatbot configuration to defaults.
     */
    public function reset(): JsonResponse
    {
        $defaults = [
            'chatbot_active' => 'true',
            'webhook_enabled' => 'true',
            'webhook_timeout' => '30',
            'webhook_retry_attempts' => '3',
        ];

        foreach ($defaults as $key => $value) {
            ChatbotConfiguration::setValue($key, $value, "Default {$key} setting");
        }

        return response()->json([
            'message' => 'Configuration reset to defaults',
            'defaults' => $defaults,
        ]);
    }
}
