<?php

namespace Codingo\Dropzoner\Events;

use App\Events\Event;

class ImageWasUploaded extends Event
{
    public $original_filename;

    public $server_filename;

    public function __construct($original_filename, $server_filename)
    {
        \Log::info('ImageWasUploaded Fired, original: ' . $original_filename . ' server: ' . $server_filename);
        $this->original_filename = $original_filename;
        $this->server_filename = $server_filename;
    }
}