<?php

namespace App\Listeners\PM\Demand;

use App\Events\PM\Demand\DemandToTest;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class DemandToTestListener implements ShouldQueue
{
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
     * @param DemandToTest $event
     * @return void
     */
    public function handle(DemandToTest $event)
    {
        $demand = $event->getDemand();
        $userIds = [];
        $testTasks = $demand->testTasks()->get();
        $testTasks->map(function ($testTask) use (&$userIds) {
            $userIds[] = $testTask->principal_user_id;
        });
        $testSubTasks = $demand->testSubtasks()->get();
        $testSubTasks->map(function ($testSubTask) use (&$userIds) {
            $userIds[] = $testSubTask->handler_id;
        });
        $users = User::query()->whereIn('id', $userIds)->get();
        if ($users->isEmpty()) {
            return;
        }

        $url = config('app.frontend_url') . '/RDmanagement/product/demandDetails?id=' . $demand->id;
        $data['content'] = "\"{$demand->number}\"的产品需求，已经发布至测试站，请安排测试工作！";
        $data['link'] = <<<EOF
        点击下方链接，可查看此需求详细情况~<br>
        <a href="{$url}" style="color: #0070BC;text-decoration: none">$url</a>
EOF;

        Mail::to($users)
            ->send(new SendMail('PMS-需求发布测试', 'mail.email_pms', $data));

    }
}
