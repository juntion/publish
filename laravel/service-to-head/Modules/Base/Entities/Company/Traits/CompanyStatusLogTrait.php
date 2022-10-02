<?php


namespace Modules\Base\Entities\Company\Traits;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Modules\Base\Entities\Company\CompanyStatusLog;

trait CompanyStatusLogTrait
{

    public static function bootCompanyStatusLogTrait()
    {
        static::created(function ($model){
            $model->createStatusLog(null, 1);
        });

        static::updated(function ($model) {
            if($model->isDirty("status")){
                $model->createStatusLog($model->getOriginal('status'), $model->status);
            }
        });
    }

    /**
     * 创建 statusLog
     * @param $oldStatus
     * @param $newStatus
     * @param $comment
     * @param  string  $statusLogAble
     */
    public function createStatusLog($oldStatus, $newStatus, $comment = null, $statusLogAble = 'statusLogs')
    {
        if (is_null($comment)) {
            $comment = request()->input('comment', '') ?? '';
        }
        $user = Auth::user();
        $this->$statusLogAble()->create([
            'user_uuid'   => $user->uuid,
            'user_name'   => $user->name,
            'action_name' => Route::currentRouteName() ?? '',
            'old_status'  => $oldStatus,
            'new_status'  => $newStatus,
            'comment'     => $comment,
            'uuid'        => Str::uuid()->getHex()->toString(),
        ]);
    }

    /**
     * 状态日志
     * @param  string  $statusLogAble
     * @return mixed
     */
    public function logs($statusLogAble = 'statusLogs')
    {
        $logs = $this->$statusLogAble()->orderBy('created_at', 'desc')->get();
        $result = $logs->map(function ($item) {
            $data['user_name'] = $item->user_name;
            $data['status'] = $item->newStatusDesc;
            $data['comment'] = $item->comment;
            $data['created_at'] = $item->created_at;
            return $data;
        });
        return $result;
    }

    public function statusLogs()
    {
        return $this->morphMany(CompanyStatusLog::class, 'model', 'model_type', 'model_uuid');
    }

    // 状态描述
    public function getStatusDescAttribute()
    {
        return $this->getStatus($this->status);
    }
}
