<?php

namespace App\Events\PM\Task;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskSetHandler
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $subTask;
    
    /**
     * @var \App\Models\User
     */
    public $handler;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($subTask, $handler)
    {
        //
        $this->subTask = $subTask;
        $this->handler = $handler;
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
