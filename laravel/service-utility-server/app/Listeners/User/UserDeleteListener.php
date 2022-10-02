<?php

namespace App\Listeners\User;

use App\Contracts\Rpc\UserRpcInterface;
use App\Events\User\UserDelete;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserDeleteListener
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
        $this->userRpc = $userRpc;
    }

    /**
     * Handle the event.
     * @param UserDelete $event
     * @throws \Exception
     */
    public function handle(UserDelete $event)
    {
        if ($event->user->origin_id) {
            //需要先判断该员工是否可以删除，需要先解除ERP系统中的销售小组绑定、新客户分配等数据才可以删除
            $adminStatus = $this->userRpc->adminStatus($event->user->origin_id);
            if($adminStatus['status'] != 'success'){
                throw new \Exception($adminStatus['message']);
            }
            try {
                $res = $this->userRpc->delete($event->user->origin_id);
                if ($res['status'] != 'success') {
                    \Log::channel('user')->info('删除数据同步到ERP出错：',[$res]);
                    throw new \Exception('删除数据同步到ERP出错');
                }
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        }
    }
}
