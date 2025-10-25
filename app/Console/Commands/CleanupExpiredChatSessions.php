<?php

namespace App\Console\Commands;

use App\Models\ChatSession;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupExpiredChatSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:cleanup-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up expired guest chat sessions and inactive sessions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧹 Starting chat session cleanup...');
        
        // Clean up expired guest sessions
        $expiredSessions = ChatSession::where('is_guest', true)
            ->where(function ($query) {
                $query->where('expires_at', '<', now())
                      ->orWhere('last_activity_at', '<', now()->subDays(7));
            })
            ->get();

        $expiredCount = $expiredSessions->count();
        
        if ($expiredCount > 0) {
            $this->info("Found {$expiredCount} expired guest sessions to clean up...");
            
            // Delete associated messages first
            $sessionIds = $expiredSessions->pluck('id');
            DB::table('chat_messages')->whereIn('chat_session_id', $sessionIds)->delete();
            
            // Delete expired sessions
            $deletedCount = ChatSession::where('is_guest', true)
                ->where(function ($query) {
                    $query->where('expires_at', '<', now())
                          ->orWhere('last_activity_at', '<', now()->subDays(7));
                })
                ->delete();
            
            $this->info("✅ Cleaned up {$deletedCount} expired guest sessions");
        } else {
            $this->info('✅ No expired guest sessions found');
        }
        
        // Clean up inactive sessions (no activity for 30 days)
        $inactiveSessions = ChatSession::where('last_activity_at', '<', now()->subDays(30))
            ->get();
            
        $inactiveCount = $inactiveSessions->count();
        
        if ($inactiveCount > 0) {
            $this->info("Found {$inactiveCount} inactive sessions to clean up...");
            
            // Delete associated messages first
            $sessionIds = $inactiveSessions->pluck('id');
            DB::table('chat_messages')->whereIn('chat_session_id', $sessionIds)->delete();
            
            // Delete inactive sessions
            $deletedInactiveCount = ChatSession::where('last_activity_at', '<', now()->subDays(30))
                ->delete();
            
            $this->info("✅ Cleaned up {$deletedInactiveCount} inactive sessions");
        } else {
            $this->info('✅ No inactive sessions found');
        }
        
        $totalCleaned = $expiredCount + $inactiveCount;
        $this->info("🎉 Cleanup completed! Total sessions cleaned: {$totalCleaned}");
        
        return Command::SUCCESS;
    }
}