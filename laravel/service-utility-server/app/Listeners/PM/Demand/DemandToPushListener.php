<?php

namespace App\Listeners\PM\Demand;

use App\Events\PM\Demand\DemandToPush;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class DemandToPushListener implements ShouldQueue
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
     * @param DemandToPush $event
     * @return void
     */
    public function handle(DemandToPush $event)
    {
        $demand = $event->demand;
        // 通知项目负责人
        if ($project = $demand->project()->first()) {
            $user = User::query()->find($project->principal_user_id);
            $url = config('app.frontend_url') . '/RDmanagement/product/demandDetails?id=' . $demand->id;

            if (!empty($demand->source_project_name)) {
                $data['content'] = <<<EOF
            "{$demand->source_project_name}"项目下，有一条"{$demand->name}"，"{$demand->number}"的产品需求，需要你推送研发！
EOF;
            } else {
                $data['content'] = <<<EOF
            "{$demand->name}"，"{$demand->number}"的产品需求，需要你推送研发！
EOF;
            }

            $data['link'] = <<<EOF
        点击下方链接，可查看此需求详细情况~<br>
        <a href="{$url}" style="color: #0070BC;text-decoration: none">$url</a>
EOF;

            Mail::to($user->email)
                ->send(new SendMail('PMS-项目需求进展（待推送）', 'mail.email_pms', $data));
        }
    }
}
