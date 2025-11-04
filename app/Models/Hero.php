<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;

class Hero extends Model implements HasMedia
{
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'order',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($hero) {
            if (empty($hero->slug)) {
                $hero->slug = Str::slug($hero->name);
            }
        });

        static::updating(function ($hero) {
            if ($hero->isDirty('name') && empty($hero->slug)) {
                $hero->slug = Str::slug($hero->name);
            }
        });
    }

    /**
     * Scope a query to only include active heroes.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order heroes by order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    /**
     * Register media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hero_image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    /**
     * Register media conversions.
     *
     * All conversions will be in WebP format:
     * - WebP originals: preserved as WebP
     * - Other formats (JPG, PNG): converted to WebP
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        // Thumb conversion - always WebP
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(200)
            ->format('webp')
            ->nonQueued();
        
        // Medium conversion - always WebP
        $this->addMediaConversion('medium')
            ->width(800)
            ->height(600)
            ->format('webp')
            ->nonQueued();
        
        // Large conversion - always WebP
        $this->addMediaConversion('large')
            ->width(1920)
            ->height(1080)
            ->format('webp')
            ->nonQueued();
    }
}
