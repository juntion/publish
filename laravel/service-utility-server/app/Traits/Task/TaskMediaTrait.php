<?php

namespace App\Traits\Task;

trait TaskMediaTrait
{
    /**
     * 更新附件
     * @param $task
     * @param $data
     */
    public function updateMedia($task, $data)
    {
        // 保留附件
        $oldMedias = $task->media();
        if (isset($data['old_media'])) {
            $deleteMedias = $oldMedias->get()->pluck('id')->reject(function ($item) use ($data) {
                return in_array($item, $data['old_media']);
            })->toArray();
            $task->media()->whereIn('id', $deleteMedias)->delete();
        } else {
            $oldMedias->delete();
        }

        // 新增附件
        if (isset($data['new_media'])) {
            $task->addMedias($data['new_media']);
        }
    }
}
