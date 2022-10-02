<?php

namespace App\Events\PM\Demand;

use App\ProjectManage\Models\Demand;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DemandToTest
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Demand
     */
    protected $demand;

    /**
     * Create a new event instance.
     *
     * @param Demand $demand
     */
    public function __construct(Demand $demand)
    {
        $this->demand = $demand;
    }

    /**
     * @return Demand
     */
    public function getDemand(): Demand
    {
        return $this->demand;
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
