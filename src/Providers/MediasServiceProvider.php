<?php

namespace EscapeWork\LaraMedias\Providers;

use Aws\S3\S3Client;
use EscapeWork\LaraMedias\Models\Media;
use EscapeWork\LaraMedias\Observers\MediaObserver;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Adapter\Local;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
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
        $root = __DIR__.'/../..';

        $this->publishes([$root.'/config/medias.php'   => config_path('medias.php')]);
        $this->loadMigrationsFrom($root.'/database/migrations');

        // loading views and translations from resources
        $this->loadValidators();

        // observers
        Media::observe(new MediaObserver());
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $root = __DIR__.'/../..';

        $this->registerProviders();

        $this->mergeConfigFrom(
            $root.'/config/medias.php',
            'medias'
        );

        if ($this->app['config']->get('medias.glide.load')) {
            $this->registerGlideServer();
        }
    }

    /**
     * Creating Glide server and registering it to the containter.
     *
     * @return void
     */
    protected function registerGlideServer()
    {
        $this->app->singleton('League\Glide\Server', function ($app) {
            $filesystem = new Filesystem($this->getGlideAdapter());
            $cachesystem = new Filesystem(new Local(config('filesystems.disks.local.root')));

            return ServerFactory::create([
                'source'             => $filesystem,
                'cache'              => $cachesystem,
                'source_path_prefix' => '',
                'cache_path_prefix'  => 'medias/.cache',
            ]);
        });
    }

    protected function getGlideAdapter()
    {
        switch (config('medias.disk') ?: config('filesystems.default')) {
            case 's3':
                $client = new S3Client([
                    'credentials' => [
                        'key'    => config('filesystems.disks.s3.key'),
                        'secret' => config('filesystems.disks.s3.secret'),
                    ],
                    'region'  => config('filesystems.disks.s3.region'),
                    'version' => 'latest',
                ]);

                $adapter = new AwsS3Adapter($client, config('filesystems.disks.s3.bucket'));

            default:
                $adapter = new Local(config('filesystems.disks.local.root'));
        }

        return $adapter;
    }

    /**
     * Resolving validators.
     *
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
     * Registering third-party providers.
     *
     * @return void
     */
    protected function registerProviders()
    {
        $this->app->register('EscapeWork\LaraMedias\Providers\RouteServiceProvider');

        if ($this->app['request']->is(config('manager.url').'/*')) {
            $this->app->register('EscapeWork\LaraMedias\Providers\EventServiceProvider');
        }
    }
}
