<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\AliasLoader;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append:[
            \App\Http\Middleware\LocaleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

    

    require_once __DIR__.'/../vendor/autoload.php';

    $app = new Laravel\Lumen\Application(
        dirname(__DIR__)
    );

    $app->withFacades();
    $app->withEloquent();

    // Register the DOMPDF service provider
    $app->register(Barryvdh\DomPDF\ServiceProvider::class);
    $app->register(Mccarlosen\LaravelMpdf\LaravelMpdfServiceProvider::class);

    // Register the alias dynamically
    $loader = AliasLoader::getInstance();
    $loader->alias('PDF', Mccarlosen\LaravelMpdf\Facades\LaravelMpdf::class);

    // Load the DOMPDF configuration
    $app->configure('dompdf');

    // Include other configurations or middleware as needed

    return $app;


