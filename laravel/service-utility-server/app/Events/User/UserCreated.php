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

class UserCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $companyId;
    public $departmentId;
    public $positionIds;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param $companyId
     * @param $departmentId
     * @param $positionIds
     */
    public function __construct(User $user, $companyId, $departmentId, $positionIds)
    {
        $this->user = $user;
        $this->companyId = $companyId;
        $this->departmentId = $departmentId;
        $this->positionIds = $positionIds;
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
