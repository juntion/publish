<?php

namespace App\Events\Auth;


use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class PermissionUpdate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $keys;
    public $type;

    /**
     * Create a new event instance.
     *
     * @param int|string|array $keys
     * @param $type
     */
    public function __construct($keys, $type)
    {
        $this->keys = $keys;
        $this->type = $type;
    }
}