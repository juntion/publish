<?php

namespace App\Listeners\Department;

use App\Contracts\Rpc\DepartmentRpcInterface;
use App\Events\Department\DepartmentCreated;
use App\Models\Department;
use App\ProjectManage\Models\BugPrincipal;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DepartmentCreateListener
{
    protected $departmentRpc;

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
     * @param DepartmentCreated $event
     * @return void
     */
    public function handle(DepartmentCreated $event)
    {
        $department = $event->department;
        $parentId = 0;
        // 查找此部门在ERP中的父部门
        if ($department->parent_id) {
            $parent = Department::find($department->parent_id);
            if ($parent && $parent->origin_id) {
                $parentId = $parent->origin_id;
            }
        }

        $res = $this->departmentRpc->store($department->toArray(), $parentId);
        if ($res['status'] == 'success') {
            $department->origin_id = $res['data']['id'];
            $department->save();
        } else {
            \Log::error('同步部门数据至ERP出错', [$res]);
        }

        // 填充bug部门负责人表
        if ($department->is_base == 1) {
            BugPrincipal::query()->create(['dept_id' => $department->id]);
        }
    }
}
