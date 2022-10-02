<?php

namespace App\Listeners\PM\Task;

use App\Events\PM\Task\SubTaskVersionInTest;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SubTaskVersionInTestListener implements ShouldQueue
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
     * @param object $event
     * @return void
     */
    public function handle(SubTaskVersionInTest $event)
    {
        $subTask = $event->subtask;
        $version = $event->version;
        // 收件人是版本管理员
        $versionAdmins = User::query()->whereIn('id', $version->adminIds())->get();
        // 抄送人：需求发布人，任务跟进人/负责人，测试跟进人/负责人
        $cc = [];
        $cc[] = $subTask->handler_id;
        $cc[] = $subTask->task->principal_user_id;
        $demand = $subTask->hasDemand()->first();
        if ($demand) {
            $cc[] = $demand->promulgator_id;
            // 测试任务
            $demand->load(['testTasks.subTasks']);
            $demand->testTasks->map(function ($testTask) use (&$cc) {
                $cc[] = $testTask->principal_user_id;
                $testTask->subTasks->map(function ($subTask) use (&$cc) {
                    $cc[] = $subTask->handler_id;
                });
            });
        }
        $ccUsers = User::query()->whereIn('id', $cc)->get();

        $subject = "pms-【{$version->product->name}{$version->full_version}】测试版本新增功能";
        $url = $this->getUrl($subTask);
        $data['content'] = '';
        if ($demand) {
            $data['content'] .= "需求 {$demand->number} {$demand->name} <br/>";
        }
        $data['content'] .= '编号为"' . $subTask->number . '"的任务，新增至本次测试中的版本，请管理员及相关需求人员注意跟进后续！';
        $data['link'] = <<<EOF
        点击下方链接，可查看此任务详细情况~<br>
        <a href="{$url}" style="color: #0070BC;text-decoration: none">$url</a>
EOF;

        Mail::to($versionAdmins)->cc($ccUsers)->send(new SendMail($subject, 'mail.email_pms', $data));
    }
}
