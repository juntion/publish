<?php

use App\Models\Permission\Permission;
use App\Support\Data\PermissionData;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // 重置角色和权限缓存
        app()['cache']->forget('spatie.permission.cache');

        // 权限创建
        Permission::createNotExists(PermissionData::getData());
    }
}
