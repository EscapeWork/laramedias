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
        $this->app['events']->listen('eloquent.deleted:*', function($model) {
            $destroyer = $this->app->make('EscapeWork\LaraMedias\Services\MediasDestroyerService');

            // model medias
            foreach ((array) config('medias.models') as $key => $config) {
                if (get_class($model) === $config['model']) {
                    $dir = config('medias.dir') . '/' . $model->getTable();
                    $destroyer->removeFromModel($model, $config, $dir);
                    return;
                }
            }
        });
    }
}
