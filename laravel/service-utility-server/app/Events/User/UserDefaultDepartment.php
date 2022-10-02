<?php

namespace App\Events\User;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserDefaultDepartment
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $departmentId;
    public $user;

    /**
     * Create a new event instance.
     *
     * @param $user
     * @param $departmentId
     */
    public function __construct($user, $departmentId)
    {
        $this->user = $user;
        $this->departmentId = $departmentId;
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
