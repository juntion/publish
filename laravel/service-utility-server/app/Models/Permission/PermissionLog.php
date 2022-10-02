<?php

namespace App\Models\Permission;

use App\Enums\Permission\PermissionLogType;
use App\Enums\Permission\RoleColumns;
use App\Models\User;
use App\Traits\DateFormatTrait;
use Illuminate\Database\Eloquent\Model;

class PermissionLog extends Model
{
    use DateFormatTrait;

    protected $fillable = ['user_id', 'user_name', 'action_name', 'old_value', 'new_value', 'comment', 'type', 'description'];

    protected $casts = [
        'old_value' => 'json',
        'new_value' => 'json',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->description = self::getHumanDesc($model);
        });
    }

    public function logAble()
    {
        return $this->morphTo('model');
    }

    public static function getHumanDesc(PermissionLog $log): string
    {
        $desc = '';
        // 角色的权限修改
        if ($log->type == PermissionLogType::ROLE_PERMISSION) {
            if ($log->comment === 'create') {
                return "由 {$log->user_name} 创建";
            }
            if ($log->comment === 'delete') {
                return "由 {$log->user_name} 删除";
            }
            if ($log->comment === 'update') {
                $desc = "由 {$log->user_name} 编辑" . PHP_EOL;
                foreach ($log->new_value as $key => $val) {
                    $desc .= '修改了' . RoleColumns::COLUMNS[$key] . '，旧值为"' . $log->old_value[$key] . '"，新值为"' . $log->new_value[$key] . '";' . PHP_EOL;
                }
                return $desc;
            }
            $desc .= '角色权限：';
            if ($addPermissionIds = array_diff($log->new_value, $log->old_value)) {
                $addPermissions = Permission::query()->whereIn('id', $addPermissionIds)->get();
                $addPermissions = $addPermissions->pluck('locale')->map(function ($item) {
                    return is_array($item) ? $item['zh-CN'] : json_decode($item, true)['zh-CN'];
                })->toArray();
                $desc .= '添加权限(' . implode(', ', $addPermissions) . ')；';
            }
            if ($delPermissionIds = array_diff($log->old_value, $log->new_value)) {
                $delPermissions = Permission::query()->whereIn('id', $delPermissionIds)->get();
                $delPermissions = $delPermissions->pluck('locale')->map(function ($item) {
                    return is_array($item) ? $item['zh-CN'] : json_decode($item, true)['zh-CN'];
                })->toArray();
                $desc .= '取消权限(' . implode(', ', $delPermissions) . ')';
            }
            return $desc;
        }
        // 角色的用户修改
        if ($log->type == PermissionLogType::ROLE_USER) {
            $desc .= '角色人员：';
            if ($log->new_value) {
                $addUsers = User::query()->whereIn('id', $log->new_value)->get();
                $desc .= '新增人员(' . implode(', ', $addUsers->pluck('name')->toArray()) . ')；';
            }
            if ($log->old_value) {
                $delUsers = User::query()->whereIn('id', $log->old_value)->get();
                $desc .= '删除人员(' . implode(', ', $delUsers->pluck('name')->toArray()) . ')';
            }
            return $desc;
        }
        // 用户角色修改
        if ($log->type == PermissionLogType::USER_ROLE) {
            $desc .= '人员角色：';
            if ($newRole = array_diff($log->new_value, $log->old_value)) {
                $addRoles = Role::query()->whereIn('id', $newRole)->orWhereIn('name', $newRole)->get();
                $desc .= '添加角色(' . implode(', ', $addRoles->pluck('name')->toArray()) . ')；';
            }
            if ($delRole = array_diff($log->old_value, $log->new_value)) {
                $delRoles = Role::query()->whereIn('id', $delRole)->orWhereIn('name', $delRole)->get();
                $desc .= '删除角色(' . implode(', ', $delRoles->pluck('name')->toArray()) . ')';
            }
            return $desc;
        }
        // 用户的直接权限修改
        if ($log->type == PermissionLogType::USER_PERMISSION) {
            $desc .= '用户权限：';
            if ($addPermissionIds = array_diff($log->new_value, $log->old_value)) {
                $addPermissions = Permission::query()->whereIn('id', $addPermissionIds)->get();
                $addPermissions = $addPermissions->pluck('locale')->map(function ($item) {
                    return is_array($item) ? $item['zh-CN'] : json_decode($item, true)['zh-CN'];
                })->toArray();
                $desc .= '添加权限(' . implode(', ', $addPermissions) . ')；';
            }
            if ($delPermissionIds = array_diff($log->old_value, $log->new_value)) {
                $delPermissions = Permission::query()->whereIn('id', $delPermissionIds)->get();
                $delPermissions = $delPermissions->pluck('locale')->map(function ($item) {
                    return is_array($item) ? $item['zh-CN'] : json_decode($item, true)['zh-CN'];
                })->toArray();
                $desc .= '取消权限(' . implode(', ', $delPermissions) . ')';
            }
        }
        return $desc;
    }
}
