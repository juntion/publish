<?php

namespace App\Listeners\User;

use App\Contracts\Rpc\UserRpcInterface;
use App\Events\User\UserUploadAvatar;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserUploadAvatarListener implements ShouldQueue
{
    /**
     * @var UserRpcInterface
     */
    private $userRpc;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserRpcInterface $userRpc)
    {
        //
        $this->userRpc = $userRpc;
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(UserUploadAvatar $event)
    {
        $user = $event->user;
        $avatarData = $event->avatarData;

        if ($adminId = $user->origin_id) {
            $res = $this->userRpc->setAvatar($adminId, $avatarData);
            if ($res['status'] != 'success') {
                \Log::error('同步用户头像至ERP出错', [$res]);
            }
        }
    }
}
