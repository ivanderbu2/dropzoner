<?php

namespace Codingo\Dropzoner\Events;

use App\Events\Event;

class ImageWasDeleted extends Event
{
    public $server_filename;

    public function __construct($server_filename)
    {
        $this->server_filename = $server_filename;
    }
}