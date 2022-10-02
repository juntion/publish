<?php

namespace App\Http\Controllers\User;

use App\Enums\Permission\PermissionLogType;
use App\Events\Auth\PermissionUpdate;
use App\Http\Controllers\Controller;
use App\Models\Permission\Role;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Traits\RefreshFlagTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    use RefreshFlagTrait;

    protected $user;

    public function __construct(UserRepository $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * 查询用户角色
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function roles(Request $request, $id)
    {
        $this->validator($request->all());

        $user = $this->getInstance($this->user, $id);
        $roles = $this->user->getRolesAndPermissions($user, $request->input('guard_name'))['roles'];
        return $this->successWithData(compact('roles'));
    }

    /**
     * 更新用户角色
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     */
    public function syncRoles(Request $request, $id)
    {
        Validator::make($request->all(), [
            'role_ids' => 'array',
            'role.ids.*' => 'required|exists:roles,id',
            'guard_name' => 'required|string',
        ])->validate();

        $guardName = $request->input('guard_name');
        $user = $this->getInstance($this->user, $id);
        $user->guard_name = $guardName;
        DB::beginTransaction();
        try {
            $old = $user->roles()->where('guard_name', $guardName)->get();
            if ($old->isNotEmpty()) {
                $user->roles()->detach($old->pluck('id')->toArray());
            }
            $user->assignRole($request->input('role_ids'));

            // 记录用户角色变化
            $oldRoles = $old->pluck('id')->toArray();
            $newRoles = $user->roles()->pluck('id')->toArray();
            if (array_diff($oldRoles, $newRoles) || array_diff($newRoles, $oldRoles)) {
                event(new PermissionUpdate($user->id, PermissionLogType::USER_ROLE));
                $user->createPermissionLog($oldRoles, $newRoles, PermissionLogType::USER_ROLE);
            }

            // 记录角色的用户变化
            if ($delRoleIds = array_diff($oldRoles, $newRoles)) {
                $delRoles = Role::query()->whereIn('id', $delRoleIds)->get();
                $delRoles->map(function (Role $role) use ($user) {
                    $role->createPermissionLog([$user->id], [], PermissionLogType::ROLE_USER);
                });
            }
            if ($addRoleIds = array_diff($newRoles, $oldRoles)) {
                $addRoles = Role::query()->whereIn('id', $addRoleIds)->get();
                $addRoles->map(function (Role $role) use ($user) {
                    $role->createPermissionLog([], [$user->id], PermissionLogType::ROLE_USER);
                });
            }

            DB::commit();
            $this->addRefreshFlag($user->id, $this->FLAG_PERMISSION);
            return $this->success();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * 批量绑定用户角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author: King
     * @version: 2020/5/15 14:52
     */
    public function attachRoles(Request $request)
    {
        Validator::make($request->all(), [
            'user_ids' => 'required|array',
            'user_ids.*' => 'required|exists:users,id',
            'role_ids' => 'array',
            'role.ids.*' => 'required|exists:roles,id',
            'guard_name' => 'required|string',
        ])->validate();

        DB::beginTransaction();
        try {
            $userIds = $request->input('user_ids');
            $roleIds = $request->input('role_ids');
            $users = $this->user->findWhereIn('id', $userIds);
            $users->each(function (User $user) use ($roleIds) {
                $oldRoles = $user->roles()->get();
                $user->assignRole($roleIds);

                // 用户角色有变化 保存修改记录
                $oldValues = $oldRoles->pluck('id')->toArray();
                $newValues = $user->roles()->pluck('id')->toArray();
                if (array_diff($oldValues, $newValues) || array_diff($newValues, $oldValues)) {
                    event(new PermissionUpdate($user->id, PermissionLogType::USER_ROLE));
                    $user->createPermissionLog($oldValues, $newValues, PermissionLogType::USER_ROLE);
                }

                // 记录角色的用户变化
                if ($delRoleIds = array_diff($oldValues, $newValues)) {
                    $delRoles = Role::query()->whereIn('id', $delRoleIds)->get();
                    $delRoles->map(function (Role $role) use ($user) {
                        $role->createPermissionLog([$user->id], [], PermissionLogType::ROLE_USER);
                    });
                }
                if ($addRoleIds = array_diff($newValues, $oldValues)) {
                    $addRoles = Role::query()->whereIn('id', $addRoleIds)->get();
                    $addRoles->map(function (Role $role) use ($user) {
                        $role->createPermissionLog([], [$user->id], PermissionLogType::ROLE_USER);
                    });
                }
            });

            DB::commit();
            $this->addRefreshFlag($userIds, $this->FLAG_PERMISSION);
            return $this->success();
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e);
            return $this->failed(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * 查询用户角色和权限
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\System\InvalidParameterException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getRolesAndPermissions(Request $request, $id)
    {
        $this->validator($request->all());

        $user = $this->getInstance($this->user, $id);
        $result = $this->user->getRolesAndPermissions($user, $request->input('guard_name'));
        return $this->successWithData($result);
    }

    protected function validator($data)
    {
        Validator::make($data, [
            'guard_name' => 'required|string',
        ])->validate();
    }
}
