<?php

namespace Dev3bdulrahman\LicenseManager;

use Dev3bdulrahman\LicenseManager\Services\LicenseManager;
use Illuminate\Support\ServiceProvider;

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
        // تحميل الـ migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // تحميل الـ routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // تحميل الـ views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'license-manager');

        // نشر الـ views والـ migrations
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/license-manager'),
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'license-manager');
    }
}
