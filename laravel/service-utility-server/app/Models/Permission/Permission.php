<?php

namespace App\Models\Permission;

use App\Traits\DateFormatTrait;
use Spatie\Permission\Models\Permission as PermissionModel;

class Permission extends PermissionModel
{
    use DateFormatTrait;

    /**
     * 创建权限
     * @param array $attributes
     */
    public static function createNotExists(array $attributes)
    {
        $permissions = static::query()->get(['name', 'guard_name'])
            ->map(function ($item) {
                return $item['name'] . $item['guard_name'];
            })->toArray();

        foreach ($attributes as $attr) {
            $attr['guard_name'] = $attr['guard_name'] ?? config('app.guard');
            $attr['locale'] = !empty($attr['locale']) ? json_encode($attr['locale']) : null;

            if (in_array($attr['name'] . $attr['guard_name'], $permissions)) {
                continue;
            }

            $data = collect($attr)->only(['name', 'comment', 'guard_name', 'group', 'locale']);
            $permission = static::create($data->toArray());

            if ($attr['guard_name'] == config('app.guard')) {
                $permission->assignRole(Role::SUPER_ROLE_ID);
            }
        }
    }

    /**
     * @param $name
     * @param string $guardName
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function findPermissionsByName($name, $guardName = null)
    {
        $guardName = $guardName ?: config('app.guard');
        if (!is_array($name)) {
            $name = [$name];
        }
        return Permission::query()->whereIn('name', $name)->where('guard_name', $guardName)->get();
    }

}
