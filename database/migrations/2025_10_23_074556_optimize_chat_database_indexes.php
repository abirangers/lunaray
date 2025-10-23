<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('chat_sessions', function (Blueprint $table) {
            // Add composite index for better query performance
            $table->index(['user_id', 'status', 'last_activity_at'], 'idx_user_status_activity');
            
            // Add index for session_id lookups (already unique, but explicit index)
            $table->index('session_id', 'idx_session_id');
        });

        Schema::table('chat_messages', function (Blueprint $table) {
            // Add composite index for session message queries
            $table->index(['chat_session_id', 'type', 'sent_at'], 'idx_session_type_sent');
            
            // Add index for user message queries
            $table->index(['user_id', 'sent_at'], 'idx_user_sent');
            
            // Add index for content search (if needed for analytics)
            $table->index(['type', 'sent_at'], 'idx_type_sent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_sessions', function (Blueprint $table) {
            $table->dropIndex('idx_user_status_activity');
            $table->dropIndex('idx_session_id');
        });

        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropIndex('idx_session_type_sent');
            $table->dropIndex('idx_user_sent');
            $table->dropIndex('idx_type_sent');
        });
    }
};