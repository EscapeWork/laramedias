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

            // model medias
            foreach ((array) config('medias.models') as $config) {
                if (get_class($model) === $config['model']) {
                    $dir = config('medias.dir') . '/' . $model->getTable();
                    $destroyer->removeFromModel($model, $config, $dir);
                    return;
                }
            }
        });
    }
}
