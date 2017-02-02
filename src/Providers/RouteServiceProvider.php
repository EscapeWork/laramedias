<?php

namespace EscapeWork\LaraMedias\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'EscapeWork\LaraMedias\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    // public function boot()
    // {
    //     parent::boot();
    // }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        if (!$this->app->routesAreCached()) {
            Route::group(['namespace' => 'EscapeWork\LaraMedias\Http\Controllers'], function () {
                require __DIR__.'/../Http/routes.php';
            });
        }
    }
}
