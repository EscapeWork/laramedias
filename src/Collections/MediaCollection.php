<?php

namespace EscapeWork\LaraMedias\Collections;

use Illuminate\Database\Eloquent\Collection;

class MediaCollection extends Collection
{

    public function __construct($models)
    {
        if ($models instanceof UploadCollection) {
            $medias = $this;

            $models->each(function ($upload) use ($medias) {
                $medias->push($upload);
            });
        } else {
            parent::__construct($models);
        }

    }

    public function resize($dir)
    {
        $resizer = app('EscapeWork\LaraMedias\Services\MediasResizeService');

        $this->each(function ($media) use ($dir, $resizer) {
            $resizer->resize($dir . '/' . $media);
        });
    }

    public function removeAll()
    {
        $this->destroyAll();
    }

    public function destroyAll()
    {
        $this->each(function($media) {
            $media->delete();
        });
    }
}
