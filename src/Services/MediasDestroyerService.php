<?php

namespace EscapeWork\LaraMedias\Services;

use EscapeWork\LaraMedias\Events\CacheNeedsCleanup;
use EscapeWork\LaraMedias\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediasDestroyerService
{
    /**
     * @var EscapeWork\LaraMedias\Models\Media
     */
    protected $media;

    public function __construct(Media $media)
    {
        $this->media = $media;
    }

    public function removeSpecificMedias(array $ids = [])
    {
        if (count($ids) === 0) {
            return;
        }

        $this->media->whereIn('id', $ids)->get()->removeAll();
    }

    public function removeFromMedias($model)
    {
        $this->media
            ->where('media_model', '=', get_class($model))
            ->where('model_id', '=', $model->id)
            ->get()
            ->removeAll();
    }

    public function removeFromModel($model, $config, $dir, $field = null)
    {
        if (is_null($field)) {
            $this->removeAllFromModel($model, $config, $dir);

            return;
        }

        if ($model->{$field}) {
            $this->removeMedia($dir.'/'.$model->{$field});
        }
    }

    public function removeAllFromModel($model, $config, $dir)
    {
        foreach ($config['fields'] as $field) {
            if ($model->{$field}) {
                $this->removeMedia($dir.'/'.$model->{$field});
            }
        }
    }

    public function removeMedia($file)
    {
        if (!$file) {
            return;
        }

        $this->removeCache($file);

        if (Storage::disk(config('medias.disk'))->exists($file)) {
            Storage::disk(config('medias.disk'))->delete($file);
        }
    }

    protected function removeCache($file)
    {
        $key = implode('/', array_slice(explode('/', $file), -3, 3));

        if (config('medias.glide.load')) {
            return app('League\Glide\Server')->deleteCache($key);
        } else {
            event(new CacheNeedsCleanup($file));
        }
    }
}
