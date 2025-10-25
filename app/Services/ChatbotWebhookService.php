<?php

namespace App\Services;

use App\Models\ChatSession;
use App\Models\ChatMessage;
use App\Models\ChatbotConfiguration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;

class ChatbotWebhookService
{
    protected string $webhookUrl;
    protected int $timeout;
    protected int $retryAttempts;

    public function __construct()
    {
        // Try environment variables first, fallback to database configuration
        $this->webhookUrl = env('CHATBOT_WEBHOOK_URL', ChatbotConfiguration::getValue('webhook_url', ''));
        $this->timeout = (int) env('CHATBOT_TIMEOUT', ChatbotConfiguration::getValue('webhook_timeout', 30));
        $this->retryAttempts = (int) env('CHATBOT_RETRY_ATTEMPTS', ChatbotConfiguration::getValue('webhook_retry_attempts', 3));
    }

    /**
     * Send a message to the n8n webhook and get the response.
     */
    public function sendMessage(ChatSession $session, ChatMessage $userMessage): array
    {
        if (empty($this->webhookUrl)) {
            throw new \Exception('Webhook URL not configured');
        }

        $payload = $this->buildPayload($session, $userMessage);
        
        $response = $this->makeRequest($payload);
        
        return $this->parseResponse($response);
    }

    /**
     * Test the webhook connection.
     */
    public function testConnection(): array
    {
        if (empty($this->webhookUrl)) {
            return [
                'success' => false,
                'error' => 'Webhook URL not configured',
            ];
        }

        $testPayload = [
            'session_id' => 'test-session-' . uniqid(),
            'chatInput' => 'Test connection from Lunaray Beauty Factory',
        ];

        try {
            $response = $this->makeRequest($testPayload);
            
            return [
                'success' => true,
                'response_time' => $response->transferStats->getHandlerStat('total_time'),
                'status_code' => $response->status(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Build the payload to send to the webhook.
     */
    protected function buildPayload(ChatSession $session, ChatMessage $userMessage): array
    {
        // Get recent conversation history for context
        $recentMessages = $session->messages()
            ->orderBy('sent_at', 'desc')
            ->limit(10)
            ->get()
            ->reverse()
            ->map(function ($message) {
                return [
                    'type' => $message->type,
                    'content' => $message->content,
                    'timestamp' => $message->sent_at->toISOString(),
                ];
            })
            ->toArray();

        return [
            'session_id' => $session->session_id,
            'chatInput' => $userMessage->content,
        ];
    }

    /**
     * Make the HTTP request to the webhook.
     */
    protected function makeRequest(array $payload): Response
    {
        $attempt = 0;
        $lastException = null;

        while ($attempt < $this->retryAttempts) {
            try {
                $response = Http::timeout($this->timeout)
                    ->withHeaders([
                        'Content-Type' => 'application/json',
                        'User-Agent' => 'Lunaray-Chatbot/1.0',
                        'X-Request-ID' => uniqid(),
                    ])
                    ->post($this->webhookUrl, $payload);

                if ($response->successful()) {
                    return $response;
                }

                // Log non-successful responses
                Log::warning('Webhook returned non-successful status', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'attempt' => $attempt + 1,
                ]);

                if ($response->status() >= 400 && $response->status() < 500) {
                    // Client error, don't retry
                    throw new \Exception("Webhook returned client error: {$response->status()}");
                }

            } catch (\Exception $e) {
                $lastException = $e;
                $attempt++;
                
                if ($attempt < $this->retryAttempts) {
                    // Wait before retry (exponential backoff)
                    $waitTime = pow(2, $attempt) * 1000; // milliseconds
                    usleep($waitTime * 1000); // convert to microseconds
                }
            }
        }

        throw $lastException ?? new \Exception('Webhook request failed after all retry attempts');
    }

    /**
     * Parse the response from the webhook.
     */
    protected function parseResponse(Response $response): array
    {
        $data = $response->json();

        if (!$data) {
            throw new \Exception('Invalid JSON response from webhook');
        }

        // Validate required fields - n8n returns 'output' field
        if (!isset($data['output'])) {
            throw new \Exception('Webhook response missing required "output" field');
        }

        return [
            'content' => $data['output'],
            'metadata' => $data['metadata'] ?? null,
        ];
    }

    /**
     * Get webhook configuration status.
     */
    public function getConfigurationStatus(): array
    {
        return [
            'webhook_url' => !empty($this->webhookUrl),
            'timeout' => $this->timeout,
            'retry_attempts' => $this->retryAttempts,
            'last_configured' => ChatbotConfiguration::where('key', 'webhook_url')
                ->first()?->updated_at,
        ];
    }
}
