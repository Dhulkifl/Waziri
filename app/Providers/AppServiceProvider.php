<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        // Register Milon Barcode provider
        


       // Register the alias dynamically
       $loader = AliasLoader::getInstance();
       $loader->alias('PDF', Mccarlosen\LaravelMpdf\Facades\LaravelMpdf::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
