<?php

namespace App\Listeners\Department;

use App\Contracts\Rpc\DepartmentRpcInterface;
use App\Events\Department\DepartmentUpdate;
use App\Models\Department;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DepartmentUpdateListener
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
     * @param DepartmentUpdate $event
     * @return void
     */
    public function handle(DepartmentUpdate $event)
    {
        $department = $event->department;
        $data = $event->data;

        if ($department->origin_id) {
            $parentId = 0;
            $topId = $department->origin_id;
            $parent = Department::find($data['parent_id']);
            if ($parent && $parent->origin_id) {
                $parentId = $parent->origin_id;
                $topId = $parent->top()->origin_id;
            }
            $type = $parentId == 0 ? 1 : 4;

            $res = $this->departmentRpc->update($department->origin_id, [
                'name' => $data['name'],
                'parent_id' => $parentId,
                'type' => $type,
                'top_id' => $topId,
            ]);
            if ($res['status'] != 'success') {
                \Log::error('修改部门同步至ERP出错', [$res]);
            }
        }
    }
}
