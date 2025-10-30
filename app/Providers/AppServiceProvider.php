<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;

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
        // Configure Vite manifest path for production (Vite 7+)
        Vite::useManifestFilename('.vite/manifest.json');
        
        // Force HTTPS in production only
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
            // Trust all proxies (needed for Vercel)
            $this->app['request']->server->set('HTTPS', 'on');
        }
    }
}
