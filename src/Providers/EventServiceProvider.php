<?php

namespace EscapeWork\LaraMedias\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->app['events']->listen('eloquent.deleted:*', function ($event, $params) {
            $model = $params[0];

            foreach ((array) config('medias.models') as $key => $config) {
                if (get_class($model) === $config['model']) {
                    $dir = config('medias.dir').'/'.$model->getTable();

                    // removing the media
                    $destroyer = $this->app->make('EscapeWork\LaraMedias\Services\MediasDestroyerService');
                    $destroyer->removeFromModel($model, $config, $dir);

                    return;
                }
            }
        });
    }
}
