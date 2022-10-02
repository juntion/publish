<?php


namespace App\Listeners\PM\Task;


use Illuminate\Support\Str;

trait TaskDetailUrl
{
    /**
     * @param $task
     * @return string
     */
    public function getUrl($task)
    {
        $url = config('app.frontend_url') . '/RDmanagement/product/task?number=' . $task->number;

        $className = class_basename($task);
        $type = explode('_', Str::snake($className))[0];
        $url .= '&type=' . $type;
        
        return $url;
    }
}
