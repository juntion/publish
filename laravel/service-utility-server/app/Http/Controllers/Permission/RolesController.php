<?php

namespace App\Http\Controllers\Permission;

use App\Enums\Permission\PermissionLogType;
use App\Events\Auth\PermissionUpdate;
use App\Exports\Permission\RolesExport;
use App\Http\Controllers\Controller;
use App\Models\Permission\Role;
use App\Repositories\Permission\RoleRepository;
use App\Traits\RefreshFlagTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;

class RolesController extends Controller
{
    use RefreshFlagTrait;

    protected $role;

    public function __construct(RoleRepository $role)
    {
        parent::__construct();
        $this->role = $role;
    }

    /**
     * 创建角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->only(['name', 'comment', 'guard_name', 'locale']);
        Validator::make($data, [
            'name' => 'required|string',
            'comment' => 'required|string',
            'guard_name' => 'required|string',
            'locale' => 'required|json',
        ])->validate();

        $createInfo = $this->role->create($data);
        if ($createInfo[0]) {
            $role = $createInfo[1];
            $role->createPermissionLog([], $role->toArray(), PermissionLogType::ROLE_PERMISSION, 'create');
            return $this->successWithData(['role' => $role]);
        }
        return $this->failedWithMessage(__('error.created_failed'));
    }

    /**
     * 更新角色
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function update(Request $request, $id)
    {
        $data = $request->only(['comment', 'locale']);
        Validator::make($data, [
            'comment' => 'required|string',
            'locale' => 'required|json',
        ])->validate();
        $role = $this->getInstance($this->role, $id);
        $role->update($data);
        return $this->success();
    }

    /**
     * 删除角色
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function delete(Request $request, $id)
    {
        // 不允许删除超管角色
        if ($id == Role::SUPER_ROLE_ID) {
            return $this->failedWithMessage(__('error.super_admin_not_allow_delete'));
        }
        $role = $this->getInstance($this->role, $id);
        event(new PermissionUpdate($role->permissions()->pluck('name')->toArray(), PermissionLogType::ROLE_PERMISSION));
        $role->createPermissionLog($role->toArray(), [], PermissionLogType::ROLE_PERMISSION, 'delete');
        $role->delete();
        return $this->success();
    }

    /**
     * 角色列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $limit = $request->input('limit');
        $roles = $this->role->getModelsList($limit);
        return $this->successWithData($roles);
    }

    /**
     * 所有角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        Validator::make($request->all(), [
            'guard_name' => 'required|string',
        ])->validate();
        $roles = $this->role->findWhere($request->only('guard_name'), ['*'], ['subSystem']);
        return $this->successWithData(['data' => $roles]);
    }

    /**
     * 更新角色权限
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function givePermissions(Request $request, $id)
    {
        Validator::make($request->all(), [
            'permission_ids' => 'required|array',
            'permission_ids.*' => 'required|exists:permissions,id',
        ])->validate();

        $role = $this->getInstance($this->role, $id);
        $oldPermissionIds = $role->permissions()->pluck('id')->toArray();
        $permissionIds = $request->get('permission_ids');

        \DB::beginTransaction();
        try {
            $role->syncPermissions($permissionIds);
        } catch (\Exception $e) {
            \DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        \DB::commit();

        // 角色权限变更记录
        if (array_diff($oldPermissionIds, $permissionIds)
            || array_diff($permissionIds, $oldPermissionIds)) {
            event(new PermissionUpdate($role->permissions()->pluck('name')->toArray(), PermissionLogType::ROLE_PERMISSION));
            $role->createPermissionLog($oldPermissionIds, $permissionIds, PermissionLogType::ROLE_PERMISSION);
        }
        // 角色关联用户需刷新
        $roleUserIds = $role->users()->get()->pluck('id')->toArray();
        $this->addRefreshFlag($roleUserIds, $this->FLAG_PERMISSION);

        return $this->success();
    }

    /**
     * 获取某个角色权限
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function getPermissions(Request $request, $id)
    {
        $type = $request->input('type', 1);
        $role = $this->getInstance($this->role, $id);
        $permissions = $role->permissions;
        if ($type == 1) {
            return $this->successWithData($permissions->pluck('id'));
        }
        $permissions = $permissions->groupBy('group')
            ->map(function ($item, $group) {
                return ['name' => __($group), 'data' => $item];
            })->values();
        return $this->successWithData(compact('permissions'));
    }

    /**
     * 获取拥有权限的用户
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsers(Role $role)
    {
        $users = $this->role->getUsers($role);
        return $this->successWithData(compact('users'));
    }

    /**
     * 获取角色的操作日志
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function logs(Role $role)
    {
        $result = $role->getPermissionLogs();
        return $this->successWithData($result);
    }

    /**
     * 导出角色相关信息
     * @param Request $request
     * @param RolesExport $export
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function export(Request $request, RolesExport $export)
    {
        return Excel::download($export, $export->exportFileName());
    }
}
