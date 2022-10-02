<?php

namespace App\Listeners\User;

use App\Contracts\Rpc\UserRpcInterface;
use App\Events\User\UserUpdate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserUpdateListener
{
    /**
     * @var UserRpcInterface
     */
    private $userRpc;

    /**
     * Create the event listener.
     *
     * @param UserRpcInterface $userRpc
     */
    public function __construct(UserRpcInterface $userRpc)
    {
        $this->userRpc = $userRpc;
    }

    /**
     * Handle the event.
     *
     * @param UserUpdate $event
     * @return void
     */
    public function handle(UserUpdate $event)
    {
        if ($adminId = $event->user->origin_id) {
            $res = $this->userRpc->update($adminId, $event->data);
            if ($res['status'] != 'success') {
                \Log::error('修改用户数据至ERP出错', [$res]);
            }
        }
    }
}
