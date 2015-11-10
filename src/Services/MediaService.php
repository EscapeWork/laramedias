<?php

namespace EscapeWork\LaraMedias\Services;

use EscapeWork\LaraMedias\Models\Media;
use EscapeWork\LaravelUploader\Collections\UploadCollection;

class MediaService
{

    protected $model;
    protected $media;
    protected $insertedMedias;

    public function __construct(Media $media)
    {
        $this->insertedMedias = [];

        $this->config = config('medias.medias');
        $this->media  = $media;
    }

    public function save($collection)
    {
        if (is_null($this->model)) {
            throw new MediaSettingsException('Configuration settings were not
                specified to this media upload');
        }

        $candidate = [
            'model_id'    => $this->model->id,
            'media_model' => get_class($this->model),
        ];

        foreach ($collection as $filename) {
            $candidate['file'] = $filename;

            if (! $media = $this->media->create($candidate)) {
                throw new MediaServiceException('Could not create media from collection');
            }

            $this->insertedMedias[] = $media->toArray();
        }

        return $this->insertedMedias;
    }

    public function to($model)
    {
        $this->model = is_object($model) ? $model : app($model);

        return $this;
    }

}
