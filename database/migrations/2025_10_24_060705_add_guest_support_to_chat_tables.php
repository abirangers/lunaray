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
        // Modify chat_sessions table
        Schema::table('chat_sessions', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
            $table->boolean('is_guest')->default(false)->after('user_id');
            $table->string('ip_address')->nullable()->after('is_guest');
            $table->timestamp('expires_at')->nullable()->after('last_activity_at');
            
            $table->index(['is_guest', 'expires_at']);
            $table->index('ip_address');
        });

        // Modify chat_messages table
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert chat_sessions table
        Schema::table('chat_sessions', function (Blueprint $table) {
            $table->dropIndex(['is_guest', 'expires_at']);
            $table->dropIndex(['ip_address']);
            $table->dropColumn(['is_guest', 'ip_address', 'expires_at']);
            $table->foreignId('user_id')->nullable(false)->change();
        });

        // Revert chat_messages table
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};