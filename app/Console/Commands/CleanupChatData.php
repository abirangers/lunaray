<?php

namespace App\Console\Commands;

use App\Models\ChatSession;
use App\Models\ChatMessage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupChatData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:cleanup {--dry-run : Show what would be deleted without actually deleting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old chat sessions and messages based on retention policy';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        
        if ($isDryRun) {
            $this->info('DRY RUN MODE - No data will be deleted');
        }

        // Get cleanup configuration
        $sessionRetentionDays = $this->getConfigValue('session_retention_days', 30);
        $messageRetentionDays = $this->getConfigValue('message_retention_days', 90);
        $cleanupEnabled = $this->getConfigValue('cleanup_enabled', 'true') === 'true';

        if (!$cleanupEnabled) {
            $this->info('Chat cleanup is disabled in configuration');
            return;
        }

        $this->info("Starting chat data cleanup...");
        $this->info("Session retention: {$sessionRetentionDays} days");
        $this->info("Message retention: {$messageRetentionDays} days");

        // Clean up old sessions
        $this->cleanupSessions($sessionRetentionDays, $isDryRun);
        
        // Clean up old messages
        $this->cleanupMessages($messageRetentionDays, $isDryRun);

        $this->info('Chat data cleanup completed');
    }

    /**
     * Get configuration value from database
     */
    private function getConfigValue(string $key, $default = null)
    {
        $config = DB::table('chat_cleanup_config')
            ->where('key', $key)
            ->first();
            
        return $config ? $config->value : $default;
    }

    /**
     * Clean up old chat sessions
     */
    private function cleanupSessions(int $retentionDays, bool $isDryRun)
    {
        $cutoffDate = now()->subDays($retentionDays);
        
        $query = ChatSession::where('last_activity_at', '<', $cutoffDate)
            ->where('status', 'closed');
            
        $count = $query->count();
        
        if ($count === 0) {
            $this->info("No old sessions to clean up");
            return;
        }
        
        if ($isDryRun) {
            $this->info("Would delete {$count} old sessions (older than {$retentionDays} days)");
        } else {
            $deleted = $query->delete();
            $this->info("Deleted {$deleted} old sessions");
        }
    }

    /**
     * Clean up old chat messages
     */
    private function cleanupMessages(int $retentionDays, bool $isDryRun)
    {
        $cutoffDate = now()->subDays($retentionDays);
        
        $query = ChatMessage::where('sent_at', '<', $cutoffDate);
        
        $count = $query->count();
        
        if ($count === 0) {
            $this->info("No old messages to clean up");
            return;
        }
        
        if ($isDryRun) {
            $this->info("Would delete {$count} old messages (older than {$retentionDays} days)");
        } else {
            $deleted = $query->delete();
            $this->info("Deleted {$deleted} old messages");
        }
    }
}