<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContentManagerController extends Controller
{
    /**
     * Display the unified admin dashboard for both content managers and admins.
     */
    public function dashboard()
    {
        // Get base statistics (available to all staff)
        $stats = [
            'total_articles' => Article::count(),
            'published_articles' => Article::published()->count(),
            'draft_articles' => Article::draft()->count(),
            'featured_articles' => Article::featured()->count(),
            'total_categories' => Category::active()->count(),
            'total_views' => Article::sum('view_count'),
        ];

        // Add admin-specific statistics if user is admin
        if (auth()->user()->hasRole('admin')) {
            $stats = array_merge($stats, [
                'total_users' => \App\Models\User::count(),
                'active_sessions' => \App\Models\ChatSession::where('status', 'active')->count(),
                'total_sessions' => \App\Models\ChatSession::count(),
                'system_health' => $this->getSystemHealthMetrics(),
            ]);
        }

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

        // Get articles by category (SQLite compatible)
        $articles_by_category = Category::withCount('articles')
            ->whereHas('articles')
            ->orderBy('articles_count', 'desc')
            ->limit(10)
            ->get();

        // Get monthly article statistics (compatible with both SQLite and MySQL)
        $connection = DB::connection();
        $driver = $connection->getDriverName();
        
        if ($driver === 'sqlite') {
            $monthly_stats = Article::select(
                    DB::raw('strftime("%Y-%m", created_at) as month'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        } else {
            // MySQL/MariaDB/PostgreSQL
            $monthly_stats = Article::select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        }

        // Get admin-specific data if user is admin
        $admin_data = [];
        if (auth()->user()->hasRole('admin')) {
            $admin_data = [
                'recent_users' => \App\Models\User::with('roles')
                    ->latest()
                    ->limit(5)
                    ->get(),
                'user_registrations' => $this->getUserRegistrationStats(),
                'system_metrics' => $this->getSystemMetrics(),
            ];
        }

        return view('admin.dashboard', compact(
            'stats',
            'recent_articles',
            'draft_articles',
            'popular_articles',
            'articles_by_category',
            'monthly_stats',
            'admin_data'
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

    /**
     * Get system health metrics for admin users.
     */
    private function getSystemHealthMetrics()
    {
        return [
            'database_size' => $this->getDatabaseSize(),
            'cache_status' => $this->getCacheStatus(),
            'storage_usage' => $this->getStorageUsage(),
            'last_backup' => $this->getLastBackupDate(),
        ];
    }

    /**
     * Get user registration statistics for admin users.
     */
    private function getUserRegistrationStats()
    {
        return [
            'this_month' => \App\Models\User::whereMonth('created_at', now()->month)->count(),
            'last_month' => \App\Models\User::whereMonth('created_at', now()->subMonth()->month)->count(),
            'this_year' => \App\Models\User::whereYear('created_at', now()->year)->count(),
            'total_registrations' => \App\Models\User::count(),
        ];
    }

    /**
     * Get system metrics for admin users.
     */
    private function getSystemMetrics()
    {
        return [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'memory_usage' => memory_get_usage(true),
            'peak_memory' => memory_get_peak_usage(true),
            'uptime' => $this->getSystemUptime(),
        ];
    }

    /**
     * Get database size in MB.
     */
    private function getDatabaseSize()
    {
        try {
            $result = DB::select("SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'size' FROM information_schema.tables WHERE table_schema = ?", [config('database.connections.mysql.database')]);
            return $result[0]->size ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get cache status.
     */
    private function getCacheStatus()
    {
        try {
            \Cache::put('health_check', 'ok', 60);
            $status = \Cache::get('health_check') === 'ok';
            \Cache::forget('health_check');
            return $status ? 'healthy' : 'unhealthy';
        } catch (\Exception $e) {
            return 'unhealthy';
        }
    }

    /**
     * Get storage usage in MB.
     */
    private function getStorageUsage()
    {
        $storagePath = storage_path();
        $totalSize = 0;
        
        if (is_dir($storagePath)) {
            $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($storagePath));
            foreach ($iterator as $file) {
                if ($file->isFile()) {
                    $totalSize += $file->getSize();
                }
            }
        }
        
        return round($totalSize / 1024 / 1024, 2);
    }

    /**
     * Get last backup date (placeholder - would integrate with backup system).
     */
    private function getLastBackupDate()
    {
        // This would integrate with your backup system
        // For now, return a placeholder
        return 'Not configured';
    }

    /**
     * Get system uptime (placeholder).
     */
    private function getSystemUptime()
    {
        // This would get actual system uptime
        // For now, return a placeholder
        return 'N/A';
    }
}
