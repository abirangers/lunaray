<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check if user is admin/content manager
        if (auth()->check() && auth()->user()->can('edit articles')) {
            return $this->adminIndex($request);
        }

        return $this->publicIndex($request);
    }

    /**
     * Admin articles index
     */
    private function adminIndex(Request $request)
    {
        $query = Article::with(['author', 'categories']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->get('category'));
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Filter by featured
        if ($request->boolean('featured')) {
            $query->featured();
        }

        $articles = $query->latest('created_at')->paginate(15);
        $categories = Category::active()->get();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    /**
     * Public articles index
     */
    private function publicIndex(Request $request)
    {
        $query = Article::published()->with(['author', 'categories']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->get('category'));
            });
        }

        $articles = $query->latest('published_at')->paginate(12);
        $categories = Category::active()->withCount('articles')->get();
        
        // Get featured articles
        $featured_articles = Article::published()->featured()->with(['author', 'categories'])->latest('published_at')->limit(3)->get();
        
        // Get popular articles
        $popular_articles = Article::published()->with(['author', 'categories'])->orderBy('view_count', 'desc')->limit(5)->get();

        return view('articles.index', compact('articles', 'categories', 'featured_articles', 'popular_articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'status' => 'required|in:draft,published',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $data = $request->all();
        $data['author_id'] = Auth::id();
        
        // Generate unique slug
        $baseSlug = Str::slug($request->title);
        $slug = $baseSlug;
        $counter = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        $data['slug'] = $slug;

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        // Set published_at if status is published
        if ($request->status === 'published') {
            $data['published_at'] = now();
        }

        $article = Article::create($data);

        // Attach categories
        if ($request->has('categories')) {
            $article->categories()->attach($request->categories);
        }

        return redirect()->route('articles.index')
            ->with('success', 'Article created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        // Increment view count
        $article->incrementViewCount();

        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $categories = Category::active()->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'status' => 'required|in:draft,published',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $data = $request->all();

        // Update slug if title changed
        if ($article->title !== $request->title) {
            $baseSlug = Str::slug($request->title);
            $slug = $baseSlug;
            $counter = 1;
            while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $data['slug'] = $slug;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        // Set published_at if status changed to published
        if ($request->status === 'published' && $article->status !== 'published') {
            $data['published_at'] = now();
        }

        $article->update($data);

        // Sync categories
        if ($request->has('categories')) {
            $article->categories()->sync($request->categories);
        } else {
            $article->categories()->detach();
        }

        return redirect()->route('articles.index')
            ->with('success', 'Article updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        // Delete featured image
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Article deleted successfully.');
    }

    /**
     * Bulk actions for articles
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:publish,unpublish,delete,feature,unfeature',
            'articles' => 'required|array',
            'articles.*' => 'exists:articles,id',
        ]);

        $articles = Article::whereIn('id', $request->articles);

        switch ($request->action) {
            case 'publish':
                $articles->update([
                    'status' => 'published',
                    'published_at' => now()
                ]);
                $message = 'Articles published successfully.';
                break;

            case 'unpublish':
                $articles->update([
                    'status' => 'draft',
                    'published_at' => null
                ]);
                $message = 'Articles unpublished successfully.';
                break;

            case 'delete':
                // Delete featured images first
                $articlesToDelete = $articles->get();
                foreach ($articlesToDelete as $article) {
                    if ($article->featured_image) {
                        Storage::disk('public')->delete($article->featured_image);
                    }
                }
                $articles->delete();
                $message = 'Articles deleted successfully.';
                break;

            case 'feature':
                $articles->update(['is_featured' => true]);
                $message = 'Articles marked as featured successfully.';
                break;

            case 'unfeature':
                $articles->update(['is_featured' => false]);
                $message = 'Articles unmarked as featured successfully.';
                break;
        }

        return redirect()->route('articles.index')
            ->with('success', $message);
    }

    /**
     * Toggle article status
     */
    public function toggleStatus(Article $article)
    {
        if ($article->status === 'draft') {
            $article->update([
                'status' => 'published',
                'published_at' => now()
            ]);
            $message = 'Article published successfully.';
        } else {
            $article->update([
                'status' => 'draft',
                'published_at' => null
            ]);
            $message = 'Article moved to draft successfully.';
        }

        return redirect()->back()
            ->with('success', $message);
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Article $article)
    {
        $article->update(['is_featured' => !$article->is_featured]);
        
        $message = $article->is_featured 
            ? 'Article marked as featured successfully.'
            : 'Article unmarked as featured successfully.';

        return redirect()->back()
            ->with('success', $message);
    }
}
