<?php

namespace EscapeWork\LaraMedias\Events;

use Illuminate\Queue\SerializesModels;

class CacheNeedsCleanup
{
    use SerializesModels;

    /** @var string */
    public $file;

    /** @param string */
    public function __construct($file)
    {
        $this->file = $file;
    }
}
