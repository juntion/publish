<?php

namespace Modules\Admin\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Modules\Admin\Entities\Admin;

class PasswordReset implements ShouldBroadcast
{
    use SerializesModels, InteractsWithSockets;

    public $broadcastQueue = 'broadcast';

    private $admin;

    /**
     * 管理员重置密码.
     * @param Admin $admin
     */
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('Admin.' . $this->admin->getKey());
    }

    public function broadcastAs()
    {
        return 'PasswordReset';
    }

    public function broadcastWith(){
        return ['info' => __('admin::auth.passwordResetBroadcast')];
    }
}
