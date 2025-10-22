<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContentManagerController extends Controller
{
    /**
     * Display the content manager dashboard.
     */
    public function dashboard()
    {
        // Get statistics
        $stats = [
            'total_articles' => Article::count(),
            'published_articles' => Article::published()->count(),
            'draft_articles' => Article::draft()->count(),
            'featured_articles' => Article::featured()->count(),
            'total_categories' => Category::active()->count(),
            'total_views' => Article::sum('view_count'),
        ];

        // Get recent articles
        $recent_articles = Article::with(['author', 'categories'])
            ->latest()
            ->limit(5)
            ->get();

        // Get draft articles that need attention
        $draft_articles = Article::draft()
            ->with(['author', 'categories'])
            ->latest()
            ->limit(5)
            ->get();

        // Get popular articles (by view count)
        $popular_articles = Article::published()
            ->with(['author', 'categories'])
            ->orderBy('view_count', 'desc')
            ->limit(5)
            ->get();

        // Get articles by category
        $articles_by_category = Category::withCount('articles')
            ->having('articles_count', '>', 0)
            ->orderBy('articles_count', 'desc')
            ->limit(10)
            ->get();

        // Get monthly article statistics
        $monthly_stats = Article::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recent_articles',
            'draft_articles',
            'popular_articles',
            'articles_by_category',
            'monthly_stats'
        ));
    }

    /**
     * Get analytics data for articles.
     */
    public function analytics(Request $request)
    {
        $query = Article::query();

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->where('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('created_at', '<=', $request->end_date);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $articles = $query->with(['author', 'categories'])
            ->orderBy('view_count', 'desc')
            ->paginate(20);

        $categories = Category::active()->get();

        return view('admin.analytics', compact('articles', 'categories'));
    }
}
