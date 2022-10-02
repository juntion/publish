<?php

namespace App\Events\PM\Bug;

use App\ProjectManage\Models\Bug;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BugExamine
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Bug
     */
    public $bug;


    /**
     * Create a new event instance.
     *
     * @param Bug $bug
     */
    public function __construct(Bug $bug)
    {
        $this->bug = $bug;
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
