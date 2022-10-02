<?php

namespace Modules\Tag\Entities;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Modules\Tag\Enums\TagDataStatus;

trait TagOperationLogTrait
{
    /**
     * 创建操作日志
     * @param array $properties
     * @param string $comment
     */
    public function createOperationLog($properties = [], $comment = '')
    {
        $data = [];
        // 操作人
        if ($user = Auth::user()) {
            $data['admin_uuid'] = $user->uuid;
            $data['admin_name'] = $user->name;
        }
        // 操作名
        $routeName = Route::currentRouteName();
        if (Str::contains($routeName, 'tags.updateStatus')) {
            $status = request()->input('status');
            if ($status == TagDataStatus::STATUS_ON) {
                $routeName = $routeName . '.open';
            }
            if ($status == TagDataStatus::STATUS_OFF) {
                $routeName = $routeName . '.close';
            }
        }
        $data['action_name'] = $routeName ?? '';
        if (!$user && empty($data['action_name'])) {
            return;
        }
        $data['properties'] = $properties;
        if (!$comment) {
            $comment = request()->input('comment', '');
        }
        $data['comment'] = $comment;
        $data['tag_name'] = $this->name;
        $data['tag_number'] = $this->number;
        $this->operationLogs()->create($data);
    }

    /**
     * 获取操作日志
     * @return mixed
     */
    public function logs()
    {
        return $this->operationLogs()->orderBy('created_at', 'desc')->get();
    }
}
