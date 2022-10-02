<?php

namespace App\Listeners\Auth;

use App\Contracts\Rpc\UserRpcInterface;
use App\Events\Auth\PasswordUpdate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordUpdateListener
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
     * @param PasswordUpdate $event
     * @return void
     */
    public function handle(PasswordUpdate $event)
    {
        if ($adminId = $event->user->origin_id) {
            $res = $this->userRpc->updatePassword($adminId, $event->password);
            if ($res['status'] != 'success') {
                \Log::error('更新密码同步ERP出错', [$res]);
            }
        }
    }
}
