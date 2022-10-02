<?php

namespace App\Listeners\Department;

use App\Contracts\Rpc\DepartmentRpcInterface;
use App\Events\Department\DepartmentDelete;
use App\ProjectManage\Models\BugPrincipal;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DepartmentDeleteListener
{
    /**
     * @var DepartmentRpcInterface
     */
    private $departmentRpc;

    /**
     * Create the event listener.
     *
     * @param DepartmentRpcInterface $departmentRpc
     */
    public function __construct(DepartmentRpcInterface $departmentRpc)
    {
        $this->departmentRpc = $departmentRpc;
    }

    /**
     * Handle the event.
     *
     * @param DepartmentDelete $event
     * @return void
     */
    public function handle(DepartmentDelete $event)
    {
        $department = $event->department;

        // 同步删除bug部门负责人
        BugPrincipal::query()->where('dept_id', $department->id)->delete();

        if ($department->origin_id) {
            $res = $this->departmentRpc->delete($department->origin_id);
            if ($res['status'] != 'success') {
                \Log::error('删除部门同步至ERP出错', [$res]);
            }
        }
    }
}
