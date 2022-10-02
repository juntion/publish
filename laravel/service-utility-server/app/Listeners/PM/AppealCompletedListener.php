<?php

namespace App\Listeners\PM;

use App\Events\PM\AppealCompleted;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class AppealCompletedListener implements ShouldQueue
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
     * @param AppealCompleted $event
     * @return void
     */
    public function handle(AppealCompleted $event)
    {
        $appeal = $event->appeal;
        $user = User::query()->find($appeal->promulgator_id);
        if (empty($user)) {
            info('User id:' . $appeal->promulgator_id . ' not found');
            return;
        }

        $url = config('app.frontend_url') . '/RDmanagement/recount/claimDetail?id=' . $appeal->id;

        $data['content'] = <<<EOF
        "{$appeal->name}"，<b>此诉求</b> "{$appeal->number}"<b>已完成</b>！
EOF;

        $data['link'] = <<<EOF
        点击下方链接，可查看此诉求详细情况~<br>
        <a href="{$url}" style="color: #0070BC;text-decoration: none">$url</a>
EOF;

        Mail::to($user->email)
            ->send(new SendMail('PMS-诉求进展提醒（已完成）', 'mail.email_pms', $data));
    }
}
