<?php

namespace App\Providers;

use App\Auctioneer\Auctioneer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            Auctioneer::class,
            function ($app) {
                return new Auctioneer();
            }
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
