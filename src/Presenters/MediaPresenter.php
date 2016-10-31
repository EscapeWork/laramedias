<?php

namespace EscapeWork\LaraMedias\Presenters;

use EscapeWork\LaravelSteroids\Presenter;

class MediaPresenter extends Presenter
{
    public function picture($w = null, $h = null, $fit = 'resize')
    {
        return asset(config('medias.url').'/general/'.$this->model->file.'?w='.$w.'&h='.$h.'&fit='.$fit.'&crop='.$this->model->crop_position);
    }
}
