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
        // Add soft delete columns for better data management
        Schema::table('chat_sessions', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('chat_messages', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add cleanup configuration table
        Schema::create('chat_cleanup_config', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default cleanup configuration
        DB::table('chat_cleanup_config')->insert([
            [
                'key' => 'session_retention_days',
                'value' => '30',
                'description' => 'Number of days to keep chat sessions',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'message_retention_days',
                'value' => '90',
                'description' => 'Number of days to keep chat messages',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'cleanup_enabled',
                'value' => 'true',
                'description' => 'Enable automatic cleanup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_cleanup_config');
        
        Schema::table('chat_sessions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};