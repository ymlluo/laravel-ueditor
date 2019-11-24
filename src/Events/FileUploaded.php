<?php

namespace ymlluo\Ueditor\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class FileUploaded implements ShouldBroadcast
{
    use  InteractsWithSockets, SerializesModels;

    public $fileInfo;
    public $result;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $fileInfo)
    {
        $this->fileInfo = $fileInfo;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        if (version_compare(app()->version(), '5.3.0', '>=')) {
            return new PrivateChannel('ueditor:file:uploaded');
        }
    }
}
