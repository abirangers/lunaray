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

        // Enhanced search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
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

        // Filter by author
        if ($request->filled('author')) {
            $query->where('author_id', $request->get('author'));
        }

        // Filter by featured
        if ($request->boolean('featured')) {
            $query->featured();
        }

        // Filter by has image
        if ($request->boolean('has_image')) {
            $query->whereNotNull('featured_image');
        }

        // Filter by high views
        if ($request->boolean('high_views')) {
            $query->where('view_count', '>=', 100);
        }

        // Sorting options
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        $allowedSorts = ['created_at', 'updated_at', 'title', 'view_count', 'status'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest('created_at');
        }

        $articles = $query->paginate(15);
        $categories = Category::active()->withCount('articles')->get();
        $authors = \App\Models\User::whereHas('articles')->select('id', 'name')->get();

        return view('admin.articles.index', compact('articles', 'categories', 'authors'));
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

    /**
     * Auto-save article draft
     */
    public function autoSave(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'article_id' => 'nullable|exists:articles,id',
        ]);

        $data = $request->only(['title', 'excerpt', 'content']);
        $data['author_id'] = Auth::id();
        $data['status'] = 'draft'; // Auto-save as draft
        $data['updated_at'] = now();

        if ($request->filled('article_id')) {
            // Update existing article
            $article = Article::findOrFail($request->article_id);
            $article->update($data);
        } else {
            // Create new draft
            $data['slug'] = Str::slug($request->title ?? 'untitled-' . time());
            $article = Article::create($data);
        }

        return response()->json([
            'success' => true,
            'article_id' => $article->id,
            'saved_at' => $article->updated_at->format('M j, Y g:i A'),
            'message' => 'Draft saved successfully'
        ]);
    }

    /**
     * Get article preview
     */
    public function preview(Article $article)
    {
        return response()->json([
            'title' => $article->title,
            'excerpt' => $article->excerpt,
            'content' => $article->content,
            'status' => $article->status,
            'is_featured' => $article->is_featured,
            'categories' => $article->categories->pluck('name'),
            'author' => $article->author->name,
            'created_at' => $article->created_at->format('M j, Y'),
            'updated_at' => $article->updated_at->format('M j, Y g:i A'),
        ]);
    }

    /**
     * Duplicate article
     */
    public function duplicate(Article $article)
    {
        $newArticle = $article->replicate();
        $newArticle->title = $article->title . ' (Copy)';
        $newArticle->slug = Str::slug($newArticle->title);
        $newArticle->status = 'draft';
        $newArticle->published_at = null;
        $newArticle->view_count = 0;
        $newArticle->is_featured = false;
        $newArticle->author_id = Auth::id();
        $newArticle->save();

        // Copy categories
        $newArticle->categories()->attach($article->categories->pluck('id'));

        return redirect()->route('articles.edit', $newArticle)
            ->with('success', 'Article duplicated successfully.');
    }

    /**
     * Export articles
     */
    public function export(Request $request)
    {
        $query = Article::with(['author', 'categories']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->get('category'));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->boolean('featured')) {
            $query->featured();
        }

        $articles = $query->latest('created_at')->get();

        $filename = 'articles-export-' . now()->format('Y-m-d-H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($articles) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID', 'Title', 'Slug', 'Excerpt', 'Status', 'Featured', 
                'Author', 'Categories', 'Views', 'Created At', 'Updated At'
            ]);

            // CSV data
            foreach ($articles as $article) {
                fputcsv($file, [
                    $article->id,
                    $article->title,
                    $article->slug,
                    $article->excerpt,
                    $article->status,
                    $article->is_featured ? 'Yes' : 'No',
                    $article->author->name,
                    $article->categories->pluck('name')->join(', '),
                    $article->view_count,
                    $article->created_at->format('Y-m-d H:i:s'),
                    $article->updated_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
