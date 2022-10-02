<?php

namespace App\Listeners\PM\Bug;

use App\Enums\ProjectManage\BugStatus;
use App\Events\PM\Bug\BugExamine;
use App\Mail\SendMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class BugExamineListener implements ShouldQueue
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
     * @param BugExamine $event
     * @return void
     */
    public function handle(BugExamine $event)
    {
        $bug = $event->bug;

        $url = config('app.frontend_url') . '/RDmanagement/bug/bugProduct?number=' . $bug->number;

        $data['content'] = <<<EOF
        编号为：<b>"{$bug->number}"</b>的故障，需要您的审批！请前往pms进行操作;
EOF;

        $data['link'] = <<<EOF
        点击下方链接，可查看此故障详细情况~<br>
        <a href="{$url}" style="color: #0070BC;text-decoration: none">$url</a>
EOF;

        if ($bug->status == BugStatus::STATUS_TO_FINANCIAL_EXAMINE) {
            $email = config('mail.emails.finance');
            $subject = 'PMS-故障审批（财务审批）';
        } else if ($bug->status == BugStatus::STATUS_TO_INTERNAL_CONTROL_EXAMINE) {
            $email = config('mail.emails.risk_control');
            $subject = 'PMS-故障审批（内控审批）';
        }

        Mail::to($email)
            ->send(new SendMail($subject, 'mail.email_pms', $data));
    }
}
