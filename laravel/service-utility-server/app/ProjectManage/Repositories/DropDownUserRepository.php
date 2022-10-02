<?php

namespace App\ProjectManage\Repositories;

use App\Models\Department;
use App\Models\Permission\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DropDownUserRepository
{
    /**
     * @param $permissionNames array|string
     * @return array
     */
    public function getUsersByPermissions($permissionNames)
    {
        $result = collect();
        $permissions = Permission::findPermissionsByName($permissionNames);
        foreach ($permissions as $permission) {
            // 拥有权限的用户
            $permissionUsers = $permission->users()->get();
            $result = $result->merge($this->filterFields($permissionUsers));

            // 拥有角色的用户
            $roles = $permission->roles()->get();
            foreach ($roles as $role) {
                $roleUsers = $role->users()->get();
                $result = $result->merge($this->filterFields($roleUsers));
            }
        }

        return $result->unique('id')->sortBy('name')->values()->toArray();
    }

    /**
     * @param Collection $userCollection
     * @return array
     */
    protected function filterFields(Collection $userCollection)
    {
        $users = $userCollection->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
            ];
        });
        return $users->toArray();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getDepartments()
    {
        return Department::query()->select(['id', 'name'])->where('is_base', 1)->get();
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function getDepartmentUser(Request $request)
    {
        $department_id = $request->input("department_id");
        $deep = $request->input('deep') == 1;

        $users = [];
        $department = Department::query()->find($department_id);
        if ($department){
            User::query()->whereHas("department",function ($query)use($department, $deep){
                if($deep){
                    $query->where($query->qualifyColumn('id'), $department->id)->orWhere("path", "like", $department->path . $department->id."-%");
                } else {
                    $query->where($query->qualifyColumn('id'), $department->id);
                }
            })->orderBy("name")->get()->map(function ($item)use (&$users){
                $users[] = [
                    'id'   => $item->id,
                    'name' => $item->name
                ];
            });
            return $users;
        } else {
            throw new \Exception("部门id参数错误，无对应的部门信息");
        }

    }

    /**
     * 获取部门的用户列表
     * @param array | int $deptIds
     * @param bool $deep
     */
    public function getDeptUsers($deptIds, bool $deep = true)
    {
        if (!is_array($deptIds)) {
            $deptIds = [$deptIds];
        }
        $users = [];
        $departments = Department::query()->whereIn('id', $deptIds)->get();
        foreach ($departments as $department) {
            User::query()->whereHas("department", function ($query) use ($department, $deep) {
                if ($deep) {
                    $query->where($query->qualifyColumn('id'), $department->id)->orWhere("path", "like", $department->path . $department->id . "-%");
                } else {
                    $query->where($query->qualifyColumn('id'), $department->id);
                }
            })->orderBy("name")->get()->map(function ($item) use (&$users) {
                $users[] = [
                    'id' => $item->id,
                    'name' => $item->name
                ];
            });
        }
        return collect($users)->unique('id')->toArray();
    }
}
