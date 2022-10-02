<?php

namespace App\Listeners\User;

use App\Contracts\Rpc\UserRpcInterface;
use App\Events\User\UserCreated;
use App\Models\Department;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreateListener
{
    /**
     * @var UserRpcInterface
     */
    private $userRpc;

    /**
     * Create the event listener.
     * UserCreateListener constructor.
     * @param UserRpcInterface $userRpc
     */
    public function __construct(UserRpcInterface $userRpc)
    {
        $this->userRpc = $userRpc;
    }

    /**
     * Handle the event.
     *
     * @param UserCreated $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $user = User::find($event->user->id);
        $userArray = $user->toArray();
        $baseDepartmentId = $departmentId = 0;
        $department = Department::find($event->departmentId);
        if ($department && $department->origin_id) {
            $departmentId = $department->origin_id;
            $baseDepartmentId = $department->is_base ? $departmentId : $department->top()->origin_id;
        }
        try {
            $res = $this->userRpc->store($userArray, $departmentId, $baseDepartmentId, $event->companyId);
            if ($res['status'] == 'success') {
                $user->origin_id = $res['data']['user_id'];
                $user->save();
            } else {
                \Log::channel('user')->info('创建用户同步至ERP出错：',[$res]);
                throw new \Exception('创建用户同步至ERP出错' . $res);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
