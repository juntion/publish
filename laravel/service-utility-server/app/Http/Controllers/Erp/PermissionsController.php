<?php

namespace App\Http\Controllers\Erp;

use App\Contracts\Rpc\PermissionRpcInterface;
use App\Repositories\Department\DepartmentRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PermissionsController extends Controller
{
    protected $user;
    protected $department;
    protected $permissionRpc;

    public function __construct(UserRepository $user, DepartmentRepository $department, PermissionRpcInterface $permissionRpc)
    {
        parent::__construct();
        $this->user = $user;
        $this->department = $department;
        $this->permissionRpc = $permissionRpc;
    }

    /**
     * 获取可分配的权限
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profiles(Request $request)
    {
        $data = [];
        $user = $this->user();
        $department = $user->department()->first();
        if ($department) {
            $baseDept = $department->top();
            $data[] = $baseDept->origin_id;
        }
        $res = $this->permissionRpc->profiles($data);
        if ($res['status'] == 'success') {
            return $this->successWithData($res['data']);
        }
        return $this->failed();
    }

    /**
     * 获取用户权限
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function userProfiles(Request $request, $id)
    {
        $user = $this->getInstance($this->user, $id);
        $res = $this->permissionRpc->userProfiles($user->origin_id);
        if ($res['status'] == 'success') {
            return $this->successWithData($res['data']);
        }
        return $this->failed();
    }

    /**
     * 添加用户权限
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function setProfiles(Request $request, $id)
    {
        Validator::make($request->all(), [
            'profile_ids' => 'required|array'
        ])->validate();
        $user = $this->getInstance($this->user, $id);

        $res = $this->permissionRpc->settingPermissions($user->origin_id, $request->input('profile_ids'));
        if ($res['status'] == 'success') {
            return $this->success();
        }
        return $this->failed();
    }

    /**
     * 删除用户权限
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function deleteProfile(Request $request, $id)
    {
        Validator::make($request->all(), [
            'profile_id' => 'required|numeric'
        ])->validate();
        $user = $this->getInstance($this->user, $id);
        $profileId = $request->input('profile_id');

        $res = $this->permissionRpc->deleteProfile($user->origin_id, $profileId);
        if ($res['status'] == 'success') {
            return $this->success();
        }
        return $this->failed();
    }

    /**
     * 批量分配用户权限
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchSetProfiles(Request $request)
    {
        Validator::make($request->all(), [
            'user_ids' => 'required|array',
            'user_ids.*' => 'required|exists:users,id',
            'profile_ids' => 'required|array',
            'profile_ids.*' => 'required|integer',
        ])->validate();

        // 找出所有用户的origin_id，去掉空值
        $users = $this->user->findWhereIn('id', $request->input('user_ids'));
        $userIds = $users->pluck('origin_id')
            ->reject(function ($value) {
                return empty($value);
            })->toArray();

        $res = $this->permissionRpc->assignPermissions($userIds, $request->input('profile_ids'));
        if ($res['status'] == 'success') {
            return $this->success();
        }
        return $this->failed();
    }

    /**
     * 经理或主管允许分配权限的人员：整个基础部门下所有人员
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function canSetProfileUsers(Request $request)
    {
        $departmentId = $request->get('department_id');
        $basicDepartment = $this->department->find($departmentId);
        // 没有部门返回空
        if (empty($basicDepartment)) {
            return $this->successWithData([]);
        }
        // 获取同级和子级部门用户，排除自己
        $users = $this->department->getUser($basicDepartment)->map(function ($item) {
            return ['id' => $item->id, 'name' => $item->name];
        });
        return $this->successWithData($users);
    }
}
