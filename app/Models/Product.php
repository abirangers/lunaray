<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_category_id',
        'name',
        'slug',
        'description',
        'features',
        'order',
        'is_featured',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'features' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to order products by order field.
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
        $this->addMediaCollection('product_image')
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
            ->width(1200)
            ->height(800)
            ->format('webp')
            ->nonQueued();
    }
}
