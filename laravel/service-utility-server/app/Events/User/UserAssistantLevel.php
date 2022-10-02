<?php

namespace App\Events\User;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserAssistantLevel
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $assistantId;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param $assistantId
     */
    public function __construct(User $user, $assistantId)
    {
        $this->user = $user;
        $this->assistantId = $assistantId;
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
