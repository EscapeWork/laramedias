<?php

namespace EscapeWork\LaraMedias\Events;

use EscapeWork\LaraMedias\Models\Media;
use Illuminate\Queue\SerializesModels;

class MediaDeleted
{
    use SerializesModels;

    /** @var \EscapeWork\LaraMedias\Models\Media */
    public $media;

    /** @param \EscapeWork\LaraMedias\Models\Media */
    public function __construct(Media $media)
    {
        $this->media = $media;
    }
}
