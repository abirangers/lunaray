<?php

namespace Database\Seeders;

use App\Models\ChatbotConfiguration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatbotConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configurations = [
            [
                'key' => 'chatbot_active',
                'value' => 'true',
                'description' => 'Enable or disable the chatbot service',
                'is_active' => true,
            ],
            [
                'key' => 'webhook_enabled',
                'value' => 'true',
                'description' => 'Enable or disable webhook integration',
                'is_active' => true,
            ],
            [
                'key' => 'webhook_url',
                'value' => '',
                'description' => 'n8n webhook URL for chatbot integration',
                'is_active' => true,
            ],
            [
                'key' => 'webhook_timeout',
                'value' => '30',
                'description' => 'Webhook request timeout in seconds',
                'is_active' => true,
            ],
            [
                'key' => 'webhook_retry_attempts',
                'value' => '3',
                'description' => 'Number of retry attempts for failed webhook requests',
                'is_active' => true,
            ],
        ];

        foreach ($configurations as $config) {
            ChatbotConfiguration::updateOrCreate(
                ['key' => $config['key']],
                $config
            );
        }

        $this->command->info('Chatbot configurations seeded successfully!');
    }
}
