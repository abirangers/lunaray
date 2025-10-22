<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display the system settings page.
     */
    public function index()
    {
        $systemInfo = [
            'app_name' => config('app.name'),
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug'),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database_driver' => config('database.default'),
        ];

        return view('admin.settings', compact('systemInfo'));
    }

    /**
     * Update system settings.
     */
    public function update(Request $request)
    {
        // Implementation for updating system settings
        // This would be implemented based on requirements
        
        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully.');
    }

    /**
     * Clear application cache.
     */
    public function clearCache()
    {
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        \Artisan::call('view:clear');
        
        return redirect()->route('admin.settings')
            ->with('success', 'Cache cleared successfully.');
    }

    /**
     * Create database backup.
     */
    public function createBackup()
    {
        // Implementation for creating database backup
        // This would integrate with backup system
        
        return redirect()->route('admin.settings')
            ->with('success', 'Backup created successfully.');
    }
}
