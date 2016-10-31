<?php

namespace EscapeWork\LaraMedias\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class MediasResizeService
{
    /**
     * @var Intervention\Image\ImageManager
     */
    protected $image;

    public function __construct(ImageManager $image)
    {
        $this->image = $image;
    }

    public function resize($image)
    {
        $width = config('medias.max_size.width');
        $height = config('medias.max_size.height');

        // this orientate method needs to be called because sometimes
        // images uploaded came rotated, but need to be ajusted
        $img = $this->image->make(Storage::disk(config('medias.disk'))->get($image))->orientate();

        if ($img->width() <= $width && $img->height() <= $height) {
            return;
        }

        if ($img->width() > $width && $img->height() > $height) {
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });

            Storage::disk(config('medias.disk'))->put($image, $img->stream());

            return;
        }

        if ($img->width() > $width) {
            $height = null;
        } elseif ($img->height() > $height) {
            $width = null;
        }

        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

        Storage::disk(config('medias.disk'))->put($image, $img->stream());
    }
}
