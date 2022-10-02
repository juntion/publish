<?php

namespace App\Listeners\User;

use App\Contracts\Rpc\UserRpcInterface;
use App\Events\User\UserDefaultDepartment;
use App\Models\Department;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserDefaultDepartmentListener
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
     * @param UserDefaultDepartment $event
     * @return void
     */
    public function handle(UserDefaultDepartment $event)
    {
        $user = $event->user;
        $departmentId = $event->departmentId;
        $department = Department::find($departmentId);
        if ($department && $department->origin_id) {
            $baseDepartmentId = $department->is_base ? $department->origin_id : $department->top()->origin_id;
            $res = $this->userRpc->department($user->origin_id, $department->origin_id, $baseDepartmentId);
            if ($res['status'] != 'success') {
                \Log::error('设置用户部门数据至ERP出错', [$res]);
            }
        }
    }
}
