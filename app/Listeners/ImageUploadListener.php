<?php

namespace App\Listeners;

use Codingo\Dropzoner\Events\ImageWasUploaded;

class ImageUploadListener
{
    /**
     * Example listener for image uploads
     * Event carries original_filename
     * and server_filename
     *
     * @param ImageWasUploaded $event
     */
    public function handle(ImageWasUploaded $event)
    {
        \Log::info('Inside ImageUploadListener, image was uploaded: ' . $event->server_filename);
    }
}