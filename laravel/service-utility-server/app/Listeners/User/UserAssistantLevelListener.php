<?php

namespace App\Listeners\User;

use App\Contracts\Rpc\UserRpcInterface;
use App\Events\User\UserAssistantLevel;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserAssistantLevelListener
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
     * @param UserAssistantLevel $event
     * @return void
     */
    public function handle(UserAssistantLevel $event)
    {
        $user = $event->user;
        if ($user->origin_id) {
            $res = $this->userRpc->setAssistantLevel($user->origin_id, $event->assistantId);
            if ($res['status'] != 'success') {
                \Log::error('设置销售职称同步至ERP出错', [$res]);
            }
        }
    }
}
