<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'status',
        'last_activity_at',
        'metadata',
        'is_guest',
        'ip_address',
        'expires_at',
    ];

    protected $casts = [
        'last_activity_at' => 'datetime',
        'metadata' => 'array',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user that owns the chat session.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the messages for the chat session.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class)->orderBy('sent_at');
    }

    /**
     * Get the latest message for the chat session.
     */
    public function latestMessage(): HasMany
    {
        return $this->hasMany(ChatMessage::class)->latest('sent_at');
    }

    /**
     * Check if the session is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Mark session as closed.
     */
    public function close(): void
    {
        $this->update(['status' => 'closed']);
    }

    /**
     * Update last activity timestamp.
     */
    public function updateActivity(): void
    {
        $this->update(['last_activity_at' => now()]);
    }

    /**
     * Check if the session is expired.
     */
    public function isExpired(): bool
    {
        if (!$this->expires_at) {
            return false;
        }
        
        return $this->expires_at->isPast();
    }

    /**
     * Check if this is a guest session.
     */
    public function isGuest(): bool
    {
        return $this->is_guest;
    }
}
