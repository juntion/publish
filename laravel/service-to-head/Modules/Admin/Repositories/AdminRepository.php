<?php

namespace Modules\Admin\Repositories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Eloquent\BaseRepository;
use Modules\Admin\Contracts\AdminRepository as ContractsAdminRepository;
use Modules\Admin\Entities\Admin;

class AdminRepository extends BaseRepository implements ContractsAdminRepository
{
    public function model()
    {
        return Admin::class;
    }

    public static function createAdmin(Admin $admin)
    {
        if (!$admin->exists) {
            $admin->uuid = $admin->uuid ?? Str::uuid()->getHex()->toString();
            $admin->save();
            $admin->refresh();
        }

        return $admin;
    }

    public static function updateAdmin(Admin $admin)
    {
        return $admin->save();
    }

    public static function deleteAdmin(Admin $admin)
    {
        if ($admin->avatar && Storage::disk('public')->exists($admin->avatar)) {
            Storage::disk('public')->delete($admin->avatar);
        }

        return $admin->delete();
    }

    /**
     * 通过原 Id 获取用户信息
     * @param $originId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public static function getAdminInfoByOriginId($originId)
    {
        $admin = Admin::query()->where('id', $originId)->first();
        return $admin;
    }

    public static function getAdminGroup($uuid)
    {
        $admin = Admin::query()->withTrashed()->find($uuid);
        if (is_null($admin)){
            return "";
        } else {
            return $admin->group_uuid;
        }
    }

    /**
     * 获取所有用户
     *
     * @param Admin $admin
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public static function getAdminList()
    {
        return Admin::all();
    }

    /**
     * @param $adminId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function getAdminByErpID($adminId)
    {
        return Admin::where('id', $adminId)->get();
    }

    /**
     * @param $uuid
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function getAdminByUuid($uuid)
    {
        return Admin::where('uuid', $uuid)->get();
    }

    /**
     * @param $name
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function getAdminByName($name)
    {
        return Admin::query()->where('name', $name)->first();
    }

    /**
     * @param array $adminIds
     * @return mixed
     */
    public static function getAdminsByErpIds(array $adminIds)
    {
        return Admin::whereIn('id', $adminIds)->get();
    }
}
