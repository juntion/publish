<?php

namespace App\Http\Controllers\User;

use App\Events\User\UserDefaultDepartment;
use App\Repositories\Department\DepartmentRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DepartmentsController extends Controller
{
    protected $user;
    protected $department;

    public function __construct(UserRepository $user, DepartmentRepository $department)
    {
        parent::__construct();
        $this->user = $user;
        $this->department = $department;
    }

    /**
     * 设置用户默认部门
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function setDefaultDepartment(Request $request, $id)
    {
        $user = $this->getInstance($this->user, $id);
        Validator::make($request->all(), [
            'department_id' => 'required|numeric|exists:departments,id',
        ])->validate();
        $this->defaultDepartment($user, $request->input('department_id'));
        return $this->success();
    }

    /**
     * 批量设置用户默认部门
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function batchSetDefaultDepartment(Request $request)
    {
        Validator::make($request->all(), [
            'department_id' => 'required|numeric|exists:departments,id',
            'user_ids' => 'required|array',
            'user_ids.*' => 'required|exists:users,id',
        ])->validate();

        $users = $this->user->findWhereIn('id', $request->input('user_ids'));
        foreach ($users as $user) {
            $this->defaultDepartment($user, $request->input('department_id'));
        }
        return $this->success();
    }

    /**
     * 设置默认部门
     * @param $user
     * @param $departmentId
     */
    protected function defaultDepartment($user, $departmentId)
    {
        // 存在默认部门
        $defaultDepartment = $user->departments()->wherePivot('is_default', 1)->first();
        if ($defaultDepartment) {
            $user->departments()->detach($defaultDepartment->id);
        }
        // 已存在关联记录
        if ($user->departments()->wherePivot('department_id', $departmentId)->first()) {
            $user->departments()->updateExistingPivot($departmentId, ['is_default' => 1]);
        } else {
            $user->departments()->attach($departmentId, ['is_default' => 1]);
        }
        event(new UserDefaultDepartment($user, $departmentId));
    }

    /**
     * 设置用户其他部门
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function setOtherDepartment(Request $request, $id)
    {
        $user = $this->getInstance($this->user, $id);
        Validator::make($request->all(), [
            'department_id' => 'required|array',
            'department_id.*' => 'required|exists:departments,id',
        ])->validate();

        try {
            $departmentIds = $request->input('department_id');
            $defaultDepartment = $user->departments()->wherePivot('is_default', 1)->first();
            if ($defaultDepartment && in_array($defaultDepartment->id, $departmentIds)) {
                return $this->failedWithMessage(__('error.department_setting_error'));
            }
            // 清除已经存在的其他部门，重新关联
            $otherDepartments = $user->departments()->wherePivot('is_default', 0)->pluck('id')->toArray();
            $user->departments()->detach($otherDepartments);
            $user->departments()->attach($departmentIds);
        } catch (\Exception $e) {
            \Log::error('设置用户其他部门失败', [$e->getMessage()]);
            return $this->failed();
        }
        return $this->success();
    }
}
