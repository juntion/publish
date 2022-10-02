<?php

namespace App\Events\PM\Task;

use App\ProjectManage\Models\ReleaseVersion;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubTaskVersionInTest
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $subtask;

    public $version;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($subtask, ReleaseVersion $version)
    {
        $this->subtask = $subtask;
        $this->version = $version;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
