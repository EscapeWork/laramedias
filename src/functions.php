<?php

if (!function_exists('media_path')) {
    function media_path($model, $field, $w = null, $h = null, $fit = 'resize', $crop = 'center')
    {
        return asset(config('medias.url').'/'.$model->table.'/'.$model->{$field}.'?w='.$w.'&h='.$h.'&fit='.$fit.'&crop='.$crop);
    }
}
