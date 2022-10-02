<?php

namespace App\Listeners\PM\Task;

use App\Events\PM\Task\TaskSetHandler;
use App\Mail\SendMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class TaskSetHandlerListener implements ShouldQueue
{
    use TaskDetailUrl;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param TaskSetHandler $event
     * @return void
     */
    public function handle(TaskSetHandler $event)
    {
        $subTask = $event->subTask;
        $handler = $event->handler;
        $demand = $subTask->demand();
        $url = $this->getUrl($subTask);

        $data['content'] = "你有一条编号为\"{$subTask->number}\"的任务需要处理！";
        if (!empty($demand)) {
            $data['content'] .= "需求为\"{$demand->number}\"&\"{$demand->name}\"";
        }

        $data['link'] = <<<EOF
        点击下方链接，可查看此任务详细情况~<br>
        <a href="{$url}" style="color: #0070BC;text-decoration: none">$url</a>
EOF;

        Mail::to($handler->email)
            ->send(new SendMail('PMS-研发任务进展（未处理）', 'mail.email_pms', $data));
    }
}
