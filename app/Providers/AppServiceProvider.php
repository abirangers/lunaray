<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Skip in console/artisan commands
        if (app()->runningInConsole()) {
            return;
        }

        try {
            $request = request();
            
            if (!$request) {
                return;
            }
            
            // Force HTTPS in production environment (if APP_URL is HTTPS)
            if (app()->environment('production')) {
                $appUrl = config('app.url', '');
                if (str_starts_with($appUrl, 'https://')) {
                    URL::forceScheme('https');
                }
                return; // Don't process ngrok logic in production
            }
            
            // Only handle ngrok detection in non-production environments
            // This ensures production is not affected by ngrok-specific logic
            if ($this->isNgrokRequest($request)) {
                // Force HTTPS for all URLs when using ngrok
                URL::forceScheme('https');
                
                // Override APP_URL if ngrok URL is detected
                $ngrokUrl = $this->getNgrokUrl($request);
                if ($ngrokUrl) {
                    config(['app.url' => $ngrokUrl]);
                    config(['filesystems.disks.public.url' => $ngrokUrl . '/storage']);
                    config(['filesystems.disks.media.url' => $ngrokUrl . '/media']);
                }
            }
        } catch (\Exception $e) {
            // Silently fail if request is not available yet
            // This can happen during early boot
        }
    }

    /**
     * Check if request is coming through ngrok
     */
    private function isNgrokRequest(Request $request): bool
    {
        $host = $request->getHost();
        
        // Check if host contains ngrok domain patterns
        return str_contains($host, 'ngrok') || 
               str_contains($host, 'ngrok-free.app') ||
               str_contains($host, 'ngrok.io');
    }

    /**
     * Get ngrok URL from request
     */
    private function getNgrokUrl(Request $request): ?string
    {
        $host = $request->getHost();
        
        if ($this->isNgrokRequest($request)) {
            $scheme = $request->getScheme();
            $port = $request->getPort();
            
            // Build URL with proper scheme (force HTTPS for ngrok)
            $url = 'https://' . $host;
            
            // Only add port if it's not default (443 for HTTPS, 80 for HTTP)
            if ($port && $port !== 443 && $port !== 80) {
                $url .= ':' . $port;
            }
            
            return $url;
        }
        
        return null;
    }
}
