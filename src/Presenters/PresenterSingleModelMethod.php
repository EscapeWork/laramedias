<?php

namespace EscapeWork\LaraMedias\Traits;

trait PresenterSingleModelMethod
{

    public function picture($options = [])
    {
        $options = array_merge([
            'field'  => 'picture',
            'width'  => 200,
            'height' => 200,
            'folder' => 'banners',
            'fit'    => 'resize',
        ], $options);

        $field = $options['field'];

        if ($picture = $this->model->{$field}) {
            return asset('media/'.$options['folder'].'/' . $picture . '?w=' . $options['width'] . '&h=' . $options['height'] . '&fit=' . $options['fit']);
        }
    }
}
