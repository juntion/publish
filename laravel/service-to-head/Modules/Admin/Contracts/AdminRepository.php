<?php

namespace Modules\Admin\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Modules\Admin\Entities\Admin;

interface AdminRepository extends RepositoryInterface, RepositoryCriteriaInterface
{
    //
    public static function createAdmin(Admin $admin);

    public static function updateAdmin(Admin $admin);

    public static function deleteAdmin(Admin $admin);

    public static function getAdminInfoByOriginId($originId);

    public static function getAdminGroup($uuid);

    public static function getAdminList();

    /**
     * @param $adminId
     * @return mixed
     */
    public static function getAdminByErpID($adminId);

    public static function getAdminByUuid($uuid);
    /**
     * @param $name
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function getAdminByName($name);

    /**
     * @param array $adminIds
     * @return mixed
     */
    public static function getAdminsByErpIds(array $adminIds);
}
