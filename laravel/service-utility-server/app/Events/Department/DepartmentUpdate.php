<?php

namespace App\Events\Department;

use App\Models\Department;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DepartmentUpdate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $department;
    public $data;

    /**
     * Create a new event instance.
     *
     * @param Department $department
     * @param $data
     */
    public function __construct(Department $department, $data)
    {
        $this->department = $department;
        $this->data = $data;
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
