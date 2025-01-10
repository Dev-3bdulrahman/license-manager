<?php

namespace Dev3bdulrahman\LicenseManager;

use Illuminate\Support\ServiceProvider;
use Dev3bdulrahman\LicenseManager\Services\LicenseManager;

class LicenseManagerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(LicenseManager::class, function ($app) {
            return new LicenseManager();
        });
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'license-manager');
        
        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/license-manager'),
            __DIR__ . '/../database/migrations' => database_path('migrations')
        ], 'license-manager');
    }
}