<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\SchemaCollection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Article extends Model implements HasMedia
{
    use HasFactory, HasSEO, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'is_featured',
        'status',
        'published_at',
        'view_count',
        'author_id',
        'author_name',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'view_count' => 'integer',
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
            description: $this->excerpt ?: Str::limit(strip_tags($this->content ?? ''), 160),
            url: '#',
            image: $this->featured_image,
            published_time: $this->published_at,
            modified_time: $this->updated_at,
            author: $this->author->name ?? 'Lunaray Beauty Factory',
            section: $this->categories->first()?->name,
            tags: $this->categories->pluck('name')->toArray(),
            schema: SchemaCollection::make()
                ->addArticle(),
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
     * Increment view count with session-based duplicate prevention and bot protection.
     */
    public function incrementViewCountWithSession()
    {
        // Check if this is a bot request
        if ($this->isBotRequest()) {
            return;
        }

        // Check if user has already viewed this article in this session
        $viewedArticles = session('viewed_articles', []);
        
        if (in_array($this->id, $viewedArticles)) {
            return; // Already viewed in this session
        }

        // Add to viewed articles in session (limit to 50 articles)
        $viewedArticles[] = $this->id;
        if (count($viewedArticles) > 50) {
            $viewedArticles = array_slice($viewedArticles, -50); // Keep only last 50
        }
        
        session(['viewed_articles' => $viewedArticles]);

        // Increment view count through cache-based batch updates
        $this->incrementViewCountWithCache();
    }

    /**
     * Check if the current request is from a bot.
     */
    public function isBotRequest()
    {
        $userAgent = request()->userAgent();
        
        if (!$userAgent) {
            return true; // No user agent, likely a bot
        }

        $botPatterns = [
            'bot', 'crawler', 'spider', 'scraper', 'curl', 'wget',
            'googlebot', 'bingbot', 'slurp', 'duckduckbot', 'baiduspider',
            'yandexbot', 'facebookexternalhit', 'twitterbot', 'linkedinbot'
        ];

        $userAgentLower = strtolower($userAgent);
        
        foreach ($botPatterns as $pattern) {
            if (str_contains($userAgentLower, $pattern)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Increment view count through cache-based batch updates.
     */
    private function incrementViewCountWithCache()
    {
        $cacheKey = "article_views_{$this->id}";
        $lastSyncKey = "article_views_sync_{$this->id}";
        
        // Get current views from cache or database
        $views = Cache::get($cacheKey, $this->view_count);
        $views++;
        
        // Store in cache
        Cache::put($cacheKey, $views, 3600); // 1 hour
        
        // Update database every 10 views or if it's been more than an hour since last sync
        $shouldSync = ($views % 10 === 0) || !Cache::has($lastSyncKey);
        
        if ($shouldSync) {
            $this->update(['view_count' => $views]);
            Cache::put($lastSyncKey, true, 3600); // 1 hour
        }
    }

    /**
     * Get the author name for display.
     */
    public function getAuthorNameAttribute($value)
    {
        return $value ?: $this->author->name;
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Register media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp']);
            
        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp']);
    }

    /**
     * Register media conversions.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(200)
            ->sharpen(10)
            ->performOnCollections('featured', 'gallery')
            ->queued();
            
        $this->addMediaConversion('medium')
            ->width(800)
            ->height(600)
            ->performOnCollections('featured', 'gallery')
            ->queued();
            
        $this->addMediaConversion('large')
            ->width(1200)
            ->height(800)
            ->performOnCollections('featured', 'gallery')
            ->queued();
    }
}
