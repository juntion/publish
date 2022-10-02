<?php

namespace App\Models\Permission;

use App\Models\Subsystem;
use App\Observers\Permission\RoleObserver;
use App\Traits\DateFormatTrait;
use App\Traits\Permission\PermissionLogTrait;
use App\Traits\PermissionsTrait;
use Spatie\Permission\Models\Role as RoleModel;

class Role extends RoleModel
{
    use PermissionsTrait, PermissionLogTrait, DateFormatTrait;

    const SUPER_ROLE_ID = 1;

    public static function createSuperRole()
    {
        if (!$role = self::where('id', self::SUPER_ROLE_ID)->first()) {
            $role = self::create([
                'name' => 'superAdmin',
                'guard_name' => config('app.guard'),
                'locale' => '{"en":"superAdmin","zh-CN":"超管"}',
            ]);
        }
        return $role;
    }

    public function subSystem()
    {
        return $this->belongsTo(Subsystem::class, 'guard_name', 'guard_name');
    }

    protected static function booted()
    {
        parent::booted();

        static::observe(RoleObserver::class);
    }
}
