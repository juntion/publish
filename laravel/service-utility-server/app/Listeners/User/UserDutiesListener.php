<?php

namespace App\Listeners\User;

use App\Contracts\Rpc\UserRpcInterface;
use App\Events\User\UserDuties;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserDutiesListener
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
     * @param UserDuties $event
     * @return void
     */
    public function handle(UserDuties $event)
    {
        $user = $event->user;
        if ($user->origin_id) {
            $res = $this->userRpc->duties($user->origin_id, $event->duties);
            if ($res['status'] != 'success') {
                \Log::error('设置用户职责同步至ERP出错', [$res]);
            }
        }
    }
}
