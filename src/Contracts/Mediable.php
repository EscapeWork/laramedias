<?php

namespace EscapeWork\LaraMedias\Contracts;

interface Mediable
{
    public function medias();

    // Example of implementation of medias() method
    // public function medias()
    // {
    //     return $this->morphMany('EscapeWork\LaraMedias\Models\Media', 'medias', 'media_model', 'model_id')
    //                 ->orderBy('order');
    // }
}
