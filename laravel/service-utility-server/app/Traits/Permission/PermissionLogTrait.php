<?php

namespace App\Traits\Permission;

use App\Models\Permission\PermissionLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

trait PermissionLogTrait
{
    public function permissionLogs()
    {
        return $this->morphMany(PermissionLog::class, 'model');
    }

    /**
     * 创建权限日志
     * @param array $oldValue
     * @param array $newValue
     * @param  $type
     * @param  $comment
     */
    public function createPermissionLog($oldValue, $newValue, $type = null, $comment = null)
    {
        if (is_null($comment)) {
            $comment = request()->input('comment', '') ?? '';
        }
        $user = Auth::user();
        $this->permissionLogs()->create([
            'user_id' => $user ? $user->id : 0,
            'user_name' => $user ? $user->name : '',
            'action_name' => Route::currentRouteName() ?? '',
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'type' => $type,
            'comment' => $comment,
        ]);
    }

    /**
     * 获取权限日志
     * @return mixed
     */
    public function getPermissionLogs()
    {
        $limit = (int)(request()->input('limit', 20));
        $columns = ['id', 'user_id', 'user_name', 'action_name', 'comment', 'description', 'created_at'];
        return $this->permissionLogs()->select($columns)->orderBy('id', 'desc')->paginate($limit);
    }
}
