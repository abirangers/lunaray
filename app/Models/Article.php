<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'is_featured',
        'status',
        'published_at',
        'view_count',
        'author_id',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'view_count' => 'integer',
    ];

    protected $richTextAttributes = [
        'content',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });

        static::updating(function ($article) {
            if ($article->isDirty('title') && empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    /**
     * Get the author that owns the article.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the categories for the article.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'article_categories');
    }

    /**
     * Scope a query to only include published articles.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at');
    }

    /**
     * Scope a query to only include featured articles.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include draft articles.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Get the article's SEO data.
     */
    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->title,
            description: $this->excerpt ?: Str::limit(strip_tags($this->content->toPlainText()), 160),
            url: route('articles.show', $this->slug),
            image: $this->featured_image,
            published_time: $this->published_at,
            modified_time: $this->updated_at,
            author: $this->author->name ?? 'Lunaray Beauty Factory',
        );
    }

    /**
     * Increment the view count.
     */
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
