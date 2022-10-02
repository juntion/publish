<?php

namespace App\Traits;

use App\ProjectManage\Models\StatusLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

trait StatusLogTrait
{
    /**
     * 创建 statusLog
     * @param $oldStatus
     * @param $newStatus
     * @param $comment
     * @param string $statusLogAble
     */
    public function createStatusLog($oldStatus, $newStatus, $comment = null, $statusLogAble = 'statusLogs')
    {
        if (is_null($comment)) {
            $comment = request()->input('comment', '') ?? '';
        }
        $user = Auth::user();
        $this->$statusLogAble()->create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'action_name' => Route::currentRouteName() ?? '',
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'comment' => $comment,
        ]);
    }

    /**
     * 状态日志
     * @param string $statusLogAble
     * @return mixed
     */
    public function logs($statusLogAble = 'statusLogs')
    {
        $logs = $this->$statusLogAble()->orderBy('id', 'desc')->get();
        $result = $logs->map(function ($item) {
            $data['user_name'] = $item->user_name;
            $data['status'] = $item->newStatusDesc;
            $data['comment'] = $item->comment;
            $data['created_at'] = $item->created_at->toDateTimeString();
            $data['action_name'] = $item->action_name;
            return $data;
        });
        return $result;
    }

    public function statusLogs()
    {
        return $this->morphMany(StatusLog::class, 'model');
    }

    // 状态描述
    public function getStatusDescAttribute()
    {
        return $this->getStatus($this->status);
    }
}
