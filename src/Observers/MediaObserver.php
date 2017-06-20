<?php

namespace EscapeWork\LaraMedias\Observers;

use EscapeWork\LaraMedias\Events\MediaAdded;
use EscapeWork\LaraMedias\Events\MediaDeleted;
use EscapeWork\LaraMedias\Events\MediaUpdated;

class MediaObserver
{

    public function created($model)
    {
        event(new MediaAdded($model));
    }

    public function updated($model)
    {
        event(new MediaUpdated($model));
    }

    public function deleted($model)
    {
        event(new MediaDeleted($model));
    }
}
