<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\CheckPanelPassword;
use App\Http\Middleware\IsResellerMiddleware;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register the panel.password binding to fix the "Target class [panel.password] does not exist" error
        $this->app->bind('panel.password', function ($app) {
            return new CheckPanelPassword();
        });
        
        // Register the is.reseller binding to fix the "Target class [is.reseller] does not exist" error
        $this->app->bind('is.reseller', function ($app) {
            return new IsResellerMiddleware();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
