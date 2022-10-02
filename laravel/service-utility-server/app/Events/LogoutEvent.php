<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LogoutEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $from;
    public $token;

    /**
     * Create a new event instance.
     *
     * @param $userId
     * @param $from
     * @param $token
     */
    public function __construct($userId, $from, $token)
    {
        $this->userId = $userId;
        $this->from = $from;
        $this->token = $token;
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
