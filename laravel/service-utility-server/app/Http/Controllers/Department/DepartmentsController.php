<?php

namespace App\Http\Controllers\Department;

use App\Events\Department\DepartmentCreated;
use App\Events\Department\DepartmentDelete;
use App\Events\Department\DepartmentUpdate;
use App\Exports\DepartmentExport;
use App\Repositories\Department\DepartmentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class DepartmentsController extends Controller
{
    protected $departments;

    public function __construct(DepartmentRepository $department)
    {
        parent::__construct();
        $this->departments = $department;
    }

    /**
     * 创建部门
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->only('parent_id', 'name', 'locale', 'code');
        Validator::make($data, [
            'parent_id' => 'required|numeric',
            'name' => 'required|string',
            'locale' => 'required|json',
            'code' => 'string',
        ])->validate();

        // 判断创建基础部门权限
        if ($data['parent_id'] == 0) {
            if (!$this->user()->can('departments.createBasic')) {
                return $this->failedWithMessage(__('error.create_basic_department'));
            }
            $data['is_base'] = 1;
            // 基础部门的部门代码不能为空
            if (!isset($data['code'])) {
                return $this->failedWithMessage(__('error.basic_department_code'));
            }
        }

        $createInfo = $this->departments->create($data);
        if ($createInfo[0]) {
            $department = $createInfo[1];

            // 通知ERP
            event(new DepartmentCreated($department));

            return $this->successWithData(compact('department'));
        }
        return $this->failedWithMessage(__('error.created_failed'));
    }

    /**
     * 更新部门
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function update(Request $request, $id)
    {
        $department = $this->getInstance($this->departments, $id);
        $data = $request->only('parent_id', 'name', 'locale', 'is_base', 'code');
        Validator::make($data, [
            'parent_id' => 'required|numeric',
            'name' => 'required|string',
            'locale' => 'required|json',
            'is_base' => 'in:0,1',
            'code' => 'string',
        ])->validate();
        if ($department->isBase()) {
            if (empty($department->code) && !isset($data['code'])) {
                return $this->failedWithMessage(__('error.basic_department_code'));
            }
        }

        $department->update($data);
        event(new DepartmentUpdate($department, $data));
        return $this->success();
    }


    /**
     * 删除部门
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function delete($id)
    {
        $department = $this->getInstance($this->departments, $id);
        if ($errorMsg = $this->canDelete($department)) {
            return $this->failedWithMessage($errorMsg);
        }
        $department->delete();
        event(new DepartmentDelete($department));
        return $this->success();
    }

    /**
     * @param $department
     * @return array|string|null
     */
    protected function canDelete($department)
    {
        $errorMsg = '';
        // 基础部门不允许删除
        if ($department->is_base && !$this->user()->can('departments.deleteBasic')) {
            return __('error.department_is_base');
        }
        // 存在子部门不允许删除
        if ($department->children->toArray()) {
            return __('error.department_has_children');
        }
        // 存在默认用户不允许删除
        if ($department->users()->wherePivot('is_default', 1)->get()->toArray()) {
            return __('error.department_has_users');
        }
        return $errorMsg;
    }

    /**
     * 获取指定部门下的用户
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function getUsers(Request $request, $id)
    {
        // 直属用户，默认所有
        $direct = $request->input('is_direct', false);
        $department = $this->getInstance($this->departments, $id);
        if ($direct) {
            $users = $department->users()->with('company')->get();
        } else {
            $users = $this->departments->getUser($department);
            $users = $users->unique('id')->values();
        }
        $users->each(function ($user) {
            $user->append(['basic_department']);
        });
        return $this->successWithData(compact('users'));
    }

    /**
     * 获取指定部门下级子部门
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDepartments(Request $request, $id)
    {
        $departments = $this->departments->getDepartments($id);
        return $this->successWithData(compact('departments'));
    }

    /**
     * 获取指定部门下所有子部门
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function getAllDepartments(Request $request)
    {
        $department = $this->getInstance($this->departments, $request->input('department_id'));
        $departments = $this->departments->getAllDepartments($department->id);
        return $this->successWithData(compact('departments'));
    }

    /**
     * 获取所有部门集合
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        $departments = $this->departments->findAll();
        return $this->successWithData(compact('departments'));
    }

    /**
     * 部门树结构
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tree(Request $request)
    {
        $trees = $this->departments->tree($request->input('parent_id', 0));
        return $this->successWithData(compact('trees'));
    }

    public function export(DepartmentExport $export)
    {
        return Excel::download($export, $export->title() . '.xlsx');
    }
}
