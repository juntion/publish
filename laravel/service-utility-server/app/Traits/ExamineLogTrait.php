<?php

namespace App\Traits;

use App\Enums\ProjectManage\BugExamineStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

trait ExamineLogTrait
{
    /**
     * 创建审批日志
     * @param $oldStatus
     * @param $newStatus
     * @param $comment
     */
    public function createExamineStatusLog($oldStatus, $newStatus, $comment = null)
    {
        if (is_null($comment)) {
            $comment = request()->input('comment', '') ?? '';
        }
        $user = Auth::user();
        $this->examineLogs()->create([
            'user_id'     => $user->id,
            'user_name'   => $user->name,
            'action_name' => Route::currentRouteName() ?? '',
            'old_status'  => $oldStatus,
            'new_status'  => $newStatus,
            'comment'     => $comment,
        ]);
    }

    /**
     * 审批状态日志
     * @param string $statusLogAble
     * @return mixed
     */
    public function examineStatusLogs()
    {
        $logs = $this->examineLogs()->orderBy('id', 'desc')->get();
        $result = $logs->map(function ($item) {
            $data['user_name'] = $item->user_name;
            $data['status'] = $item->newStatusDesc;
            $data['comment'] = $item->comment;
            $data['created_at'] = $item->created_at->toDateTimeString();
            return $data;
        });
        return $result;
    }

    // 状态描述
    public function getExamineStatusDescAttribute()
    {
        return BugExamineStatus::getDesc($this->examine_status);
    }
}
