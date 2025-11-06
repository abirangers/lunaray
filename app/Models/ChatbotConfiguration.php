<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatbotConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get configuration value by key.
     */
    public static function getValue(string $key, $default = null)
    {
        $config = static::where('key', $key)
            ->where('is_active', true)
            ->first();

        return $config ? $config->value : $default;
    }

    /**
     * Set configuration value by key.
     */
    public static function setValue(string $key, $value, ?string $description = null): void
    {
        static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'description' => $description,
                'is_active' => true,
            ]
        );
    }

    /**
     * Get all active configurations.
     */
    public static function getAllActive(): array
    {
        return static::where('is_active', true)
            ->pluck('value', 'key')
            ->toArray();
    }
}
