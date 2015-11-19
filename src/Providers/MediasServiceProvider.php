<?php

namespace EscapeWork\LaraMedias\Providers;

use Illuminate\Support\ServiceProvider;
use League\Glide\ServerFactory;

class MediasServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $root = __DIR__ . '/../..';

        $this->publishes([
            $root . '/config/medias.php'   => config_path('medias.php'),
            $root . '/database/migrations' => 'database/migrations',
        ]);

        # loading views and translations from resources
        $this->loadValidators();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $root = __DIR__ . '/../..';

        $this->registerProviders();
        $this->registerGlideServer();

        $this->mergeConfigFrom(
            $root . '/config/medias.php', 'medias'
        );
    }

    /**
     * Creating Glide server and registering it to the containter
     * @return void
     */
    protected function registerGlideServer()
    {
        $this->app->singleton('League\Glide\Server', function($app) {
            $filesystem = $app->make('Illuminate\Contracts\Filesystem\Filesystem');

            return ServerFactory::create([
                'source'             => $filesystem->getDriver(),
                'cache'              => $filesystem->getDriver(),
                'source_path_prefix' => 'app/medias',
                'cache_path_prefix'  => 'medias/.cache',
            ]);
        });
    }

    /**
     * Resolving validators
     * @return void
     */
    protected function loadValidators()
    {
        $this->app->validator->extend(
            'image_array',
            'EscapeWork\LaraMedias\Validators\ImageArrayValidator@validate'
        );
    }

    /**
     * Registering third-party providers
     * @return void
     */
    protected function registerProviders()
    {
        $this->app->register('EscapeWork\LaraMedias\Providers\RouteServiceProvider');
        $this->app->register('EscapeWork\LaravelUploader\Providers\LaravelUploaderServiceProvider');

        if ($this->app['request']->is(config('manager.url') . '/*')) {
            $this->app->register('EscapeWork\LaraMedias\Providers\EventServiceProvider');
        }
    }
}
