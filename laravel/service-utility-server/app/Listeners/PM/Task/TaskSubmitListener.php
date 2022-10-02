<?php

namespace App\Listeners\PM\Task;

use App\Events\PM\Task\TaskSubmit;
use App\Mail\SendMail;
use App\Models\User;
use App\ProjectManage\Models\DesignSubTask;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class TaskSubmitListener implements ShouldQueue
{
    use TaskDetailUrl;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param TaskSubmit $event
     * @return void
     */
    public function handle(TaskSubmit $event)
    {
        $subTask = $event->subTask;
        if ($subTask instanceof DesignSubTask) {
            $userId = $subTask->part()->first()->principal_user_id;
        } else {
            $userId = $subTask->task()->first()->principal_user_id;
        }
        $user = User::query()->find($userId);
        $demand = $subTask->demand();
        $url = $this->getUrl($subTask);

        $data['content'] = "编号为\"{$subTask->number}\"的任务，你的组员已提交，请尽快验收操作！";
        if (!empty($demand)) {
            $data['content'] .= "需求为\"{$demand->number}\"&\"{$demand->name}\"";
        }

        $data['link'] = <<<EOF
        点击下方链接，可查看此任务详细情况~<br>
        <a href="{$url}" style="color: #0070BC;text-decoration: none">$url</a>
EOF;

        Mail::to($user->email)
            ->send(new SendMail('PMS-研发任务进展（已提交）', 'mail.email_pms', $data));
    }
}
