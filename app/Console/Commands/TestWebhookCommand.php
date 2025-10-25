<?php

namespace App\Console\Commands;

use App\Services\ChatbotWebhookService;
use Illuminate\Console\Command;

class TestWebhookCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'webhook:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test n8n webhook connection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Testing n8n Webhook Connection...');
        $this->newLine();

        try {
            $webhookService = new ChatbotWebhookService();
            $result = $webhookService->testConnection();
            
            if ($result['success']) {
                $this->info('✅ Webhook connection SUCCESS!');
                $this->line('📊 Response time: ' . ($result['response_time'] ?? 'N/A') . 's');
                $this->line('📊 Status code: ' . ($result['status_code'] ?? 'N/A'));
            } else {
                $this->error('❌ Webhook connection FAILED!');
                $this->line('🚨 Error: ' . ($result['error'] ?? 'Unknown error'));
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Exception: ' . $e->getMessage());
        }

        $this->newLine();
        $this->info('🔧 Configuration Status:');
        $config = $webhookService->getConfigurationStatus();
        foreach ($config as $key => $value) {
            $this->line("  $key: " . (is_bool($value) ? ($value ? 'true' : 'false') : $value));
        }
    }
}
