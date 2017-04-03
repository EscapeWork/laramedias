<?php

namespace EscapeWork\LaraMedias\Services;

use EscapeWork\LaraMedias\Models\Media;
use Illuminate\Filesystem\Filesystem;

class MediasDestroyerService
{
    /**
     * @var EscapeWork\LaraMedias\Models\Media
     */
    protected $media;

    /**
     * @var Illuminate\Filesystem\Filesystem
     */
    protected $files;

    public function __construct(Media $media, Filesystem $files)
    {
        $this->media = $media;
        $this->files = $files;
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

        $this->removeMedia($dir.'/'.$model->{$field});
    }

    public function removeAllFromModel($model, $config, $dir)
    {
        foreach ($config['fields'] as $field) {
            $this->removeMedia($dir.'/'.$model->{$field});
        }
    }

    public function removeMedia($file)
    {
        $this->removeCache($file);

        if ($this->files->exists($file)) {
            $this->files->delete($file);
        }
    }

    protected function removeCache($file)
    {
        $key = implode('/', array_slice(explode('/', $file), -3, 3));

        return app('League\Glide\Server')->deleteCache($key);
    }
}
