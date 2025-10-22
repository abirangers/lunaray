<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_session_id',
        'user_id',
        'type',
        'content',
        'metadata',
        'sent_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'sent_at' => 'datetime',
    ];

    /**
     * Get the chat session that owns the message.
     */
    public function chatSession(): BelongsTo
    {
        return $this->belongsTo(ChatSession::class);
    }

    /**
     * Get the user that sent the message.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the message is from a user.
     */
    public function isUserMessage(): bool
    {
        return $this->type === 'user';
    }

    /**
     * Check if the message is from the bot.
     */
    public function isBotMessage(): bool
    {
        return $this->type === 'bot';
    }

    /**
     * Check if the message is a system message.
     */
    public function isSystemMessage(): bool
    {
        return $this->type === 'system';
    }

    /**
     * Get formatted content with basic HTML formatting.
     */
    public function getFormattedContentAttribute(): string
    {
        $content = htmlspecialchars($this->content, ENT_QUOTES, 'UTF-8');
        
        // Convert line breaks to <br> tags
        $content = nl2br($content);
        
        // Convert URLs to clickable links
        $content = preg_replace(
            '/(https?:\/\/[^\s]+)/',
            '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>',
            $content
        );
        
        return $content;
    }
}
