<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function map()
    {
        $this->mapApi1Routes();
        $this->mapApi2Routes();
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'namespace' => $this->namespace, 'middleware' => 'web',
        ], function ($router) {
            require base_path('routes/web.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApi1Routes()
    {
        Route::group([
            'middleware' => 'auth:api',
            'namespace' => $this->namespace .'\API\V1',
            'prefix' => 'api/v1',
        ], function ($router) {
            require base_path('routes/api1.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApi2Routes()
    {
        Route::group([
            'middleware' => 'auth:api',
            'namespace' => $this->namespace .'\API\V2',
            'prefix' => 'api/v2',
        ], function ($router) {
            require base_path('routes/api2.php');
        });

        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace .'\API\V2',
            'prefix' => 'ajax',
        ], function ($router) {
            require base_path('routes/api2.php');
        });
    }
}
