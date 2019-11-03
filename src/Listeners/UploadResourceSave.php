<?php

namespace ymlluo\Ueditor\Listeners;

use ymlluo\Ueditor\Events\FileUploaded;
use ymlluo\Ueditor\Models\UploadResource;

class UploadResourceSave
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param FileUploaded $event
     * @return void
     */
    public function handle(FileUploaded $event)
    {
        $fileInfo = $event->fileInfo;
        UploadResource::store($fileInfo);
    }
}
