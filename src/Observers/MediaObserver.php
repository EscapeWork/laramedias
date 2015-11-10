<?php

namespace EscapeWork\LaraMedias\Observers;

class MediaObserver
{

    public function creating($model)
    {
        $model->order = $model->getNextOrder();
    }
}
