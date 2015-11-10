<?php

namespace EscapeWork\LaraMedias\Providers;

use EscapeWork\LaraMedias\Models\Media;
use EscapeWork\LaraMedias\Observers\MediaObserver;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Media::observe(new MediaObserver);
    }

    public function register()
    {
        $this->app['events']->listen('eloquent.deleted:*', function($model) {
            $destroyer = $this->app->make('EscapeWork\LaraMedias\Services\MediasDestroyerService');

            // medias table
            foreach (config('medias.medias.tables') as $config) {
                if (get_class($model) === $config['model']) {
                    $destroyer->removeFromMedias($model);
                    return;
                }
            }

            // model medias
            foreach (config('medias.models') as $config) {
                if (get_class($model) === $config['model']) {
                    $destroyer->removeFromModel($model, $config);
                    return;
                }
            }
        });
    }
}
